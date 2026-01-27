<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche - Afrik'hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet" />

    <style>
        :root {
            --color-primary: #006d77; 
            --color-primary-light: #00afb9;
            --main-gradient: linear-gradient(135deg, #006d77, #00afb9);
            --color-soft-bg: #f8f9fa;
            --color-background: #FFFFFF; 
            --footer-height: 60px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-background);
            padding-bottom: var(--footer-height);
            color: #444;
        }

        .btn-custom-primary {
            background: var(--main-gradient);
            border: none;
            color: white;
            transition: transform 0.2s;
        }
        .btn-custom-primary:hover {
            transform: scale(1.02);
            color: white;
            opacity: 0.9;
        }

        .btn-outline-custom {
            border: 2px solid var(--color-primary);
            color: var(--color-primary);
            background: transparent;
        }
        .btn-outline-custom:hover {
            background: var(--color-primary);
            color: white;
        }

        .text-primary { color: var(--color-primary) !important; }

        .card {
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid #edf2f7 !important;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 109, 119, 0.1);
        }
        .card-img-top { height: 12rem; object-fit: cover; }

        /* Sidebar version claire */
        #sidebar {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(100%);
            position: fixed;
            top: 0; right: 0;
            width: 100%; max-width: 300px;
            z-index: 1060;
            height: 100%;
            background-color: var(--color-soft-bg);
            padding: 1.5rem;
            border-left: 1px solid #eee;
        }
        #sidebar.active { transform: translateX(0); }
        .sidebar-link {
            color: #4a5568;
            padding: 12px 15px;
            text-decoration: none;
            font-size: 0.95rem;
            display: block;
            border-radius: 8px;
        }
        #sidebar-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.3); z-index: 1050; display: none;
        }
        #sidebar-overlay.active { display: block; }
    </style>
</head>

<body>

<header class="bg-white border-bottom border-light">
    <div class="container-fluid px-4 py-3 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <a href="{{ route('accueil') }}">
                <img style="width: 75px;" src="{{ asset('assets/images/logo_01.png') }}" alt="Logo"/>
            </a>
        </div>

        {{-- FORMULAIRE DE RECHERCHE --}}
        <form class="d-flex mx-auto search-form-container d-none d-md-flex" style="max-width: 450px;" method="GET" action="{{ route('residences.recherche') }}">
            <input class="form-control me-2 rounded-pill border-light-subtle bg-light px-4" type="search"
                   placeholder="Rechercher une ville..." name="ville_quartier"
                   value="{{ request('ville_quartier') ?? '' }}">
            <button class="btn btn-custom-primary rounded-circle" style="width: 45px; height: 45px;" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>

        {{-- MENU NAV --}}
        <ul class="navbar-nav d-none d-lg-flex flex-row gap-3 align-items-center mb-0">
            <li><a href="{{ route('accueil') }}" class="nav-link">Accueil</a></li>
            <li><a href="{{ route('residences.recherche') }}" class="nav-link">Rechercher</a></li>
            <li><a href="{{ route('faq') }}" class="nav-link">FAQ</a></li>

            @auth
                @if(Auth::user()->type_compte === 'client')
                    <li><a href="{{ route('clients_historique') }}" class="nav-link">Mes réservations</a></li>
                    <li><a href="{{ route('devenir_pro') }}" class="btn btn-outline-custom rounded-pill px-3">Devenir Pro</a></li>
                @endif

                @if(Auth::user()->type_compte === 'professionnel')
                    <li><a href="{{ route('utilisateur_pro') }}" class="nav-link">Mes résidences</a></li>
                    <li><a href="{{ route('pro.dashboard') }}" class="nav-link">Dashboard Pro</a></li>
                @endif

                <li>
                    <a href="{{ route('logout') }}" class="btn btn-custom-primary rounded-pill px-4">
                        Déconnexion
                    </a>
                </li>
            @endauth

            @guest
                <li>
                    <a href="{{ route('login') }}" class="btn btn-custom-primary rounded-pill px-4">
                        Connexion
                    </a>
                </li>
            @endguest
        </ul>

        <button id="toggleSidebar" class="btn btn-light rounded-circle ms-3 shadow-sm" type="button">
             <i class="fas fa-bars text-primary"></i>
        </button>
    </div>
</header>

