@extends('heritage')

@section('titre', 'connexion')



@section('ux-ui')

<link rel="stylesheet" href="{{ asset('assets/css/connexion.css') }}">

@endsection



@section('contenu')

    @include('includes.messages')

    <!-- Carte de Connexion (Utilisation de classes Tailwind de base pour la robustesse) -->
    <div class="w-full max-w-lg bg-white bg-opacity-10 backdrop-blur-md rounded-xl p-8 sm:p-10 border border-white border-opacity-30 shadow-2xl">

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-teal-400 mb-2">
                Connexion
            </h1>
            <p class="text-gray-200">
                Le code est bien en cours d'exécution.
            </p>
        </div>

        <form>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-300 mb-1">E-mail</label>
                <input type="email" id="email" class="w-full p-3 rounded-lg bg-white bg-opacity-20 border border-gray-600 text-white placeholder-gray-400 focus:ring-teal-400 focus:border-teal-400" placeholder="utilisateur@exemple.com">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Mot de passe</label>
                <input type="password" id="password" class="w-full p-3 rounded-lg bg-white bg-opacity-20 border border-gray-600 text-white placeholder-gray-400 focus:ring-teal-400 focus:border-teal-400" placeholder="********">
            </div>

            <button type="submit" class="w-full bg-teal-500 hover:bg-teal-600 text-gray-900 font-bold py-3 rounded-full transition duration-150">
                Se connecter
            </button>
        </form>
    </div>

@endsection
