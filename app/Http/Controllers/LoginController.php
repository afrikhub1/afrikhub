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

        // 🔒 Vérification du statut
        if ($user->statut !== 'actif') {
            return back()->withErrors([
            'email' => 'Veuillez vérifier votre compte avant de vous connecter'
            ]);
        }

        if ($user->type_compte == 'professionnel') {

            $route= 'client_dashboard';
        }
        else {
            $route = 'dashboard';
        }

        // Connexion
        Auth::login($user);

        return redirect()->route($route);
    }
}
