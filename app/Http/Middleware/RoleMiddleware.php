<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $userRoles = auth()->payload()->get('roles');

        if (!array_intersect($roles, $userRoles)) {
            return response()->json(['error' => 'Forbidden'], 403);
        }
        // If the user has the required roles, proceed with the request.
        return $next($request);
    }
}
