<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'CheckBlockedAccount' => \App\Http\Middleware\CheckBlockedAccount::class,
            'checkRole' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (HttpException $exception, Request $request) {
            if ($request->is(['admin', 'admin/*'])) {
                if ($exception->getStatusCode() == 404) {
                    return response()->view("errors.404-admin", [], 404);
                }
            }

            if ($exception->getStatusCode() == 404) {
                return response()->view("errors.404", [], 404);
            }
        });
    })->create();