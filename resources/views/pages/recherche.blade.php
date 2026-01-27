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
            --color-primary: #FF8C00; 
            --color-primary-hover: #CC7000;
            --color-secondary: #212529;
            --color-background: #FFFFFF; /* Forcé en blanc pour retirer le dark mode */
            --footer-height: 60px;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-background);
            padding-bottom: var(--footer-height);
            color: #333;
        }

        /* Tailles de texte et design */
        h2 { font-size: 1.75rem !important; }
        .card-title { font-size: 1.15rem !important; }
        .card-text { font-size: 0.9rem !important; }
        .btn { font-size: 0.9rem !important; font-weight: 500; }

        .btn-custom-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: white;
            transition: all 0.2s;
        }
        .btn-custom-primary:hover {
            background-color: var(--color-primary-hover);
            color: white;
        }
        .btn-dark-secondary {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            color: white;
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #eee !important;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }
        .card-img-top {
            height: 12rem;
            object-fit: cover;
        }

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
        }
        #sidebar.active { transform: translateX(0); }
        .sidebar-link {
            color: #dee2e6;
            padding: 12px 15px;
            text-decoration: none;
            font-size: 0.95rem;
        }
    </style>
</head>

<body>

{{-- HEADER - Version Claire --}}
<header class="bg-white border-bottom shadow-sm">
    <div class="container-fluid px-3 py-2 d-flex align-items-center justify-content-between">

        <div class="d-flex align-items-center">
            <a href="{{ route('accueil') }}">
                <img class="h-auto" style="width: 80px;" src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo"/>
            </a>
        </div>

        <form class="d-flex mx-auto search-form-container" style="max-width: 500px;" method="GET" action="{{ route('recherche') }}">
            <input class="form-control me-2 rounded-pill border-light-subtle bg-light" type="search"
                   placeholder="Ville, quartier, référence..." aria-label="Rechercher" name="ville_quartier"
                   value="{{ request('ville_quartier') ?? '' }}"
            />
            <button class="btn btn-custom-primary rounded-pill" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <ul class="navbar-nav d-none d-lg-flex flex-row align-items-center mb-0 ms-4 g-4">
            <li class="nav-item mx-2">
                @if(Auth::user()->type_compte == 'professionnel')
                    <a href="{{ route('pro.dashboard') }}" class="nav-link text-dark fw-bold mx-2"> <i class="fas fa-user-circle text-primary"></i> Profil</a>
                @endif
                @if(Auth::user()->type_compte == 'client')
                    <a href="{{ route('clients_historique') }}" class="nav-link text-dark fw-bold mx-2">
                        <i class="fa fa-user-circle me-2 text-primary"></i>Profil
                    </a>
                @endif
            </li>
            <a href="javascript:history.back()" class="nav-link text-muted fw-bold small me-3">
               <i class="fas fa-arrow-left"></i> Retour</a>
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="btn btn-custom-primary btn-sm px-4 rounded-pill">
                    <i class="fa fa-sign-out me-2"></i> Déconnexion
                </a>
            </li>
        </ul>

        <button id="toggleSidebar" class="btn btn-link ms-3 p-0" type="button">
             <i class="fas fa-bars fa-lg text-dark"></i>
        </button>
    </div>
</header>

