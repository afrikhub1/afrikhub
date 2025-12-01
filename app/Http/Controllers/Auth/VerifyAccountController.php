<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class VerifyAccountController extends Controller
{

    public function verify(string $token, Request $request)
    {
        // Récupérer l'email depuis la query string
        $email = $request->query('email');

        // Chercher l'utilisateur correspondant
        $user = User::where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$user) {
            // Lien invalide ou déjà utilisé
            return redirect()->route('login')->with('error', 'Lien de vérification invalide.');
        }

        // Activer le compte
        $user->status = 'actif';
        $user->token = null; // supprimer le token
        $user->save();

        return redirect()->route('login')->with('success', 'Votre compte a été vérifié avec succès.');
    }
}
