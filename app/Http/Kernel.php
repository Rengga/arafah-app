<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
    ];

    protected $middlewareGroups = [
        'web' => [
            // middleware web
        ],

        'api' => [
            // middleware api
        ],
    ];

    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,

        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ];
}