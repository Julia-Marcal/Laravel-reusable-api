<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Cache\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        app(RateLimiter::class)->for('global', function ($request) {
            return Limit::perMinute(100)->by($request->ip());
        });

        $middleware->append(\Illuminate\Routing\Middleware\ThrottleRequests::class . ':global');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
