@component('mail::message')
# Order Status Update

Hello {{ $order->customer->first_name }},

The status of your order #{{ $order->order_no }} has been updated.

## New Status
{{ $statusMessage }}

## Order Summary
**Order Number:** #{{ $order->order_no }}  
**Total:** KES {{ number_format($order->amount, 2) }}  
**Status:** {{ $order->getStatusLabel() }}

@component('mail::button', ['url' => url('/account/orders/' . $order->id)])
View Order
@endcomponent

Track your order progress anytime in your account.

{{ config('app.name') }} Team
@endcomponent