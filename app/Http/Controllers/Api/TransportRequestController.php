<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\TransportRequest;
use App\Models\WalletAudit;
use App\Notifications\SmsNotification;

class TransportRequestController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return TransportRequest::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'user', 'order', 'order.items', 'provider',
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
        $trnsRequest = TransportRequest::with(['provider', 'order'])
            ->findOrFail($id);

        $previousBalance = $trnsRequest->provider->wallet;
        $trnsRequest->provider->wallet +=$trnsRequest->amount;
        $trnsRequest->provider->save();

        $trnsRequest->status = TransportRequest::STATUS_APPROVED;
        $trnsRequest->admin_id = auth()->id();
        $trnsRequest->save();

        makeAudit(
            $trnsRequest->provider->id,
            'App\Models\User',
            'Ksh'.$trnsRequest->amount. ' transport expense for order '. $trnsRequest->order->order_no,
            WalletAudit::CREDIT,
            auth()->id(),
            $trnsRequest->amount,
            $previousBalance,
        );

        $message = 'Hi '.$trnsRequest->provider->first_name .' your transport expense for order number '.$trnsRequest->order->order_no .' has been credited to your wallet.';

        $trnsRequest->provider->notify(new SmsNotification($message));

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
        $trnsRequest = TransportRequest::with(['provider', 'order'])
            ->findOrFail($id);
        $trnsRequest->status = TransportRequest::STATUS_DENIED;
        $trnsRequest->admin_id = auth()->id();
        $trnsRequest->save();

        return response()->json();
    }
}
