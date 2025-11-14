<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        if ($user->role !== $role) {
            return abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }

}
