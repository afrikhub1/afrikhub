<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Vérifie si l'admin est connecté via le guard 'admin'
        if (!Auth::guard('admin')->check()) {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Accès refusé.');
        }

        return $next($request);
    }
}
