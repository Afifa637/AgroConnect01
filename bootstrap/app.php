<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\FarmerLoginCheck;
use App\Http\Middleware\CustomerLoginCheck;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global middleware
        $middleware->use([
            // example: \App\Http\Middleware\TrustProxies::class,
            // example: \App\Http\Middleware\CheckForMaintenanceMode::class,
        ]);

        // Route middleware aliases
        $middleware->alias([
            'farmer.check'   => FarmerLoginCheck::class,
            'customer.check' => CustomerLoginCheck::class,
        ]);
        
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // configure exception handling if needed
    })->create();
