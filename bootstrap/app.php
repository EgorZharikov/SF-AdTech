<?php

use App\Http\Middleware\CheckBanned;
use App\Http\Middleware\checkWalletBalance;
use App\Http\Middleware\Dashboard;
use App\Http\Middleware\IsAdministrator;
use App\Http\Middleware\IsAdvertiser;
use App\Http\Middleware\IsWebmaster;
use App\Http\Middleware\Subscribed;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'webmaster' => IsWebmaster::class,
            'advertiser' => IsAdvertiser::class,
            'administrator' => IsAdministrator::class,
            'subscribed' => Subscribed::class,
            'checkWalletBalance' => checkWalletBalance::class,
            'dashboard' => Dashboard::class,
            'checkBanned' => CheckBanned::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
