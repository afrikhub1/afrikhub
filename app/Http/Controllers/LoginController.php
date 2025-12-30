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

        // 🔹 Vérification cookie si query string residence existe
        $residenceId = $request->query('residence');
        if ($residenceId) {
            $cookie = cookie(
                'residence_to_reserve',  // nom
                $residenceId,            // valeur
                60,                      // durée en minutes
                null,                    // path
                null,                    // domaine (auto)
                true,                    // secure (HTTPS)
                true,                    // httpOnly
                false,                   // raw
                'Lax'                    // SameSite
            );

            // 🔹 On dd() pour vérifier le cookie
            dd([
                'residenceId' => $residenceId,
                'cookie' => $cookie,
                'cookies_in_request' => $request->cookies->all(),
            ]);
        }

        // 🔹 Si pas de residenceId, on dd() quand même
        dd([
            'message' => 'Pas de résidence dans la query string',
            'cookies_in_request' => $request->cookies->all(),
        ]);
    }
}
