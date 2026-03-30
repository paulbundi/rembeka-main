<?php

use App\Auth\ImpersonationManager;
use App\Facades\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Referralcode;
use App\Models\User;
use App\Models\WalletAudit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

/**
 * @return bool
 */
function isImpersonating(): bool
{
    return app(ImpersonationManager::class)->isImpersonating();
}

/**
 * Check if user has permissions.
 *
 * @param string $permission
 *
 * @return bool
 */
function canAccess(string $permission): bool
{
    return auth()->user()->hasPermission($permission) ? true : false;
}

/**
 * Get Otp message
 *
 * @return string
 */
function getOtpMessage($forPayment = false): string
{
    $otp =  rand(1000, 9999);

    session()->put('otp', [
        'otp' => $otp,
        'expires' => Carbon::now()->addMinutes(3),
    ]);

    if ($forPayment) {
        session()->put('intended-route', 'payment.mode');
    }

    $message = 'Your verification code for Rembeka is: '.$otp;
    \Log::info($message);

    return $message;
}

/**
 * generate order numbers
 *
 * @return string
 */
function generateOrderNumber($order, $isStkPush = false)
{
    $orderNo = $order->id;

    if ($order) {
        $orderNo = $order->id;
    }

    if ($isStkPush) {
        return 'ST'.$orderNo;
    }

    return 'RO'.$orderNo;
}

/**
 * @return array
 */
function reserveCart()
{
    return Cart::getContent();
}

/**
 * restore cart from session.
 *
 * @return void
 */
function restoreCart()
{
    if (!session()->has('guest_cart')) {
        return;
    }

    /** @var \App\Cart\Cart $guestCart */
    $guestCart = session()->pull('guest_cart');
    // $guestCart->session(session()->getId());

    $cart = Cart::session(session()->getId());

    info(session()->getId());
    $guestCartItems = $guestCart->toArray();

    if ($guestCart->isNotEmpty()) {
        $cart->add($guestCartItems);
    }
}

/**
 * Create audit trails for accounts transactions.
 *
 * @param int    $auditableId
 * @param string $model
 * @param string $description
 * @param int    $transactionEffect //debit/credit
 * @param int    $userId
 *
 * @return void
 */
function makeAudit(
    int $auditableId,
    String $model,
    String $description,
    int $transactionEffect,
    int $userId,
    float $amount,
    float $previousBalance,
    ?int $orderId = null
):void {
    WalletAudit::create([
        'auditable_id' => $auditableId,
        'auditable_type' => $model,
        'description' => $description,
        'effect_type' => $transactionEffect,
        'user_id' => $userId, //1 rep: system , this is for clone jobs.
        'amount' => $amount,
        'previous_balance' => $previousBalance,
        'order_id' => $orderId,
    ]);
}

/**
 * Calculate order value.
 *
 * @param int $id
 *
 * @return void
 */
function updateOrderPricing(int $id)
{
    $order = Order::where('id', $id)
        ->with(['items', 'referralCode'])
        ->first();

    $referralCode = DB::table('referralcode_user')
        ->where('user_id', $order->user_id)
        ->where('referralcode_id', $order->referral_code_id)
        ->first();
    
    $newTotal = 0;
    $uniqueOrders = [];
    $hasDeliveryFee = false;
    $tax = 0;

    $referralDiscount = 0;


    $order->items->each(function ($item) use ($referralCode, $order, &$newTotal, &$uniqueOrders, &$hasDeliveryFee, $tax, &$referralDiscount) {
        if ($item->type == OrderItem::TYPE_SERVICE) {
            if(!in_array($item->provider_id, $uniqueOrders)) {
                array_push($uniqueOrders, $item->provider_id);
            }

            if ($item->assisting_provider_id != null && !in_array($item->assisting_provider_id, $uniqueOrders)) {
                array_push($uniqueOrders, $item->assisting_provider_id);
            }

            if (!$item->rembeka_discount && $order->referralCode) {

                if($order->referralCode->user_id == $order->user_id) {
                    $referralDiscount += ($item->amount * ($order->referralCode->ambassador_discount / 100));

                }else if($referralCode->redeemed_times == 1 && $order->referralCode->referred_first_visit_discount > 0) {
                    $referralDiscount += ($item->amount * ($order->referralCode->referred_first_visit_discount / 100));

                }else if($referralCode->redeemed_times == 2 && $order->referralCode->referred_second_visit_discount > 0){

                    $referralDiscount += ($item->amount * ($order->referralCode->referred_second_visit_discount / 100));
                }

            }
        }

        if ($item->type == OrderItem::TYPE_PRODUCT) {
            $tax += $item->amount * 16 / 100;
        }


        $newTotal += $item->amount;

        if (!$hasDeliveryFee && $item->type == OrderItem::TYPE_PRODUCT) {
            $hasDeliveryFee = true;
        }
    });

    $transportCost = $order->has_transport_cost == 1 ? count($uniqueOrders) * Product::PROVIDER_TRANSPORT_COST : 0;

    $newTotal = $newTotal + $transportCost + $tax;

    if ($hasDeliveryFee) {
        $newTotal += $order->delivery_amount;
    } else {
        $order->delivery_amount = 0;
    }

    $newTotal = $newTotal - $referralDiscount;

    $balance = $newTotal - $order->paid;
    $order->referral_discount = $referralDiscount;
    $order->amount = $newTotal;
    $order->transport_cost = $transportCost;
    $order->balance = $balance;// avoid negative.
    $order->saveQuietly();

    if($balance < 0) {
        handleOverPayment($balance, $order);
    }
}

/**
 * Remit overpayment to wallet.
 *
 * @param [type] $amount
 * @param [type] $order
 * @return void
 */
function handleOverPayment($amount, $order)
{

    $user = User::where('id', $order->user_id)
        ->first();

    $previousBalance =  $user->wallet;

    $user->wallet += abs($amount);
    $user->saveQuietly();

    $description = 'Overpayment of Order {$order->order_no} of Ksh. '.number_format($amount, 2) .' remitted to your wallet';
    makeAudit(
        $order->user_id,
        'App\Models\User',
        $description,
        WalletAudit::CREDIT,
        auth()->id(),
        $amount,
        $previousBalance,
    );

}
