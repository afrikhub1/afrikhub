<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;


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

        if ($user->status !== 'actif') {
            return back()->withErrors(['email' => 'Votre compte est désactivé']);
        }

        // Connexion
        Auth::login($user);
        $request->session()->regenerate();

        // 🔹 Création du cookie si query string residence existe
        $residenceId = $request->query('residence');
        if ($residenceId) {
            $cookie = cookie('residence_to_reserve', $residenceId, 60); // 60 min
            // Rediriger vers la page détails avec cookie
            return redirect()->route('details', $residenceId)->withCookie($cookie);
        }

        // Redirection normale selon le type de compte
        if ($user->type_compte == 'client') {
            return redirect()->route('clients_historique');
        } else {
            return redirect()->route('pro.dashboard');
        }
    }
}