<div id="sidebar-overlay" onclick="toggleSidebar()"></div>
<div id="sidebar" class="text-white d-flex flex-column shadow-lg">
    <button id="closeSidebar" class="btn text-white align-self-end p-0 mb-4" type="button" onclick="toggleSidebar()">
        <i class="fas fa-times fa-2x"></i>
    </button>

    <div class="w-100 d-flex flex-column gap-2">
        <div class="mb-4 pb-3 border-bottom border-secondary">
             @auth
                 <h4 class="text-lg font-bold text-white mb-0"> {{ Auth::user()->name }}</h4>
                 <span class="text-xs text-orange-400 uppercase tracking-wider">{{ Auth::user()->type_compte }}</span>
             @endauth
        </div>

        @if(Auth::user()->type_compte == 'professionnel')
            <a href="{{ route('reservationRecu') }}" class="sidebar-link"><i class="fas fa-history me-2"></i> Mon Historique</a>
            <a href="{{ route('pro.dashboard') }}" class="sidebar-link"><i class="fas fa-user-circle me-2"></i> Mon Compte</a>
            <a href="{{ route('pro.residences') }}" class="sidebar-link"><i class="fas fa-hotel me-2"></i> Mes Residences</a>
            <a href="{{ route('mise_en_ligne') }}" class="sidebar-link"><i class="fas fa-upload me-2"></i> Mise en ligne</a>
            <a href="{{ route('occupees') }}" class="sidebar-link"><i class="fas fa-calendar-alt me-2"></i> Résidences Occupées</a>
            <a href="{{ route('mes_demandes') }}" class="sidebar-link"><i class="fas fa-bell me-2"></i> Demandes</a>
        @endif
         @if(Auth::user()->type_compte == 'client')
            <a href="{{ route('clients_historique') }}" class="sidebar-link"><i class="fas fa-user-circle me-2"></i> Mon Compte</a>
        @endif
        <a href="{{ route('accueil') }}" class="sidebar-link"><i class="fas fa-home me-2"></i> Accueil</a>

        <div class="mt-4 pt-3 border-top border-secondary">
            <a href="{{ route('logout') }}" class="btn btn-custom-primary rounded-pill w-100">
                <i class="fa fa-sign-out me-2"></i> Déconnexion
            </a>
        </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="mb-5 text-center fw-bold text-dark">
        Résultats pour : <span class="text-primary">{{ request('ville_quartier') ?: 'Toutes les résidences' }}</span>
    </h2>
    
    <div class="row">
        @include('includes.messages')

        <div class="col-12 main-content">
            @if ($recherches->isEmpty())
                <div class="alert bg-light border text-center fw-bold rounded-3 p-5">
                    <i class="fas fa-search fa-3x mb-3 text-muted"></i><br>
                    Désolé, aucune résidence trouvée.
                </div>
            @else
                <div class="row g-4 justify-content-center">
                    @foreach($recherches as $residence)
                        @php
                            $images = is_string($residence->img) ? json_decode($residence->img, true) : ($residence->img ?? []);
                            $firstImage = $images[0] ?? asset('assets/images/placeholder.jpg');
                        @endphp

                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
                            <div class="card h-100 w-100 shadow-sm">
                                <a href="javascript:void(0)" class="glightbox-trigger-{{ $residence->id }}">
                                   <img src="{{ $firstImage }}" alt="{{ $residence->nom }}" class="card-img-top" loading="lazy">
                                </a>

                                @foreach($images as $key => $image)
                                    <a href="{{ $image }}" class="glightbox" data-gallery="gallery-{{ $residence->id }}" style="display: none;" data-trigger=".glightbox-trigger-{{ $residence->id }}"></a>
                                @endforeach

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold text-dark mb-2">{{ $residence->nom }}</h5>
                                    <p class="card-text text-muted mb-3">
                                         {{ Str::limit($residence->description, 80) }}
                                    </p>
                                    
                                    <div class="small mb-3">
                                        <div class="mb-1"><i class="fas fa-map-marker-alt me-2 text-primary"></i> {{ $residence->ville }}</div>
                                        <div class="fw-bold text-dark"><i class="fas fa-tag me-2 text-primary"></i> {{ number_format($residence->prix_journalier ?? 0, 0, ',', ' ') }} FCFA / jour</div>
                                    </div>

                                    <a href="{{ route('details', $residence->id) }}" class="btn btn-dark-secondary rounded-pill mt-auto w-100">
                                        Détails <i class="fas fa-arrow-right ms-2"></i>
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

    if (toggleButton) toggleButton.addEventListener('click', toggleSidebar);

    const lightbox = GLightbox();
    document.querySelectorAll('[data-trigger]').forEach(link => {
        const triggerSelector = link.getAttribute('data-trigger');
        const triggerElement = document.querySelector(triggerSelector);
        if (triggerElement) {
            triggerElement.addEventListener('click', function(e) {
                e.preventDefault();
                const galleryLinks = document.querySelectorAll(`.glightbox[data-gallery="${link.getAttribute('data-gallery')}"]`);
                if (galleryLinks.length > 0) lightbox.openAt(0, galleryLinks[0]);
            });
        }
    });
</script>
</body>
</html>