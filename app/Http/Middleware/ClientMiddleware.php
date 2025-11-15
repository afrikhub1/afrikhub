<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ClientMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('danger', 'Vous devez être connecté pour accéder à cette page.');
        }

        if (Auth::user()->type_compte !== 'client') {
            return redirect('/')->with('danger', 'Accès réservé aux clients.');
        }

        return $next($request);
    }
}
