<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Provider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderBooked extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var Provider
     */
    protected $provider;

    /**
     * @var Order
     */
    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Provider $provider, Order $order)
    {
        $this->provider = $provider;
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //TODO optimise this by loading from memory -> order->items->filter;
        $items = OrderItem::where('provider_id', $this->provider->id)
            ->where('order_id', $this->order->id)
            ->with(['product'])
            ->get();

        return $this->markdown('mail.orders.order-booked', [
            'items' => $items,
            'order' => $this->order,
        ]);
    }
}
