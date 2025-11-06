<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche - Afrik'hub Résidences Meublées</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- GLightbox -->
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet" />

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        /* Styles de base et couleurs */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F5F5F5;
        }
        .btn-custom-orange {
            background-color: #FF8C00;
            border-color: #FF8C00;
            color: white;
        }
        .btn-custom-orange:hover {
            background-color: #CC7000;
            border-color: #CC7000;
            color: white;
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .cursor-pointer {
            cursor: pointer;
        }

        /* Style spécifique pour la Sidebar Coulissante */
        #sidebar {
            transition: transform 0.3s ease-in-out;
            transform: translateX(100%); /* Initialement caché à droite */
            position: fixed;
            top: 0;
            right: 0;
            width: 100%; /* Pleine largeur sur mobile */
            max-width: 350px; /* Limite la largeur sur desktop */
            z-index: 1060; /* Au-dessus de Bootstrap modals */
            height: 100%;
            background-color: #212529; /* Couleur sombre */
            padding: 1.5rem;
            box-shadow: -4px 0 12px rgba(0, 0, 0, 0.5);
            overflow-y: auto;
        }
        #sidebar.active {
            transform: translateX(0); /* Fait apparaître la sidebar */
        }
        /* Liens de la sidebar */
        .sidebar-link {
            color: #dee2e6;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 8px;
            transition: background-color 0.2s;
            text-align: center;
            font-weight: 500;
        }
        .sidebar-link:hover {
            background-color: #343a40;
            color: white;
        }

        /* Bouton de déconnexion */
        .btn-logout {
            background-color: #dc3545;
            border-color: #dc3545;
            font-weight: 600;
            color: white;
        }
        .btn-logout:hover {
            background-color: #c82333;
            border-color: #c82333;
            color: white;
        }

        /* Overlay pour cacher le contenu */
        #sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1050;
            display: none;
            transition: opacity 0.3s;
        }
        #sidebar-overlay.active {
            display: block;
        }
        /* Ajustement du contenu */
        .main-content {
            padding-top: 20px;
        }

        /* Supprime la règle qui cachait la sidebar sur desktop */
        /* La sidebar est maintenant disponible sur toutes les tailles via le bouton */
    </style>
</head>

<body>

{{-- NOUVEAU HEADER --}}
<header class="bg-dark shadow sticky-top">
    <div class="container-fluid px-3 py-2 d-flex align-items-center justify-content-between">

        <!-- Brand/Logo -->
        <a class="navbar-brand fw-bold text-white d-flex align-items-center me-4" href="{{ route('accueil') }}">
            <i class="fas fa-globe me-2 text-warning"></i> <span class="d-none d-sm-inline">AfrikHub</span>
        </a>

        <!-- Search Form (Central et prioritaire) -->
        <form class="d-flex mx-auto flex-grow-1" style="max-width: 500px;" method="GET" action="{{ route('recherche') }}">
            <input class="form-control me-2 rounded-pill border-secondary" type="search"
                    placeholder="Ville, quartier, référence..." aria-label="Rechercher" name="ville_quartier" />
            <button class="btn btn-custom-orange text-white rounded-pill" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <!-- User Actions (Desktop) -->
        <ul class="navbar-nav d-none d-lg-flex flex-row align-items-center mb-0 ms-4">
            <li class="nav-item mx-2">
                <a href="{{ route('dashboard') }}" class="nav-link text-white"><i class="fa fa-user me-1 text-warning"></i> Mon Espace</a>
            </li>
            <li class="nav-item mx-2">
                <a href="{{ route('logout') }}" class="btn btn-logout btn-sm px-3 py-2 d-flex align-items-center rounded-pill">
                    <i class="fa fa-sign-out me-2"></i> Déconnexion
                </a>
            </li>
        </ul>

        <!-- Menu Button (Visible sur TOUS les écrans) -->
        <button id="toggleSidebar" class="btn btn-dark ms-3 p-0" type="button" aria-label="Menu">
             <i class="fas fa-bars fa-lg text-white"></i>
        </button>
    </div>
</header>

