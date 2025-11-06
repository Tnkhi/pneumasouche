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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'check.activity' => \App\Http\Middleware\CheckUserActivity::class,
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
        
        // Exclure la route de login de la vérification CSRF
        $middleware->validateCsrfTokens(except: [
            'login'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
