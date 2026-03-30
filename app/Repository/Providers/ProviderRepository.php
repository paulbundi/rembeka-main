<?php

namespace App\Repository\Providers;

use App\Models\MpesaBTCTransaction;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class ProviderRepository
{
    /**
     * generate Provider Dashboard data.
     *
     * @param int $id
     *
     * @return array
     */
    public function dashboard(int $id):array
    {
        $user =  User::where('organization_id', $id)->first();

        $withdrawAmount = MpesaBTCTransaction::where('user_id', $user->id)
            ->where('status', MpesaBTCTransaction::CONFIRMED)
            ->sum('amount');
        $withdrawTransactions = MpesaBTCTransaction::where('user_id', $user->id)->paginate();

        $completedOrders = Order::whereIn('status', [Order::STATUS_PARTIAL_DELIVERY, Order::STATUS_FULFILLED, Order::STATUS_PARTIAL_RATING, Order::STATUS_COMPLETED,
        ])->whereHas('items', function ($query) use ($id) {
            return $query->where('provider_id', $id)
            ->where('type', OrderItem::TYPE_SERVICE);
        })
        ->with(['location', 'customer', 'items.product', 'items' => function ($query) use ($id) {
            return $query->where('provider_id', $id);
        }])
        ->get();

        $pendingOrders = Order::whereHas('items', function ($query) use ($id) {
            return $query->where('provider_id', $id)
            ->where('type', OrderItem::TYPE_SERVICE);
        })->whereIn('status', [Order::STATUS_WAITING_CONFIRMATION, Order::STATUS_PENDING_PAYMENT, Order::STATUS_ORDER_CONFIRMED,
        ])->with(['location', 'customer', 'items.product', 'items' => function ($query) use ($id) {
            return $query->where('provider_id', $id);
        }])->get();

        $earnings = 0;

        $completedOrders->each(function ($order) use (&$earnings) {
            $order->items->each(function ($item) use (&$earnings) {
                $earnings += $item->provider_amount;
            });
        });

        $pendingIncome = 0;
        $pendingOrders->each(function ($order) use (&$pendingIncome) {
            $order->items->each(function ($item) use (&$pendingIncome) {
                $pendingIncome += $item->provider_amount;
            });
        });

        return  [
            'completedOrders' => $completedOrders,
            'pendingOrders' => $pendingOrders,
            'earnings' => $earnings,
            'pendingIncome' => $pendingIncome,
            'user' => $user,
            'withdrawAmount' => $withdrawAmount,
            'withdrawTransactions' => $withdrawTransactions,
        ];
    }
}
