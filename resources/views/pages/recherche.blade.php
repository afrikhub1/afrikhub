<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche - Afrik'hub</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet" />

    <style>
        :root {
            --color-primary: #FF8C00;
            --color-primary-hover: #CC7000;
            --color-secondary: #212529;
            --color-background: #F8F9FA;
            --font-main: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            font-family: var(--font-main);
            background-color: var(--color-background);
            color: #333;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* Typographie Hiérarchisée */
        h1, h2, h3 { font-weight: 800; letter-spacing: -0.02em; }
        .card-title { font-weight: 700; font-size: 1.15rem; color: var(--color-secondary); }
        .text-price { font-weight: 800; color: #10b981; }

        /* Boutons & Interaction */
        .btn-custom-primary {
            background-color: var(--color-primary);
            border: none;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            transition: all 0.2s ease;
        }
        .btn-custom-primary:hover {
            background-color: var(--color-primary-hover);
            transform: translateY(-1px);
        }

        /* Cartes de Résidences Améliorées */
        .card-residence {
            border: none;
            border-radius: 16px;
            background: #ffffff;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-residence:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .card-img-container {
            position: relative;
            height: 200px;
            overflow: hidden;
            border-radius: 16px 16px 0 0;
        }
        .card-img-top {
            height: 100%;
            width: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .card-residence:hover .card-img-top { transform: scale(1.1); }

        /* Badge de disponibilité */
        .badge-status {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0.5em 1em;
        }

        /* Sidebar & Overlay */
        #sidebar {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(100%);
            background-color: #ffffff; /* Suppression du fond sombre */
            color: var(--color-secondary);
        }
        #sidebar.active { transform: translateX(0); }
        .sidebar-link {
            color: var(--color-secondary);
            font-weight: 600;
            padding: 1rem;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.2s;
        }
        .sidebar-link:hover { background: #f3f4f6; color: var(--color-primary); }
    </style>
</head>

<body>

<header class="bg-white border-bottom sticky-top py-2">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <a href="{{ route('accueil') }}">
            <img style="width: 70px;" src="{{ asset('assets/images/logo_01.png') }}" alt="Logo">
        </a>

        <form class="d-flex flex-grow-1 mx-lg-5 mx-2" style="max-width: 600px;" method="GET" action="{{ route('recherche') }}">
            <div class="input-group">
                <input class="form-control rounded-start-pill border-end-0 ps-4" type="search" 
                       placeholder="Où allez-vous ?" name="ville_quartier" value="{{ request('ville_quartier') }}">
                <button class="btn btn-custom-primary rounded-end-pill px-4" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <div class="d-none d-lg-flex align-items-center gap-3">
            @auth
                <a href="{{ Auth::user()->type_compte == 'professionnel' ? route('pro.dashboard') : route('clients_historique') }}" 
                   class="text-decoration-none text-dark fw-semibold">
                    <i class="fas fa-user-circle me-1"></i> Mon Profil
                </a>
            @endauth
            <button id="toggleSidebar" class="btn border-0">
                <i class="fas fa-bars fa-lg"></i>
            </button>
        </div>
    </div>
</header>

<div id="sidebar-overlay" class="fixed inset-0 bg-black/50 z-[1050] hidden" onclick="toggleSidebar()"></div>
<div id="sidebar" class="fixed top-0 right-0 w-80 h-full z-[1060] p-4 shadow-2xl overflow-y-auto">
    <div class="flex justify-between items-center mb-8">
        <span class="font-bold text-xl">Menu</span>
        <button onclick="toggleSidebar()" class="text-2xl">&times;</button>
    </div>
    
    <nav class="flex flex-column gap-2">
        @auth
            <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                <small class="text-gray-500 block">Connecté en tant que</small>
                <span class="font-bold">{{ Auth::user()->name }}</span>
            </div>
            @if(Auth::user()->type_compte == 'professionnel')
                <a href="{{ route('pro.residences') }}" class="sidebar-link"><i class="fas fa-hotel me-2"></i>Mes Résidences</a>
                <a href="{{ route('mise_en_ligne') }}" class="sidebar-link"><i class="fas fa-plus-circle me-2"></i>Publier</a>
            @endif
        @endauth
        <a href="{{ route('accueil') }}" class="sidebar-link"><i class="fas fa-home me-2"></i>Accueil</a>
        <hr class="my-4">
        <a href="{{ route('logout') }}" class="btn btn-outline-danger rounded-pill w-full">Déconnexion</a>
    </nav>
</div>

<main class="container py-5">
    <header class="text-center mb-5">
        <h1 class="display-6 mb-2">Trouvez votre prochain séjour</h1>
        <p class="text-muted">Résultats pour : <span class="text-primary fw-bold">{{ request('ville_quartier') ?: 'Toutes les localités' }}</span></p>
    </header>

    @include('includes.messages')

    @if ($recherches->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-search fa-3x text-gray-300 mb-3"></i>
            <h3 class="text-muted">Aucun résultat trouvé</h3>
            <a href="{{ route('accueil') }}" class="btn btn-link text-primary mt-2">Réinitialiser la recherche</a>
        </div>
    @else
        <div class="row g-4">
            @foreach($recherches as $residence)
                @php
                    $images = is_string($residence->img) ? json_decode($residence->img, true) : ($residence->img ?? []);
                    $firstImage = $images[0] ?? asset('assets/images/placeholder.jpg');
                    $dateDispo = \Carbon\Carbon::parse($residence->date_disponible);
                @endphp

                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <article class="card card-residence h-100 shadow-sm">
                        <div class="card-img-container">
                            <a href="#" class="glightbox-trigger-{{ $residence->id }}">
                                <img src="{{ $firstImage }}" class="card-img-top" alt="{{ $residence->nom }}">
                            </a>
                        </div>

                        <div class="card-body d-flex flex-column p-4">
                            <div class="mb-2">
                                @if ($dateDispo->isPast() || $dateDispo->isToday())
                                    <span class="badge badge-status bg-green-100 text-green-700 rounded-pill">Disponible</span>
                                @else
                                    <span class="badge badge-status bg-orange-100 text-orange-700 rounded-pill">Le {{ $dateDispo->translatedFormat('d M.') }}</span>
                                @endif
                            </div>

                            <h5 class="card-title text-truncate mb-1">{{ $residence->nom }}</h5>
                            <p class="text-muted small mb-3"><i class="fas fa-map-marker-alt me-1"></i> {{ $residence->ville }}, {{ $residence->quartier ?? 'Quartier non précisé' }}</p>

                            <div class="d-flex gap-3 mb-4 text-muted small">
                                <span><i class="fas fa-bed me-1 text-primary"></i> {{ $residence->nombre_chambres }}</span>
                                <span><i class="fas fa-shower me-1 text-primary"></i> {{ $residence->nombre_douches ?? 1 }}</span>
                            </div>

                            <div class="mt-auto d-flex align-items-center justify-content-between">
                                <div>
                                    <span class="text-price fs-5">{{ number_format($residence->prix_journalier, 0, ',', ' ') }}</span>
                                    <small class="text-muted">/jour</small>
                                </div>
                                <a href="{{ route('details', $residence->id) }}" class="btn btn-custom-primary btn-sm rounded-pill">
                                    Détails
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            @endforeach
        </div>
    @endif
</main>

<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        sidebar.classList.toggle('active');
        overlay.classList.toggle('hidden');
        document.body.classList.toggle('overflow-hidden');
    }

    document.getElementById('toggleSidebar').addEventListener('click', toggleSidebar);

    const lightbox = GLightbox({ selector: '.glightbox' });
</script>

</body>
</html>