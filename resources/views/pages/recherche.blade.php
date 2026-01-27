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
        /* Intégration de ta couleur de base */
        :root {
            --color-primary-gradient: linear-gradient(135deg, #006d77, #00afb9);
            --color-primary: #006d77;
            --color-secondary: #1a202c; 
            --color-background: #f0f7f8;
            --footer-height: 60px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-background);
            padding-bottom: var(--footer-height);
        }

        /* Utilitaires personnalisés */
        .bg-custom-gradient { background: var(--color-primary-gradient); }
        .text-custom-primary { color: var(--color-primary); }

        /* Boutons */
        .btn-custom-primary {
            background: var(--color-primary-gradient);
            border: none;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 109, 117, 0.2);
        }
        .btn-custom-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 109, 117, 0.3);
            color: white;
            opacity: 0.9;
        }

        .btn-dark-secondary {
            background-color: var(--color-secondary);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-dark-secondary:hover {
            background-color: #000;
            color: white;
        }

        /* Cartes de résidence (Look Whaoo) */
        .card {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: white;
        }
        .card:hover {
            transform: translateY(-12px);
            box-shadow: 0 25px 50px -12px rgba(0, 109, 119, 0.25);
        }
        .card-img-top {
            height: 14rem;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        .card:hover .card-img-top {
            transform: scale(1.1);
        }

        /* Sidebar & Overlay */
        #sidebar {
            transition: transform 0.4s cubic-bezier(0.77, 0, 0.175, 1);
            transform: translateX(100%);
            position: fixed;
            top: 0; right: 0; width: 100%; max-width: 320px;
            z-index: 1060; height: 100%;
            background: var(--color-secondary);
            padding: 2rem 1.5rem;
            box-shadow: -10px 0 30px rgba(0,0,0,0.3);
        }
        #sidebar.active { transform: translateX(0); }
        
        .sidebar-link {
            color: #cbd5e0;
            padding: 14px 18px;
            border-radius: 12px;
            transition: all 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .sidebar-link:hover {
            background: rgba(255,255,255,0.1);
            color: #00afb9;
            padding-left: 25px;
        }

        #sidebar-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 109, 119, 0.3);
            backdrop-filter: blur(4px);
            z-index: 1050; display: none;
        }
        #sidebar-overlay.active { display: block; }

        /* Badge de prix flottant */
        .price-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            padding: 5px 15px;
            border-radius: 12px;
            font-weight: 800;
            color: var(--color-primary);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            z-index: 10;
        }
    </style>
</head>

<body>

{{-- HEADER --}}
<header class="bg-white border-b border-gray-100 py-3 shadow-sm">
    <div class="container-fluid px-4 d-flex align-items-center justify-content-between">
        
        <div class="d-flex align-items-center">
            <a href="{{ route('accueil') }}">
                <img class="h-auto" style="width: 70px;" src="{{ asset('assets/images/logo_01.png') }}" alt="Logo"/>
            </a>
        </div>

        <form class="d-flex mx-auto search-form-container w-100" style="max-width: 600px;" method="GET" action="{{ route('recherche') }}">
            <div class="relative w-full d-flex">
                <input class="form-control me-2 rounded-pill border-gray-200 px-4 py-2" type="search"
                       placeholder="Où voulez-vous aller ?" aria-label="Rechercher" name="ville_quartier"
                       value="{{ request('ville_quartier') ?? '' }}" />
                <button class="btn btn-custom-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <ul class="navbar-nav d-none d-lg-flex flex-row align-items-center mb-0 g-4">
            <li class="nav-item mx-2">
                @if(Auth::user()->type_compte == 'professionnel')
                    <a href="{{ route('pro.dashboard') }}" class="nav-link text-dark fw-bold hover:text-cyan-600 transition"> <i class="fas fa-user-circle mr-1"></i> Profil</a>
                @endif
                @if(Auth::user()->type_compte == 'client')
                    <a href="{{ route('clients_historique') }}" class="nav-link text-dark fw-bold"> <i class="fa fa-user-circle mr-1"></i> Profil</a>
                @endif
            </li>
            <li class="nav-item mx-3">
                <a href="javascript:history.back()" class="text-gray-500 hover:text-red-500 transition no-underline fw-bold">
                    <i class="fas fa-arrow-left mr-1"></i> Retour
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="btn btn-custom-primary btn-sm px-4 py-2 rounded-pill font-bold">
                    Quitter
                </a>
            </li>
        </ul>

        <button id="toggleSidebar" class="btn btn-link ms-3 p-0" type="button">
             <i class="fas fa-bars-staggered fa-lg text-custom-primary"></i>
        </button>
    </div>
</header>

