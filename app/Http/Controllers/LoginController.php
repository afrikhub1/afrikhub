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

        // 🔹 Récupérer l'ID de résidence depuis le POST (champ hidden dans le formulaire)
        $residenceId = $request->input('residence');

        if ($residenceId) {
            // Crée le cookie (HTTPS + httpOnly)
            $cookie = cookie(
                'residence_to_reserve', // nom
                $residenceId,           // valeur
                60,                     // durée en minutes
                null,                   // path
                null,                   // domaine
                true,                   // secure
                true,                   // httpOnly
                false,                  // raw
                'Lax'                   // SameSite
            );

            // 🔹 DD pour vérifier la création du cookie
            dd([
                'message' => 'Cookie créé !',
                'cookie_name' => 'residence_to_reserve',
                'cookie_value' => $residenceId,
                'cookies_in_request' => $request->cookies->all()
            ]);

            // Pour production, rediriger vers détails avec le cookie
            // return redirect()->route('details', ['id' => $residenceId])->withCookie($cookie);
        }

        // 🔹 DD si pas de résidence (pour tests)
        dd([
            'message' => 'Pas de résidence dans le formulaire',
            'cookies_in_request' => $request->cookies->all()
        ]);

    }
}
