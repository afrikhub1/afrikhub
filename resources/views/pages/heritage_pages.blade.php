<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ config('app.name') }} - @yield('title')</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    /* ===== Base ===== */
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f3f4f6;
        font-size: 16px;
        line-height: 1.6;
        color: #1f2937;
    }
    p, span, li, a { font-size: 1rem; font-weight: 400; line-height: 1.6; }

    /* ===== Titres ===== */
    h1 { font-size: 1.875rem; font-weight: 700; color: #111827; }
    h2 { font-size: 1.5rem; font-weight: 600; color: #111827; }
    h5 { font-size: 1rem; font-weight: 500; color: #111827; }

    /* ===== Header ===== */
    header h1 { font-size: 1.25rem; font-weight: 600; color: #fff; }

    /* ===== Stats ===== */
    .stats-link {
        flex: 1 1 20%;
        min-width: 120px;
        padding: 0.5rem;
        text-align: center;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #d1d5db;
        transition: background 0.2s;
    }
    .stats-link:hover { background-color: #1f2937; }

    /* ===== Sidebar ===== */
    #sidebar {
        transition: transform 0.3s ease-in-out;
        transform: translateX(100%);
        position: fixed;
        top: 0;
        right: 0;
        width: 80%;
        max-width: 350px;
        height: 100%;
        z-index: 50;
        padding: 1.5rem;
        box-shadow: -4px 0 12px rgba(0,0,0,0.3);
        overflow-y: auto;
        font-size: 16px;
        background-color: #111827;
    }
    #sidebar.active { transform: translateX(0); }
    #sidebar a { font-size: 1rem; font-weight: 500; transition: color 0.2s; }

    /* ===== Main ===== */
    main { padding-top: 8rem; padding-left: 1rem; padding-right: 1rem; }

    @media (min-width: 1024px) { main { padding-left: 2rem; padding-right: 2rem; } }

    /* ===== Footer ===== */
    footer { font-size: 0.875rem; color: #6b7280; text-align: center; padding: 1rem 0; }

    /* ===== Badges ===== */
    span { font-size: 0.75rem; }

    /* ===== Responsive ===== */
    @media (max-width: 768px) {
        body { font-size: 14px; }
        header h1, .headerfixe_link { font-size: 0.8rem; }
        .stats-link { flex: 1 1 45%; font-size: 0.75rem; margin-bottom: 0.25rem; }
        #sidebar a { font-size: 0.875rem; }
        /* ===== Titres ===== */
        h1 { font-size: 1.5rem; font-weight: 700; color: #111827; }
        h2 { font-size: 1.2rem; font-weight: 600; color: #111827; }
        h5 { font-size: 0.8rem; font-weight: 500; color: #111827; }
    }
    </style>
</head>

<body class="bg-gray-50">

    <!-- HEADER FIXE -->
    <header class="bg-gray-900 shadow-lg fixed top-0 left-0 right-0 z-40">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between py-3">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('accueil') }}" class="block">
                        <img src="{{ asset('assets/images/logo_01.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto" />
                    </a>
                    <h1>{{ Auth::user()->name ?? 'Utilisateur' }}</h1>
                </div>
                <div class="flex items-center space-x-2">
                    <a href="{{ route('mise_en_ligne') }}" class="btn btn-indigo flex items-center gap-1 text-white headerfixe_link">
                        <i class="fas fa-plus"></i> Ajouter
                    </a>
                    <a href="{{ route('clients_historique') }}" class="btn btn-gray flex items-center gap-1 text-white headerfixe_link">
                        <i class="fas fa-calendar-check"></i> Réservations
                    </a>
                    <a href="{{ route('recherche') }}" class="text-gray-300 hover:text-white p-2 rounded-lg headerfixe_link">
                        <i class="fas fa-search"></i>
                    </a>
                    <a href="{{ route('pro.dashboard') }}" class="btn btn-gray flex items-center gap-1 text-white headerfixe_link">
                        <i class="fas fa-user"></i> Profil
                    </a>
                    <button id="toggleSidebar" class="p-2 rounded-lg text-white hover:bg-indigo-700 transition headerfixe_link">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- Stats -->
            <div class="flex flex-wrap justify-between text-center border-t border-gray-800 py-2 -mx-2">
                <a href="{{ route('pro.residences') }}" class="stats-link">
                    <i class="fas fa-home mr-1"></i> Résidences
                    <span class="ml-1 px-2 bg-red-600 text-xs font-bold rounded-full">{{ $totalResidences }}</span>
                </a>
                <a href="{{ route('occupees') }}" class="stats-link">
                    <i class="fas fa-lock mr-1"></i> Occupées
                    <span class="ml-1 px-2 bg-yellow-500 text-xs font-bold rounded-full">{{ $totalResidencesOccupees }}</span>
                </a>
                <a href="{{ route('mes_demandes') }}" class="stats-link">
                    <i class="fas fa-spinner mr-1"></i> Demandes
                    <span class="ml-1 px-2 bg-gray-600 text-xs font-bold rounded-full">{{ $totalDemandesEnAttente }}</span>
                </a>
                <a href="{{ route('reservationRecu') }}" class="stats-link">
                    <i class="fas fa-clock mr-1"></i> Historique
                    <span class="ml-1 px-2 bg-green-600 text-xs font-bold rounded-full">{{ $totalReservationsRecu }}</span>
                </a>
            </div>
        </div>
    </header>

    <!-- SIDEBAR -->
    <aside id="sidebar" class="text-white flex flex-col items-center">
        <button id="closeSidebar" class="absolute top-4 right-4 text-gray-400 hover:text-white">
            <i class="fas fa-times"></i>
        </button>

        <div class="mt-12 w-full flex flex-col space-y-4">
            <a href="{{ route('accueil') }}" class="sidebar-link">Accueil</a>
            <a href="{{ route('recherche') }}" class="sidebar-link">Recherche</a>
            <a href="{{ route('reservationRecu') }}" class="sidebar-link">Réservation</a>
            <a href="{{ route('pro.dashboard') }}" class="sidebar-link">Profil</a>
            <a href="{{ route('pro.residences') }}" class="sidebar-link">Mes Résidences</a>
            <a href="{{ route('mise_en_ligne') }}" class="sidebar-link">Mise en ligne</a>
            <a href="{{ route('occupees') }}" class="sidebar-link">Résidences occupées</a>
            <a href="{{ route('mes_demandes') }}" class="sidebar-link">Demandes</a>
            <a href="{{ route('logout') }}" class="w-full text-center py-2 bg-red-600 hover:bg-red-700 rounded-lg font-semibold shadow-lg flex items-center justify-center gap-2">
                Déconnexion
            </a>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="pt-md-32 p-35 mb-16 px-4">
        <div class="m-0 p-4">
            @include('includes.messages')
            @yield('main')
        </div>
    </main>

    <!-- FOOTER -->
    <footer>
        © {{ date('Y') }} {{ config('app.name') }} — Tous droits réservés
    </footer>

    <!-- JS Sidebar -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        toggleSidebar.addEventListener('click', () => sidebar.classList.add('active'));
        closeSidebar.addEventListener('click', () => sidebar.classList.remove('active'));

        document.addEventListener('click', e => {
            if (!sidebar.contains(e.target) && !toggleSidebar.contains(e.target)) {
                sidebar.classList.remove('active');
            }
        });
    </script>

    <!-- GLightbox -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            GLightbox({ selector: '.glightbox', touchNavigation: true, loop: true, zoomable: true });
        });
    </script>

    @stack('scripts')
    @yield('script')
</body>
</html>
