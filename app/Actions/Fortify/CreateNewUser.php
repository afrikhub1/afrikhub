<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\{Auth, Hash, Mail, Validator};
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Stevebauman\Location\Facades\Location;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        // 1. VALIDATION (Utilisation de 'name' pour matcher ton formulaire)
        Validator::make($input, [
            'name' => [
                'required',
                'string',
                'max:100',
                'min:3', // 7 était peut-être un peu long, mais à ta guise
                Rule::unique(User::class, 'name'),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'contact' => ['required', 'string'],
            'type_compte' => ['required', 'string', 'in:client,professionnel'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
                'confirmed',
            ],
        ], [
            'name.required' => 'Le nom est obligatoire.',
            'name.unique'   => 'Ce nom d\'utilisateur est déjà pris.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.unique'   => 'Cet email est déjà utilisé.',
            'password.regex' => 'Le mot de passe doit contenir une majuscule, un chiffre et un caractère spécial.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ])->validate();

        // 2. CRÉATION DE L'UTILISATEUR
        $email = $input['email'];
        $token = md5(uniqid() . $email);

        $utilisateur = User::create([
            'name'        => $input['name'], // On utilise 'name' ici
            'email'       => $email,
            'contact'     => $input['contact'],
            'token'       => $token,
            'type_compte' => $input['type_compte'],
            'status'      => 'inactif',
            'password'    => Hash::make($input['password']),
        ]);

        // 3. LOG D'ACTIVITÉ
        try {
            $ip = request()->ip();
            $position = Location::get($ip);
            ActivityLog::create([
                'user_id'     => $utilisateur->id,
                'action'      => 'creation de compte',
                'description' => 'Utilisateur a créé un compte avec succès.',
                'ip_address'  => $ip,
                'pays'        => $position ? $position->countryName : null,
                'ville'       => $position ? $position->cityName : null,
                'latitude'    => $position ? $position->latitude : null,
                'longitude'   => $position ? $position->longitude : null,
                'code_pays'   => $position ? $position->countryCode : null,
                'user_agent'  => request()->header('User-Agent'),
            ]);
        } catch (\Exception $e) {
            // On évite de bloquer l'inscription si la géolocalisation échoue
            \Log::error("Erreur log activité: " . $e->getMessage());
        }

        // 4. ENVOI DU MAIL
        Mail::to($utilisateur->email)->send(new \App\Mail\TokenMail($utilisateur));

        // 5. GESTION DE LA REDIRECTION (Custom Fortify)
        Auth::logout();

        $message = "Inscription réussie ! Un email de validation a été envoyé à " . $utilisateur->email . ". Veuillez valider votre compte avant de vous connecter.";

        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            redirect()->route('login')->with('success', $message)
        );

        return $utilisateur;
    }
}
