<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion Admin</title>

        <!-- FontAwesome -->
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

        <!-- Tailwind -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 p-4">

        <div class="w-full max-w-md bg-white/90 backdrop-blur-lg rounded-2xl shadow-2xl p-8 animate-fadeIn">

            <h2 class="text-3xl font-extrabold text-center text-gray-800 mb-6 flex items-center justify-center gap-3">
                <i class="fas fa-user-shield text-indigo-600 text-4xl"></i>
                Connexion Admin
            </h2>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 shadow-sm">
                    <ul class="list-disc pl-5 ">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email -->
                <div class="flex flex-col gap-1">
                    <label for="email" class="text-gray-700 font-semibold">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition"
                        placeholder="admin@exemple.com" required>
                </div>

                <!-- Mot de passe -->
                <div class="flex flex-col gap-1">
                    <label for="password" class="text-gray-700 font-semibold">Mot de passe</label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition"
                        placeholder="••••••••" required>
                </div>

                <!-- Bouton -->
                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-semibold transition duration-200 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                    <i class="fas fa-sign-in-alt"></i>
                    Se connecter
                </button>
            </form>

            <p class="text-center text-gray-600  mt-6">
                &copy; {{ date('Y') }} Mon Application — Tous droits réservés
            </p>
        </div>

        <!-- Animation -->
        <style>
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fadeIn {
                animation: fadeIn 0.6s ease-out;
            }
        </style>

    </body>
</html>
