<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check() && (Auth::user()->user_type == 1 || Auth::user()->user_type == 0)) {
            return redirect('/admin/dashboard');
        } 

        if (Auth::guard($guard)->check() && Auth::user()->user_type == 3) {
            return redirect('/');
        } 

        return $next($request);
    }
}
