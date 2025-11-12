<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        /*Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();*/

        Validator::make($input, [
            // Validation de l'email
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/',
                'confirmed',
            ],

        ], [
            // ✉️ Messages pour l'email
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.string'   => 'L\'adresse email doit être une chaîne de caractères.',
            'email.email'    => 'Le format de l\'adresse email est invalide.',
            'email.max'      => 'L\'adresse email ne doit pas dépasser 255 caractères.',
            'email.unique'   => 'Cet email est déjà utilisé.',

            // 🔐 Messages pour le mot de passe
            'password.required'   => 'Le mot de passe est obligatoire.',
            'password.string'     => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min'        => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.mixedCase'  => 'Le mot de passe doit contenir des majuscules et des minuscules.',
            'password.numbers'    => 'Le mot de passe doit contenir au moins un chiffre.',
            'password.symbols'    => 'Le mot de passe doit contenir au moins un symbole.',
            'password.confirmed'  => 'La confirmation du mot de passe ne correspond pas.',
        ])->validate();


        $email= $input['email'];
        $name = $input['nom'];
        $contact = $input['contact'];
        $type_compte = $input['type_compte'];
        $statut='inactif';
        $token = md5(uniqid() . $email); // 32 caractères hex, aucun caractère spécial

        $utilisateur =User::create([
            'name' => $name,
            'email' => $email,
            'contact' => $contact,
            'token' => $token,
            'type_compte' => $type_compte,
            'statut' => $statut,
            'password' => Hash::make($input['password']),
        ]);
        LOG : afficher la pile d'exécution
Log::debug('User created and about to login', [
    'user_id' => $user->id,
    'trace' => collect(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))->map(function($trace) {
        return [
            'file' => $trace['file'] ?? null,
            'line' => $trace['line'] ?? null,
            'function' => $trace['function'] ?? null,
            'class' => $trace['class'] ?? null,
        ];
    })->toArray(),
]);

Auth::login($user);

Log::debug('Auth::login executed', ['user_id' => $user->id]);

        // Envoi du mail avec le token
        \Illuminate\Support\Facades\Mail::to($utilisateur->email)->send(new \App\Mail\TokenMail($utilisateur));

        return $utilisateur;

    }


}
