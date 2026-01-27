<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche - Afrik'hub</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">

    <style>
        :root {
            --color-primary: #006d77;
            --color-primary-light: #00afb9;
            --color-accent: #ffb703;
            --main-gradient: linear-gradient(135deg, #006d77, #00afb9);
            --color-soft-bg: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: #444;
        }

        /* ===== HEADER ===== */
        .main-header {
            background: var(--main-gradient);
            color: white;
        }
        .main-header .nav-link {
            color: white !important;
            font-weight: 500;
        }
        .main-header .nav-link:hover {
            opacity: 0.85;
        }

        .btn-custom-primary {
            background: white;
            color: var(--color-primary);
            border: none;
            font-weight: 600;
        }
        .btn-custom-primary:hover {
            background: #f1f5f9;
            color: var(--color-primary);
        }

        .btn-outline-custom {
            border: 2px solid white;
            color: white;
            background: transparent;
        }
        .btn-outline-custom:hover {
            background: white;
            color: var(--color-primary);
        }

        .card {
            border-radius: 16px;
            transition: 0.3s;
        }
        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 28px rgba(0,0,0,0.12);
        }

        .card-img-top {
            height: 12rem;
            object-fit: cover;
        }

        /* Sidebar */
        #sidebar {
            position: fixed;
            right: 0;
            top: 0;
            height: 100%;
            max-width: 300px;
            width: 100%;
            background: var(--color-soft-bg);
            transform: translateX(100%);
            transition: 0.4s;
            z-index: 1060;
            padding: 1.5rem;
        }
        #sidebar.active {
            transform: translateX(0);
        }
        #sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.35);
            display: none;
            z-index: 1050;
        }
        #sidebar-overlay.active {
            display: block;
        }
        .sidebar-link {
            display: block;
            padding: 12px 14px;
            border-radius: 10px;
            color: #374151;
            text-decoration: none;
        }
        .sidebar-link:hover {
            background: rgba(0,109,119,0.1);
        }
    </style>
</head>

<body>

<!-- ================= HEADER ================= -->
<header class="main-header">
    <div class="container-fluid px-4 py-3 d-flex align-items-center justify-content-between">

        <a href="{{ route('accueil') }}">
            <img src="{{ asset('assets/images/logo_01.png') }}" style="width:75px">
        </a>

        <form class="d-none d-md-flex mx-auto" style="max-width:450px"
              method="GET" action="{{ route('recherche') }}">
            <input class="form-control me-2 rounded-pill px-4"
                   type="search"
                   name="ville_quartier"
                   placeholder="Rechercher une ville..."
                   value="{{ request('ville_quartier') ?? '' }}">
            <button class="btn btn-light rounded-circle" style="width:45px;height:45px">
                <i class="fas fa-search text-primary"></i>
            </button>
        </form>

        <ul class="navbar-nav d-none d-lg-flex flex-row gap-3 align-items-center mb-0">

            <li><a href="{{ route('accueil') }}" class="nav-link">Accueil</a></li>
            <li><a href="{{ route('faq') }}" class="nav-link">FAQ</a></li>

            @auth
                {{-- CLIENT UNIQUEMENT --}}
                @if(Auth::user()->type_compte === 'client')
                    <li>
                        <a href="{{ route('clients_historique') }}" class="nav-link">
                            Mes réservations
                        </a>
                    </li>
                @endif

                {{-- PROFESSIONNEL UNIQUEMENT --}}
                @if(Auth::user()->type_compte === 'professionnel')
                    <li>
                        <a href="{{ route('pro.dashboard') }}" class="nav-link">
                            Dashboard Pro
                        </a>
                    </li>
                @endif

                <li>
                    <a href="{{ route('logout') }}"
                       class="btn btn-custom-primary rounded-pill px-4">
                        Déconnexion
                    </a>
                </li>
            @endauth

            @guest
                <li>
                    <a href="{{ route('login') }}"
                       class="btn btn-custom-primary rounded-pill px-4">
                        Connexion
                    </a>
                </li>
            @endguest
        </ul>

        <button id="toggleSidebar" class="btn btn-light rounded-circle ms-3">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</header>

<!-- ================= SIDEBAR ================= -->
<div id="sidebar-overlay" onclick="toggleSidebar()"></div>
<div id="sidebar">

    <button class="btn btn-light rounded-circle mb-4" onclick="toggleSidebar()">
        <i class="fas fa-times"></i>
    </button>

    @auth
        <div class="mb-4 border-bottom pb-3">
            <strong>{{ Auth::user()->name }}</strong><br>
            <span class="badge bg-light text-primary border">
                {{ Auth::user()->type_compte }}
            </span>
        </div>
    @endauth

    <a href="{{ route('accueil') }}" class="sidebar-link">
        <i class="fas fa-home me-2 text-primary"></i> Accueil
    </a>

    {{-- CLIENT --}}
    @auth
        @if(Auth::user()->type_compte === 'client')
            <a href="{{ route('clients_historique') }}" class="sidebar-link">
                <i class="fas fa-calendar-check me-2 text-primary"></i> Mes réservations
            </a>
            <a href="{{ route('factures') }}" class="sidebar-link">
                <i class="fas fa-file-invoice me-2 text-primary"></i> Mes factures
            </a>
        @endif

        {{-- PRO --}}
        @if(Auth::user()->type_compte === 'professionnel')
            <a href="{{ route('pro.dashboard') }}" class="sidebar-link">
                <i class="fas fa-gauge me-2 text-primary"></i> Dashboard Pro
            </a>
            <a href="{{ route('pro.residences') }}" class="sidebar-link">
                <i class="fas fa-building me-2 text-primary"></i> Mes résidences
            </a>
        @endif
    @endauth

    <a href="{{ route('faq') }}" class="sidebar-link">
        <i class="fas fa-circle-question me-2 text-primary"></i> FAQ
    </a>

    <div class="mt-auto pt-4">
        <a href="{{ route('logout') }}"
           class="btn btn-outline-danger w-100 rounded-pill">
            Quitter
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
        document.getElementById('sidebar-overlay').classList.toggle('active');
    }
    document.getElementById('toggleSidebar').addEventListener('click', toggleSidebar);
</script>

</body>
</html>
