<?php

use App\Http\Middleware\setLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Router;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        using: function (Router $router) {

            $router->middleware('web')
                ->namespace('App\Http\Controllers')
                ->group(base_path('routes/web.php'));

            $router->middleware('web')
                ->namespace('App\Http\Controllers\dashboard')
                ->group(base_path('routes/dashboard/web.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->alias([
            'local_middleware' => setLocale::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
