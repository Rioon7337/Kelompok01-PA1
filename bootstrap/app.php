<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Tambahkan CSRF validation
        $middleware->validateCsrfTokens(except: [
            // Tambahkan route yang perlu dikecualikan (opsional)
            // '/login',
            // '/register',
        ]);
        
        // Trust all proxies (important for Railway)
        $middleware->trustProxies(at: '*');
        
        // Session configuration
        $middleware->web(append: [
            \Illuminate\Session\Middleware\StartSession::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
