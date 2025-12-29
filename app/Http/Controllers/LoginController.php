<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Récupération de l'utilisateur
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Identifiants invalides']);
        }

        // 🔒 Vérification du status
        if ($user->status !== 'actif') {
            return back()->withErrors(['email' => 'Votre compte est désactivé']);
        }

        // Connexion
        Auth::login($user);
        $request->session()->regenerate();

        // 🔹 Vérifier si un cookie pour réservation existe
        if ($residenceId = $request->cookie('residence_to_reserve')) {
            // Supprimer le cookie après récupération
            cookie()->queue(cookie()->forget('residence_to_reserve'));

            // Rediriger vers la page de réservation pour cette résidence
            return redirect()->route('details', $residenceId);
        }

        // Redirection normale selon le type de compte
        if ($user->type_compte == 'client') {
            return redirect()->route('clients_historique');
        } else {
            return redirect()->route('pro.dashboard');
        }
    }
}
