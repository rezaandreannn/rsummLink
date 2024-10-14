<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogSessionExpiry
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Mengecek jika sesi habis berdasarkan last_activity
        if (
            Auth::check() && Session::has('last_activity') &&
            now()->diffInMinutes(Session::get('last_activity')) > config('session.lifetime')
        ) {
            // Log saat sesi habis
            activity()
                ->causedBy(Auth::user())
                ->event('expired')
                ->log('User session expired');

            Auth::logout();
            Session::invalidate();
            return redirect('/login'); // redirect ke login
        }

        Session::put('last_activity', now());

        return $next($request);
    }
}
