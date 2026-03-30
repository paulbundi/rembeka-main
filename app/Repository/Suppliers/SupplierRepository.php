<?php

namespace App\Repository\Suppliers;

use App\Models\MpesaBTCTransaction;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Supplier;

class SupplierRepository
{
    /**
     * generate Provider Dashboard data.
     *
     * @param int $id
     *
     * @return array
     */
    public function dashboard(int $userId):array
    {
        $supplier = Supplier::where('id', $userId)
            ->with(['user'])
            ->first();

        $withdrawAmount = MpesaBTCTransaction::where('user_id', $supplier->user->id)
            ->where('status', MpesaBTCTransaction::CONFIRMED)
            ->sum('amount');
        $withdrawTransactions = MpesaBTCTransaction::where('user_id', $supplier->user->id)->paginate();

        $completedOrders = Order::whereIn('status', [Order::STATUS_PARTIAL_DELIVERY, Order::STATUS_FULFILLED, Order::STATUS_PARTIAL_RATING, Order::STATUS_COMPLETED,
        ])->whereHas('items', function ($query) use ($userId) {
            return $query->where('provider_id', $userId)
            ->where('type', OrderItem::TYPE_PRODUCT);
        })
        ->with(['location', 'customer', 'items.product', 'items' => function ($query) use ($userId) {
            return $query->where('provider_id', $userId);
        }])
        ->get();

        $pendingOrders = Order::whereHas('items', function ($query) use ($userId) {
            return $query->where('provider_id', $userId)
                ->where('type', OrderItem::TYPE_PRODUCT);
        })->whereIn('status', [Order::STATUS_WAITING_CONFIRMATION, Order::STATUS_PENDING_PAYMENT, Order::STATUS_ORDER_CONFIRMED,
        ])->with(['location', 'customer', 'items.product', 'items' => function ($query) use ($userId) {
            return $query->where('provider_id', $userId);
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
            'supplier' => $supplier,
            'withdrawAmount' => $withdrawAmount,
            'withdrawTransactions' => $withdrawTransactions,
            'user' => $supplier->user,
        ];
    }
}
