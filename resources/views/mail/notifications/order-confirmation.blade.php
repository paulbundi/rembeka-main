@component('mail::message')
# Order Confirmation

Hello {{ $order->customer->first_name }},

Thank you for your order! We have received your request and are processing it.

## Order Details

**Order Number:** #{{ $order->order_no }}  
**Total Amount:** KES {{ number_format($order->amount, 2) }}  
**Amount Paid:** KES {{ number_format($order->paid, 2) }}  
**Balance:** KES {{ number_format($order->balance, 2) }}  
**Order Date:** {{ $order->created_at->format('M d, Y') }}

@component('mail::button', ['url' => url('/account/orders/' . $order->id)])
View Order Details
@endcomponent

You will receive updates as your order progresses. Our stylists will contact you shortly.

Thanks for choosing Rembeka!

{{ config('app.name') }}
@endcomponent