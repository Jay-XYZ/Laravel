<?php
namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's middleware aliases.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        'role' => \App\Http\Middleware\CheckRole::class,
        'token.message' => \App\Http\Middleware\TokenMessageMiddleware::class,
    ];
}