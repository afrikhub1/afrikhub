<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;
use App\Models\ActivityLog;


class LogController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Identifiants invalides']);
        }

        if ($user->status !== 'actif') {
            return back()->withErrors(['email' => 'Votre compte est désactivé']);
        }

        Auth::login($user);
        $request->session()->regenerate();

        // 🔹 Redirection après vérification du cookie
        if ($residenceId = $request->cookie('residence_to_reserve')) {
            cookie()->queue(cookie()->forget('residence_to_reserve'));
            return redirect()->route('details', ['id' => $residenceId]);
        }

        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'Connexion',
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'), // Navigateur et OS
        ]);

        return $user->type_compte == 'client'
            ? redirect()->route('clients_historique')
            : redirect()->route('pro.dashboard');
    }

    public function logout()
    {
        Auth::logout();

        // ✅ Supprimer la session actuelle (optionnel mais recommandé)
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // ✅ Rediriger vers la page de connexion
        return redirect()->route('login');
    }


}



