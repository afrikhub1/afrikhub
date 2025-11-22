<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Responsive</title>
    <!-- Chargement du CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Configuration de la police Inter par défaut */
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Définition du dégradé personnalisé pour le panneau d'information */
        .gradient-custom-2 {
            /* Exemple de dégradé vif pour simuler 'gradient-custom-2' */
            background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
        }

        /* Styles pour masquer la partie logo sur mobile si désiré, mais nous la gardons visible et centrée ici */
        .logo-img {
            max-width: 150px;
            height: auto;
            margin: 0 auto;
        }

        /* Classe pour le centrage des éléments du formulaire (simulant les form-outline Bootstrap) */
        .form-outline input {
            padding: 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            width: 100%;
        }
        .form-outline label {
            display: none; /* Simplification pour Tailwind, la label est cachée ou devient un placeholder */
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Section principale - centrage vertical et horizontal -->
    <section class="min-h-screen flex items-center justify-center py-5 px-4 sm:px-6 lg:px-8">
        <div class="container w-full max-w-6xl">
            <div class="flex justify-center items-center">
                <div class="w-full xl:w-10/12">
                    <!-- Carte principale - utilise flex sur grand écran -->
                    <div class="bg-white rounded-xl shadow-2xl overflow-hidden lg:flex">

                        <!-- LEFT FORM (col-lg-6) -->
                        <div class="w-full lg:w-6/12 p-6 sm:p-12">
                            <div class="flex flex-col items-center justify-center">
                                <!-- Logo -->
                                <div class="text-center mb-6">
                                    <!-- Remplacer par l'URL de l'image réelle -->
                                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo" class="logo-img">
                                </div>

                                <form action="#" method="POST" class="w-full max-w-md">
                                    <h1 class="text-2xl font-bold mb-4 text-gray-800 text-center">Me connecter à mon compte</h1>

                                    <!-- Placeholder pour les messages d'erreur/succès -->
                                    <div class="mb-4 text-red-500 text-sm">
                                        <!-- @include('includes.messages') -->
                                    </div>

                                    <!-- Champ Email -->
                                    <div class="form-outline mb-4">
                                        <input type="email" placeholder="Email" class="form-control" name="email" id="email" value="" required autocomplete="email" autofocus/>
                                        <label class="form-label" for="email"></label>
                                    </div>

                                    <!-- Champ Mot de passe -->
                                    <div class="form-outline mb-4">
                                        <input type="password" placeholder="Mot de passe" class="form-control" name="password" id="mots_de_passe" required />
                                        <label class="form-label" for="password"></label>
                                    </div>

                                    <!-- Bouton de connexion et lien mot de passe oublié -->
                                    <div class="text-center pt-1 mb-6 pb-1">
                                        <button type="submit" name="connexion" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-md">
                                            Se connecter
                                        </button>
                                        <a class="text-gray-500 hover:text-blue-500 text-sm mt-3 inline-block" href="#">Mot de passe oublié ?</a>
                                    </div>

                                    <!-- Liens Inscription et Accueil -->
                                    <div class="flex items-center justify-between border-t pt-4">
                                        <a class="w-1/2 mr-2 text-center border border-red-500 hover:bg-red-50 text-red-600 font-semibold py-2 rounded-lg transition duration-200" href="#">Inscription</a>
                                        <a class="w-1/2 ml-2 text-center border border-green-500 hover:bg-green-50 text-green-600 font-semibold py-2 rounded-lg transition duration-200" href="#">Accueil</a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- RIGHT INFO (col-lg-6) -->
                        <div class="w-full lg:w-6/12 gradient-custom-2 text-white flex items-center p-8 rounded-b-xl lg:rounded-r-xl lg:rounded-bl-none">
                            <div class="px-3 py-4 md:p-5 mx-md-4">
                                <h2 class="text-2xl font-semibold mb-4">Trouvez l’hébergement qui vous ressemble</h2>
                                <p class="text-sm opacity-90 leading-relaxed">
                                    Que vous cherchiez une résidence de vacances, un logement pour un court séjour ou un hébergement longue durée,
                                    notre plateforme vous connecte aux meilleures offres disponibles.
                                    Réservez en toute simplicité et profitez d’un confort adapté à vos besoins.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
