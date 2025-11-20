<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordController extends Controller
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

        // Stocker le token dans la base (table password_resets)
        \DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );

        $resetUrl = url('/reset-password/' . $token . '?email=' . urlencode($request->email));

        // Envoyer l'email (exemple simple)
        Mail::send('emails.reset-password', ['url' => $resetUrl], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Réinitialisation de votre mot de passe');
        });

        return back()->with('status', 'Un lien de réinitialisation a été envoyé à votre email.');
    }

    // Afficher le formulaire de réinitialisation
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
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

        $record = \DB::table('password_resets')->where('email', $request->email)->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Le token est invalide ou a expiré.']);
        }

        // Mettre à jour le mot de passe
        $user = User::where('email', $request->email)->first();
        $user->password = $request->password;
        $user->save();

        // Supprimer le token
        \DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('status', 'Votre mot de passe a été réinitialisé avec succès.');
    }
}
