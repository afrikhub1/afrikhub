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

    <!-- GLightbox -->
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet" />

    <style>
        :root {
            --color-primary: #006d77;
            --color-primary-light: #00afb9;
            --main-gradient: linear-gradient(135deg, #006d77, #00afb9);
            --color-soft-bg: #f8f9fa;
            --color-background: #ffffff;
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
            opacity: 0.9;
            color: white;
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

        .text-primary {
            color: var(--color-primary) !important;
        }

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

        .card-img-top {
            height: 12rem;
            object-fit: cover;
        }

        /* Sidebar */
        #sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: 100%;
            max-width: 300px;
            height: 100%;
            background-color: var(--color-soft-bg);
            padding: 1.5rem;
            border-left: 1px solid #eee;
            z-index: 1060;
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #sidebar.active {
            transform: translateX(0);
        }

        .sidebar-link {
            color: #4a5568;
            padding: 12px 15px;
            text-decoration: none;
            font-size: 0.95rem;
            display: block;
            border-radius: 8px;
        }

        #sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1050;
            display: none;
        }
        #sidebar-overlay.active {
            display: block;
        }
    </style>
</head>

<body>

<header class="bg-white border-bottom border-light">
    <div class="container-fluid px-4 py-3 d-flex align-items-center justify-content-between">

        <a href="{{ route('accueil') }}">
            <img src="{{ asset('assets/images/logo_01.png') }}" alt="Logo" style="width: 75px;">
        </a>

        <form class="d-none d-md-flex mx-auto" style="max-width: 450px;" method="GET" action="{{ route('recherche') }}">
            <input class="form-control me-2 rounded-pill bg-light px-4"
                   type="search"
                   name="ville_quartier"
                   placeholder="Rechercher une ville..."
                   value="{{ request('ville_quartier') ?? '' }}">
            <button class="btn btn-custom-primary rounded-circle" style="width:45px;height:45px">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <a href="{{ route('logout') }}" class="btn btn-custom-primary d-none d-lg-block rounded-pill px-4">
            Déconnexion
        </a>

        <button id="toggleSidebar" class="btn btn-light rounded-circle shadow-sm ms-3">
            <i class="fas fa-bars text-primary"></i>
        </button>
    </div>
</header>

<div id="sidebar-overlay" onclick="toggleSidebar()"></div>

<div id="sidebar" class="shadow-xl">
    <button class="btn btn-light rounded-circle mb-4" onclick="toggleSidebar()">
        <i class="fas fa-times"></i>
    </button>

    @auth
        <div class="mb-4 border-bottom pb-3">
            <h6 class="fw-bold">{{ Auth::user()->name }}</h6>
            <span class="badge bg-light text-primary border">{{ Auth::user()->type_compte }}</span>
        </div>
    @endauth

    <a href="{{ route('accueil') }}" class="sidebar-link">
        <i class="fas fa-home me-2 text-primary"></i> Accueil
    </a>

    <div class="mt-auto pt-4">
        <a href="{{ route('logout') }}" class="btn btn-outline-danger w-100 rounded-pill">
            Quitter
        </a>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center fw-bold mb-5">
        Résultats pour :
        <span class="text-primary">
            {{ request('ville_quartier') ?: 'Toutes les résidences' }}
        </span>
    </h2>

    @if($recherches->isEmpty())
        <p class="text-center text-muted">Aucun résultat trouvé.</p>
    @else
        <div class="row g-4 justify-content-center">
            @foreach($recherches as $residence)
                @php
                    $images = is_string($residence->img) ? json_decode($residence->img, true) : [];
                    $firstImage = $images[0] ?? asset('assets/images/placeholder.jpg');
                    $dateDispo = \Carbon\Carbon::parse($residence->date_disponible);
                @endphp

                <div class="col-sm-6 col-lg-4 col-xl-3 d-flex">
                    <div class="card w-100">
                        <img src="{{ $firstImage }}" class="card-img-top">

                        <div class="card-body d-flex flex-column">
                            <h5 class="fw-bold">{{ $residence->nom }}</h5>

                            <div class="small text-muted mb-2">
                                <i class="fas fa-bed text-primary"></i> {{ $residence->nombre_chambres ?? 0 }} chambres
                                •
                                <i class="fas fa-couch text-primary"></i> {{ $residence->nombre_salons ?? 0 }} salons
                            </div>

                            <div class="fw-bold mb-2">
                                {{ number_format($residence->prix_journalier, 0, ',', ' ') }} FCFA / jour
                            </div>

                            <span class="mb-3">
                                @if($dateDispo->isPast())
                                    <span class="badge bg-success">Disponible</span>
                                @elseif($dateDispo->isToday())
                                    <span class="badge bg-primary">Aujourd'hui</span>
                                @else
                                    <span class="badge bg-warning">
                                        Libre le {{ $dateDispo->translatedFormat('d F') }}
                                    </span>
                                @endif
                            </span>

                            <a href="{{ route('details', $residence->id) }}"
                               class="btn btn-outline-custom rounded-pill mt-auto">
                                Détails
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
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
