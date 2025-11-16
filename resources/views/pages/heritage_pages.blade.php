<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} @yield('dashboard')</title>

    <!-- ======================= ASSETS CSS ======================= -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Police Inter (utilisée partout) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- ======================= STYLE GLOBAL ======================= -->
    <style>
        :root {
            --danger-color: #ef4444;
            --bg: #f7f8fb;
            --card-bg: #ffffff;
            --muted: #6b7280;
            --dark: #0f1724;
            --primary: #ff8a00;
            --accent-2: #00b4a2;
            --glass: rgba(255, 255, 255, 0.7);
            --radius: 14px;
            --shadow-soft: 0 10px 30px rgba(15, 23, 36, 0.06);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            min-height: 100vh;
        }

        /* ---------------- SIDEBAR ---------------- */
        #sidebar {
            transition: transform 0.3s ease-in-out;
            transform: translateX(100%);
            position: fixed;
            top: 0;
            right: 0;
            width: 350px;
            height: 100%;
            background-color: #1f2937;
            padding: 1.5rem;
            z-index: 50;
            box-shadow: -4px 0 12px rgba(0, 0, 0, 0.3);
        }

        #sidebar.active {
            transform: translateX(0);
        }

        /* ---------------- SCROLL HORIZONTAL IMAGES ---------------- */
        .image-scroll-wrapper {
            overflow-x: auto;
            white-space: nowrap;
            scrollbar-width: thin;
        }

        .glass-header {
    background: rgba(20, 20, 20, 0.4);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    transition: background 0.3s ease;
}

.glass-header:hover {
    background: rgba(20, 20, 20, 0.65);
}

.logo {
    height: 50px;
    width: auto;
    transition: transform 0.4s ease;
}

.logo:hover {
    transform: rotate(-5deg) scale(1.05);
}

.nav-link {
    position: relative;
    font-weight: 500;
    transition: color 0.3s ease;
}

.nav-link::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -4px;
    width: 0%;
    height: 2px;
    background: #ffc107;
    transition: width 0.3s ease;
}

.nav-link:hover {
    color: #ffc107 !important;
}

.nav-link:hover::after {
    width: 100%;
}

/* Menu mobile */
.mobile-menu {
    position: fixed;
    top: 0;
    right: -100%;
    width: 75%;
    height: 100%;
    z-index: 2000;
    transition: right 0.4s ease;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.mobile-menu.active {
    right: 0;
    box-shadow: -3px 0 15px rgba(0, 0, 0, 0.4);
}

#menu-toggle:focus {
    outline: none;
}

    </style>
</head>

<body>

    <!-- ===========================================================
            HEADER (fixe) + NAVIGATION
         =========================================================== -->
    @yield('header')

    <header class="bg-dark shadow-lg fixed top-0 left-0 right-0 z-40">
        <div class="max-w-7xl mx-auto px-4">

            <!-- Ligne du haut : Logo + nom utilisateur + bouton menu -->
            <div class="flex items-center justify-between py-3">
                <div class="flex items-center space-x-4">
                    <img class="w-20 md:w-28 lg:w-32 h-auto"
                        src="{{ asset('assets/images/logo_01.png') }}"
                        alt="AfrikHub Logo">

                    <h1 class="text-xl font-semibold text-white">
                        {{ Auth::user()->name }}
                    </h1>
                </div>

                <a href="{{ route('recherche') }}">
                    <i class="fas fa-search text-light"></i>
                </a>

                <button id="toggleSidebar"
                        class="p-2 rounded-lg text-white hover:bg-indigo-700 transition">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Navigation secondaire -->
            <div class="flex flex-wrap justify-between border-t border-gray-800 py-2">

                <a href="{{ route('residences') }}" class="nav-item">
                    <i class="fas fa-home mr-1"></i> Résidences
                </a>

                <a href="{{ route('occupees') }}" class="nav-item">
                    <i class="fas fa-lock mr-1"></i> Occupées
                </a>

                <a href="{{ route('mes_demandes') }}" class="nav-item">
                    <i class="fas fa-spinner mr-1"></i> Demandes
                </a>

                <a href="{{ route('historique') }}" class="nav-item">
                    <i class="fas fa-clock mr-1"></i> Historique
                </a>

            </div>

        </div>
    </header>

    <!-- ===========================================================
            SIDEBAR (menu latéral)
         =========================================================== -->
    <div id="sidebar" class="text-white flex flex-col items-center">

        <!-- Bouton fermer -->
        <button id="closeSidebar"
                class="absolute top-4 right-4 text-gray-400 hover:text-white">
            <i class="fas fa-times text-2xl"></i>
        </button>

        <!-- Liste des liens -->
        <div class="mt-12 w-full flex flex-col space-y-4">

            <a href="{{ route('accueil') }}" class="sidebar-link">
                <i class="fas fa-home mr-1"></i> Accueil
            </a>

            <a href="{{ route('recherche') }}" class="sidebar-link">
                <i class="fas fa-search mr-1"></i> Recherche
            </a>

            <a href="{{ route('historique') }}" class="sidebar-link">
                <i class="fas fa-book mr-1"></i> Réservation
            </a>

            <a href="{{ route('dashboard') }}" class="sidebar-link">
                <i class="fas fa-user mr-1"></i> Mon Compte
            </a>

            <a href="{{ route('mise_en_ligne') }}" class="sidebar-link">
                Mise en ligne
            </a>

            <a href="{{ route('residences') }}" class="sidebar-link">
                Mes Résidences
            </a>

            <a href="{{ route('occupees') }}" class="sidebar-link">
                Résidences occupées
            </a>

            <a href="{{ route('mes_demandes') }}" class="sidebar-link">
                Demandes
            </a>

            <div class="py-2 w-full">
                <a href="{{ route('logout') }}" class="w-full text-center py-2 px-4 bg-red-600 hover:bg-red-700 rounded-lg font-semibold shadow-lg">
                    Déconnexion
                </a>
            </div>

        </div>
    </div>

    <!-- ===========================================================
            CONTENU PRINCIPAL
         =========================================================== -->
    <main class="container mx-auto px-4 py-8 pt-44 lg:pt-40">
        @include('includes.messages')
        @yield('main')
    </main>

    @yield('footer')

    <!-- ===========================================================
            SCRIPTS
         =========================================================== -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // ============= Lightbox =============
            GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
                openEffect: 'zoom',
                closeEffect: 'zoom',
                slideEffect: 'slide',
            });

            // ============= Sidebar =============
            const toggleSidebar = document.getElementById('toggleSidebar');
            const closeSidebar = document.getElementById('closeSidebar');
            const sidebar = document.getElementById('sidebar');

            toggleSidebar?.addEventListener('click', () => sidebar.classList.add('active'));
            closeSidebar?.addEventListener('click', () => sidebar.classList.remove('active'));
        });
    </script>

    @stack('scripts')
    @yield('script')

</body>
</html>
