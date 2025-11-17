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
            Auth::guard('admin')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return response()->view('pages.force_logout', [
                'redirect' => route('login'),
                'message' => 'Accès réservé aux clients. Vous avez été déconnecté.'
            ]);
        }
        return $next($request);
    }
}
