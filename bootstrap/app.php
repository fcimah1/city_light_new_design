<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// use Laravel\Socialite\Facades\Socialite;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'user' => \App\Http\Middleware\IsUser::class,
            'auth' => \App\Http\Middleware\Authenticate::class,
            'admin_auth' => \App\Http\Middleware\AdminAuthenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'app_language' => \App\Http\Middleware\AppLanguage::class,
            'admin' => \App\Http\Middleware\IsAdmin::class,
            'seller' => \App\Http\Middleware\IsSeller::class,
            'unbanned' => \App\Http\Middleware\IsUnbanned::class,
            'checkout' => \App\Http\Middleware\CheckoutMiddleware::class,
            'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
            'redirect.based.on.country' => \App\Http\Middleware\RedirectBasedOnCountry::class,
            'verifiedNot' => \App\Http\Middleware\verfirdNot::class,

        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
