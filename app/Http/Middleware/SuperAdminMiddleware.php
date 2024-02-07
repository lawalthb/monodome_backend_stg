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


        // && auth()->user()->hasRole('Super Admin')
        if (auth()->check() ) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized, only super admin allow'], 403);
    }
}
