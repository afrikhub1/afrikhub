<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // Afficher le formulaire "mot de passe oublié"
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Envoyer l'email de réinitialisation
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(60);

        // Stocker le token dans la base (table password_reset_tokens)
        \DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );

        $resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($request->email));

        // Envoyer un email simple avec le lien, sans utiliser la vue de formulaire
        Mail::raw("Cliquez sur ce lien pour réinitialiser votre mot de passe : $resetUrl", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Réinitialisation de votre mot de passe');
        });

        return redirect()->route('login')->with('success', 'Un lien de réinitialisation a été envoyé à votre email.');
    }

    // Afficher le formulaire de réinitialisation
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    // Traiter la réinitialisation
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:6',
            'token' => 'required',
        ]);

        $record = \DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Le token est invalide ou a expiré.']);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        \DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Votre mot de passe a été réinitialisé avec succès.');
    }
}
