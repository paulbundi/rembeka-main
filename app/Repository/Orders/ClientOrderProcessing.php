<?php

namespace App\Repository\Orders;

use App\Mail\OrderPlaced;
use App\Models\Order;
use App\Notifications\SmsNotification;
use Illuminate\Support\Facades\Mail;

class ClientOrderProcessing
{
    /**
     * @var Order
     */
    protected $order;

    public function __construct(Order $order)
    {
        $order = Order::where('id', $order->id)
            ->with(['customer', 'items.provider'])
            ->first();
        $this->order = $order;
        $this->notifyClient();
    }

    /**
     * @return void
     */
    public function notifyClient(): void
    {
        $message = 'Hi '.$this->order->customer->first_name. ', Thank you for shopping with Rembeka. Your order number '.
            $this->order->order_no.' is being processed. An email with the order details has been sent to '
            .$this->order->customer->email;

        $this->order->customer->notify(new SmsNotification($message));

        $this->orderInvoiceMail();
    }

    /**
     * send Email notification for payment.
     *
     * @return void
     */
    public function orderInvoiceMail()
    {
        Mail::to($this->order->customer)
            ->queue(new OrderPlaced($this->order));
    }
}
