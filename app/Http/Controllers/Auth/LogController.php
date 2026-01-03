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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Identifiants invalides']);
        }

        if ($user->status !== 'actif') {
            return back()->withErrors(['email' => 'Votre compte est désactivé']);
        }

        Auth::login($user);
        $request->session()->regenerate();

        // 🔹 Redirection après vérification du cookie
        if ($residenceId = $request->cookie('residence_to_reserve')) {
            cookie()->queue(cookie()->forget('residence_to_reserve'));
            return redirect()->route('details', ['id' => $residenceId]);
        }

        // Journalisation de l'activité
        $ip = request()->ip();
        $position = Location::get($ip);
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'Connexion',
            'description'=> 'Utilisateur connecté avec succès.',
            'ip_address' => $ip,
            'pays'       => $position ? $position->countryName : null,
            'ville'      => $position ? $position->cityName : null,
            'latitude'   => $position ? $position->latitude : null,
            'longitude'  => $position ? $position->longitude : null,
            'code_pays'  => $position ? $position->countryCode : null,
            'user_agent' => request()->header('User-Agent'), // Navigateur et OS
        ]);

        return $user->type_compte == 'client'
            ? redirect()->route('clients_historique')
            : redirect()->route('pro.dashboard');
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



