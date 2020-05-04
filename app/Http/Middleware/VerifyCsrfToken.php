<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/logout', '/api/company/balance/set', '/liqpay/status', '/liqpay/server', 'api/image/upload', 'bigmarketing/liqpay/server', 'bigmarketing/liqpay/status', 'api/xml/upload/rozetka', 'api/xml/upload/prom', 'api/xml/upload/zakupka'
    ];
}
