<?php

// Middleware
use App\Http\Middleware\ClientToken;
use App\Http\Middleware\JwtToken;

// Custom Error Handler
use App\Exceptions\CustomErrorHandler;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        apiPrefix: '',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('auth.client', [ClientToken::class]);
        $middleware->appendToGroup('auth.client.jwt', [
            ClientToken::class,
            JwtToken::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (\Exception $e) {
            return CustomErrorHandler::handler($e);
        });
    })->create();
