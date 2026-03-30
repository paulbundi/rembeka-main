@component('mail::message')

{{ $campaign->message }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
