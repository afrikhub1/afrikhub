<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ClientMiddleware
{
    public function handle($request, Closure $next)
    {
        // Vérifie si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect('/login')->with('danger', 'Vous devez être connecté pour accéder à cette page.');
        }

        // Vérifie si l'utilisateur est bien un client
        if (Auth::user()->type_compte !== 'client') {
            Auth::logout();                       // Déconnexion du guard 'web' par défaut
            $request->session()->invalidate();    // Invalide la session
            $request->session()->regenerateToken(); // Régénère le token CSRF
            return redirect('/')->with('error', 'Accès réservé aux clients.');
        }

        return $next($request);
    }
}
