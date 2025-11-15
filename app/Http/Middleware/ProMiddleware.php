<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ProMiddleware
{
    public function handle($request, Closure $next)
    {
        // Si l'utilisateur n'est pas connecté OU n'est pas PRO
        if (!Auth::check() || Auth::user()->type_compte !== 'professionnel') {
            return redirect('/')
                ->with('danger', 'Accès réservé aux professionnels.');
        }

        return $next($request);
    }
}
