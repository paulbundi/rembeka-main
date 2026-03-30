<?php

namespace App\Http\Controllers\Api;

use App\Models\MpesactobDeposit;
use App\Models\Order;
use App\Repository\Payment\MpesaValidationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CtobController extends AbstractApiController
{
    /**
     * get current model.
     *
     * @return string
     */
    protected function getModel(): string
    {
        return MpesactobDeposit::class;
    }

    /**
     * Get the allowed includes.
     *
     * @return array
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'user', 'order',
        ];
    }


    /**
     * Confirm c2b payments
     *
     * @param Request $request
     * @return void
     */
    public function confirmPayment(Request $request)
    {
        $data = $request->validate([
            'transaction_id' => 'required',
        ]);


        if(Cache::get($data['transaction_id'])) {
            return response()->json([
                'errors' => [
                    'error' => ['Give it a min and try again!'],
                ]
            ], 400);
        }else {
            Cache::put($data['transaction_id'], auth()->id(), 60);
        }


        if (MpesactobDeposit::where('trans_id', $data['transaction_id'])->exists()) {
            return response()->json([
                'errors' => [
                    'error' => ['That transaction code is already used!'],
                ]
            ], 400);
        }


        $validate = new MpesaValidationRepository();
        return $validate->validateCtoBTransaction($data['transaction_id']);
    }

    /**
     * AttachPayment To order
     *
     * @param Request $request
     * @return void
     */
    public function attachPaymentToOrder(Request $request)
    {
        $data = $request->validate([
            'orderNo' => 'required',
            'payment_id' => 'required',
        ]);

        $order = Order::where('order_no', $data['orderNo'])->first();

        $payment = MpesactobDeposit::where('id', $data['payment_id'])->first();

        if (!$order || $order->paid == $order->amount) {
            return response()->json(['message' =>[
                'type' => 'error',
                'message' => 'Order is already fully paid',
            ]], 400);
        }

        if ($payment->trans_id != null && $payment->bill_ref_id != null) {

            return response()->json(['message' =>[
                'type' => 'error',
                'message' => 'Transaction already linked',
            ]], 400);
        }

        $order->paid += $payment->amount;
        $order->balance -= $payment->amount;

        if ($order->status == Order::STATUS_PENDING_PAYMENT) {
            $order->status = Order::STATUS_ORDER_CONFIRMED;
        }
        $order->save();

        

        $payment->trans_id = $order->order_no;
        $payment->bill_ref_no = $order->order_no;
        $payment->order_id = $order->id;
        $payment->save();


        return response()->json(
            [
                'message' => [
                    'type' => 'success',
                    'message' => 'Order Paid successfully',
                ]
            ]
        );
    }
}
