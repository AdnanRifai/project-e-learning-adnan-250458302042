<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectBasedOnRole
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // redirect otomatis kalau user buka route lain selain dashboard mereka
            if ($user->role === 'admin' && !$request->is('admin/*')) {
                return redirect()->route('admin.dashboard');
            }

            if ($user->role === 'user' && !$request->is('user/*')) {
                return redirect()->route('user.dashboard');
            }

            // Tambahin role lain sesuai kebutuhan
        }

        return $next($request);
    }
}
