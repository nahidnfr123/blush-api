<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // For Laravel Passport ...
//        return $next($request)
//            ->header('Access-Control-Allow-Origin', '*')
//            ->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS')
//            ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Token-Auth, Authorization');

        // For sanctum ...
        $allowedOrigins = [
            config('app.frontend_url'),
        ];
        $requestOrigin = $request->headers->get('origin');

        if (in_array($requestOrigin, $allowedOrigins)) {
            return $next($request)
                ->header('Access-Control-Allow-Origin', $requestOrigin)
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE')
                ->header('Access-Control-Allow-Credentials', 'true')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }

        return $next($request);
    }
}
