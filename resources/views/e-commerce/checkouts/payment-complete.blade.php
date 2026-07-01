@extends('layouts.e-commerce')
@section('content')
<main>
    <div class="container" style="margin-top:8em;">
        <section class="">
            <div class="container-fluid d-flex flex-column align-items-center">
                <div class="order-complete-container">
                    <i class="bi bi-bag-check-fill fs-1"></i>
                    @if(isset($payment_method) && $payment_method === 'paystack')
                        <h1 class="section-title blue mt-4">Payment Successful!</h1>
                        <p class="summary">
                            Thank you, Your payment has been processed successfully. Your order ID is: {{ $order->order_no }} of amount: Ksh {{number_format((float)$order->amount)}}. Please check your email for details. Please note Orders placed after 6pm will be fulfilled on the next day from 9am. Call or Whatsapp us for any clarification on +254789311440.
                        </p>
                        <div class="mt-3">
                            <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
                        </div>
                    @else
                        <h1 class="section-title blue mt-4">Order Placed!</h1>
                        <p class="summary">
                            Thank you, Your order has been placed. Your order ID is: {{ $order->order_no }} of amount: Ksh {{number_format((float)$order->amount)}} ( exclusive of delivery fees). Please check your email for details. Please note Orders placed after 6pm will be fulfilled on the next day from 9am. Call or Whatsapp us for any clarification on +254789311440.
                        </p>
                    @endif
                </div>
            </div>
        </section>
    </div>
</main>
@endsection