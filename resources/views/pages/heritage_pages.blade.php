<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} @yield('dashboard')</title>

    <!-- CSS communs -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/accueil.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* Configuration Tailwind pour utiliser la police Inter et styles globaux */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        :root {
            --primary-color: #4f46e5; /* Indigo 600 */
            --danger-color: #ef4444; /* Red 500 */
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Gray 100 */
            min-height: 100vh;
        }
        /* Style spécifique pour la Sidebar */
        #sidebar {
            transition: transform 0.3s ease-in-out;
            transform: translateX(100%);
            position: fixed;
            top: 0;
            right: 0;
            width: 350px;
            z-index: 50;
            height: 100%;
            background-color: #1f2937; /* Dark Gray 800 */
            padding: 1.5rem;
            box-shadow: -4px 0 12px rgba(0, 0, 0, 0.3);
        }
        #sidebar.active {
            transform: translateX(0);
        }
        /* Style pour la Lightbox (utilisé ici comme référence, mais GLightbox gère la sienne) */
        .lightbox-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        /* Conteneur de défilement pour les albums */
        .image-scroll-wrapper {
            overflow-x: auto;
            white-space: nowrap;
            /* Permet le défilement horizontal */
            scrollbar-width: thin;
        }
    </style>
</head>
<body>

    @yield('header')   <!-- Header + Sidebar ici -->
        <!-- Header & Navigation Bar (FIXE) -->
        <header class="bg-dark shadow-lg fixed top-0 left-0 right-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Top Row: Logo, Title, Toggle Button -->
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center space-x-4">
                        <!-- Placeholder Logo -->
                        <div class="flex items-center">
                            <img class="w-20 md:w-28 lg:w-32 h-auto" src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo"/>
                        </div>
                        <h1 class="text-xl text-capitalize font-semibold text-white">{{ Auth::user()->name }}</h1>
                    </div>


                        <a href="{{ route('recherche')}}"><i class="fas fa-search mr-1 text-light"></i></a>


                    <!-- Toggle Button (pour ouvrir la Sidebar) -->
                    <button id="toggleSidebar" class="p-2 rounded-lg text-white hover:bg-indigo-700 focus:outline-none transition duration-150">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                </div>

                <!-- Bottom Row: Nav Links/Stats -->
                <div class="flex flex-wrap justify-between text-center border-t border-gray-800 py-2 -mx-4">

                    <a href="{{ route('residences') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                        <i class="fas fa-home mr-1"></i> Résidences
                    </a>

                    <a href="{{ route('occupees') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                        <i class="fas fa-lock mr-1"></i> Occupées
                    </a>

                    <a href="{{ route('mes_demandes') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                        <i class="fas fa-spinner mr-1"></i> Demandes
                    </a>

                    <a href="{{ route('historique') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                        <i class="fas fa-clock mr-1"></i> Historique
                    </a>
                </div>
            </div>
        </header>

        <!-- Sidebar -->
        <div id="sidebar" class="text-white flex flex-col items-center">

            <button id="closeSidebar" class="absolute top-4 right-4 text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="mt-12 w-full flex flex-col space-y-4">

                <a href="{{ route('accueil') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">
                    <i class="fas fa-home mr-1"></i> Accueil
                </a>

                <a href="{{ route('recherche') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">
                    <i class="fas fa-search mr-1"></i>Recherche
                </a>

                <a href="{{ route('historique') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">
                    Réservation
                </a>

                <a href="{{ route('dashboard') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">
                    <i class="fas fa-user mr-1"></i> Mon Compte
                </a>

                <a href="{{ route('mise_en_ligne') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">
                    Mise en ligne
                </a>


                <a href="{{ route('residences') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">
                    Mes Residences
                </a>

                <a href="{{ route('occupees') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">
                    Residence occupées
                </a>

                <a href="{{ route('mes_demandes') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">
                    Demandes de reservations
                </a>

                <div class="py-2 w-full mx-auto row m-0">
                    <a href="{{ route('logout') }}" class="w-full text-center py-2 px-4 bg-red-600 hover:bg-red-700 rounded-lg font-semibold transition shadow-lg">
                        Déconnexion
                    </a>
                </div>
            </div>
        </div>
        <!-- FIN HEADER & SIDEBAR -->


    <main class="container mx-auto px-4 py-8 pt-44 lg:pt-40">
        <!-- message alerte -->
        @include('includes.messages')

        @yield('main')   <!-- Contenu principal de chaque page -->
    </main>

    @yield('footer')

    <!-- Scripts communs -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggleSidebar');
            const closeButton = document.getElementById('closeSidebar');
            const sidebar = document.getElementById('sidebar');

            toggleButton?.addEventListener('click', ()=> sidebar.classList.add('active'));
            closeButton?.addEventListener('click', ()=> sidebar.classList.remove('active'));

            GLightbox({ selector: '.glightbox', touchNavigation:true, loop:true });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        // Initialisation de GLightbox avec effets
            const lightbox = GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
                openEffect: 'zoom',
                closeEffect: 'zoom',
                slideEffect: 'slide',
        });

        // LOGIQUE DE LA SIDEBAR
        const toggleButton = document.getElementById('toggleSidebar');
        const closeButton = document.getElementById('closeSidebar');
        const sidebar = document.getElementById('sidebar');

        if (toggleButton && sidebar) {
            toggleButton.addEventListener('click', function() {
                sidebar.classList.add('active');
            });
        }

        if (closeButton && sidebar) {
            closeButton.addEventListener('click', function() {
                sidebar.classList.remove('active');
            });
        }
    });
</script>


    @stack('scripts')

    @yield('script')
</body>
</html>
