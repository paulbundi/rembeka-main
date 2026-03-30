<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'b2c_results',
        'b2c_timeout',
        'payment_confirmation',
        'payment_validation',
        'status/callback',
        'sms/callback',
    ];
}
