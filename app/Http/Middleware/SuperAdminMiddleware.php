<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && (auth()->user()->hasRole('Super Admin') || auth()->user()->getAllPermissions()->isNotEmpty())) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized, only Super Admins with permissions are allowed'], 403);
    }

}
