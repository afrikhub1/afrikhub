<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devenir professionnel - Afrik'Hub</title>

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

    <!-- Bouton Retourner -->
    <div class="absolute top-6 left-6">
        <a href="javascript:history.back()"
            class="inline-flex items-center gap-2 text-gray-700 bg-white shadow-md px-4 py-2 rounded-xl hover:bg-gray-200 transition">
            ← Retourner
        </a>
    </div>

    <div class="min-h-screen flex items-center justify-center px-4 py-10">

        <!-- Carte principale -->
        <div class="bg-white shadow-xl rounded-2xl p-10 max-w-lg w-full text-center">

            <!-- Logo -->
            <img src="{{ asset('assets/images/logo_01.png') }}"
                alt="AfrikHub Logo"
                class="w-24 mx-auto mb-6">

            <h1 class="text-3xl font-bold text-gray-800 mb-4">
                Devenir Professionnel
            </h1>

            <p class="text-gray-600 mb-8 leading-relaxed">
                Passez au compte professionnel pour publier des résidences, gérer vos réservations,
                accéder à un tableau de bord avancé et augmenter votre visibilité sur Afrik’Hub.
            </p>

            <!-- Formulaire -->
            <form method="POST" action="{{ route('valider_devenir_pro') }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-lg py-4 rounded-xl shadow-md transition-all duration-200">
                    Passer en compte Professionnel
                </button>
            </form>

            <p class="mt-6 text-gray-500 text-sm">
                Votre compte restera actif et vos données seront conservées.
            </p>

        </div>
    </div>

</body>

</html>
