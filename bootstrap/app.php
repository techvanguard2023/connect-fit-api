<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Aliases de middleware (usados nas rotas)
        $middleware->alias([
            'auth'     => \App\Http\Middleware\Authenticate::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

            // seus aliases
            'user'     => \App\Http\Middleware\EnsureIsUser::class,
            'customer'  => \App\Http\Middleware\EnsureIsCustomer::class,
            'employee' => \App\Http\Middleware\EnsureIsEmployee::class,
        ]);

        // (Opcional) adicionar a grupos existentes, se quiser:
        // $middleware->appendToGroup('api', \App\Http\Middleware\AlgumGlobalParaApi::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();