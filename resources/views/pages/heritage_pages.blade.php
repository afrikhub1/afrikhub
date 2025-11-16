<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ config('app.name') }} - @yield('title')</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Police Inter pour un rendu propre et moderne */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }

        /* Sidebar (menu latéral) */
        #sidebar {
            transition: transform 0.3s ease-in-out;
            transform: translateX(100%);
            position: fixed;
            top: 0;
            right: 0;
            width: 350px;
            height: 100%;
            background-color: #1f2937;
            z-index: 50;
            padding: 1.5rem;
            box-shadow: -4px 0 12px rgba(0, 0, 0, 0.3);
        }
        #sidebar.active {
            transform: translateX(0);
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- HEADER FIXE -->
    <header class="bg-gray-900 shadow-lg fixed top-0 left-0 right-0 z-40">
        <div class="max-w-7xl mx-auto px-4">

            <!-- Première ligne : Logo, nom, bouton menu -->
            <div class="flex items-center justify-between py-3">
                <div class="flex items-center space-x-4">
                    <div class="h-10 w-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                        A'H
                    </div>
                    <h1 class="text-xl font-semibold text-white">
                        gestionnaire@afrikhub.com
                    </h1>
                </div>

                <!-- Bouton toggle sidebar -->
                <button id="toggleSidebar" class="p-2 rounded-lg text-white hover:bg-indigo-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                </button>
            </div>

            <!-- Ligne des statistiques -->
            <div class="flex flex-wrap justify-between text-center border-t border-gray-800 py-2 -mx-4">

                <a href="{{ route('residences') }}" class="flex-1 min-w-[25%] p-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    <i class="fas fa-home mr-1"></i> Résidences
                    <span class="ml-1 px-2 bg-red-600 text-xs font-bold rounded-full">3</span>
                </a>

                <a href="{{ route('occupees') }}" class="flex-1 min-w-[25%] p-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    <i class="fas fa-lock mr-1"></i> Occupées
                    <span class="ml-1 px-2 bg-yellow-500 text-xs font-bold rounded-full">1</span>
                </a>

                <a href="{{ route('mes_demandes') }}" class="flex-1 min-w-[25%] p-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    <i class="fas fa-spinner mr-1"></i> Demandes
                    <span class="ml-1 px-2 bg-gray-600 text-xs font-bold rounded-full">2</span>
                </a>

                <a href="{{ route('historique') }}" class="flex-1 min-w-[25%] p-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    <i class="fas fa-clock mr-1"></i> Historique
                    <span class="ml-1 px-2 bg-green-600 text-xs font-bold rounded-full">4</span>
                </a>

            </div>
        </div>
    </header>

    <!-- SIDEBAR (Menu latéral) -->
    <aside id="sidebar" class="text-white flex flex-col items-center">

        <!-- Bouton fermer -->
        <button id="closeSidebar" class="absolute top-4 right-4 text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Liens -->
        <div class="mt-12 w-full flex flex-col space-y-4">

            <a href="{{ route('accueil') }}" class="w-full text-center py-2 hover:bg-gray-700 rounded-lg">
                <i class="fa-solid fa-house mr-2"></i> Accueil
            </a>

            <a href="{{ route('recherche') }}" class="w-full text-center py-2 hover:bg-gray-700 rounded-lg">
                <i class="fa-solid fa-magnifying-glass mr-2"></i> Recherche
            </a>

            <a href="{{ route('historique') }}" class="w-full text-center py-2 hover:bg-gray-700 rounded-lg">
                <i class="fa-solid fa-clock-rotate-left mr-2"></i> Réservation
            </a>

            <a href="{{ route('dashboard') }}" class="w-full text-center py-2 hover:bg-gray-700 rounded-lg">
                <i class="fa-solid fa-user mr-2"></i> Mon Compte
            </a>

            <a href="{{ route('residences') }}" class="w-full text-center py-2 hover:bg-gray-700 rounded-lg">
                <i class="fa-solid fa-building mr-2"></i> Mes Résidences
            </a>

            <a href="{{ route('mise_en_ligne') }}" class="w-full text-center py-2 hover:bg-gray-700 rounded-lg">
                <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Mise en ligne
            </a>

            <a href="{{ route('occupees') }}" class="w-full text-center py-2 hover:bg-gray-700 rounded-lg">
                <i class="fa-solid fa-lock mr-2"></i> Résidences occupées
            </a>

            <a href="{{ route('mes_demandes') }}" class="w-full text-center py-2 hover:bg-gray-700 rounded-lg">
                <i class="fa-solid fa-envelope-open-text mr-2"></i> Demandes
            </a>

            <a href="{{ route('logout') }}"
            class="w-full text-center py-2 bg-red-600 hover:bg-red-700 rounded-lg font-semibold shadow-lg">
                <i class="fa-solid fa-right-from-brush mr-2"></i> Déconnexion
            </a>

        </div>
    </aside>

    <!-- CONTENU PRINCIPAL -->
    <main class="pt-28 mb-16">
        <div class="max-w-7xl mx-auto px-4">
            @include('includes.messages')
            @yield('main')
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="text-center text-sm text-gray-500 mt-12 mb-8">
        © {{ date('Y') }} {{ config('app.name') }} — Tous droits réservés
    </footer>

    <!-- SCRIPT : ouverture / fermeture sidebar -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.add('active');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('active');
        });
    </script>

    @stack('scripts')
    @yield('script')
</body>
</html>