{{-- SIDEBAR --}}
<div id="sidebar-overlay" onclick="toggleSidebar()"></div>
<div id="sidebar" class="text-white d-flex flex-column">
    <button id="closeSidebar" class="btn text-white align-self-end p-0 mb-5" type="button" onclick="toggleSidebar()">
        <i class="fas fa-times-circle fa-2x opacity-50 hover:opacity-100"></i>
    </button>

    <div class="w-100 d-flex flex-column gap-2">
        <div class="mb-5 border-b border-gray-700 pb-4">
             @auth
                 <p class="text-gray-400 text-xs uppercase tracking-widest mb-1">Bienvenue,</p>
                 <h4 class="text-2xl font-bold"> {{ Auth::user()->name }}</h4>
             @endauth
        </div>

        @if(Auth::user()->type_compte == 'professionnel')
            <a href="{{ route('reservationRecu') }}" class="sidebar-link"><i class="fas fa-chart-line w-8"></i> Activité</a>
            <a href="{{ route('pro.dashboard') }}" class="sidebar-link"><i class="fas fa-id-card w-8"></i> Mon Compte</a>
            <a href="{{ route('pro.residences') }}" class="sidebar-link"><i class="fas fa-house-chimney w-8"></i> Mes Residences</a>
            <a href="{{ route('mise_en_ligne') }}" class="sidebar-link"><i class="fas fa-plus-circle w-8"></i> Ajouter un bien</a>
            <a href="{{ route('occupees') }}" class="sidebar-link"><i class="fas fa-calendar-check w-8"></i> Occupations</a>

        @endif

        <a href="{{ route('clients_historique') }}" class="sidebar-link"><i class="fas fa-user w-8"></i> Mode Client</a>
        <a href="{{ route('accueil') }}" class="sidebar-link"><i class="fas fa-home w-8"></i> Accueil</a>

        <div class="mt-10">
            <a href="{{ route('logout') }}" class="btn btn-danger rounded-xl w-100 py-3 font-bold shadow-lg">
                <i class="fa fa-power-off mr-2"></i> Déconnexion
            </a>
        </div>
    </div>
</div>

{{-- CONTENU PRINCIPAL --}}
<div class="container my-5">
    <div class="text-center mb-12">
        <span class="text-custom-primary font-black uppercase tracking-widest text-xs">Exploration</span>
        <h2 class="mt-2 font-black text-4xl text-gray-900">
            {{ request('ville_quartier') ?: 'Toutes nos résidences' }}
        </h2>
        <div class="h-1.5 w-20 bg-custom-gradient mx-auto mt-4 rounded-full"></div>
    </div>

    <div class="row">
        @include('includes.messages')

        <div class="col-12 main-content">
            @if ($recherches->isEmpty())
                <div class="bg-white p-12 rounded-[2rem] text-center shadow-sm">
                    <div class="w-20 h-20 bg-orange-50 text-orange-400 rounded-full d-flex align-items-center justify-content-center mx-auto mb-4">
                        <i class="fas fa-search-minus fa-2x"></i>
                    </div>
                    <p class="text-xl font-bold text-gray-800">Aucun résultat trouvé</p>
                    <p class="text-gray-500">Essayez d'élargir votre zone de recherche.</p>
                </div>
            @else
                <div class="row g-5">
                    @foreach($recherches as $residence)
                        @php
                            $images = is_string($residence->img) ? json_decode($residence->img, true) : ($residence->img ?? []);
                            $firstImage = $images[0] ?? asset('assets/images/placeholder.jpg');
                        @endphp

                        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
                            <div class="card h-100 shadow-sm">
                                <div class="relative overflow-hidden">
                                    <div class="price-badge">
                                        {{ number_format($residence->prix_journalier ?? 0, 0, ',', ' ') }} <small class="text-[10px]">FCFA</small>
                                    </div>
                                    
                                    <a href="javascript:void(0)" class="glightbox-trigger-{{ $residence->id }}">
                                        <img src="{{ $firstImage }}" class="card-img-top" alt="{{ $residence->nom }}" loading="lazy">
                                    </a>
                                </div>

                                {{-- Liens GLightbox CACHÉS --}}
                                @foreach($images as $key => $image)
                                    <a href="{{ $image }}" class="glightbox" data-gallery="gallery-{{ $residence->id }}" style="display: none;"></a>
                                @endforeach

                                <div class="card-body p-4 d-flex flex-column">
                                    <h5 class="font-black text-xl text-gray-800 mb-2 truncate">{{ $residence->nom }}</h5>
                                    <p class="text-gray-500 text-sm mb-4 line-clamp-2 italic">
                                        {{ Str::limit($residence->description, 80) }}
                                    </p>

                                    <div class="bg-gray-50 rounded-2xl p-3 mb-4 grid grid-cols-2 gap-2">
                                        <div class="text-center">
                                            <p class="text-[10px] text-gray-400 font-bold uppercase mb-0">Chambres</p>
                                            <p class="font-black text-custom-primary mb-0">{{ $residence->nombre_chambres ?? '0' }}</p>
                                        </div>
                                        <div class="text-center border-l border-gray-200">
                                            <p class="text-[10px] text-gray-400 font-bold uppercase mb-0">Ville</p>
                                            <p class="font-bold text-gray-700 mb-0">{{ $residence->ville ?? '-' }}</p>
                                        </div>
                                    </div>

                                    @php $dateDispo = \Carbon\Carbon::parse($residence->date_disponible); @endphp
                                    <div class="mb-4">
                                        @if ($dateDispo->isPast() || $dateDispo->isToday())
                                            <span class="w-100 d-block text-center py-2 rounded-xl bg-green-50 text-green-600 text-[10px] font-black uppercase tracking-wider border border-green-100">
                                                <i class="fas fa-check-circle mr-1"></i> Disponible
                                            </span>
                                        @else
                                            <span class="w-100 d-block text-center py-2 rounded-xl bg-cyan-50 text-cyan-700 text-[10px] font-black uppercase tracking-wider border border-cyan-100">
                                                Prévu le {{ $dateDispo->translatedFormat('d M') }}
                                            </span>
                                        @endif
                                    </div>

                                    <a href="{{ route('details', $residence->id) }}" class="btn btn-dark-secondary rounded-xl py-3 font-bold mt-auto transition hover:scale-105">
                                        Voir l'offre <i class="fas fa-arrow-right ms-2 text-[10px]"></i>
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