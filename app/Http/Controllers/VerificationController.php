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
            return response()->json([
                'message' => 'Token invalide ou expiré.',
            ], 400);
        }

        // Mettre à jour l'utilisateur : token supprimé et compte activé
        $user->update([
            'token' => null,
            'statut' => 'actif',
            'email_verified_at' => now(),
        ]);

        return redirect()->view('pages.message')->with('success', 'Votre compte a été vérifié avec succès 🎉');
    }

}
