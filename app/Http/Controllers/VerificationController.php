<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class VerificationController extends Controller
{
    /**
     * Vérifie le token de l'utilisateur lors de la confirmation du compte
     */
    public function verify($token)
    {
        // Recherche l'utilisateur correspondant au token
        $user = User::where('token', $token)->first();

        // Si aucun utilisateur ne correspond
        if (!$user) {
            return redirect()->route('messages')->with('error', 'La confirmation a échoué ❌');
        }

        // Si le compte est déjà vérifié
        if ($user->email_verified_at) {
            return redirect()->route('messages')->with('info', 'Votre compte est déjà vérifié ✅');
        }

        // Mettre à jour l'utilisateur : suppression du token et activation du compte
        $user->update([
            'token' => null,
            'statut' => 'actif',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('messages')->with('success', 'Votre compte a été vérifié avec succès 🎉');
    }
}
