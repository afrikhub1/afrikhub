<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion Admin</title>

        <!-- FontAwesome -->
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
        <!-- Tailwind -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="min-h-screen flex items-center justify-center p-4" style='background: linear-gradient(135deg, #006d77, #00afb9);'>

        <div class="w-full max-w-md bg-white/90 backdrop-blur-lg rounded-2xl shadow-2xl p-8 animate-fadeIn">

            <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-6 flex items-center justify-center gap-3">
                <i class="fas fa-user-shield text-indigo-600 text-4xl"></i>
                Connexion Admin
            </h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 shadow-sm">
                    <ul class="list-disc pl-5 ">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5" autocomplete="off">
                @csrf

                <!-- Email -->
                <div class="flex flex-col gap-1">
                    <label for="email" class="text-gray-700 font-semibold">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" autocomplete="off"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition"
                        placeholder="admin@exemple.com" required>
                </div>

                <!-- Mot de passe -->
                <div class="flex flex-col gap-1">
                    <label for="password" class="text-gray-700 font-semibold">Mot de passe</label>
                    <input type="password" name="password" id="password" autocomplete="off"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 
                        outline-none transition"placeholder="mots de passe" required>
                    
                    <!-- Icône pour afficher/masquer le mot de passe -->
                    <span id="togglePassword" 
                        style="position: absolute; right: 20px; top: 13px; cursor: pointer; z-index: 10; color: #555;">
                        <i class="fa-solid fa-eye" id="eyeIcon"></i>
                    </span>
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

        <script>
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const eyeIcon = document.querySelector('#eyeIcon');

            togglePassword.addEventListener('click', function (e) {
                // Basculer le type d'input
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                // Basculer l'icône (œil / œil barré)
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        </script>

    </body>
</html>
