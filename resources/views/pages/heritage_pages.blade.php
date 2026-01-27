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

    /* BASE */
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
        -webkit-font-smoothing: antialiased;
    }

    /* VARIABLES DE COULEURS HARMONISÉES */
    :root {
        --brand-gradient: linear-gradient(135deg, #006d77, #00afb9);
        --brand-dark: #006d77;
        --brand-light: #00afb9;
    }

    /* HEADER & STATS */
    .main-header {
        background: var(--brand-gradient);
    }

    .stats-link {
        flex: 1 1 20%;
        text-align: center;
        transition: all 0.2s ease;
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
    }
    .stats-link:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
    }

    /* RESPONSIVE DESIGN */
    @media (max-width: 767px) {
        body { font-size: 14px; }
        main { padding-top: 9.5rem; }
        .stats-link { font-size: 0.7rem; padding: 0.5rem 0.2rem; }
        .stats-link i { display: block; margin-bottom: 3px; font-size: 1.1rem; }
    }

    @media (min-width: 768px) {
        main { padding-top: 10.5rem; padding-left: 2rem; padding-right: 2rem; }
        .stats-link { font-size: 0.85rem; padding: 0.6rem; border-radius: 0.5rem; }
        .stats-link i { margin-right: 5px; }
    }

    /* SIDEBAR */
    #sidebar {
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateX(100%);
        position: fixed;
        top: 0; right: 0; width: 85%; max-width: 320px; height: 100%;
        z-index: 1000;
        padding: 2rem 1.5rem;
        background: var(--brand-gradient);
        box-shadow: -10px 0 30px rgba(0,0,0,0.2);
    }
    #sidebar.active { transform: translateX(0); }
    
    .sidebar-link {
        display: flex;
        align-items: center;
        padding: 1rem;
        color: white;
        text-decoration: none;
        border-radius: 0.75rem;
        margin-bottom: 0.5rem;
        transition: background 0.2s;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .sidebar-link:hover {
        background: rgba(255, 255, 255, 0.1);
    }
    .sidebar-link i { width: 30px; font-size: 1.2rem; opacity: 0.9; }

    /* BOUTONS */
    .btn-brand {
        background: #fff;
        color: var(--brand-dark) !important;
        font-weight: 700;
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .btn-brand:hover {
        background: #f1f5f9;
        transform: translateY(-1px);
    }

    @media (max-width: 590px) { .reservation { display: none; } }
    </style>
</head>

<body>

    <header class="main-header shadow-lg fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-3 md:px-4">
            
            <div class="flex items-center justify-between py-2 md:py-4">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('accueil') }}">
                        <img src="{{ asset('assets/images/logo_01.png') }}" alt="Logo" class="h-9 md:h-12 w-auto" />
                    </a>
                    <h1 class="text-white text-base md:text-xl font-bold m-0 tracking-tight truncate max-w-[130px] md:max-w-none">
                        {{ Auth::user()->name ?? 'Espace Pro' }}
                    </h1>
                </div>
                
                <div class="flex items-center space-x-2 md:space-x-4">
                    <a href="{{ route('mise_en_ligne') }}" class="btn btn-brand px-3 py-1.5 md:px-5 md:py-2 rounded-lg text-xs md:text-sm flex items-center gap-2 transition-all">
                        <i class="fas fa-plus-circle"></i> <span class="hidden sm:inline">Ajouter</span>
                    </a>

                    <a href="{{ route('recherche') }}" class="text-white/80 hover:text-white p-2 transition">
                        <i class="fas fa-search fa-lg"></i>
                    </a>

                    <button id="toggleSidebar" class="p-2 bg-white/10 text-white rounded-lg hover:bg-white/20 transition-all border border-white/20">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between border-t border-white/10 py-2">
                <a href="{{ route('pro.residences') }}" class="stats-link">
                    <i class="fas fa-home"></i>
                    <span class="hidden md:inline">Résidences</span>
                    <span class="ml-1 px-2 py-0.5 bg-white/20 text-[10px] font-black rounded-full text-white">{{ $totalResidences }}</span>
                </a>
                <a href="{{ route('occupees') }}" class="stats-link">
                    <i class="fas fa-calendar-check"></i>
                    <span class="hidden md:inline">Occupées</span>
                    <span class="ml-1 px-2 py-0.5 bg-yellow-400 text-[10px] font-black rounded-full text-black">{{ $totalResidencesOccupees }}</span>
                </a>
                <a href="{{ route('mes_demandes') }}" class="stats-link">
                    <i class="fas fa-bell"></i>
                    <span class="hidden md:inline">Demandes</span>
                    <span class="ml-1 px-2 py-0.5 bg-red-500 text-[10px] font-black rounded-full text-white">{{ $totalDemandesEnAttente }}</span>
                </a>
                <a href="{{ route('reservationRecu') }}" class="stats-link">
                    <i class="fas fa-receipt"></i>
                    <span class="hidden md:inline">Historique</span>
                    <span class="ml-1 px-2 py-0.5 bg-green-400 text-[10px] font-black rounded-full text-black">{{ $totalReservationsRecu }}</span>
                </a>
            </div>
        </div>
    </header>

    <aside id="sidebar">
        <div class="flex justify-between items-center mb-10">
            <div class="bg-white/10 px-3 py-1 rounded-full">
                <span class="text-[10px] font-black tracking-widest text-white uppercase">Menu Navigation</span>
            </div>
            <button id="closeSidebar" class="w-10 h-10 flex items-center justify-center rounded-full bg-black/10 text-white hover:bg-black/20 transition">
                <i class="fas fa-times fa-lg"></i>
            </button>
        </div>

        <nav class="space-y-1">
            <a href="{{ route('accueil') }}" class="sidebar-link"><i class="fas fa-th-large"></i> Accueil</a>
            <a href="{{ route('pro.residences') }}" class="sidebar-link"><i class="fas fa-layer-group"></i> Mes Résidences</a>
            <a href="{{ route('mes_demandes') }}" class="sidebar-link"><i class="fas fa-inbox"></i> Demandes</a>
            <a href="{{ route('reservationRecu') }}" class="sidebar-link"><i class="fas fa-history"></i> Historique</a>
            <a href="{{ route('clients_historique') }}" class="sidebar-link"><i class="fas fa-user"></i> Mode Client</a>
            <a href="{{ route('pro.dashboard') }}" class="sidebar-link"><i class="fas fa-user-cog"></i> Mon Profil</a>
            
            <div class="mt-12 pt-6 border-t border-white/10">
                <a href="{{ route('logout') }}" class="flex items-center justify-center gap-3 w-full py-4 bg-white text-[#006d77] rounded-xl font-black shadow-xl hover:bg-red-50 hover:text-red-600 transition-all active:scale-95">
                    <i class="fas fa-power-off"></i> DÉCONNEXION
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

        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.add('active');
            document.body.style.overflow = 'hidden'; // Empêche le scroll quand menu ouvert
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('active');
            document.body.style.overflow = '';
        });

        document.addEventListener('click', e => {
            if (!sidebar.contains(e.target) && !toggleSidebar.contains(e.target)) {
                sidebar.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    </script>
</body>
</html>