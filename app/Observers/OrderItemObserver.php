<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderItem;

class OrderItemObserver
{
    /**
     * check if item is delitable.
     *
     * @param OrderItem $item
     *
     * @return void
     */
    public function deleting(OrderItem $item)
    {
        $item->load(['order']);

        if (in_array($item->order->status, [
            Order::STATUS_FULFILLED ,
            Order::STATUS_PARTIAL_RATING,
            Order::STATUS_COMPLETED ,
        ])) {
            return false;
        }
    }

    public function deleted(OrderItem $item)
    {
        updateOrderPricing($item->order_id);
    }
}
