<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\FarmerLoginCheck;
use App\Http\Middleware\CustomerLoginCheck;
use App\Http\Middleware\AdminLoginMiddleware;
use App\Http\Middleware\CheckSession;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAuthenticated;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global middleware
        $middleware->use([
        ]);

        // Route middleware aliases
        $middleware->alias([
            'auth'           => Authenticate::class,
            'guest'          => RedirectIfAuthenticated::class,
            'admin.check'    => AdminLoginMiddleware::class,
            'farmer.check'   => FarmerLoginCheck::class,
            'customer.check' => CustomerLoginCheck::class,
            'check.session'  => CheckSession::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // configure exception handling if needed
    })->create();