{{-- SIDEBAR COULISSANTE (Mobile First, mais visible sur Desktop via bouton) --}}
<div id="sidebar-overlay" onclick="toggleSidebar()"></div>
<div id="sidebar" class="text-white d-flex flex-column">

    <button id="closeSidebar" class="btn text-white align-self-end p-0 mb-4" type="button" aria-label="Fermer" onclick="toggleSidebar()">
        <i class="fas fa-times fa-2x"></i>
    </button>

    <div class="w-100 d-flex flex-column gap-3">

        <!-- Header esthétique -->
        <div class="text-center mb-4 pb-3 border-bottom border-secondary">
             <i class="fas fa-bars fa-2x mb-2" style="color: #FF8C00;"></i>
             <h4 class="fw-bold">MENU PRINCIPAL</h4>
        </div>

        <a href="{{ route('accueil') }}" class="sidebar-link"><i class="fas fa-home me-2"></i> Accueil</a>

        <a href="{{ route('recherche') }}" class="sidebar-link active" style="background-color: #343a40;"><i class="fas fa-search me-2"></i> Recherche</a>

        <a href="{{ route('historique') }}" class="sidebar-link"><i class="fas fa-history me-2"></i> Réservation</a>

        <a href="{{ route('dashboard') }}" class="sidebar-link">
            <i class="fas fa-user me-2"></i> Mon Compte
        </a>

        <a href="{{ route('residences') }}" class="sidebar-link"><i class="fas fa-hotel me-2"></i> Mes Residences</a>

        <a href="{{ route('mise_en_ligne') }}" class="sidebar-link"><i class="fas fa-upload me-2"></i> Mise en ligne</a>

        <a href="{{ route('occupees') }}" class="sidebar-link"><i class="fas fa-calendar-alt me-2"></i> Residence occupées</a>

        <a href="{{ route('mes_demandes') }}" class="sidebar-link"><i class="fas fa-bell me-2"></i> Demandes de reservations</a>

        <div class="mt-4 pt-3 border-top border-secondary">
            <a href="{{ route('logout') }}" class="btn btn-logout rounded-pill w-100 shadow">
                <i class="fa fa-sign-out me-2"></i> Déconnexion
            </a>
        </div>
    </div>
</div>
<!-- FIN SIDEBAR -->

{{-- CONTENU PRINCIPAL --}}
<div class="container-fluid">
    <div class="row">

        <div class="col-12 main-content">
            <main class="container my-5">
                <h2 class="mb-4 text-center fw-bold fs-3">
                    Résultats de recherche pour <span class="text-warning">{{ request('ville_quartier') }}</span>
                </h2>

                @if ($recherches->isEmpty())
                    <div class="alert alert-info text-center">Aucune résidence trouvée pour cette recherche.</div>
                @else
                    <div class="row g-4 justify-content-center">
                        @foreach($recherches as $residence)
                            @php
                                $images = json_decode($residence->img, true);
                                $firstImage = $images[0] ?? 'https://placehold.co/400x250/E0E7FF/4F46E5?text=Pas+d\'image';
                            @endphp

                            <div class="col-sm-6 col-md-6 col-lg-4">
                                <div class="card shadow-sm h-100 border-0 rounded-4 overflow-hidden">
                                                                        {{-- Image principale cliquable pour galerie --}}
                                    <img src="{{ $firstImage }}" alt="Image de la résidence {{ $residence->nom }}"
                                        class="card-img-top rounded-top-3"
                                        style="height: 12rem; object-fit: cover; cursor: pointer;">

                                    {{-- Autres images (liens cachés pour GLightbox) --}}
                                    @foreach($images as $key => $image)
                                        @if($key > 0)
                                            <a href="{{ $image }}"
                                            class="glightbox"
                                            data-gallery="gallery-{{ $residence->id }}"
                                            data-title="{{ $residence->nom }}"
                                            style="display: none;"></a>
                                        @endif
                                    @endforeach


                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $residence->nom }}</h5>
                                        <p class="card-text text-truncate" title="{{ $residence->description }}">
                                            {{ Str::limit($residence->description, 100) }}
                                        </p>
                                        <ul class="list-unstyled small mb-3">
                                            <li><strong>Chambres :</strong> {{ $residence->nombre_chambres ?? '-' }}</li>
                                            <li><strong>Prix journalier :</strong> {{ number_format($residence->prix_journalier ?? 0, 0, ',', ' ') }} FCFA</li>
                                            <li><strong>Ville :</strong> {{ $residence->ville ?? '-' }}</li>
                                        </ul>

                                        <a href="{{ route('details', $residence->id) }}" class="btn btn-dark rounded-pill mt-auto">
                                            Détails
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>

<!-- GLightbox + Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
    // Initialise GLightbox pour les galeries d'images
    const lightbox = GLightbox({
        selector: '.glightbox'
    });

    // Ajoute un écouteur de clic sur l'image principale pour ouvrir la galerie
    document.querySelectorAll('.card-img-top').forEach(img => {
        img.addEventListener('click', function() {
            const card = this.closest('.card');
            const firstLink = card.querySelector('.glightbox');
            if (firstLink) {
                firstLink.click();
            }
        });
    });


    // --- Logique pour le menu latéral coulissant ---
    const sidebar = document.getElementById('sidebar');
    const toggleButton = document.getElementById('toggleSidebar');
    const overlay = document.getElementById('sidebar-overlay');

    function toggleSidebar() {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
        // Empêche le défilement du body lorsque le menu est ouvert
        document.body.classList.toggle('overflow-hidden');
    }

    // Lie les événements aux boutons
    if (toggleButton) {
        toggleButton.addEventListener('click', toggleSidebar);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
