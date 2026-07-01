<?php

namespace App\Repository\Payment;

use App\Models\PaystackPayment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackService
{
    protected $baseUrl;
    protected $secretKey;

    public function __construct()
    {
        $this->baseUrl = 'https://api.paystack.co';
        $this->secretKey = trim(config('services.paystack.secret'));

        if (empty($this->secretKey)) {
            Log::error('Paystack secret key is missing. Set PAYSTACK_SECRET_KEY in .env');
        }
    }

    public function initializePayment(int $amount, string $email, int $orderId, int $userId): array
    {
        $reference = 'ps_' . uniqid() . '_' . $orderId;
        $amountInKobo = $amount * 100;

        try {
            if (empty($this->secretKey)) {
                return [
                    'type' => 'error',
                    'notice' => 'Payment gateway is not configured. Please contact support.',
                ];
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/transaction/initialize', [
                'amount' => $amountInKobo,
                'email' => $email,
                'reference' => $reference,
                'callback_url' => route('paystack.callback'),
                'metadata' => [
                    'order_id' => $orderId,
                    'user_id' => $userId,
                ],
            ]);

            $data = $response->json();

            if (!$response->successful() || !($data['status'] ?? false)) {
                return [
                    'type' => 'error',
                    'notice' => $data['message'] ?? 'Failed to initialize Paystack payment',
                ];
            }

            $payment = PaystackPayment::create([
                'user_id' => $userId,
                'order_id' => $orderId,
                'reference' => $reference,
                'amount' => $amount,
                'authorization_url' => $data['data']['authorization_url'] ?? null,
                'access_code' => $data['data']['access_code'] ?? null,
                'status' => 'pending',
            ]);

            return [
                'type' => 'success',
                'authorization_url' => $data['data']['authorization_url'],
                'reference' => $reference,
                'payment' => $payment,
            ];
        } catch (\Exception $e) {
            Log::error('Paystack initialization failed: ' . $e->getMessage());
            return [
                'type' => 'error',
                'notice' => 'Failed to connect to payment gateway',
            ];
        }
    }

    public function verifyPayment(string $reference): array
    {
        try {
            if (empty($this->secretKey)) {
                return [
                    'type' => 'error',
                    'notice' => 'Payment gateway is not configured. Please contact support.',
                ];
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ])->get($this->baseUrl . '/transaction/verify/' . $reference);

            $data = $response->json();

            if (!$response->successful() || !($data['status'] ?? false)) {
                return [
                    'type' => 'error',
                    'notice' => $data['message'] ?? 'Failed to verify payment',
                ];
            }

            $payment = PaystackPayment::where('reference', $reference)->first();
            
            if ($payment) {
                $payment->status = $data['data']['status'] === 'success' ? 'success' : 'failed';
                $payment->transaction_id = $data['data']['id'] ?? null;
                $payment->paid_at = $data['data']['paid_at'] ?? null;
                $payment->save();
            }

            return [
                'type' => 'success',
                'status' => $data['data']['status'],
                'payment' => $payment,
                'data' => $data['data'],
            ];
        } catch (\Exception $e) {
            Log::error('Paystack verification failed: ' . $e->getMessage());
            return [
                'type' => 'error',
                'notice' => 'Failed to verify payment',
            ];
        }
    }

    public function handleWebhook(array $data): array
    {
        $event = $data['event'] ?? null;
        $transaction = $data['data'] ?? null;

        if (!$event || !$transaction) {
            return ['type' => 'error', 'notice' => 'Invalid webhook payload'];
        }

        $payment = PaystackPayment::where('reference', $transaction['reference'])->first();

        if (!$payment) {
            return ['type' => 'error', 'notice' => 'Payment not found'];
        }

        if ($event === 'charge.success' && ($transaction['status'] ?? null) === 'success') {
            $payment->status = 'success';
            $payment->transaction_id = $transaction['id'] ?? null;
            $payment->paid_at = now();
            $payment->save();

            return ['type' => 'success', 'payment' => $payment];
        }

        return ['type' => 'success', 'payment' => $payment];
    }
}