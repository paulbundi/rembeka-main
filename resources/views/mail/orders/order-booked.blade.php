@component('mail::message')
Hi,

A new Order ({{ $order->order_no }}) from {{ $order->customer->first_name}} has been booked. 

Kindly review and action.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
