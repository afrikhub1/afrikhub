<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin</title>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            <i class="fas fa-user-shield mr-2 text-indigo-600"></i> Connexion Admin
        </h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                       placeholder="admin@exemple.com" required>
            </div>

            <!-- Mot de passe -->
            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-1">Mot de passe</label>
                <input type="password" name="password" id="password"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                       placeholder="••••••••" required>
            </div>

            <!-- Bouton -->
            <div>
                <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition duration-150 shadow-md flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </button>
            </div>
        </form>

        <p class="text-center text-gray-500 text-sm mt-4">
            &copy; {{ date('Y') }} Mon Application
        </p>
    </div>

</body>
</html>
