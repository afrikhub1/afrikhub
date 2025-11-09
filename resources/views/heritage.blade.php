<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @yield('titre')

        <!-- GLightbox CSS (pour le carrousel d'images) -->
        <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">

        <!-- Vos Assets Locaux -->
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
        <!-- Font Awesome est remplacé ici par le lien local -->
        <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Inter Font -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    </head>
<body>

    @yield('header')
         <!-- HEADER + SIDEBAR -->
        <style>
            /* Styles Header & Sidebar */
            #sidebar {
                transition: transform 0.3s ease-in-out;
                transform: translateX(100%);
                position: fixed;
                top: 0;
                right: 0;
                width: 350px;
                z-index: 50;
                height: 100%;
                background-color: #1f2937;
                padding: 1.5rem;
                box-shadow: -4px 0 12px rgba(0, 0, 0, 0.3);
            }
            #sidebar.active {
                transform: translateX(0);
            }
        </style>

        <header class="bg-gray-900 shadow-lg fixed top-0 left-0 right-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center space-x-4">
                        <div class="h-10 w-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">A'H</div>
                        <h1 class="text-xl font-semibold text-white">gestionnaire@afrikhub.com</h1>
                    </div>
                    <button id="toggleSidebar" class="p-2 rounded-lg text-white hover:bg-indigo-700 focus:outline-none transition duration-150">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>

                <div class="flex flex-wrap justify-between text-center border-t border-gray-800 py-2 -mx-4">
                    <a href="{{ route('residences') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                        <i class="fas fa-home mr-1"></i> Résidences
                        <span class="ml-1 px-2 py-0.5 bg-red-600 text-white text-xs font-bold rounded-full">{{ $residences->count() }}</span>
                    </a>
                    <a href="{{ route('occupees') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                        <i class="fas fa-lock mr-1"></i> Occupées
                        <span class="ml-1 px-2 py-0.5 bg-yellow-500 text-gray-900 text-xs font-bold rounded-full">1</span>
                    </a>
                    <a href="{{ route('mes_demandes') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                        <i class="fas fa-spinner mr-1"></i> Demandes
                        <span class="ml-1 px-2 py-0.5 bg-gray-600 text-white text-xs font-bold rounded-full">2</span>
                    </a>
                    <a href="{{ route('historique') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                        <i class="fas fa-clock mr-1"></i> Historique
                        <span class="ml-1 px-2 py-0.5 bg-green-600 text-white text-xs font-bold rounded-full">4</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Sidebar -->
        <div id="sidebar" class="text-white flex flex-col items-center">
            <button id="closeSidebar" class="absolute top-4 right-4 text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <div class="mt-12 w-full flex flex-col space-y-4">
                <a href="{{ route('accueil') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition"><i class="fas fa-home mr-1"></i> Accueil</a>
                <a href="{{ route('recherche') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Recherche</a>
                <a href="{{ route('historique') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Réservation</a>
                <a href="#" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition"><i class="fas fa-user mr-1"></i> Mon Compte</a>
                <a href="{{ route('residences') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Mes Residences</a>
                <a href="{{ route('mise_en_ligne') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Mise en ligne</a>
                <a href="{{ route('occupees') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Residence occupées</a>
                <a href="{{ route('mes_demandes') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Demandes de reservations</a>
                <div class="py-2 w-full mx-auto row m-0">
                    <a href="{{ route('logout') }}" class="w-full text-center py-2 px-4 bg-red-600 hover:bg-red-700 rounded-lg font-semibold transition shadow-lg">Déconnexion</a>
                </div>
            </div>
        </div>

    @yield('main')


    @yield('footer')



    @yield('script')

        <!-- Scripts JS + style global du body si nécessaire -->
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f3f4f6;
                min-height: 100vh;
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
        <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialisation GLightbox
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            openEffect: 'zoom',
            closeEffect: 'zoom',
            slideEffect: 'slide',
        });

        // Sidebar Toggle
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
</body>
</html>
