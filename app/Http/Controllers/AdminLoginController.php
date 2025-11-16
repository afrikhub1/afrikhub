<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Affiche le formulaire de connexion admin.
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Traite la connexion admin.
     */
    public function login(Request $request)
    {
        // Validation des champs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Récupère l'admin par email
        $admin = Admin::where('email', $request->email)->first();

        // Vérifie si l'admin existe et que le mot de passe correspond
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Connecte l'admin manuellement
            Auth::login($admin);

            return redirect()->route('admin_dashboard'); // route vers dashboard admin
        }

        // Si échec
        return back()->withErrors(['email' => 'Identifiants incorrects'])->withInput();
    }

    /**
     * Déconnecte l'admin.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }
}
