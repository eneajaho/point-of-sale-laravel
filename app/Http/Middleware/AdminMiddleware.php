<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->isAdmin() || Auth::user()->isManager()) {
            return $next($request);
        } else {
            return response()->json(['error' => 'Only Administrator can access this route!'], 401);
        }
    }
}
