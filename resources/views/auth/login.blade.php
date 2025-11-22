<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion à Afrikhub</title>
    <!-- Chargement de Tailwind CSS pour un style moderne et responsive -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Configuration de base pour la police et la transition */
        :root {
            --color-primary: #34D399; /* Vert émeraude 400 */
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Fond gris clair */
        }
        .gradient-background {
            /* Un dégradé subtil pour le fond de la page entière (facultatif mais agréable) */
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
        }
        .submit-button {
            transition: all 0.2s ease-in-out;
        }
        .submit-button:hover {
            box-shadow: 0 4px 15px -3px rgba(52, 211, 153, 0.7); /* Ombre verte au survol */
            transform: translateY(-1px);
        }
        /* Styles pour le mode sombre ou les erreurs de formulaire (non-Tailwind pur) */
        .input-error {
            border-color: #EF4444; /* Rouge 500 */
        }
    </style>
</head>
<body class="gradient-background min-h-screen flex items-center justify-center p-4">

    <!-- Conteneur Principal (Centré et Adaptatif) -->
    <div class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8 sm:p-10 transition-all duration-300">

        <!-- En-tête -->
        <div class="text-center mb-8">
            <!-- Remplacer par le logo Afrikhub si disponible -->
            <div class="text-5xl font-extrabold text-green-500 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">
                Bienvenue sur Afrikhub
            </h1>
            <p class="text-gray-500 mt-2">
                Connectez-vous pour accéder à votre espace
            </p>
        </div>

        <!-- Section de Messages (pour les erreurs CSRF 419 ou autres) -->
        <div id="message-container" class="mb-6 hidden">
            <!-- Ce bloc serait rendu par Laravel si des erreurs de session existaient -->
            <div class="p-3 text-sm rounded-lg bg-red-100 border border-red-300 text-red-700" role="alert">
                <!-- Message d'erreur PHP/Laravel s'afficherait ici -->
                <p>
                    <strong id="error-title">Erreur de Connexion :</strong>
                    <span id="error-message">Veuillez vérifier vos identifiants ou le formulaire a expiré (419).</span>
                </p>
            </div>
        </div>

        <!-- Formulaire de Connexion -->
        <!-- ATTENTION : L'action et la méthode sont celles du journal de l'erreur -->
        <!-- Vous devrez remplacer l'action et ajouter la directive @csrf dans votre Blade -->
        <form method="POST" action="/login-auth" id="loginForm">
            <!-- Le champ CSRF caché est CRUCIAL pour éviter le 419.
                 Dans Laravel Blade, cela se fait avec @csrf.
                 Ici, nous simulons le champ pour l'esthétique HTML pur. -->
            <input type="hidden" name="_token" value="SIMULATED_CSRF_TOKEN_HERE">

            <div class="space-y-4">
                <!-- Champ Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse E-mail</label>
                    <input type="email" id="email" name="email" required autocomplete="email"
                           placeholder="exemple@mail.com"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out">
                </div>

                <!-- Champ Mot de Passe -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de Passe</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password"
                           placeholder="••••••••"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-150 ease-in-out">
                </div>

                <!-- Option Se Souvenir de Moi et Mot de Passe Oublié -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember_me" type="checkbox"
                               class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                            Se souvenir de moi
                        </label>
                    </div>

                    <a href="#" class="text-sm font-medium text-green-600 hover:text-green-500 hover:underline">
                        Mot de passe oublié ?
                    </a>
                </div>
            </div>

            <!-- Bouton de Soumission -->
            <div class="mt-6">
                <button type="submit"
                        class="submit-button w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-md text-sm font-bold text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Se Connecter
                </button>
            </div>
        </form>

        <!-- Pied de Page (Alternative) -->
        <div class="mt-8 text-center text-sm text-gray-500">
            Pas encore de compte ?
            <a href="#" class="font-bold text-green-600 hover:text-green-500 hover:underline">
                Créer un compte
            </a>
        </div>
    </div>

    <script>
        // Fonctionnalité pour la gestion des messages d'erreur dans le navigateur
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const error = urlParams.get('error');

            // Ceci est une simulation pour montrer comment les messages pourraient s'afficher
            if (error === 'csrf_expired') {
                const container = document.getElementById('message-container');
                const title = document.getElementById('error-title');
                const message = document.getElementById('error-message');

                if (container && title && message) {
                    title.textContent = "Page Expirée (Erreur 419) :";
                    message.textContent = "Veuillez réessayer. La session du formulaire a expiré.";
                    container.classList.remove('hidden');
                }
            }

            // Gestion de l'action du formulaire (seulement pour l'exemple HTML)
            const form = document.getElementById('loginForm');
            if(form) {
                form.addEventListener('submit', function(e) {
                    // Ici, dans votre application Laravel, la soumission se ferait normalement.
                    // Si le jeton est manquant ou périmé, Laravel répondra avec un 419.
                    console.log('Tentative de connexion...');
                });
            }
        });
    </script>
</body>
</html>
