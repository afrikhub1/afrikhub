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

    /* ===== Base (Mode Clair) ===== */
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f9fafb;
        font-size: 16px; /* Base pour desktop */
        line-height: 1.5;
        color: #1f2937;
        -webkit-font-smoothing: antialiased;
    }

    /* ===== Typographie Responsive ===== */
    h1 { font-size: 1.75rem; font-weight: 700; color: #111827; letter-spacing: -0.025em; }
    h2 { font-size: 1.35rem; font-weight: 600; color: #111827; }
    h5 { font-size: 1rem; font-weight: 500; }
    p, span, li, a { font-size: 1rem; }

    /* Ajustements pour écrans < 720px */
    @media (max-width: 720px) {
        body { font-size: 14px; } /* Réduction de la base */
        h1 { font-size: 1.4rem; }
        h2 { font-size: 1.15rem; }
        h5 { font-size: 0.9rem; }
        p, span, li, a { font-size: 0.95rem; }
        
        /* Ajustement du Header Mobile */
        header h1 { font-size: 0.9rem !important; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 120px; }
    }

    /* ===== Header & Stats ===== */
    .stats-link {
        flex: 1 1 20%;
        min-width: 100px;
        padding: 0.4rem;
        text-align: center;
        border-radius: 0.5rem;
        font-size: 0.75rem; /* Plus petit pour tenir sur une ligne */
        font-weight: 600;
        color: #9ca3af;
        transition: all 0.2s;
    }
    .stats-link i { display: block; margin-bottom: 2px; font-size: 1rem; }
    
    @media (min-width: 768px) {
        .stats-link { font-size: 0.85rem; }
        .stats-link i { display: inline; margin-bottom: 0; margin-right: 4px; }
    }

    /* ===== Sidebar ===== */
    #sidebar {
        transition: transform 0.3s ease-in-out;
        transform: translateX(100%);
        position: fixed;
        top: 0; right: 0; width: 85%; max-width: 320px; height: 100%;
        z-index: 100;
        padding: 2rem 1.5rem;
        background-color: #111827;
        box-shadow: -10px 0 15px -3px rgba(0, 0, 0, 0.1);
    }
    #sidebar.active { transform: translateX(0); }
    .sidebar-link { display: block; padding: 0.75rem 0; color: #e5e7eb; border-bottom: 1px solid #1f2937; }

    /* ===== Main Spacing ===== */
    main { padding-top: 10.5rem; } /* Espace pour le header double */
    
    @media (max-width: 720px) {
        main { padding-top: 9.5rem; } 
    }

    /* Utilitaires */
    .btn-indigo { background-color: #4f46e5; color: white; }
    .btn-indigo:hover { background-color: #4338ca; }
    </style>
</head>

<body class="bg-gray-50">

    <header class="bg-gray-900 shadow-xl fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-3">
            <div class="flex items-center justify-between py-2 md:py-3">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('accueil') }}">
                        <img src="{{ asset('assets/images/logo_01.png') }}" alt="Logo" class="h-8 md:h-10 w-auto" />
                    </a>
                    <h1 class="text-white text-base md:text-lg m-0">{{ Auth::user()->name ?? 'Pro' }}</h1>
                </div>
                
                <div class="flex items-center space-x-1 md:space-x-2">
                    <a href="{{ route('mise_en_ligne') }}" class="px-2 py-1.5 rounded-md bg-indigo-600 text-white text-xs font-bold md:text-sm flex items-center gap-1">
                        <i class="fas fa-plus"></i> <span class="hidden xs:inline">Ajouter</span>
                    </a>
                    <a href="{{ route('recherche') }}" class="p-2 text-gray-400 hover:text-white">
                        <i class="fas fa-search"></i>
                    </a>
                    <button id="toggleSidebar" class="p-2 bg-gray-800 text-white rounded-md">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between border-t border-gray-800 py-2">
                <a href="{{ route('pro.residences') }}" class="stats-link">
                    <i class="fas fa-home text-blue-400"></i>
                    <span>{{ $totalResidences }}</span>
                </a>
                <a href="{{ route('occupees') }}" class="stats-link">
                    <i class="fas fa-lock text-yellow-500"></i>
                    <span>{{ $totalResidencesOccupees }}</span>
                </a>
                <a href="{{ route('mes_demandes') }}" class="stats-link">
                    <i class="fas fa-envelope text-purple-400"></i>
                    <span>{{ $totalDemandesEnAttente }}</span>
                </a>
                <a href="{{ route('reservationRecu') }}" class="stats-link">
                    <i class="fas fa-history text-green-500"></i>
                    <span>{{ $totalReservationsRecu }}</span>
                </a>
            </div>
        </div>
    </header>

    <aside id="sidebar">
        <div class="flex justify-between items-center mb-8">
            <span class="text-xs font-bold tracking-widest text-gray-500 uppercase">Menu</span>
            <button id="closeSidebar" class="text-gray-400"><i class="fas fa-times fa-lg"></i></button>
        </div>

        <nav class="space-y-1">
            <a href="{{ route('accueil') }}" class="sidebar-link font-medium">Tableau de bord</a>
            <a href="{{ route('pro.residences') }}" class="sidebar-link">Mes Résidences</a>
            <a href="{{ route('mes_demandes') }}" class="sidebar-link">Demandes</a>
            <a href="{{ route('reservationRecu') }}" class="sidebar-link">Historique</a>
            <a href="{{ route('pro.dashboard') }}" class="sidebar-link">Mon Profil</a>
            
            <div class="pt-10">
                <a href="{{ route('logout') }}" class="flex items-center justify-center gap-2 w-full py-3 bg-red-600/10 text-red-500 rounded-xl font-bold border border-red-600/20">
                    <i class="fas fa-power-off"></i> Déconnexion
                </a>
            </div>
        </nav>
    </aside>

    <main class="max-w-7xl mx-auto px-2 md:px-4">
        @include('includes.messages')
        @yield('main')
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
</body>
</html>