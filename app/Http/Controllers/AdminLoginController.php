<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * Affiche le formulaire de login admin.
     */
    public function showLoginForm()
    {
        return view('admin.login'); // ton fichier Blade : resources/views/admin/login.blade.php
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

        $credentials = $request->only('email', 'password');

        // Tentative de connexion
        if (Auth::attempt($credentials)) {
            // Vérifie le rôle
            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => 'Accès refusé : vous n\'êtes pas administrateur.']);
            }

            // Redirection vers le dashboard admin
            return redirect()->view('admin.admin');
        }

        // Si échec de connexion
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
