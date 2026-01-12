<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Stevebauman\Location\Facades\Location;
use App\Models\ActivityLog;

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
        $user->email_verified_at = now();
        $user->save();

        // Journalisation de l'activité
        $ip = request()->ip();
        $position = Location::get($ip);
        ActivityLog::create([
            'user_id'    => $user->id,
            'action'     => 'compte vérifié',
            'description' => 'Utilisateur a vérifié son compte.',
            'ip_address' => $ip,
            'pays'       => $position ? $position->countryName : null,
            'ville'      => $position ? $position->cityName : null,
            'latitude'   => $position ? $position->latitude : null,
            'longitude'  => $position ? $position->longitude : null,
            'code_pays'  => $position ? $position->countryCode : null,
            'user_agent' => request()->header('User-Agent'), // Navigateur et OS
        ]);

        return redirect()->route('login')->with('success', 'Votre compte a été vérifié avec succès.');
    }
}
