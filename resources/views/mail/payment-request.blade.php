@component('mail::message')
# Hi {{$order->customer->first_name}}

Thank you for shopping with rembeka. Kindly make a payment of Kshs <b>{{$order->balance}} </b> to paybill number <b>{{ config('services.paybill_no') }}</b> and use <b>{{$order->order_no}}</b> as the account.

Also, find attached the invoice details.

Thanks for shopping with us,<br>
{{ config('app.name') }}
@endcomponent
