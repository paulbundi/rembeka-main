@component('mail::message')
# Password Reset Request

Hello,

You recently requested to reset your password for your Rembeka account.

@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

This password reset link will expire in 60 minutes.

If you did not request this password reset, no further action is required. Your password will remain unchanged.

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent