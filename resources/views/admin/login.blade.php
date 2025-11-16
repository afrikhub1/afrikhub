<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">Connexion Administrateur</h1>

        <!-- Message d'erreur -->
        <div id="error-message" class="hidden bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
            Email ou mot de passe incorrect.
        </div>

        <form action="/admin/login" method="POST" class="space-y-4">
            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" id="email" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Mot de passe -->
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">Mot de passe</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Se souvenir de moi -->
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="mr-2">
                <label for="remember" class="text-gray-700 text-sm">Se souvenir de moi</label>
            </div>

            <!-- Bouton -->
            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition duration-150">
                Se connecter
            </button>
        </form>

        <p class="text-sm text-gray-500 mt-4 text-center">
            © 2025 Mon Application
        </p>
    </div>

</body>
</html>
