<?php

namespace App\Repository\Cart;

use App\Channels\SmsChannel;
use App\Facades\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Repository\Payment\RequestMpesaPayment;
use Illuminate\Support\Facades\DB;

class CartRepository
{
    protected $requestPayment;

    public function __construct(RequestMpesaPayment $requestPayment)
    {
        $this->requestPayment = $requestPayment;
    }

    /**
     * Create Order
     *
     * @return void
     */
    public function createOrder($phone = null, $payOnDelivery = false)
    {
        $cart = Cart::toArray();
        $amount = $cart['total'];
        // if (session()->has('pay_in_full') && !$payOnDelivery) {
        //     $amount = $cart['total'];
        // }

        $referralCode = DB::table('referralcode_user')
            ->where('user_id', auth()->id())
            ->first();

        $notes = session()->get('notes');

        $data = [
            'user_id' => auth()->id(),
            'amount' => $cart['total'],
            'paid' => 0,
            'balance' => $cart['total'],
            'notes' => $notes,
            'location_id' => session()->get('checkout_address'),
            'paying_no' => $phone,
            'status' => Order::STATUS_PENDING_PAYMENT,
            'channel_id' => 1,
            'payment_on_delivery' => $payOnDelivery ? 1 : null,
        ];

        if ($referralCode && $referralCode->referralcode_id){
            $data = array_merge($data,[
                'referral_code_id' => $referralCode->referralcode_id,
            ]);
        }

        $order = Order::create($data);


        $addressId = session()->get('address_id');

        $order->stk_order_no = generateOrderNumber($order, true);
        $order->address_id = $addressId;
        $order->save();


        $this->createOrderItem($order);

        Cart::clear();
        session()->forget(['notes', 'address_id' ]);
        $response = [];

        $message =  "A new Order {$order->order_no} has been made.";

        (new SmsChannel)->notify(config('services.sms-line'), $message);

        if($phone && !$payOnDelivery) {
            $response = $this->requestPayment->viaStkPush($amount, $order->stk_order_no, $order->id, $phone);
        }
        $response['order'] = $order;

        return $response;
    }

    /**
     * Create order Items
     *
     * @param Order $order
     *
     * @return void
     */
    public function createOrderItem(Order $order)
    {
        $cart = Cart::toArray();
        foreach ($cart['items'] as $item) {
            if ($item->type == Product::TYPE_PRODUCT) {
                $this->createProductOrderItem($order, $item);
            } else {
                $this->createServiceOrderItem($order, $item);
            }
        }

        updateOrderPricing($order->id);

    }

    /**
     * Create Order product Item
     *
     * @param Order  $order
     * @param [type] $item
     *
     * @return void
     */
    public function createProductOrderItem(Order $order, $item)
    {
        $product =  (object) $item->product;

        OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->product_id,
                'category_id' => 1,
                'provider_id' => $product->supplier_id,
                'quantity' => $item->qty,
                'amount' =>  $item->qty * $product->amount,
                'provider_amount' => $item->qty * $product->supplier_price,
                'percentage_commission' => $product->mark_up_percentage,
                'type' => Product::TYPE_PRODUCT,
                'status' => OrderItem::STATUS_PENDING,
            ]);
    }

    /**
     * Create Service OrderItems.
     *
     * @return void
     */
    public function createServiceOrderItem(Order $order, $item)
    {
        $product =  (object) $item->product;
        OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'category_id' => 1,
                'provider_id' => $item->provider,
                'quantity' => $item->qty,
                'appointment_date' => $item->appointmentDate,
                'appointment_time' => $item->appointmentTime,
                'amount' =>  $item->qty * $product->final_price,
                'provider_amount' => $item->qty * $product->provider_cost,
                'percentage_commission' => $product->commission,
                'type' => Product::TYPE_SERVICE,
                'status' => OrderItem::STATUS_PENDING,
            ]);
    }
}
