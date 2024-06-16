<?php

use App\Http\Middleware\Cors;
use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsVendor;
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
    ->withBroadcasting(
        __DIR__ . '/../routes/channels.php',
        ['prefix' => 'api', 'middleware' => ['api', 'auth:api']],
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('api', [
            ForceJsonResponse::class,
            Cors::class,
        ]);
        $middleware->alias([
            'json' => ForceJsonResponse::class,
            'cors' => Cors::class,

            'scopes' => \Laravel\Passport\Http\Middleware\CheckScopes::class,
            'scope' => \Laravel\Passport\Http\Middleware\CheckForAnyScope::class,
//            'abilities' => CheckAbilities::class,
//            'ability' => CheckForAnyAbility::class,
            'is_admin' => IsAdmin::class,
            'is_vendor' => IsVendor::class,

            // spatie permission middleware
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
