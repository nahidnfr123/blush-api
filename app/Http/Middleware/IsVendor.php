<?php

namespace App\Http\Middleware;

use App\Enums\GuardEnums as Guard;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsVendor
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guard = Guard::Vendor->value;

        if (!auth($guard)->check() || !auth($guard)->user()->tokenCan('check-vendor')) {
            return $this->failure('Unauthorized.', 401);
        }
        $user = Auth::guard($guard)->user();
        if (!$user->hasAnyRole('vendor admin', 'vendor user')) {
            return $this->failure('Unauthorized.', 401);
        }
        $checkTokenDate = Carbon::now();
        $tokenEndData = Auth::guard($guard)?->user()?->token()?->expires_at;
        $tokenEndData = Carbon::parse($tokenEndData);

        $dateResult = $tokenEndData->gte($checkTokenDate);
        if (!$dateResult) {
            return $this->failure('Token Expired.', 401);
        }

        return $next($request);
    }
}
