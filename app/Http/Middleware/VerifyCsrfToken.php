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
        // 'broadcasting/auth',
        'paystack/*',
        'paystack/webhooks/*',
        '/subscription/webhook',
        '/payment/webhook',
        'paystack',
        'api/v1/*',
        'api/*'
    ];
}
