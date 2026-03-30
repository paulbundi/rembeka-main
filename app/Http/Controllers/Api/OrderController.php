<?php

namespace App\Http\Controllers\Api;

use App\Mail\OrderCreated;
use App\Mail\PaymentRequest;
use App\Models\Inquiry;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PdqPayment;
use App\Models\Product;
use App\Models\ProductPricing;
use App\Models\ProviderPricing;
use App\Models\Store;
use App\Models\User;
use App\Models\WalletAudit;
use App\Notifications\SmsNotification;
use App\Notifications\WalletPaymentNotification;
use App\Repository\Orders\ProviderOrderProcessing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Break_;

class OrderController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return Order::class;
    }

    /**
     * Get a new query instance.
     *
     * @return Builder
     */
    protected function newQuery(): Builder
    {
        $query = $this->model->newQuery()
            ->whereHas('items', function ($query) {
                return $query->where('type', Product::TYPE_SERVICE);
            });
        if (auth()->user()->account_type == User::TYPE_CORPORATE) {
            $query->where('user_id', auth()->id());
        }

        return $query;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'customer', 'items.provider', 'items.assistingProvider','items.product', 'items.category', 'items', 'channel', 'admin',
            'items.supplier', 'store','address',
        ];
    }

    /**
     * Create a new Record.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = $this->getRequest();
        $this->preStore($request);
        $this->model->fill($request->only(array_keys($request->rules())));

        $data = $request->all();
        $amount = 0; // update after discount is calculated etc. avoids double query
        $this->model->amount = $amount;
        $this->model->paid = 0;
        $this->model->balance = $amount;
        $this->model->status = Order::STATUS_PENDING_PAYMENT;
        $this->model->referral_code_id = $data['referral_code_id'] ?? null;
        $this->model->save();
        $this->model->refresh();

        $storeId = $request->get('store_id');

        if(isset($data['referral_code_id']) && $data['referral_code_id'] != null) {
            $this->createReferral();
        }

        $this->createOrderItems($data, $storeId);

        updateOrderPricing($this->model->id);

        if ($request->get('inquiry_id')) {
            Inquiry::where('id', $request->get('inquiry_id'))
                ->update(['status' => Inquiry::STATUS_CONVERTED]);
        }

        $this->model->customer->return_times += 1;
        $this->model->customer->save();

        $this->notifyClient();

        return response()->json();
    }


    /**
     * Keep Track of referrals
     *
     * @return void
     */
    public function createReferral()
    {

        if (DB::table('referralcode_user')
        ->where('user_id', $this->model->user_id)
        ->where('referralcode_id', $this->model->referral_code_id)
        ->exists()) {

        DB::table('referralcode_user')
            ->where('user_id', $this->model->user_id)
            ->where('referralcode_id', $this->model->referral_code_id)
            ->increment('redeemed_times');
    
    } else {
        $inserted =DB::table('referralcode_user')->insert([
            'user_id' => $this->model->user_id,
            'referralcode_id' => $this->model->referral_code_id,
            'redeemed_times' => 1,
        ]);

    }
          
    }
    /**
     * Create order items.
     *
     * @param array $data
     *
     * @return void
     */
    public function createOrderItems(array  $data, int $franchiseId = null): void
    {
        $franchise = null;

        if ($franchiseId) {
            $franchise = Store::find($franchiseId);
        }

        foreach ($data['order_items'] as $item) {
            if ($item['type'] == Product::TYPE_SERVICE) {
                $providerPricing = ProviderPricing::where('provider_id', $item['provider']['id'])
                    ->where('product_id', $item['product']['id'])
                    ->with(['product.discount'])
                    ->first();

                $this->storeServiceOrderItems($providerPricing, $item, $franchise);
            }

            if ($item['type'] == Product::TYPE_PRODUCT) {
                $productPricing = ProductPricing::where('supplier_id', $item['provider']['id'])
                        ->where('product_id', $item['product']['id'])
                        ->with(['product.discount'])
                        ->first();

                $this->storeProductOrderItems($productPricing, $item);
            }
        }
    }

    /**
     * Re-usable for create and update order items.
     *
     * @param ProviderPricing $providerPricing
     * @param array           $item
     *
     * @return void
     */
    public function storeServiceOrderItems(ProviderPricing $providerPricing, array $item, $franchise = null): void
    {
        $item['provider_discount'] = $item['provider_discount'] ?? 0;
        $item['providerDiscountAmount'] = 0;
        $item['rembekaDiscountAmount'] = 0;
        $isDiscounted =  false;
    
        $originalPricing = $providerPricing->amount;
            
        if (isset($item['assistStylist'])) { // if sharing stylist, pricing is the new price.
            $originalPricing =  $item['assistStylist']['newPrice'];
        }

        $commission = $providerPricing->product->constant_commission ?
            $providerPricing->product->commission :
            ($franchise ?  $franchise->commission :  $providerPricing->product->commission);

        $item['providerCost'] = $providerPricing->cost_of_labour * ((100 - $commission) / 100); //cost_of_labour subject to location or service commission.

        $originalProviderCost =  $item['providerCost'];

        if (isset($item['assistStylist'])) { // if sharing stylist, cost of labour == 35% of the new price minus 100 platform fee.
            $item['providerCost'] = ($originalPricing - 100) * 0.35;
        }

        if ($item['provider_discount']) {// provider has given a discount.
            $discountedProviderCost = $item['providerCost'] *  ((100 - $item['provider_discount']) / 100);
            $item['providerDiscountAmount'] = $item['providerCost'] - $discountedProviderCost;
            $item['providerCost'] = $discountedProviderCost;
            $isDiscounted =  true;
        }

        if ($providerPricing && $providerPricing->product->discount) {// Rembeka has given a discount.
            $item['rembekaDiscount'] = $providerPricing->product->discount->discount_amount;
            //choose to user $originalPricing over discount->payable amount on this because stylists are allowed custom pricing but the discount should hold.
            $item['rembekaDiscountedPrice'] = $originalPricing  *  (100 -  $item['rembekaDiscount']) / 100 ;
            $item['rembekaDiscountAmount'] =  ($originalPricing *  $item['quantity']) - ($item['quantity'] * $item['rembekaDiscountedPrice']);
            $isDiscounted =  true;
        }

        $newClientPrice = ($originalPricing - $item['rembekaDiscountAmount']) - $item['providerDiscountAmount'];

        $amount =  $item['quantity'] * $newClientPrice;

        $providerAmount = $item['quantity'] * $item['providerCost'];
        $item['provider_discount_amount'] = $item['quantity'] * ($item['providerDiscountAmount'] ?? 0);//
        $totalDiscountAmount = $item['quantity'] * ($item['rembekaDiscountAmount'] + $item['providerDiscountAmount']);


        $orderItemData = [
                'order_id' => $this->model->id,
                'product_id' => $item['product']['id'],
                'category_id' =>  1,
                'provider_id' => $item['provider']['id'],
                'quantity' => $item['quantity'],
                'status' => OrderItem::STATUS_PENDING,
                'appointment_date' => $item['appointmentDate'],
                'appointment_time' => $item['appointmentTime'],
                'service_pricing' =>  $originalPricing,
                'rembeka_discount' => $item['rembekaDiscount'] ?? null,
                'rembeka_discount_amount' => $item['rembekaDiscountAmount'] ?? null,
                'amount' => $amount,
                'provider_amount' => $providerAmount,
                'provider_discount' => $item['provider_discount'],
                'provider_discount_amount' => $item['provider_discount_amount'] ?? null,
                'provider_cost' => $originalProviderCost,
                'un_discounted_commission' => $commission,
                'percentage_commission' =>  $commission - ($item['rembekaDiscount']?? 0),
                'beneficiary' => $item['beneficiary']?? null,
                'type' => Product::TYPE_SERVICE,
            ];

            if (isset($item['assistStylist'])) {

                $orderItemData = array_merge($orderItemData, [
                    'assisting_provider_id' => $item['assistStylist']['id'],
                    'shared_commission' => ['35', '35', '30'],
                ]);
            }
           



        if ($isDiscounted) {
            $orderItemData = array_merge($orderItemData, [
                'discounted' => 1,
                'discount_amount' => $totalDiscountAmount,
                'total_discount' => $totalDiscountAmount,
            ]);
        }
        
        OrderItem::create($orderItemData);
    }

    /**
     * Re-usable for create and update order items.
     *
     * @param ProviderPricing $providerPricing
     * @param array           $item
     *
     * @return void
     */
    public function storeProductOrderItems(ProductPricing $productPricing, array $item): void
    {
        $item['provider_discount'] = $item['provider_discount'] ?? 0;
        if ($productPricing && $productPricing->product->discount) {
            $supplierAmount = $item['quantity'] * $item['providerCost']  * ((100 - $item['provider_discount']) / 100);

            $discountAmount = $item['quantity'] *
                ($productPricing->product->discount->product_price - $productPricing->product->discount->payable);

            $amount =  ($item['quantity'] * $item['productPricing']);

            dd($amount, 'discounted', 'This is here since we havent built support for product discount.');
            OrderItem::create([
                'order_id' => $model ?? $this->model->id,
                'product_id' => $item['product']['id'],
                'category_id' =>  1,
                'provider_id' => $item['provider']['id'],
                'quantity' => $item['quantity'],
                'status' => OrderItem::STATUS_PENDING,
                'amount' => $amount,
                'provider_amount' => $supplierAmount,
                'provider_discount' => $item['provider_discount'],
                'percentage_commission' =>  $item['percentage_commission'] ?? $productPricing->mark_up_percentage,
                'discounted' => 1,
                'discount_amount' =>  $discountAmount,
                'beneficiary' => $item['beneficiary']?? null,
                'type' => Product::TYPE_PRODUCT,
                'pricing_id' => $item['pricing_id'],

            ]);
        } else {
            $supplierAmount = ($item['quantity'] * $item['providerCost']) *  ((100 - $item['provider_discount']) / 100);

            OrderItem::create([
                'order_id' => $this->model->id,
                'product_id' => $item['product']['id'],
                'category_id' =>  1,
                'provider_id' => $item['provider']['id'],
                'quantity' => $item['quantity'],
                'status' => OrderItem::STATUS_PENDING,
                'amount' => $item['quantity'] * $item['productPricing'], // this is already calculated on the ui.
                'provider_amount' => $supplierAmount,
                'provider_discount' => $item['provider_discount'],
                'percentage_commission' =>  $item['percentage_commission'] ??  $productPricing->mark_up_percentage,
                'beneficiary' => $item['beneficiary'] ?? null,
                'type' => Product::TYPE_PRODUCT,
                'pricing_id' => $item['pricing_id'],
            ]);

            ProductPricing::where('supplier_id', $item['provider']['id'])
                ->where('product_id', $item['product']['id'])
                ->where('size', $item['size'])
                ->decrement('instock', $item['quantity']);
        }
    }

    /**
     * Notify client when order is created.
     *
     * @return void
     */
    public function notifyClient(): void
    {
        $this->model->load('customer');
        $message = 'Hi '.$this->model->customer->first_name.', Thank you for booking with us, your order number is '
        .$this->model->order_no. '.For payment, use Mpesa paybill number '
        .config('services.paybill_no').' and account as '
        .$this->model->order_no.' We have shared a detail invoice to '
        .$this->model->customer->email.'. Thank you for choosing Rembeka Online';

        $this->model->customer->notify(new SmsNotification($message));

        Mail::to($this->model->customer)
            ->queue(new OrderCreated($this->model));
    }

    /**
     * Confirm Order.
     *
     * @param Request $request
     * @param Order   $order
     *
     * @return void
     */
    public function confirmOrder(Request $request, Order $order)
    {
        $order = Order::where('id', $request->id)->first();

        if ($request->get('value') == 1) {
            if ($order->has_transport_cost == 0) {
                $order->status = Order::STATUS_PENDING_SERVICE;
            } else {
                $order->status = Order::STATUS_ORDER_CONFIRMED;
            }
            $order->save();

            new ProviderOrderProcessing($order);

            return response()->json();
        }

        if ($request->get('value') == 2) {
            $order->status = Order::STATUS_CANCELED;
            $order->cancel_reason = $request->get('reason');
            $order->save();

            $this->handleReverseCash($order);
        }

        return response()->json();
    }

    /**
     * Return cash to wallet if order already paid.
     *
     * @param Order $order
     *
     * @return void
     */
    public function handleReverseCash(Order $order):void
    {
        if ($order->paid < 0) {
            return;
        }

        DB::transaction(function () use ($order) {
            $user = User::where('id', $order->user_id)
                ->lockForUpdate()
                ->first();

            $previousAmount = $user->wallet;
            $amount = $order->paid;

            $user->wallet += $amount;
            $user->save();

            $order->refund_status = Order::REFUNDED;
            $order->paid = 0;
            $order->balance = $order->amount;
            $order->save();

            $description = 'Ksh '.$amount. ' Credited to your account as a reversal of payment on order '. $order->order_no;

            makeAudit(
                $user->id,
                'App\Models\User',
                $description,
                WalletAudit::CREDIT,
                auth()->id(),
                $amount,
                $previousAmount,
                $order->id
            );
        });
    }

    /**
     * Resend invoice
     *
     * @param int $id
     *
     * @return void
     */
    public function requestForPayment(int $id)
    {
        $order = Order::with(['customer'])->findOrFail($id);

        if ($order->balance < 1) {
            return;
        }

        $requestPayment = 'Hi '.$order->customer->first_name.', kindly make a payment for Ksh'. $order->balance .' to paybill number '
            .config('services.paybill_no'). '.Use ' .$order->order_no.' as the account, more details on the invoice has been shared on '
            .$order->customer->email.'. Thank you for choosing Rembeka Online';

        Mail::to($order->customer)->send(
            new PaymentRequest($order)
        );
        $order->customer->notify(new SmsNotification($requestPayment));

        return response()->json();
    }

    /**
     * add order items.
     *
     * @param Request $request
     *
     * @return void
     */
    public function addOrderItems(Request $request)
    {
        $data =  $request->all();

        $this->model = Order::with(['store'])->findOrFail($data['id']);

        foreach ($data['items'] as $item) {
            if ($item['type'] == Product::TYPE_PRODUCT) {
                $productPricing = ProductPricing::where('id', $item['pricing_id'])
                    ->with(['product.discount'])
                    ->first();

                $this->storeProductOrderItems($productPricing, $item);
            }
            if ($item['type'] == Product::TYPE_SERVICE) {
                $providerPricing = ProviderPricing::where('provider_id', $item['provider']['id'])
                    ->where('product_id', $item['product']['id'])
                    ->with(['product.discount'])
                    ->first();

                $this->storeServiceOrderItems($providerPricing, $item, $this->model->store);
            }
        }

        updateOrderPricing($this->model->id);

        return response()->json();
    }

    /**
     * Pay corporate orders from corporate wallet.
     *
     * @param Request $request
     *
     * @return void
     */
    public function payOrderFromWallet(Request $request)
    {
        $data = $request->validate([
            'orderId' => 'required',
        ]);

        $order =  Order::with(['customer'])->findOrFail($data['orderId']);

        if ($order->balance == 0 || $order->customer->wallet < 1) {
            return response()->json(['error' =>'Please check wallet Balance.'], 400);
        }

        $previousAmount = $order->customer->wallet;
        $payableAmount = $order->balance;
        $paid = 0;
        $balance = 0;

        if ($previousAmount < $payableAmount) { // partail payment.
            $order->customer->wallet = $order->customer->wallet - $previousAmount;
            $paid = $previousAmount;
            $balance = $payableAmount - $previousAmount;
        } else {
            $paid = $payableAmount;
            $order->customer->wallet = $order->customer->wallet - $payableAmount;
        }

        $order->customer->save();

        $order->status = $order->status == Order::STATUS_PENDING_PAYMENT ?
                Order::STATUS_ORDER_CONFIRMED :
                $order->status;

        $order->paid += $paid;
        $order->balance = $balance;
        $order->save();

        $description = 'Ksh '.$paid. ' debited from your account for payment of order no '. $order->order_no;

        makeAudit(
            $order->customer->id,
            'App\Models\User',
            $description,
            WalletAudit::DEBIT,
            auth()->id(),
            $paid,
            $previousAmount,
            $order->id
        );
        $order->customer->notify(new WalletPaymentNotification($order, $paid));

        return response()->json([
            'success' => 'Payment Successfully',
        ]);
    }

    /**
     * Re-work payable amount.
     *
     * @param integer $id
     * @return void
     */
    public function reWorkPayable(int $id)
    {
        updateOrderPricing($id);
        return response()->json([]);
    }

    /**
     * Record Pdq Payments
     *
     * @param Request $request
     * @return void
     */
    public function pdqPayment(Request $request)
    {
        $data = $request->validate([
            'order_id' => 'required|integer',
            'user_id' => 'required|integer',
            'card_number' =>'required',
            'receipt_no' =>'required',
            'amount' =>'required|integer',
        ]);

        PdqPayment::create($data);

        $order = Order::findOrFail($data['order_id']);

        $order->paid += $data['amount'];
        $order->balance -= $data['amount'];
        $order->save();

        return response()->json();
    }
}
