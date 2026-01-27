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
            --color-primary: #FFA500; /* Ta couleur de base exacte */
            --color-primary-hover: #e69500;
            --color-secondary: #212529;
            --color-background: #ffffff; /* Fond blanc pur sans mode sombre */
            --footer-height: 60px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-background);
            color: var(--color-secondary);
            padding-bottom: var(--footer-height);
        }

        /* Boutons personnalisés */
        .btn-custom-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: white !important;
            transition: all 0.2s;
        }

        .btn-custom-primary:hover {
            background-color: var(--color-primary-hover);
            border-color: var(--color-primary-hover);
            transform: translateY(-1px);
        }

        .btn-dark-secondary {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            color: white;
        }

        /* Cartes de résidence */
        .card {
            background-color: #ffffff;
            border: 1px solid #eee;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .text-primary {
            color: var(--color-primary) !important;
        }

        /* Icônes de détails */
        .fa-bed, .fa-map-marker-alt, .fa-hotel {
            color: var(--color-primary) !important;
        }

        /* Sidebar Coulissante */
        #sidebar {
            transition: transform 0.3s ease-in-out;
            transform: translateX(100%);
            position: fixed;
            top: 0;
            right: 0;
            width: 100%;
            max-width: 300px;
            z-index: 1060;
            height: 100%;
            background-color: var(--color-secondary);
            padding: 1.5rem;
            box-shadow: -6px 0 16px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
        }

        #sidebar.active {
            transform: translateX(0);
        }

        .sidebar-link {
            color: #dee2e6;
            padding: 12px 15px;
            text-decoration: none;
            display: block;
            border-radius: 8px;
        }

        .sidebar-link:hover {
            background-color: #343a40;
            color: var(--color-primary);
        }

        /* Badge disponibilité */
        .bg-orange-100 { background-color: #fff9f0; }
        .text-orange-700 { color: var(--color-primary); }

        /* Barre de recherche */
        .form-control:focus {
            border-color: var(--color-primary);
            box-shadow: 0 0 0 0.25rem rgba(255, 165, 0, 0.2);
        }
    </style>
</head>

<body>

<header class="bg-dark shadow">
    <div class="container-fluid px-3 py-2 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <a href="{{ route('accueil') }}">
                <img style="width: 80px;" src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo"/>
            </a>
        </div>

        <form class="d-flex mx-auto search-form-container" style="max-width: 500px;" method="GET" action="{{ route('recherche') }}">
            <input class="form-control me-2 rounded-pill border-secondary" type="search"
                   placeholder="Ville, quartier..." aria-label="Rechercher" name="ville_quartier"
                   value="{{ request('ville_quartier') ?? '' }}" />
            <button class="btn btn-custom-primary rounded-pill" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <ul class="navbar-nav d-none d-lg-flex flex-row align-items-center mb-0 ms-4">
            <li class="nav-item mx-2">
                @if(Auth::user()->type_compte == 'professionnel')
                    <a href="{{ route('pro.dashboard') }}" class="nav-link text-white fw-bold"> <i class="fas fa-user-circle"></i> Profil</a>
                @else
                    <a href="{{ route('clients_historique') }}" class="nav-link text-white fw-bold"> <i class="fa fa-user-circle"></i> Profil</a>
                @endif
            </li>
            <li class="nav-item mx-2">
                <a href="{{ route('logout') }}" class="btn btn-custom-primary btn-sm px-3 rounded-pill">
                    <i class="fa fa-sign-out"></i> Déconnexion
                </a>
            </li>
        </ul>

        <button id="toggleSidebar" class="btn btn-link ms-3 p-0" type="button">
             <i class="fas fa-bars fa-lg text-white"></i>
        </button>
    </div>
</header>

<div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 hidden z-[1050]"></div>

<div id="sidebar" class="text-white">
    <button class="btn text-white float-end mb-4" onclick="toggleSidebar()">
        <i class="fas fa-times fa-2x"></i>
    </button>

    <div class="w-100 mt-5">
        <div class="text-center mb-4 pb-3 border-bottom border-secondary">
             @auth <h4 class="text-muted"> {{ Auth::user()->name }}</h4> @endauth
        </div>

        @if(Auth::user()->type_compte == 'professionnel')
            <a href="{{ route('reservationRecu') }}" class="sidebar-link"><i class="fas fa-history me-2"></i> Historique</a>
            <a href="{{ route('pro.residences') }}" class="sidebar-link"><i class="fas fa-hotel me-2"></i> Mes Résidences</a>
            <a href="{{ route('mise_en_ligne') }}" class="sidebar-link"><i class="fas fa-upload me-2"></i> Publier</a>
        @endif
        <a href="{{ route('accueil') }}" class="sidebar-link"><i class="fas fa-home me-2"></i> Accueil</a>

        <div class="mt-4 pt-3 border-top border-secondary">
            <a href="{{ route('logout') }}" class="btn btn-custom-primary rounded-pill w-100">Déconnexion</a>
        </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="mb-5 text-center fw-bold fs-3">
        Résultats pour : <span class="text-primary">{{ request('ville_quartier') ?: 'Toutes les résidences' }}</span>
    </h2>

    <div class="row g-4 justify-content-center">
        @forelse($recherches as $residence)
            @php
                $images = is_string($residence->img) ? json_decode($residence->img, true) : ($residence->img ?? []);
                $firstImage = $images[0] ?? asset('assets/images/placeholder.jpg');
            @endphp

            <div class="col-sm-6 col-lg-4 col-xl-3 d-flex">
                <div class="card shadow-sm h-100 w-100">
                    <a href="javascript:void(0)" class="glightbox-trigger-{{ $residence->id }}">
                        <img src="{{ $firstImage }}" class="card-img-top" loading="lazy" style="height: 200px; object-fit: cover;">
                    </a>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $residence->nom }}</h5>
                        <p class="small text-muted mb-3">{{ Str::limit($residence->description, 70) }}</p>
                        
                        <div class="mb-3 small">
                            <div class="mb-1"><i class="fas fa-map-marker-alt me-2"></i>{{ $residence->ville }}</div>
                            <div class="fw-bold text-success"><i class="fas fa-money-bill-wave me-2"></i>{{ number_format($residence->prix_journalier, 0, ',', ' ') }} FCFA / jour</div>
                        </div>

                        <a href="{{ route('details', $residence->id) }}" class="btn btn-dark-secondary rounded-pill mt-auto">
                            Détails <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-warning text-center">Aucune résidence trouvée.</div>
        @endforelse
    </div>
</div>

@include('includes.footer')

<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
        document.getElementById('sidebar-overlay').classList.toggle('hidden');
    }
    const lightbox = GLightbox();
</script>
</body>
</html>