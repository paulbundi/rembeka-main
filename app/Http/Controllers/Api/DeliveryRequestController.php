<?php

namespace App\Http\Controllers\Api;

use App\Models\DeliveryRequest;
use App\Models\Order;
use App\Models\TransportRequest;
use App\Models\WalletAudit;
use App\Notifications\SmsNotification;

class DeliveryRequestController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return DeliveryRequest::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'admin', 'order', 'order.items', 'driver',
        ];
    }

    /**
     * Approve transport on order.
     *
     * @param int $id
     *
     * @return void
     */
    public function approveTransport(int $id)
    {
        $trnsRequest = DeliveryRequest::with(['driver', 'order'])
            ->findOrFail($id);

        $previousBalance = $trnsRequest->driver->wallet;
        $trnsRequest->driver->wallet +=$trnsRequest->amount;
        $trnsRequest->driver->save();

        $trnsRequest->status = DeliveryRequest::STATUS_APPROVED;
        $trnsRequest->admin_id = auth()->id();
        $trnsRequest->save();


        Order::where('id', $trnsRequest->order_id)
            ->update(['driver_paid' => Order::DRIVER_PAID]);

        makeAudit(
            $trnsRequest->driver->id,
            'App\Models\User',
            'Ksh'.$trnsRequest->amount. ' delivery expense for order '. $trnsRequest->order->order_no,
            WalletAudit::CREDIT,
            auth()->id(),
            $trnsRequest->amount,
            $previousBalance,
        );

        $message = 'Hi '.$trnsRequest->driver->first_name .' your delivery expense for order number '.$trnsRequest->order->order_no .' has been credited to your wallet.';

        $trnsRequest->driver->notify(new SmsNotification($message));

        return response()->json();
    }

    /**
     * Approve transport on order.
     *
     * @param int $id
     *
     * @return void
     */
    public function dennyRequest(int $id)
    {
        $trnsRequest = DeliveryRequest::with(['driver', 'order'])
            ->findOrFail($id);
        $trnsRequest->status = DeliveryRequest::STATUS_DENIED;
        $trnsRequest->admin_id = auth()->id();
        $trnsRequest->save();

        return response()->json();
    }
}
