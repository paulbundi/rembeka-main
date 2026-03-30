@component('mail::message')
# Hi {{$order->customer->first_name}}

We have created an order for you on Rembeka Online platform, 
Kindly see attached details for the order.

To make payments, use mpesa baybill number {{config('services.paybill_no')}} and {{$order->order_no}} as the 
account number.

Thanks for choosing Rembeka Online Limited,<br>
{{ config('app.name') }}
@endcomponent
