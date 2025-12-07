<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\{
    Auth,
    Hash,
    Log,
    Mail,
    Validator
};
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Valide et crée un nouvel utilisateur enregistré.
     *
     * @param  array<string, string>  $input
     * @return \App\Models\User
     */
    public function create(array $input): User
    {
        // Validation des champs
        Validator::make($input, [
            // Mise à jour de la règle de taille maximale à 7 caractères pour 'nom'
            'nom' => [
                'required',
                'string',
                'max:25',
                'min:7',
                Rule::unique(User::class, 'name'),
            ],
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
            // Mise à jour du message d'erreur pour la taille maximale du 'nom'
            'nom.required' => 'Le nom est obligatoire.',
            'nom.string'   => 'Le nom doit être une chaîne de caractères.',
            'nom.max'      => 'Le nom ne doit pas dépasser 25 caractères.', // Message mis à jour
            'nom.unique'   => 'Ce nom d\'utilisateur est déjà pris.',

            // Messages d'erreur pour le champ 'email'
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.string'   => 'L\'adresse email doit être une chaîne de caractères.',
            'email.email'    => 'Le format de l\'adresse email est invalide.',
            'email.max'      => 'L\'adresse email ne doit pas dépasser 255 caractères.',
            'email.unique'   => 'Cet email est déjà utilisé.',

            // Messages d'erreur pour le champ 'password'
            'password.required'  => 'Le mot de passe est obligatoire.',
            'password.string'    => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min'       => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ])->validate();

        // Récupération des champs
        $email      = $input['email'];
        $name       = $input['nom'];
        $contact    = $input['contact'];
        $typeCompte = $input['type_compte'];
        $status     = 'inactif';
        $token      = md5(uniqid() . $email);

        // Création de l'utilisateur
        $utilisateur = User::create([
            'name'        => $name,
            'email'       => $email,
            'contact'     => $contact,
            'token'       => $token,
            'type_compte' => $typeCompte,
            'status'      => $status,
            'password'    => Hash::make($input['password']),
        ]);


        // Envoi du mail de confirmation
        Mail::to($utilisateur->email)->send(new \App\Mail\TokenMail($utilisateur));

        // Déconnexion immédiate
        Auth::logout();

        //notification
        session()->flash('success', 'Inscription réussie ! Veuillez consulter votre email pour activer votre compte.');

        // Redirection vers logout ou login
        redirect()->route('logout')->send(); // <- ici on force la redirection

        // On retourne quand même l’utilisateur pour Fortify (même si redirigé)
        return $utilisateur;
    }
}
