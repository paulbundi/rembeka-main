<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductPricing;

class OrderObserver
{
    /**
     * Listen for order created.
     *
     * @param Order $order
     *
     * @return void
     */
    public function created(Order $order)
    {
        $order->order_no = generateOrderNumber($order);
        $order->save();

        if($order->amount < 1) {
            updateOrderPricing($order->id);
        }
    }

    /**
     * Listen for updated.
     *
     * @param Order $order
     *
     * @return void
     */
    public function updated(Order $order)
    {
        if ($order->status == Order::STATUS_CANCELED) {
            $order->load('items');

            $order->items->each(function ($item) {
                if ($item->type == OrderItem::TYPE_PRODUCT) {
                    ProductPricing::where('id', $item->pricing_id)
                        ->increment('instock', $item->quantity);
                }
            });
        }else {
            updateOrderPricing($order->id);
        }
    }
}
