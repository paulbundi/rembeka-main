@component('mail::message')
# Welcome to Rembeka!

Hi {{ $user->first_name ?? $user->name }},

Thank you for joining Rembeka - where conveniently beautiful matters!

We're excited to have you as part of our community. Here's what you can do:

- Browse our collection of services and products
- Book appointments with top stylists
- Track your orders and deliveries
- Earn loyalty points on every purchase

@component('mail::button', ['url' => url('/login')])
Get Started
@endcomponent

If you have any questions, feel free to reach out to us.

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent