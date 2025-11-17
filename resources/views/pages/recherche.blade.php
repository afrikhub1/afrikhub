<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche - Afrik'hub</title>
    <!-- Utilisation de CDN pour minimiser les dépendances locales -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet" />

    <style>
        /* Variables de couleur et Police */
        :root {
            --color-primary: #FF8C00; /* Orange Custom */
            --color-primary-hover: #CC7000;
            --color-secondary: #212529; /* Dark Bootstrap */
            --color-background: #F8F9FA; /* Light Gray */
            --footer-height: 60px; /* Hauteur estimée pour le footer fixe */
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-background);
            /* Ajout du padding-bottom pour laisser de la place au footer fixe */
            padding-bottom: var(--footer-height);
        }

        /* Boutons personnalisés (Orange Primaire) */
        .btn-custom-primary {
            background-color: var(--color-primary);
            border-color: var(--color-primary);
            color: white;
            transition: background-color 0.2s, border-color 0.2s;
        }
        .btn-custom-primary:hover {
            background-color: var(--color-primary-hover);
            border-color: var(--color-primary-hover);
            color: white;
        }
        /* Boutons personnalisés (Sombre Secondaire) */
        .btn-dark-secondary {
            background-color: var(--color-secondary);
            border-color: var(--color-secondary);
            color: white;
        }
        .btn-dark-secondary:hover {
            background-color: #343a40;
            border-color: #343a40;
            color: white;
        }

        /* Styles des cartes de résidence */
        .card {
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .card-img-top {
            height: 12rem;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .card:hover .card-img-top {
            transform: scale(1.05);
        }
        .card-text-truncate {
            display: -webkit-box;
            -webkit-line-clamp: 3; /* Limite à 3 lignes */
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Style spécifique pour la Sidebar Coulissante */
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
            box-shadow: -6px 0 16px rgba(0, 0, 0, 0.7);
            overflow-y: auto;
        }
        #sidebar.active {
            transform: translateX(0);
        }
        .sidebar-link {
            color: #dee2e6;
            padding: 12px 15px;
            font-weight: 500;
            /* SUPPRESSION DU SOULIGNEMENT DES LIENS */
            text-decoration: none;
        }
        .sidebar-link:hover {
            background-color: #343a40;
            color: white;
        }
        /* Overlay */
        #sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1050;
            display: none;
        }
        #sidebar-overlay.active {
            display: block;
        }
        /* HEADER - Ajustements pour la responsivité */
        @media (max-width: 991.98px) {
            .navbar-nav {
                display: none !important;
            }
            .search-form-container {
                max-width: 90%;
                margin: 0 auto;
            }
        }

    </style>
</head>

<body>

{{-- HEADER (NON FIXE) - Thème Sombre et Orange --}}
<header class="bg-dark shadow">
    <div class="container-fluid px-3 py-2 d-flex align-items-center justify-content-between">

        <!-- Brand/Logo -->
        <div class="d-flex align-items-center">
            <a href="{{ route('accueil') }}">
                <img class="h-auto" style="width: 80px;" src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo"/>
            </a>
        </div>

        <!-- Search Form (Central et prioritaire) -->
        <form class="d-flex mx-auto search-form-container" style="max-width: 500px;" method="GET" action="{{ route('recherche') }}">
            <input class="form-control me-2 rounded-pill border-secondary" type="search"
                   placeholder="Ville, quartier, référence..." aria-label="Rechercher" name="ville_quartier"
                   value="{{ request('ville_quartier') ?? '' }}"
            />
            <button class="btn btn-custom-primary text-white rounded-pill" type="submit">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <!-- User Actions (Desktop) -->
        <ul class="navbar-nav d-none d-lg-flex flex-row align-items-center mb-0 ms-4 g-4">
            <li class="nav-item mx-2">
                <!-- Texte blanc sur fond sombre -->
                @if(Auth::user()->type_compte == 'professionnel')
                    <a href="{{ route('dashboard') }}" class="nav-link text-white fw-bold mx-2"> <i class="fas fa-user-circle"></i> Profil</a>
                @endif

                @if(Auth::user()->type_compte == 'client')
                    <a href="{{ route('clients_historique') }}" class="nav-link text-white fw-bold mx-2">
                        <i class="fa fa-user-circle me-2"></i>Profil
                    </a>
                @endif
            </li>
            <a href="javascript:history.back()" class="nav-link text-white fw-bold">
               <i class="fas fa-sign-out"></i> Retour</a>
            <li class="nav-item mx-2">
                <!-- Bouton orange pour contraste élevé -->
                <a href="{{ route('logout') }}" class="btn btn-custom-primary btn-sm px-3 py-2 d-flex align-items-center rounded-pill">
                    <i class="fa fa-sign-out me-2"></i> Déconnexion
                </a>
            </li>
        </ul>

        <!-- Menu Button (Visible sur TOUS les écrans) -->
        <button id="toggleSidebar" class="btn btn-link ms-3 p-0" type="button" aria-label="Menu">
             <!-- Icône blanche sur fond sombre -->
             <i class="fas fa-bars fa-lg text-white"></i>
        </button>
    </div>
</header>

{{-- SIDEBAR COULISSANTE --}}
<div id="sidebar-overlay" onclick="toggleSidebar()"></div>
<div id="sidebar" class="text-white d-flex flex-column">

    <button id="closeSidebar" class="btn text-white align-self-end p-0 mb-4" type="button" aria-label="Fermer" onclick="toggleSidebar()">
        <i class="fas fa-times fa-2x"></i>
    </button>

    <div class="w-100 d-flex flex-column gap-3">
        <div class="text-center mb-4 pb-3 border-bottom border-secondary">
             @auth
                 <h4 class="small text-muted mb-0">Connecté comme : {{ Auth::user()->name }}</h4>
             @endauth
        </div>

        @if(Auth::user()->type_compte == 'professionnel')
            <a href="{{ route('reservationRecu') }}" class="sidebar-link"><i class="fas fa-history me-2"></i> Mon Historique</a>
            <a href="{{ route('dashboard') }}" class="sidebar-link"><i class="fas fa-user-circle me-2"></i> Mon Compte</a>
            <a href="{{ route('residences') }}" class="sidebar-link"><i class="fas fa-hotel me-2"></i> Mes Residences</a>
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
<!-- FIN SIDEBAR -->

{{-- CONTENU PRINCIPAL --}}
<div class="container my-5">
    <h2 class="mb-5 text-center fw-bold fs-3 text-secondary">
        Résultats de recherche pour : <span class="text-primary">{{ request('ville_quartier') ?: 'Toutes les résidences' }}</span>
    </h2>

    <div class="row">
        <div class="col-12 main-content">
            @if ($recherches->isEmpty())
                <div class="alert alert-warning text-center fw-bold rounded-3 p-4">
                    <i class="fas fa-exclamation-triangle me-2"></i> Désolé, aucune résidence trouvée pour cette recherche.
                </div>
            @else
                <div class="row g-4 justify-content-center">
                    @foreach($recherches as $residence)
                        @php
                            $images = is_string($residence->img) ? json_decode($residence->img, true) : ($residence->img ?? []);
                            // Fallback pour la première image
                            $firstImage = $images[0] ?? asset('assets/images/placeholder.jpg');
                        @endphp

                        <div class="col-sm-6 col-md-6 col-lg-4 d-flex">
                            <div class="card shadow h-100 border-0 rounded-4 overflow-hidden w-100">
                                <a href="javascript:void(0)"
                                   class="glightbox-trigger-{{ $residence->id }}">
                                    <img src="{{ $firstImage }}"
                                         alt="Image de la résidence {{ $residence->nom }}"
                                         class="card-img-top"
                                         loading="lazy">
                                </a>

                                {{-- Liens GLightbox CACHÉS pour la galerie --}}
                                @foreach($images as $key => $image)
                                    <a href="{{ $image }}"
                                       class="glightbox"
                                       data-gallery="gallery-{{ $residence->id }}"
                                       data-title="{{ $residence->nom }} - Image {{ $key + 1 }}"
                                       style="display: none;"
                                       aria-label="Voir l'image {{ $key + 1 }}"
                                       data-index="{{ $key }}"
                                       data-trigger=".glightbox-trigger-{{ $residence->id }}"
                                    ></a>
                                @endforeach

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold text-dark">{{ $residence->nom }}</h5>
                                    <p class="card-text text-muted card-text-truncate" title="{{ $residence->description }}">
                                        {{ Str::limit($residence->description, 100) }}
                                    </p>
                                    <ul class="list-unstyled small mb-3 mt-2">
                                        <li><i class="fas fa-bed me-2 text-primary"></i> <strong>Chambres :</strong> {{ $residence->nombre_chambres ?? '-' }}</li>
                                        <li><i class="fas fa-bed me-2 text-primary"></i> <strong>Salon :</strong> {{ $residence->nombre_salons ?? '-' }}</li>
                                        <li><i class="fas fa-map-marker-alt me-2 text-primary"></i> <strong>Situation :</strong> {{ $residence->pays ?? '-' }}/{{ $residence->ville ?? '-' }}</li>
                                        <li class="fw-bold mt-2">
                                            <i class="fas fa-money-bill-wave me-2 text-success"></i>
                                            Prix/jour : {{ number_format($residence->prix_journalier ?? 0, 0, ',', ' ') }} FCFA
                                        </li>
                                        <li class="fw-bold mt-2 text-danger fw-600">
                                            <i class="fas fa-calendar-check me-2"></i>
                                            Prochaine disponibilité : {{ \Carbon\Carbon::parse($residence->date_disponible)->translatedFormat('d F Y') }}
                                        </li>

                                        @php
                                            use Carbon\Carbon;

                                            $dateDispo = Carbon::parse($residence->date_disponible); // date de la résidence
                                            $today = Carbon::today();
                                        @endphp

                                        <li class="mt-2">
                                            @if ($dateDispo->isPast())
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                                    Disponible depuis le {{ $dateDispo->translatedFormat('d F Y') }}
                                                </span>
                                            @elseif ($dateDispo->isToday())
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                                    Disponible
                                                </span>
                                            @else
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-700">
                                                    Disponible le {{ $dateDispo->translatedFormat('d F Y') }}
                                                </span>
                                            @endif
                                        </li>

                                    </ul>

                                    <a href="{{ route('details', $residence->id) }}" class="btn btn-dark-secondary rounded-pill mt-auto">
                                        Voir les Détails <i class="fas fa-arrow-right ms-2"></i>
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

{{-- PIED DE PAGE (FIXE EN BAS) --}}
<footer class="bg-dark text-white-50 py-3 fixed-bottom shadow-lg">
    <div class="container text-center">
        <p class="mb-0">© {{ date('Y') }} Afrik'hub. Tous droits réservés.</p>
        <p class="small">Plateforme de Résidences Meublées.</p>
    </div>
</footer>

<!-- GLightbox + Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
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

    if (toggleButton) {
        toggleButton.addEventListener('click', toggleSidebar);
    }

    // --- Logique GLightbox pour la galerie --
    // Initialise GLightbox
    const lightbox = GLightbox();

    // Ajoute un écouteur de clic sur le lien 'a' qui enveloppe l'image pour ouvrir le premier lien GLightbox
    document.querySelectorAll('[data-trigger]').forEach(link => {
        const triggerSelector = link.getAttribute('data-trigger');
        const triggerElement = document.querySelector(triggerSelector);

        if (triggerElement) {
            // Empêche le comportement par défaut du lien pour le gérer manuellement
            triggerElement.addEventListener('click', function(e) {
                e.preventDefault();

                // Trouve tous les liens GLightbox pour cette galerie
                const galleryLinks = document.querySelectorAll(`.glightbox[data-gallery="${link.getAttribute('data-gallery')}"]`);

                // Déclenche l'ouverture de la galerie à l'indice 0
                if (galleryLinks.length > 0) {
                     // Utilise la méthode d'API de GLightbox pour ouvrir la galerie à l'indice 0
                    lightbox.openAt(0, galleryLinks[0]);
                }
            });
        }
    });

</script>
</body>
</html>
