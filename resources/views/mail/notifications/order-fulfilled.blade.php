@component('mail::message')
# Order Fulfilled

Hello {{ $order->customer->first_name }},

Great news! Your order #{{ $order->order_no }} has been fulfilled and delivered.

## Order Summary
**Order Number:** #{{ $order->order_no }}  
**Total Amount:** KES {{ number_format($order->amount, 2) }}  
**Order Date:** {{ $order->created_at->format('M d, Y') }}

We hope you're satisfied with your purchase. Please consider leaving a review to help us improve our services.

@component('mail::button', ['url' => url('/account/orders/' . $order->id)])
View Order
@endcomponent

Thank you for choosing Rembeka!

{{ config('app.name') }}
@endcomponent