<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        // Mise à jour du type de compte
        $user->type_compte = 'professionnel';
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Votre compte est maintenant professionnel.');
    }
}
