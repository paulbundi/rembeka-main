<?php

namespace App\Repository\Payment;

use App\Models\MpesaTopUpTransaction;
use SmoDav\Mpesa\Laravel\Facades\STK;

class RequestMpesaPayment
{
    /**
     * Request payment via stkpush Mpesa Deposit.
     *
     * @param int $amount
     *
     * @return array
     */
    public static function viaStkPush(int $amount, $orderNo, $orderId = null, $phone = null): array
    {
        $phone = '254'.($phone ? substr($phone, -9) : substr(auth()->user()->phone, -9));

        $response = STK::request($amount)
            ->from($phone)
            ->usingReference($orderNo, 'Payment')
            ->push();

        if (property_exists($response, 'errorCode') || $response->ResponseCode != '0') {
            return [
                'type' => 'error',
                'notice' => $response->errorMessage ?? 'error',
            ];
        }

        $data = [
            'user_id' => auth()->id(),
            'amount' => $amount,
            'merchant_request_id' => $response->MerchantRequestID,
            'checkout_request_id' => $response->CheckoutRequestID,
            'response_code' => $response->ResponseCode,
            'response_description' => $response->ResponseDescription,
            'customer_message' => $response->CustomerMessage,
            'reference_id' => $orderNo,
            'trans_id' =>  $orderNo,
            'active_phone_number' => $phone,
        ];

        if ($orderId != null) {
            $data = array_merge($data, [
                'order_id' => $orderId,
            ]);
        }
        MpesaTopUpTransaction::create($data);

        return [
            'type' => 'success',
            'notice' =>'A payment request has been pushed to your phone, Please check request to complete your order.',
        ];
    }
}
