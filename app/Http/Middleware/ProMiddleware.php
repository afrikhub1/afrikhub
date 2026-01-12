<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ProMiddleware
{
    public function handle($request, Closure $next)
    {
        // 1. Vérification de l'accès
        if (!Auth::check() || Auth::user()->type_compte !== 'professionnel') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return response()->view('pages.force_logout', [
                'redirect' => route('login'),
                'message' => 'Accès réservé aux professionnels. Vous avez été déconnecté.'
            ]);
        }

        // 2. Récupération de la réponse
        $response = $next($request);

        // 3. AJOUT DES HEADERS ANTI-CACHE (C'est ici que ça se joue !)
        // On force le navigateur à ne pas sauvegarder la page précédente
        return $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
    }
}
