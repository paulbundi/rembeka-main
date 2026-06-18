<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    public function __construct(string $token, string $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        $url = url('/reset-password/' . $this->token . '?email=' . urlencode($this->email));

        return $this->subject('Reset Your Password - ' . config('app.name'))
            ->markdown('mail.notifications.password-reset', ['url' => $url]);
    }
}