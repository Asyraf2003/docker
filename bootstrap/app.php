<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::prefix('admin')->name('admin.')->group(base_path('routes/admin.php'));
            Route::prefix('user')->name('user.')->group(base_path('routes/user.php'));
            Route::prefix('other')->name('other.')->group(base_path('routes/other.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'set.locale' => \App\Http\Middleware\SetLocale::class,
            'admin.2fa'  => \App\Http\Middleware\EnsureAdminHas2FA::class,
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {})
    ->withProviders(require __DIR__.'/providers.php')
    ->create();
