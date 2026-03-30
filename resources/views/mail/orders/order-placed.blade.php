@component('mail::message')
# Hi {{$order->customer->first_name}}

Your order payment has been received and dispatched.

Kindly find attached payment details for your order.


Thanks for shopping with us,<br>
{{ config('app.name') }}
@endcomponent
