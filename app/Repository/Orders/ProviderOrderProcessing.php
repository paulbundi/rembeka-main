<?php

namespace App\Repository\Orders;

use App\Mail\OrderBooked;
use App\Models\Order;
use App\Notifications\SmsNotification;
use Illuminate\Support\Facades\Mail;

class ProviderOrderProcessing
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
        $this->notifyProvider();
    }

    /**
     * Notify order item Providers.
     *
     * @return void
     */
    public function notifyProvider()
    {
        //TODO fix to pick unique providers
        $items = $this->order->items->sortBy('id')->unique();
        $message = 'New order  No. '.$this->order->order_no.' for '.$this->order->customer->first_name.' has been placed.';
        $items->each(function ($item) use ($message) {
            $item->provider->notify(new SmsNotification($message));
            Mail::to($item->provider)
                ->queue(new OrderBooked($item->provider, $this->order));
        });
    }
}
