<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'refresh.role' => \App\Http\Middleware\RefreshUserRole::class,
            // 'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
        
        // Add RefreshUserRole middleware to web group to run on all web requests
        $middleware->appendToGroup('web', \App\Http\Middleware\RefreshUserRole::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
