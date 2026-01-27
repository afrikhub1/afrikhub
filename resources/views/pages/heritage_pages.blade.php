<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ config('app.name') }} - @yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    /* CSS COMMUN */
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f3f4f6;
        -webkit-font-smoothing: antialiased;
    }

    /* VERSION MOBILE (< 768px) */
    @media (max-width: 767px) {
        body { font-size: 14px; }
        h1 { font-size: 1.4rem; font-weight: 700; }
        main { padding-top: 9.5rem; } /* Hauteur header mobile */
        
        .stats-link {
            flex: 1 1 20%;
            min-width: 70px;
            padding: 0.4rem;
            text-align: center;
            font-size: 0.7rem;
            font-weight: 600;
        }
        .stats-link i { display: block; margin-bottom: 2px; font-size: 1rem; }
    }

    /* VERSION DESKTOP (>= 768px) */
    @media (min-width: 768px) {
        body { font-size: 16px; line-height: 1.6; }
        h1 { font-size: 1.875rem; font-weight: 700; }
        main { padding-top: 10rem; padding-left: 2rem; padding-right: 2rem; }
        
        .stats-link {
            flex: 1 1 20%;
            min-width: 120px;
            padding: 0.5rem;
            font-size: 0.875rem;
            transition: background 0.2s;
            color: #d1d5db;
        }
        .stats-link:hover { background: linear-gradient(135deg, #006d77, #00afb9); color: white; }
    }

    /* SIDEBAR (Commune) */
    #sidebar {
        transition: transform 0.3s ease-in-out;
        transform: translateX(100%);
        position: fixed;
        top: 0; right: 0; width: 80%; max-width: 350px; height: 100%;
        z-index: 100;
        padding: 2rem 1.5rem;
        background: linear-gradient(135deg, #006d77, #00afb9);
        box-shadow: -10px 0 15px rgba(0,0,0,0.3);
    }
    #sidebar.active { transform: translateX(0); }
    .sidebar-link { display: block; padding: 0.75rem 0; color: #e5e7eb; border-bottom: 1px solid #1f2937; text-decoration: none; }

    /* Utilitaires spécifiques */
    .btn-indigo { background-color: #4f46e5; color: white; }
    @media (max-width: 590px) { .reservation { display: none; } }
    </style>
</head>

<body>

    <header class="shadow-xl fixed top-0 left-0 right-0 z-50" style="background: linear-gradient(135deg, #006d77, #00afb9);">
        <div class="max-w-7xl mx-auto px-3 md:px-4">
            
            <div class="flex items-center justify-between py-2 md:py-3">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('accueil') }}">
                        <img src="{{ asset('assets/images/logo_01.png') }}" alt="Logo" class="h-8 md:h-10 w-auto" />
                    </a>
                    <h1 class="text-white text-sm md:text-xl font-semibold m-0 truncate max-w-[120px] md:max-w-none">
                        {{ Auth::user()->name ?? 'Utilisateur' }}
                    </h1>
                </div>
                
                <div class="flex items-center space-x-1 md:space-x-3">
                    <a href="{{ route('mise_en_ligne') }}" class="btn btn-indigo px-2 py-1.5 md:px-4 md:py-2 rounded-md text-xs md:text-sm flex items-center gap-1">
                        <i class="fas fa-plus"></i> <span class="hidden sm:inline">Ajouter</span>
                    </a>

                    <a href="{{ route('clients_historique') }}" class="hidden md:flex btn btn-secondary items-center gap-2 text-sm">
                        <i class="fas fa-calendar-check"></i> Réservations
                    </a>

                    <a href="{{ route('recherche') }}" class="text-gray-400 hover:text-white p-2">
                        <i class="fas fa-search"></i>
                    </a>

                    <a href="{{ route('pro.dashboard') }}" class="hidden md:flex text-gray-400 hover:text-white p-2 border border-gray-700 rounded-lg">
                        <i class="fas fa-user"></i>
                    </a>

                    <button id="toggleSidebar" class="p-2 bg-gray-800 text-white rounded-md hover:bg-indigo-600 transition">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between border-t border-gray-800 py-2 -mx-2">
                <a href="{{ route('pro.residences') }}" class="stats-link">
                    <i class="fas fa-home text-blue-400"></i>
                    <span class="hidden md:inline">Résidences</span>
                    <span class="ml-1 px-2 bg-red-600 text-[10px] font-bold rounded-full text-white">{{ $totalResidences }}</span>
                </a>
                <a href="{{ route('occupees') }}" class="stats-link">
                    <i class="fas fa-lock text-yellow-500"></i>
                    <span class="hidden md:inline">Occupées</span>
                    <span class="ml-1 px-2 bg-yellow-600 text-[10px] font-bold rounded-full text-white">{{ $totalResidencesOccupees }}</span>
                </a>
                <a href="{{ route('mes_demandes') }}" class="stats-link">
                    <i class="fas fa-envelope text-purple-400"></i>
                    <span class="hidden md:inline">Demandes</span>
                    <span class="ml-1 px-2 bg-gray-600 text-[10px] font-bold rounded-full text-white">{{ $totalDemandesEnAttente }}</span>
                </a>
                <a href="{{ route('reservationRecu') }}" class="stats-link">
                    <i class="fas fa-history text-green-500"></i>
                    <span class="hidden md:inline">Historique</span>
                    <span class="ml-1 px-2 bg-green-600 text-[10px] font-bold rounded-full text-white">{{ $totalReservationsRecu }}</span>
                </a>
            </div>
        </div>
    </header>

    <aside id="sidebar" class="text-white">
        <div class="flex justify-between items-center mb-6">
            <span class="text-xs font-bold tracking-widest text-gray-500 uppercase">Menu</span>
            <button id="closeSidebar" class="text-gray-400 hover:text-white"><i class="fas fa-times fa-lg"></i></button>
        </div>

        <nav class="flex flex-col space-y-2">
            <a href="{{ route('accueil') }}" class="sidebar-link"><i class="fas fa-home mr-3 text-indigo-400"></i>Accueil</a>
            <a href="{{ route('pro.residences') }}" class="sidebar-link"><i class="fas fa-building mr-3 text-indigo-400"></i>Mes Résidences</a>
            <a href="{{ route('mes_demandes') }}" class="sidebar-link"><i class="fas fa-paper-plane mr-3 text-indigo-400"></i>Demandes</a>
            <a href="{{ route('reservationRecu') }}" class="sidebar-link"><i class="fas fa-check-circle mr-3 text-indigo-400"></i>Réservations</a>
            <a href="{{ route('pro.dashboard') }}" class="sidebar-link"><i class="fas fa-user-circle mr-3 text-indigo-400"></i>Mon Profil</a>
            
            <div class="pt-8">
                <a href="{{ route('logout') }}" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-bold flex items-center justify-center gap-2 transition shadow-lg">
                    <i class="fas fa-power-off"></i> Déconnexion
                </a>
            </div>
        </nav>
    </aside>

    <main>
        <div class="container-fluid m-0 p-0">
            @include('includes.messages')
            @yield('main')
        </div>
    </main>

    @include('includes.footer')

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

    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            GLightbox({ selector: '.glightbox', touchNavigation: true, loop: true, zoomable: true });
        });
    </script>
    @stack('scripts')
</body>
</html>