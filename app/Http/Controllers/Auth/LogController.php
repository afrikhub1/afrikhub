<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Stevebauman\Location\Facades\Location;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ActivityLog;


class LogController extends Controller
{
    public function login(Request $request)
    {
        // 1. Si la requête est en GET (affichage de la page), on nettoie tout
        if ($request->isMethod('get')) {
            if (Auth::check()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // On redirige vers la même page avec un paramètre pour ne pas boucler
                return redirect()->route('login')->with('cleared', true);
            }

            
        }

        // 2. Si on est ici, c'est que c'est une requête POST (Tentative de connexion)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        // Vérification identifiants
        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Identifiants invalides']);
        }

        // Vérification statut
        if ($user->status !== 'actif') {
            return back()->withErrors(['email' => 'Votre compte est désactivé']);
        }

        // Connexion réussie
        Auth::login($user);
        $request->session()->regenerate();

        // Journalisation de l'activité
        $this->logActivity($user);

        // --- GESTION DES REDIRECTIONS PRIORITAIRES ---

        // A. Lien de paiement (Mail)
        if (session()->has('url.intended')) {
            return redirect()->intended();
        }

        // B. Cookie de réservation
        if ($residenceId = $request->cookie('residence_to_reserve')) {
            cookie()->queue(cookie()->forget('residence_to_reserve'));
            return redirect()->route('details', ['id' => $residenceId]);
        }

        // C. Par défaut selon le rôle
        return $user->type_compte == 'client'
            ? redirect()->route('clients_historique')
            : redirect()->route('pro.dashboard');
    }

    /**
     * Petite fonction privée pour garder le code propre
     */
    private function logActivity($user)
    {
        $ip = request()->ip();
        $position = Location::get($ip);
        ActivityLog::create([
            'user_id'     => $user->id,
            'action'      => 'Connexion',
            'description' => 'Utilisateur connecté avec succès.',
            'ip_address'  => $ip,
            'pays'        => $position ? $position->countryName : null,
            'ville'       => $position ? $position->cityName : null,
            'latitude'    => $position ? $position->latitude : null,
            'longitude'   => $position ? $position->longitude : null,
            'code_pays'   => $position ? $position->countryCode : null,
            'user_agent'  => request()->header('User-Agent'),
        ]);
    }

    public function logout()
    {
        // Journalisation de l'activité
        $ip = request()->ip();
        $position = Location::get($ip);
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'Deconnexion',
            'description' => 'Utilisateur deconnecté avec succès.',
            'ip_address' => $ip,
            'pays'       => $position ? $position->countryName : null,
            'ville'      => $position ? $position->cityName : null,
            'latitude'   => $position ? $position->latitude : null,
            'longitude'  => $position ? $position->longitude : null,
            'code_pays'  => $position ? $position->countryCode : null,
            'user_agent' => request()->header('User-Agent'), // Navigateur et OS
        ]);

        Auth::logout();

        // Supprimer la session actuelle (optionnel mais recommandé)
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Rediriger vers la page de connexion
        return redirect()->route('login');
    }


}



