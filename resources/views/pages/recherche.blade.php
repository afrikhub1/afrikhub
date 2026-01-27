<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche - Afrik'hub</title>
    <!-- Utilisation de CDN pour minimiser les dépendances locales -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet" />


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
                    <a href="{{ route('pro.dashboard') }}" class="nav-link text-white fw-bold mx-2"> <i class="fas fa-user-circle"></i> Profil</a>
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

        <!--Bouton menu -->
        <button id="toggleSidebar" class="btn btn-link ms-3 p-0" type="button" aria-label="Menu">
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
                 <h4 class="text-xl text-muted mb-0"> {{ Auth::user()->name }}</h4>
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
<!-- FIN SIDEBAR -->

{{-- CONTENU PRINCIPAL --}}
<div class="container my-5">
    <h2 class="mb-5 text-center fw-bold fs-3 text-secondary">
        Résultats de recherche pour : <span class="text-primary">{{ request('ville_quartier') ?: 'Toutes les résidences' }}</span>
    </h2>
    

    <div class="row">
        
        @include('includes.messages')

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

                        <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 d-flex">
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
                                        <li>
                                            <i class="fas fa-bed me-2 text-primary"></i>
                                            <strong>Chambres :</strong> {{ $residence->nombre_chambres ?? '-' }}
                                        </li>
                                        <li>
                                            <i class="fas fa-bed me-2 text-primary"></i>
                                            <strong>Salon :</strong> {{ $residence->nombre_salons ?? '-' }}
                                        </li>
                                        <li>
                                            <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                            <strong>Situation :</strong> {{ $residence->pays ?? '-' }}/{{ $residence->ville ?? '-' }}
                                        </li>
                                        <li class="fw-bold mt-2">
                                            <i class="fas fa-money-bill-wave me-2 text-success"></i>
                                            Prix/jour : {{ number_format($residence->prix_journalier ?? 0, 0, ',', ' ') }} FCFA
                                        </li>
                                       @php
                                            $dateDispo = \Carbon\Carbon::parse($residence->date_disponible);
                                        @endphp

                                        @if ($dateDispo->isPast())
                                            <li>
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                                    Disponible depuis le {{ $dateDispo->translatedFormat('d F Y') }}
                                                </span>
                                            </li>
                                        @elseif ($dateDispo->isToday())
                                            <li>
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                                    Disponible
                                                </span>
                                            </li>
                                        @else
                                            <li>
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-700">
                                                    Disponible le {{ $dateDispo->translatedFormat('d F Y') }}
                                                </span>
                                            </li>
                                        @endif


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
 @include('includes.footer')

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
