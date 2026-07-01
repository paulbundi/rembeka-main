<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaystackPayment;
use App\Models\Order;
use App\Jobs\PaymentValidated;
use App\Repository\Cart\CartRepository;
use App\Repository\Payment\PaystackService;
use Illuminate\Http\Request;

class PaystackController extends Controller
{
    public function initialize(Request $request, PaystackService $paystackService, CartRepository $cartRepository)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $orderResponse = $cartRepository->createPaystackOrder($request->phone ?? auth()->user()->phone);
        
        $order = $orderResponse['order'];
        $amount = (int) round((float) $order->balance);

        $response = $paystackService->initializePayment(
            $amount,
            $validated['email'],
            $order->id,
            auth()->id()
        );

        if (isset($response['type']) && $response['type'] === 'error') {
            return response()->json($response, 422);
        }

        return response()->json($response);
    }

    public function callback(Request $request, PaystackService $paystackService)
    {
        $reference = $request->query('trxref');

        if (!$reference) {
            return redirect()->route('home')->with([
                'message' => [
                    'type' => 'error',
                    'message' => 'Invalid payment reference',
                ],
            ]);
        }

        $response = $paystackService->verifyPayment($reference);

        if (isset($response['type']) && $response['type'] === 'success' && $response['status'] === 'success') {
            $payment = $response['payment'];
            $order = $payment->order;

            if ($order) {
                PaymentValidated::dispatch($order);
            }

            return view('e-commerce.checkouts.payment-complete', [
                'order' => $order,
                'payment_method' => 'paystack',
            ]);
        }

        $payment = PaystackPayment::where('reference', $reference)->first();
        $order = $payment ? $payment->order : null;

        return view('e-commerce.checkouts.payment-mode', [
            'response' => [
                'type' => 'error',
                'notice' => $response['notice'] ?? 'Payment verification failed',
                'order' => $order,
            ],
        ]);
    }

    public function webhook(Request $request, PaystackService $paystackService)
    {
        $secret = config('services.paystack.webhook_secret');
        
        $signature = $request->header('x-paystack-signature');
        $payload = $request->getContent();

        if ($secret && $signature && hash_hmac('sha512', $payload, $secret) !== $signature) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $data = $request->all();
        $result = $paystackService->handleWebhook($data);

        if (isset($result['type']) && $result['type'] === 'success') {
            $payment = $result['payment'];
            if ($payment->status === 'success') {
                $order = $payment->order;
                if ($order) {
                    PaymentValidated::dispatch($order);
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}