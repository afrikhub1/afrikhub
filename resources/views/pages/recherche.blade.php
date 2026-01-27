<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche - Afrik'hub</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet" />

    <style>
        /* Variables de couleur et Police */
        :root {
            --color-primary: #FF8C00; /* Orange Custom */
            --color-primary-hover: #CC7000;
            --color-secondary: #212529; /* Dark Bootstrap */
            --color-background: #FFFFFF; /* Fond Blanc (Pas de Dark Mode) */
            --footer-height: 60px;
        }
        
        body {
            font-family: 'Inter', sans-serif; /* Typographie plus moderne */
            background-color: var(--color-background);
            color: #1a1a1a;
            padding-bottom: var(--footer-height);
            -webkit-font-smoothing: antialiased;
        }

        /* Ajustements Typographiques */
        h2 { font-weight: 800; letter-spacing: -0.02em; }
        .card-title { font-weight: 700; color: #111; }
        .card-text { font-weight: 400; line-height: 1.5; color: #4b5563; }
        .sidebar-link { font-weight: 500; letter-spacing: 0.01em; }

        /* Boutons personnalisés */
        .btn-custom-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: white;
            font-weight: 600;
            transition: background-color 0.2s, transform 0.1s;
        }
        .btn-custom-primary:hover {
            background-color: var(--color-primary-hover);
            border-color: var(--color-primary-hover);
            color: white;
            transform: translateY(-1px);
        }
        .btn-dark-secondary {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            color: white;
            font-weight: 600;
        }
        .btn-dark-secondary:hover {
            background-color: #343a40;
            color: white;
        }

        /* Styles des cartes */
        .card {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #edf2f7;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #ffffff;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        }
        .card-img-top {
            height: 12rem;
            object-fit: cover;
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
            box-shadow: -6px 0 16px rgba(0, 0, 0, 0.3);
            overflow-y: auto;
        }
        #sidebar.active { transform: translateX(0); }
        .sidebar-link {
            color: #dee2e6;
            padding: 12px 15px;
            text-decoration: none;
            display: block;
        }
        .sidebar-link:hover {
            background-color: #343a40;
            color: white;
            border-radius: 8px;
        }
        #sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1050;
            display: none;
        }
        #sidebar-overlay.active { display: block; }
    </style>
</head>

<body class="p-0">

<header class="bg-dark shadow">
    <div class="container-fluid px-3 py-2 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <a href="{{ route('accueil') }}">
                <img class="h-auto" style="width: 80px;" src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo"/>
            </a>
        </div>

        <form class="d-flex mx-auto search-form-container" style="max-width: 500px;" method="GET" action="{{ route('recherche') }}">
            <input class="form-control me-2 rounded-pill border-0 shadow-sm ps-4" type="search"
                   placeholder="Ville, quartier, référence..." aria-label="Rechercher" name="ville_quartier"
                   value="{{ request('ville_quartier') ?? '' }}" />
            <button class="btn btn-custom-primary text-white rounded-pill" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <ul class="navbar-nav d-none d-lg-flex flex-row align-items-center mb-0 ms-4 g-4">
            <li class="nav-item mx-2">
                @if(Auth::user()->type_compte == 'professionnel')
                    <a href="{{ route('pro.dashboard') }}" class="nav-link text-white fw-bold mx-2"> <i class="fas fa-user-circle"></i> Profil</a>
                @endif
                @if(Auth::user()->type_compte == 'client')
                    <a href="{{ route('clients_historique') }}" class="nav-link text-white fw-bold mx-2">
                        <i class="fa fa-user-circle me-2"></i>Profil
                    </a>
                @endif
            </li>
            <a href="javascript:history.back()" class="nav-link text-white fw-bold mx-3">
               <i class="fas fa-arrow-left me-1"></i> Retour</a>
            <li class="nav-item mx-2">
                <a href="{{ route('logout') }}" class="btn btn-custom-primary btn-sm px-3 py-2 d-flex align-items-center rounded-pill">
                    <i class="fa fa-sign-out me-2"></i> Déconnexion
                </a>
            </li>
        </ul>

        <button id="toggleSidebar" class="btn btn-link ms-3 p-0" type="button" aria-label="Menu">
             <i class="fas fa-bars fa-lg text-white"></i>
        </button>
    </div>
</header>

<div id="sidebar-overlay" onclick="toggleSidebar()"></div>
<div id="sidebar" class="text-white d-flex flex-column">
    <button id="closeSidebar" class="btn text-white align-self-end p-0 mb-4" type="button" onclick="toggleSidebar()">
        <i class="fas fa-times fa-2x"></i>
    </button>

    <div class="w-100 d-flex flex-column gap-1">
        <div class="text-center mb-4 pb-3 border-bottom border-secondary">
             @auth
                 <h4 class="text-xl font-bold mb-0"> {{ Auth::user()->name }}</h4>
             @endauth
        </div>

        @if(Auth::user()->type_compte == 'professionnel')
            <a href="{{ route('reservationRecu') }}" class="sidebar-link"><i class="fas fa-history me-2"></i> Mon Historique</a>
            <a href="{{ route('pro.dashboard') }}" class="sidebar-link"><i class="fas fa-user-circle me-2"></i> Mon Compte</a>
            <a href="{{ route('pro.residences') }}" class="sidebar-link"><i class="fas fa-hotel me-2"></i> Mes Residences</a>
            <a href="{{ route('mise_en_ligne') }}" class="sidebar-link"><i class="fas fa-upload me-2"></i> Mise en ligne</a>
            <a href="{{ route('occupees') }}" class="sidebar-link"><i class="fas fa-calendar-alt me-2"></i> Résidences Occupées</a>
            <a href="{{ route('mes_demandes') }}" class="sidebar-link"><i class="fas fa-bell me-2"></i> Demandes de Réservations</a>
        @endif
         @if(Auth::user()->type_compte == 'client')
            <a href="{{ route('clients_historique') }}" class="sidebar-link"><i class="fas fa-user-circle me-2"></i> Mon Compte</a>
        @endif
        <a href="{{ route('accueil') }}" class="sidebar-link"><i class="fas fa-home me-2"></i> Accueil</a>

        <div class="mt-4 pt-3 border-top border-secondary">
            <a href="{{ route('logout') }}" class="btn btn-custom-primary rounded-pill w-100 shadow">
                <i class="fa fa-sign-out me-2"></i> Déconnexion
            </a>
        </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="mb-5 text-center text-secondary">
        Résultats de recherche pour : <span class="text-primary">{{ request('ville_quartier') ?: 'Toutes les résidences' }}</span>
    </h2>

    <div class="row">
        @include('includes.messages')

        <div class="col-12 main-content">
            @if ($recherches->isEmpty())
                <div class="alert alert-warning text-center fw-bold rounded-3 p-4">
                    <i class="fas fa-exclamation-triangle me-2"></i> Désolé, aucune résidence trouvée.
                </div>
            @else
                <div class="row g-4 justify-content-center">
                    @foreach($recherches as $residence)
                        @php
                            $images = is_string($residence->img) ? json_decode($residence->img, true) : ($residence->img ?? []);
                            $firstImage = $images[0] ?? asset('assets/images/placeholder.jpg');
                        @endphp

                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
                            <div class="card h-100 border-0 w-100 shadow-sm">
                                <a href="javascript:void(0)" class="glightbox-trigger-{{ $residence->id }}">
                                    <img src="{{ $firstImage }}" alt="{{ $residence->nom }}" class="card-img-top" loading="lazy">
                                </a>

                                @foreach($images as $key => $image)
                                    <a href="{{ $image }}" class="glightbox" data-gallery="gallery-{{ $residence->id }}" style="display: none;"></a>
                                @endforeach

                                <div class="card-body d-flex flex-column p-4">
                                    <h5 class="card-title mb-2 text-truncate">{{ $residence->nom }}</h5>
                                    <p class="card-text small text-muted mb-3">
                                         {{ Str::limit($residence->description, 85) }}
                                    </p>
                                    <ul class="list-unstyled small mb-4 flex-grow-1">
                                        <li class="mb-1"><i class="fas fa-bed me-2 text-primary"></i> <strong>Chambres :</strong> {{ $residence->nombre_chambres ?? '-' }}</li>
                                        <li class="mb-1"><i class="fas fa-couch me-2 text-primary"></i> <strong>Salon :</strong> {{ $residence->nombre_salons ?? '-' }}</li>
                                        <li class="mb-1"><i class="fas fa-map-marker-alt me-2 text-primary"></i> <strong>Situation :</strong> {{ $residence->ville ?? '-' }}</li>
                                        <li class="mt-3 fs-6">
                                            <span class="text-success fw-bold">
                                                <i class="fas fa-tag me-1"></i> {{ number_format($residence->prix_journalier ?? 0, 0, ',', ' ') }} FCFA / jour
                                            </span>
                                        </li>
                                    </ul>

                                    <a href="{{ route('details', $residence->id) }}" class="btn btn-dark-secondary rounded-pill w-100">
                                        Voir Détails <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

@include('includes.footer')

<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const toggleButton = document.getElementById('toggleSidebar');
    const overlay = document.getElementById('sidebar-overlay');

    function toggleSidebar() {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
        document.body.classList.toggle('overflow-hidden');
    }

    if (toggleButton) { toggleButton.addEventListener('click', toggleSidebar); }
    const lightbox = GLightbox();

    document.querySelectorAll('[class^="glightbox-trigger-"]').forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.className.split('-').pop();
            const galleryLinks = document.querySelectorAll(`.glightbox[data-gallery="gallery-${id}"]`);
            if (galleryLinks.length > 0) { lightbox.openAt(0, galleryLinks[0]); }
        });
    });
</script>
</body>
</html>