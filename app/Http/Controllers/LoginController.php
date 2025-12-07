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
            return back()->withErrors([
            'email' => 'Votre compte est désactié'
            ]);
        }
        // on verifie si le l'utilisateur est un client
        if ($user->type_compte == 'client') {

            $route= 'clients_historique';
        }
        // sinon il est forcement un user pro
        else {
            $route = 'pro.dashboard';
        }

        // Connexion
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route($route);
    }
}
