<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;
use App\Models\ActivityLog;

class DevenirProController extends Controller
{
    // Affiche la page "Devenir Professionnel"
    public function devenirPro()
    {
        return view('pages.devenir_pro');
    }

    // Change le type de compte
    public function validerDevenirPro(Request $request)
    {
        $ip = request()->ip();
        $position = Location::get($ip);
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'changement de type de compte en professionnel',
            'description' => 'l\'utilisateur a changé son type de compte en professionnel.',
            'ip_address' => $ip,
            'pays'       => $position ? $position->countryName : null,
            'ville'      => $position ? $position->cityName : null,
            'latitude'   => $position ? $position->latitude : null,
            'longitude'  => $position ? $position->longitude : null,
            'code_pays'  => $position ? $position->countryCode : null,
            'user_agent' => request()->header('User-Agent'), // Navigateur et OS
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        // Mise à jour du type de compte
        $user->type_compte = 'professionnel';
        $user->save();

        // Regénère la session pour éviter le 419
        $request->session()->regenerate();

        return redirect()->route('pro.dashboard')->with('success', 'Votre compte est maintenant professionnel.');
    }
}