{{-- SIDEBAR --}}
<div id="sidebar-overlay" onclick="toggleSidebar()"></div>
<div id="sidebar" class="shadow-xl">
    <button id="closeSidebar" class="btn btn-light rounded-circle mb-4" type="button" onclick="toggleSidebar()">
        <i class="fas fa-times text-muted"></i>
    </button>
    <div class="w-100 d-flex flex-column gap-2">
        @auth
            <div class="mb-4 pb-3 border-bottom">
                 <h4 class="h6 fw-bold text-dark mb-1"> {{ Auth::user()->name }}</h4>
                 <span class="badge rounded-pill bg-light text-primary border">{{ Auth::user()->type_compte }}</span>
            </div>
        @endauth

        <a href="{{ route('accueil') }}" class="sidebar-link"><i class="fas fa-home me-2 text-primary"></i> Accueil</a>
        <a href="{{ route('residences.recherche') }}" class="sidebar-link"><i class="fas fa-search me-2 text-primary"></i> Rechercher</a>

        @auth
            @if(Auth::user()->type_compte === 'client')
                <a href="{{ route('clients_historique') }}" class="sidebar-link"><i class="fas fa-book me-2 text-primary"></i> Mes réservations</a>
                <a href="{{ route('devenir_pro') }}" class="sidebar-link"><i class="fas fa-user-tie me-2 text-primary"></i> Devenir Pro</a>
            @endif

            @if(Auth::user()->type_compte === 'professionnel')
                <a href="{{ route('utilisateur_pro') }}" class="sidebar-link"><i class="fas fa-building me-2 text-primary"></i> Mes résidences</a>
                <a href="{{ route('pro.dashboard') }}" class="sidebar-link"><i class="fas fa-tachometer-alt me-2 text-primary"></i> Dashboard Pro</a>
            @endif
        @endauth

        <div class="mt-auto pt-4">
            <a href="{{ route('logout') }}" class="btn btn-outline-danger w-100 rounded-pill border-light">Quitter</a>
        </div>
    </div>
</div>

{{-- CONTENU PRINCIPAL --}}
<div class="container my-5">
    <h2 class="mb-5 text-center fw-bold">
        Résultats pour : <span class="text-primary">{{ request('ville_quartier') ?: 'Toutes les résidences' }}</span>
    </h2>

    {{-- FORMULAIRE FILTRE --}}
    <form method="GET" action="{{ route('residences.recherche') }}" class="row g-2 mb-4">
        <div class="col-md-4">
            <input type="text" name="ville_quartier" class="form-control" placeholder="Ville ou quartier" value="{{ request('ville_quartier') }}">
        </div>
        <div class="col-md-3">
            <select name="type" class="form-select">
                <option value="">Type de résidence</option>
                <option value="studio" @selected(request('type')=='studio')>Studio</option>
                <option value="appartement" @selected(request('type')=='appartement')>Appartement</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="prix_max" class="form-control" placeholder="Prix max" value="{{ request('prix_max') }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Rechercher</button>
        </div>
    </form>

    {{-- LISTE DES RESIDENCES --}}
    <div class="row g-4 justify-content-center">
        @forelse($residences as $residence)
            @php
                $images = is_string($residence->img) ? json_decode($residence->img, true) : ($residence->img ?? []);
                $firstImage = $images[0] ?? asset('assets/images/placeholder.jpg');
                $dateDispo = \Carbon\Carbon::parse($residence->date_disponible);
            @endphp

            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
                <div class="card h-100 w-100 shadow-sm border-0">
                    <img src="{{ $firstImage }}" alt="{{ $residence->nom }}" class="card-img-top">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-2">{{ $residence->nom }}</h5>
                        <div class="d-flex flex-wrap gap-3 small mb-3 text-muted">
                            <span><i class="fas fa-bed me-1 text-primary"></i> <strong>{{ $residence->nombre_chambres ?? '0' }}</strong> Chambre(s)</span>
                            <span><i class="fas fa-couch me-1 text-primary"></i> <strong>{{ $residence->nombre_salons ?? '0' }}</strong> Salon(s)</span>
                        </div>

                        <div class="small mb-3">
                            <div class="mb-1"><i class="fas fa-map-marker-alt me-2 text-primary"></i> {{ $residence->ville }}</div>
                            <div class="fw-bold text-dark">{{ number_format($residence->prix_journalier ?? 0, 0, ',', ' ') }} FCFA / jour</div>
                        </div>

                        <div class="mb-4">
                            @if ($dateDispo->isPast())
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Disponible</span>
                            @elseif ($dateDispo->isToday())
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">Aujourd'hui</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-700">Libre le {{ $dateDispo->translatedFormat('d F') }}</span>
                            @endif
                        </div>

                        {{-- BOUTONS SELON TYPE --}}
                        @auth
                            @if(Auth::user()->type_compte === 'client')
                                <a href="{{ route('reservation.store', $residence->id) }}" class="btn btn-success rounded-pill mt-auto w-100">Réserver</a>
                            @endif
                            @if(Auth::user()->type_compte === 'professionnel')
                                <span class="badge bg-info mt-auto">Mode professionnel</span>
                            @endif
                        @endauth

                        <a href="{{ route('details', $residence->id) }}" class="btn btn-outline-custom rounded-pill mt-2 w-100">
                            Détails
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="fw-medium text-muted">Aucune résidence trouvée.</p>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $residences->withQueryString()->links() }}
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
