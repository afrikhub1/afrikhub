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
            --primary-gradient: linear-gradient(135deg, #006d77, #00afb9);
            --primary-color: #006d77;
            --secondary-dark: #1a202c;
            --bg-light: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            padding-bottom: 60px;
        }

        /* Boutons & Couleurs */
        .btn-custom-primary {
            background: var(--primary-gradient);
            border: none;
            color: white;
            font-weight: 700;
            transition: all 0.3s ease;
        }
        .btn-custom-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 109, 119, 0.2);
            color: white;
        }

        .btn-dark-secondary {
            background-color: var(--secondary-dark);
            border: none;
            color: white;
            font-weight: 700;
        }

        /* Design des Cartes */
        .card {
            border: none;
            border-radius: 24px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            background: white;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px -12px rgba(0, 109, 119, 0.15);
        }
        .card-img-top {
            height: 14rem;
            object-fit: cover;
            transition: transform 0.8s ease;
        }
        .card:hover .card-img-top {
            transform: scale(1.1);
        }

        /* Badge de prix Glassmorphism */
        .price-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            padding: 0.5rem 1.2rem;
            border-radius: 15px;
            color: var(--primary-color);
            font-weight: 900;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            z-index: 10;
        }

        /* Sidebar Coulissante */
        #sidebar {
            transition: transform 0.4s cubic-bezier(0.7, 0, 0.3, 1);
            transform: translateX(100%);
            position: fixed;
            top: 0; right: 0; width: 100%; max-width: 320px;
            z-index: 1060; height: 100%;
            background: var(--secondary-dark);
            padding: 2rem;
            box-shadow: -15px 0 35px rgba(0,0,0,0.2);
        }
        #sidebar.active { transform: translateX(0); }
        
        .sidebar-link {
            color: #e2e8f0;
            padding: 12px 15px;
            border-radius: 12px;
            transition: 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .sidebar-link:hover {
            background: rgba(0, 175, 185, 0.1);
            color: #00afb9;
        }

        #sidebar-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(3px);
            z-index: 1050; display: none;
        }
        #sidebar-overlay.active { display: block; }
    </style>
</head>

<body>

{{-- HEADER --}}
<header class="bg-white shadow-sm sticky-top">
    <div class="container-fluid px-4 py-2 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <a href="{{ route('accueil') }}">
                <img style="width: 75px;" src="{{ asset('assets/images/logo_01.png') }}" alt="Logo"/>
            </a>
        </div>

        <form class="d-flex mx-auto search-form-container w-100" style="max-width: 550px;" method="GET" action="{{ route('recherche') }}">
            <div class="input-group">
                <input class="form-control rounded-start-pill border-end-0 px-4" type="search"
                       placeholder="Ville, quartier..." name="ville_quartier"
                       value="{{ request('ville_quartier') ?? '' }}" />
                <button class="btn btn-custom-primary rounded-end-pill px-4" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <ul class="navbar-nav d-none d-lg-flex flex-row align-items-center mb-0 ms-4 gap-3">
            <li class="nav-item">
                @if(Auth::user()->type_compte == 'professionnel')
                    <a href="{{ route('pro.dashboard') }}" class="nav-link text-dark fw-bold"> <i class="fas fa-user-circle text-custom-primary"></i> Profil</a>
                @endif
                @if(Auth::user()->type_compte == 'client')
                    <a href="{{ route('clients_historique') }}" class="nav-link text-dark fw-bold"> <i class="fa fa-user-circle text-custom-primary"></i> Profil</a>
                @endif
            </li>
            <a href="javascript:history.back()" class="nav-link text-muted fw-medium small"> <i class="fas fa-undo-alt"></i> Retour</a>
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="btn btn-custom-primary btn-sm px-4 rounded-pill">Quitter</a>
            </li>
        </ul>

        <button id="toggleSidebar" class="btn btn-link ms-3 p-0" type="button">
             <i class="fas fa-bars-staggered fa-lg text-dark"></i>
        </button>
    </div>
</header>

{{-- SIDEBAR --}}
<div id="sidebar-overlay" onclick="toggleSidebar()"></div>
<div id="sidebar" class="text-white d-flex flex-column">
    <button id="closeSidebar" class="btn text-white align-self-end p-0 mb-4" type="button" onclick="toggleSidebar()">
        <i class="fas fa-times fa-2x opacity-50"></i>
    </button>

    <div class="w-100 d-flex flex-column gap-2">
        <div class="text-center mb-5 pb-3 border-bottom border-gray-700">
             @auth
                 <p class="text-xs text-uppercase tracking-widest text-gray-500 mb-1">Session active</p>
                 <h4 class="font-bold"> {{ Auth::user()->name }}</h4>
             @endauth
        </div>

        @if(Auth::user()->type_compte == 'professionnel')
            <a href="{{ route('reservationRecu') }}" class="sidebar-link"><i class="fas fa-history me-3"></i> Historique</a>
            <a href="{{ route('pro.dashboard') }}" class="sidebar-link"><i class="fas fa-user-circle me-3"></i> Mon Compte</a>
            <a href="{{ route('pro.residences') }}" class="sidebar-link"><i class="fas fa-hotel me-3"></i> Mes Residences</a>
            <a href="{{ route('mise_en_ligne') }}" class="sidebar-link"><i class="fas fa-upload me-3"></i> Mise en ligne</a>
            <a href="{{ route('occupees') }}" class="sidebar-link"><i class="fas fa-calendar-alt me-3"></i> Occupées</a>
            <a href="{{ route('mes_demandes') }}" class="sidebar-link"><i class="fas fa-bell me-3"></i> Demandes</a>
        @endif
        
        <a href="{{ route('accueil') }}" class="sidebar-link"><i class="fas fa-home me-3"></i> Accueil</a>

        <div class="mt-5 pt-4">
            <a href="{{ route('logout') }}" class="btn btn-custom-primary rounded-xl w-100 py-3">
                <i class="fa fa-sign-out me-2"></i> Déconnexion
            </a>
        </div>
    </div>
