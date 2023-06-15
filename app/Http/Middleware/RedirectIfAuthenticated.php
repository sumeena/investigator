<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @param string|null ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if (!Auth::guard($guard)->user()->userRole) {
                    return redirect('/login');
                }
                if (Auth::guard($guard)->user()->userRole->role == 'hiring-manager') {
                    return redirect('/hm');
                } else if (Auth::guard($guard)->user()->userRole->role == 'company-admin') {
                    return redirect('/company-admin/profile');
                } else if (Auth::guard($guard)->user()->userRole->role == 'investigator') {
                    return redirect('/investigator/profile');
                } else if (Auth::guard($guard)->user()->userRole->role == 'admin') {
                    return redirect('/admin');
                } else {
                    Auth::guard($guard)->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return redirect('/login');
                }
            } else {
                return redirect('/login');
            }
        }

        return $next($request);
    }
}