</div>

{{-- CONTENU PRINCIPAL --}}
<div class="container my-5">
    <div class="mb-12 text-center">
        <h2 class="fw-black fs-2 text-dark">
            Résultats pour : <span class="text-transparent bg-clip-text" style="background-image: var(--primary-gradient);">{{ request('ville_quartier') ?: 'Toutes les résidences' }}</span>
        </h2>
        <div class="h-1 w-20 bg-custom-gradient mx-auto mt-3 rounded-full"></div>
    </div>

    <div class="row">
        @include('includes.messages')

        <div class="col-12 main-content">
            @if ($residences->isEmpty())
                <div class="alert bg-white shadow-sm text-center py-5 rounded-4 border-0">
                    <i class="fas fa-search-minus fa-3x text-gray-200 mb-3"></i>
                    <p class="fw-bold text-gray-500">Désolé, aucune résidence ne correspond à votre recherche.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach($residences as $residence)
                        @php
                            $images = is_string($residence->img) ? json_decode($residence->img, true) : ($residence->img ?? []);
                            $firstImage = $images[0] ?? asset('assets/images/placeholder.jpg');
                        @endphp

                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
                            <div class="card shadow-sm w-100 overflow-hidden">
                                <div class="position-relative">
                                    <div class="price-badge">
                                        {{ number_format($residence->prix_journalier ?? 0, 0, ',', ' ') }} <small class="text-[10px]">FCFA</small>
                                    </div>

                                    <a href="javascript:void(0)" class="glightbox-trigger-{{ $residence->id }} block">
                                        <img src="{{ $firstImage }}" alt="{{ $residence->nom }}" class="card-img-top" loading="lazy">
                                    </a>
                                </div>

                                {{-- Liens GLightbox CACHÉS --}}
                                @foreach($images as $key => $image)
                                    <a href="{{ $image }}" class="glightbox" data-gallery="gallery-{{ $residence->id }}" data-title="{{ $residence->nom }}" style="display: none;"></a>
                                @endforeach

                                <div class="card-body d-flex flex-column p-4">
                                    <h5 class="fw-black text-dark mb-1">{{ $residence->nom }}</h5>
                                    <p class="text-muted small mb-4 line-clamp-2">
                                        {{ Str::limit($residence->description, 90) }}
                                    </p>

                                    <div class="bg-light rounded-3 p-3 mb-4">
                                        <div class="d-flex justify-content-between mb-2 small">
                                            <span class="text-muted"><i class="fas fa-bed me-2"></i>Chambres</span>
                                            <span class="fw-bold">{{ $residence->nombre_chambres ?? '-' }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between small">
                                            <span class="text-muted"><i class="fas fa-map-marker-alt me-2"></i>Situation</span>
                                            <span class="fw-bold">{{ $residence->ville ?? '-' }}</span>
                                        </div>
                                    </div>

                                    @php $dateDispo = \Carbon\Carbon::parse($residence->date_disponible); @endphp
                                    <div class="mb-4 text-center">
                                        @if ($dateDispo->isPast() || $dateDispo->isToday())
                                            <span class="badge bg-green-100 text-green-700 px-3 py-2 rounded-pill w-100 font-bold">Disponible</span>
                                        @else
                                            <span class="badge bg-orange-100 text-orange-700 px-3 py-2 rounded-pill w-100 font-bold">Le {{ $dateDispo->translatedFormat('d F') }}</span>
                                        @endif
                                    </div>

                                    <a href="{{ route('details', $residence->id) }}" class="btn btn-dark-secondary rounded-pill py-2 w-100 transition hover:scale-105">
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
    const overlay = document.getElementById('sidebar-overlay');
    const toggleButton = document.getElementById('toggleSidebar');

    function toggleSidebar() {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
        document.body.classList.toggle('overflow-hidden');
    }

    if (toggleButton) { toggleButton.addEventListener('click', toggleSidebar); }

    const lightbox = GLightbox();
    document.querySelectorAll('[data-trigger]').forEach(link => {
        const triggerSelector = link.getAttribute('data-trigger');
        const triggerElement = document.querySelector(triggerSelector);
        if (triggerElement) {
            triggerElement.addEventListener('click', function(e) {
                e.preventDefault();
                const galleryLinks = document.querySelectorAll(`.glightbox[data-gallery="${link.getAttribute('data-gallery')}"]`);
                if (galleryLinks.length > 0) { lightbox.openAt(0, galleryLinks[0]); }
            });
        }
    });
</script>
</body>
</html>