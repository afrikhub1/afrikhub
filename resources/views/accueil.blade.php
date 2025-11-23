<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Afrik'Hub</title>
    <!-- Chargement de Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chargement de Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Chargement de GLightbox (pour les galeries d'images) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <!-- Police Inter pour l'esthétique -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* Variables et Styles Généraux */
        :root {
            --primary-color: #006d77; /* Couleur principale (Bleu-vert) */
            --secondary-color: #83c5be;
            --danger-color: #dc3545;
            --bg-light: #e0f2f1; /* Fond très clair, proche de votre #e0f2f1 */
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa; /* Fond clair */
            scroll-behavior: smooth;
        }

        /* HEADER */
        header {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        header .img-fluid {
            max-height: 50px; /* Taille du logo */
            width: auto;
        }

        /* NAVIGATION PRINCIPALE (Desktop) */
        #entete {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        #entete a {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            color: #fff;
            display: flex;
            align-items: center;
            transition: background-color 0.3s, transform 0.2s;
        }
        #entete a .badge {
            margin-left: 0.5rem;
            color: #fff;
            text-transform: uppercase;
        }
        #entete a.bg-dark { background-color: #343a40 !important; }
        #entete a.bg-dark:hover { background-color: #000 !important; transform: translateY(-1px); }
        #entete a.bg-danger { background-color: var(--danger-color) !important; }
        #entete a.bg-danger:hover { background-color: #c82333 !important; transform: translateY(-1px); }
        /* Liens de navigation non-connexion/inscription */
        #entete li:nth-child(4) a, #entete li:nth-child(5) a, #entete li:nth-child(6) a {
            background-color: var(--primary-color) !important;
        }
        #entete li:nth-child(4) a:hover, #entete li:nth-child(5) a:hover, #entete li:nth-child(6) a:hover {
            background-color: #004c54 !important;
        }

        /* Menu DROPDOWN (Mobile) */
        .dropdown-toggle {
            display: none; /* Caché par défaut sur desktop */
            background-color: var(--primary-color);
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            text-transform: uppercase;
        }
        .dropdown-menu {
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .dropdown-menu a {
            text-transform: capitalize;
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Réactivité de la Navigation */
        @media (min-width: 992px) { /* Large screens */
            .nav-item.dropdown {
                display: none;
            }
        }
        @media (max-width: 991.98px) { /* Tablets and smaller */
            #entete {
                display: none; /* Cacher le menu horizontal */
            }
            .nav-item.dropdown {
                display: block;
                width: 100%;
                text-align: right;
            }
            .dropdown-toggle {
                display: inline-block; /* Afficher le bouton menu */
            }
            .dropdown-menu {
                right: 0;
                left: auto;
                min-width: 200px;
            }
        }
        /* SECTION ACCUEIL */
        #accueil {
            background: var(--bg-light);
            padding: 5rem 1rem !important;
        }
        #accueil h2 {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        .btn-reserver {
            background-color: var(--primary-color);
            color: #fff;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: background-color 0.3s, box-shadow 0.3s;
            display: inline-block;
            margin-top: 1rem;
        }
        .btn-reserver:hover {
            background-color: #004c54;
            box-shadow: 0 4px 10px rgba(0, 109, 119, 0.4);
            color: #fff;
        }

        /* SECTION HÉBERGEMENT */
        #hebergement h2 {
            text-align: center;
            font-size: 2rem;
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 2rem;
            border-bottom: 3px solid var(--secondary-color);
            display: inline-block;
            padding-bottom: 0.5rem;
        }
        #hebergement {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        #hebergement .row {
            max-width: 1200px;
        }
        #hebergement img {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        /* Custom Accordion/Services */
        .accordion-item {
            border-radius: 10px !important;
            margin-bottom: 1rem;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .accordion-button {
            font-weight: 600;
            text-transform: uppercase;
            color: var(--primary-color);
            background-color: #fff !important;
            border-radius: 10px !important;
        }
        .accordion-button:not(.collapsed) {
            color: #fff;
            background-color: var(--primary-color) !important;
            box-shadow: none;
        }
        .accordion-body {
            background: #fff;
        }
        .services-list {
            list-style: none;
            padding-left: 1rem;
            margin: 0;
            font-size: 0.9rem;
            color: #555;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        .services-list li::before {
            content: "•";
            color: var(--secondary-color);
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }
        /* Custom JS active class for accordion content display */
        .accordion-item.active .services-list {
            max-height: 500px; /* Grande valeur pour permettre l'expansion */
        }
        .accordion-item.active .toggle-services i {
            transform: rotate(180deg);
        }
        .toggle-services i {
            transition: transform 0.3s;
        }

        /* Cartes de Résidences */
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .card-text-truncate {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 3; /* Limite à 3 lignes */
            -webkit-box-orient: vertical;
            height: 60px; /* Hauteur fixe pour éviter le CLS */
        }
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        }
        .btn-dark {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        /* FOOTER */
        footer {
            background-color: #343a40;
            color: #fff;
            padding: 2rem 1rem;
            text-align: center;
            margin-top: 3rem;
            border-top: 5px solid var(--secondary-color);
        }
        footer p {
            margin: 0;
            font-size: 0.9rem;
        }

    </style>
</head>
<body>

<!-- HEADER -->
<header class="p-1">
    <div class="col-12 row m-0 align-items-center">
        <!-- Logo -->
        <div class="col-lg-2 col-md-2 col-3">
            <img class="img-fluid" src="https://placehold.co/150x50/006d77/ffffff?text=LOGO+01" alt="Afrik'Hub Logo" />
            <!-- Original: {{ asset('assets/images/logo_01.png') }} -->
        </div>

        <!-- Navigation -->
        <nav class="col-lg-10 col-md-10 col-9">
            <ul class="d-flex justify-content-end py-2 align-items-center list-unstyled m-0">
                <!-- Menu Desktop -->
                <ul id="entete" class="list-unstyled d-none d-lg-flex">
                    <li><a href="javascript:void(0)" class="bg-dark" aria-label="connexion"><span class="fa-solid fa-sign-in-alt"></span><span class="badge">connexion</span></a></li>
                    <li><a href="javascript:void(0)" class="bg-dark" aria-label="inscription"><span class="fa-solid fa-user-plus"></span><span class="badge">inscription</span></a></li>
                    <li><a href="javascript:void(0)" class="bg-danger"><span class="fa-solid fa-user-shield"></span><span class="badge">admin</span></a></li>
                    <li><a href="#hebergement"><span class="fa-solid fa-house"></span><span class="badge">hébergement</span></a></li>
                    <li><a href="#location"><span class="fa-solid fa-car"></span><span class="badge">véhicule</span></a></li>
                    <li><a href="#contact"><span class="fa-solid fa-phone"></span><span class="badge">contact</span></a></li>
                </ul>

                <!-- Menu Mobile (Dropdown) -->
                <li class="nav-item dropdown d-lg-none">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Menu</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-label="submenu">
                        <li><a class="dropdown-item" href="javascript:void(0)">Connexion</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)">Inscription</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)">Admin</a></li>
                        <li><a class="dropdown-item" href="#hebergement">Hébergements</a></li>
                        <li><a class="dropdown-item" href="#location">Véhicules</a></li>
                        <li><a class="dropdown-item" href="#circuits">Circuits</a></li>
                        <li><a class="dropdown-item" href="#reservation">Réservation</a></li>
                        <li><a class="dropdown-item" href="#contact">Contact</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>

<!-- Contenu principal -->
<div class="container-fluid p-0">
    <nav class="row col-12 justify-content-center m-0 p-0">

        <!-- Section accueil -->
        <section id="accueil" class="text-center py-5 w-100">
            <div class="container">
                <!-- @include('includes.messages') -->
                <div class="alert alert-success text-center d-none" role="alert">
                    Message de bienvenue !
                </div>

                <h2>Bienvenue</h2>
                <span class="fs-6">Explorez l'Afrique autrement avec Afrik’Hub</span><br><br>
                <a href="javascript:void(0)" class="btn-reserver me-2">Réserver</a>
                <a href="javascript:void(0)" class="btn-reserver">Ajouter un bien</a>
            </div>
        </section>

        <!-- Section hébergement -->
        <section id="hebergement" class="my-5 col-12 row m-0 justify-content-center">
            <h2 class="col-12 text-center">hébergements</h2>

            <div class="row g-4 align-items-center col-12 col-xl-10 mx-auto">

                <!-- Image section -->
                <div class="col-12 col-lg-6 d-flex justify-content-center">
                    <img class="w-100" style="max-width: 500px;" src="https://placehold.co/800x600/006d77/ffffff?text=Image+H%C3%A9bergement" alt="Image illustrant l'hébergement"/>
                    <!-- Original: {{ asset('assets/images/hebergement.jpg') }} -->
                </div>

                <!-- Accordion/Details section -->
                <div class="col-12 col-lg-6">
                    <div class="accordion" id="accordionHebergement">

                        <!-- Types d'hébergements -->
                        <div class="accordion-item border-0" style="background: var(--bg-light);">
                            <h2 class="accordion-header mt-lg-5" id="headingTypes">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTypes" aria-expanded="true" aria-controls="collapseTypes">
                                    types d'hébergements
                                </button>
                            </h2>
                            <div id="collapseTypes" class="accordion-collapse collapse show" aria-labelledby="headingTypes" data-bs-parent="#accordionHebergement">
                                <div class="accordion-body">
                                    <div class="mb-3 border-0 accordion-item-custom">
                                        <div class="d-flex align-items-center justify-content-between"><strong>Studio</strong><span class="toggle-services"><i class="fas fa-chevron-down"></i></span></div>
                                        <ul class="services-list mt-2"><li>wifi gratuit</li><li>ventilateur</li><li>caméra de surveillance</li></ul>
                                    </div>
                                    <div class="mb-3 accordion-item-custom">
                                        <div class="d-flex align-items-center justify-content-between"><strong>Chambre unique</strong><span class="toggle-services"><i class="fas fa-chevron-down"></i></span></div>
                                        <ul class="services-list mt-2"><li>wifi gratuit</li><li>climatisation</li><li>petit déjeuner inclus</li></ul>
                                    </div>
                                    <div class="mb-3 accordion-item-custom">
                                        <div class="d-flex align-items-center justify-content-between"><strong>Villa avec piscine</strong><span class="toggle-services"><i class="fas fa-chevron-down"></i></span></div>
                                        <ul class="services-list mt-2"><li>wifi gratuit</li><li>piscine privée</li><li>climatisation</li><li>parking gratuit</li></ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Conditions de réservation -->
                        <div class="accordion-item border-0" style="background: var(--bg-light);">
                            <h2 class="accordion-header" id="headingConditions">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseConditions" aria-expanded="false" aria-controls="collapseConditions">
                                    conditions de réservation
                                </button>
                            </h2>
                            <div id="collapseConditions" class="accordion-collapse collapse" aria-labelledby="headingConditions" data-bs-parent="#accordionHebergement">
                                <div class="accordion-body">
                                    <ul>
                                        <li>réservation préalable requise</li>
                                        <li>acompte de 20% pour confirmation</li>
                                        <li>annulation gratuite jusqu'à 48h avant l'arrivée</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="javascript:void(0)" class="btn-reserver">réserver</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Placeholder pour l'autre section (véhicules) -->
        <section id="location" class="text-center py-5 w-100 bg-light">
            <h2 class="mb-4" style="font-size: 2rem; color: var(--primary-color); font-weight: 700;">Véhicules</h2>
            <p class="fs-5 text-muted">Bientôt disponible : Location de voitures et motos pour explorer l'Afrique en toute liberté.</p>
            <a href="javascript:void(0)" class="btn-reserver" style="background-color: #fca311 !important;">Voir les options</a>
        </section>

        <section id="circuits" class="text-center py-5 w-100 bg-white">
            <h2 class="mb-4" style="font-size: 2rem; color: var(--primary-color); font-weight: 700;">Circuits organisés</h2>
            <p class="fs-5 text-muted">Découvrez nos circuits thématiques pour des expériences inoubliables en Afrique.</p>
            <a href="javascript:void(0)" class="btn-reserver" style="background-color: #e85d04 !important;">Explorer</a>
        </section>
    </nav>

    <!-- SECTION LISTE DES RÉSIDENCES (Simulation de la boucle) -->
    <div class="container py-5">
        <h2 class="text-center mb-5" style="font-size: 2rem; color: var(--primary-color); font-weight: 700; border-bottom: 3px solid var(--secondary-color); display: inline-block; padding-bottom: 0.5rem; margin: 0 auto 2rem auto;">Nos Résidences Populaires</h2>

        <div class="row m-0">
            <!-- Simulation: @if ($residences->isEmpty()) -->
            <!-- <div class="alert alert-warning text-center fw-bold rounded-3 p-4">...</div> -->
            <!-- Simulation: @else -->
            <div class="row g-4 justify-content-center mb-4">

                <!-- Début de la Simulation de la boucle @foreach($residences as $residence) -->

                <!-- Résidence Mock 1 -->
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex">
                    <div class="card shadow h-100 border-0 rounded-4 overflow-hidden w-100">
                        <!-- URL Image 1 -->
                        <a href="javascript:void(0)" class="glightbox-trigger-1">
                            <img src="https://placehold.co/400x200/006d77/ffffff?text=Image+1"
                                 alt="Image de la résidence Étoile"
                                 class="card-img-top"
                                 loading="lazy">
                        </a>

                        <!-- Liens GLightbox CACHÉS (Simulation) -->
                        <a href="https://placehold.co/800x600/006d77/ffffff?text=Galerie+1.1" class="glightbox" data-gallery="gallery-1" data-title="Étoile - Image 1" style="display: none;" data-index="0" data-trigger=".glightbox-trigger-1"></a>
                        <a href="https://placehold.co/800x600/83c5be/000000?text=Galerie+1.2" class="glightbox" data-gallery="gallery-1" data-title="Étoile - Image 2" style="display: none;" data-index="1" data-trigger=".glightbox-trigger-1"></a>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark">Résidence Étoile</h5>
                            <p class="card-text text-muted card-text-truncate" title="Description longue de la résidence Étoile, moderne et proche du centre-ville, idéale pour les voyages d'affaires ou les séjours prolongés.">
                                Description longue de la résidence Étoile, moderne et proche du centre-ville, idéale pour les voyages d'affaires ou les séjours prolongés.
                            </p>
                            <ul class="list-unstyled small mb-3 mt-2">
                                <li><i class="fas fa-bed me-2 text-primary"></i> <strong>Chambres :</strong> 2</li>
                                <li><i class="fas fa-bed me-2 text-primary"></i> <strong>Salon :</strong> 1</li>
                                <li><i class="fas fa-map-marker-alt me-2 text-primary"></i> <strong>Situation :</strong> Sénégal/Dakar</li>
                                <li class="fw-bold mt-2">
                                    <i class="fas fa-money-bill-wave me-2 text-success"></i>
                                    Prix/jour : 50 000 FCFA
                                </li>
                                <li class="fw-bold mt-2 text-danger fw-600">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    Prochaine disponibilité : 15 Novembre 2025
                                </li>
                            </ul>
                            <a href="javascript:void(0)" class="btn btn-dark rounded mt-auto">
                                Voir les Détails <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Résidence Mock 2 -->
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex">
                    <div class="card shadow h-100 border-0 rounded-4 overflow-hidden w-100">
                        <!-- URL Image 2 -->
                        <a href="javascript:void(0)" class="glightbox-trigger-2">
                            <img src="https://placehold.co/400x200/83c5be/000000?text=Image+2"
                                 alt="Image de la résidence Hibiscus"
                                 class="card-img-top"
                                 loading="lazy">
                        </a>

                        <!-- Liens GLightbox CACHÉS (Simulation) -->
                        <a href="https://placehold.co/800x600/83c5be/000000?text=Galerie+2.1" class="glightbox" data-gallery="gallery-2" data-title="Hibiscus - Image 1" style="display: none;" data-index="0" data-trigger=".glightbox-trigger-2"></a>
                        <a href="https://placehold.co/800x600/006d77/ffffff?text=Galerie+2.2" class="glightbox" data-gallery="gallery-2" data-title="Hibiscus - Image 2" style="display: none;" data-index="1" data-trigger=".glightbox-trigger-2"></a>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark">Villa Hibiscus</h5>
                            <p class="card-text text-muted card-text-truncate" title="Superbe villa avec piscine privée, idéale pour les familles ou les groupes. Située en bord de mer.">
                                Superbe villa avec piscine privée, idéale pour les familles ou les groupes. Située en bord de mer, elle offre un cadre de rêve.
                            </p>
                            <ul class="list-unstyled small mb-3 mt-2">
                                <li><i class="fas fa-bed me-2 text-primary"></i> <strong>Chambres :</strong> 4</li>
                                <li><i class="fas fa-bed me-2 text-primary"></i> <strong>Salon :</strong> 2</li>
                                <li><i class="fas fa-map-marker-alt me-2 text-primary"></i> <strong>Situation :</strong> Côte d'Ivoire/Abidjan</li>
                                <li class="fw-bold mt-2">
                                    <i class="fas fa-money-bill-wave me-2 text-success"></i>
                                    Prix/jour : 150 000 FCFA
                                </li>
                                <li class="fw-bold mt-2 text-danger fw-600">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    Prochaine disponibilité : 22 Décembre 2025
                                </li>
                            </ul>
                            <a href="javascript:void(0)" class="btn btn-dark rounded mt-auto">
                                Voir les Détails <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Résidence Mock 3 -->
                <div class="col-sm-6 col-md-4 col-lg-3 d-flex">
                    <div class="card shadow h-100 border-0 rounded-4 overflow-hidden w-100">
                        <!-- URL Image 3 -->
                        <a href="javascript:void(0)" class="glightbox-trigger-3">
                            <img src="https://placehold.co/400x200/fca311/000000?text=Image+3"
                                 alt="Image de la résidence Savane"
                                 class="card-img-top"
                                 loading="lazy">
                        </a>

                        <!-- Liens GLightbox CACHÉS (Simulation) -->
                        <a href="https://placehold.co/800x600/fca311/000000?text=Galerie+3.1" class="glightbox" data-gallery="gallery-3" data-title="Savane - Image 1" style="display: none;" data-index="0" data-trigger=".glightbox-trigger-3"></a>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark">Appartement Savane</h5>
                            <p class="card-text text-muted card-text-truncate" title="Un petit appartement cosy pour une personne ou un couple, en plein cœur de la ville, près de toutes les commodités.">
                                Un petit appartement cosy pour une personne ou un couple, en plein cœur de la ville, près de toutes les commodités. Entièrement équipé.
                            </p>
                            <ul class="list-unstyled small mb-3 mt-2">
                                <li><i class="fas fa-bed me-2 text-primary"></i> <strong>Chambres :</strong> 1</li>
                                <li><i class="fas fa-bed me-2 text-primary"></i> <strong>Salon :</strong> -</li>
                                <li><i class="fas fa-map-marker-alt me-2 text-primary"></i> <strong>Situation :</strong> Cameroun/Yaoundé</li>
                                <li class="fw-bold mt-2">
                                    <i class="fas fa-money-bill-wave me-2 text-success"></i>
                                    Prix/jour : 25 000 FCFA
                                </li>
                                <li class="fw-bold mt-2 text-danger fw-600">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    Prochaine disponibilité : 01 Décembre 2025
                                </li>
                            </ul>
                            <a href="javascript:void(0)" class="btn btn-dark rounded mt-auto">
                                Voir les Détails <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Fin de la Simulation de la boucle -->

            </div>
            <!-- Simulation: @endif -->
        </div>
    </div>
</div>


<!-- Footer -->
<footer>
    <p id="contact">&copy; 2025 afrik’hub. tous droits réservés.<br />afrikhub@gmail.com</p>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Initialisation de GLightbox pour toutes les galeries
        const lightbox = GLightbox({
            selector: '.glightbox',
            touchNavigation: true,
            loop: true,
            autoplayVideos: true,
            openEffect: 'zoom',
            closeEffect: 'fade',
        });

        // Logique pour déclencher GLightbox sur le clic de l'image principale
        document.querySelectorAll('[data-trigger]').forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                // Trouver le premier lien caché de la galerie correspondante
                const targetSelector = `.glightbox[data-trigger=".${e.currentTarget.classList[0]}"]`;
                const firstLink = document.querySelector(targetSelector);

                if (firstLink) {
                    lightbox.openAt(firstLink.getAttribute('data-index'));
                }
            });
        });


        // --- Logique du Custom Accordion (similaire à votre script Blade) ---
        // Votre script cible des classes spécifiques dans votre structure Blade.
        // Je vais ajuster la logique pour qu'elle fonctionne avec les éléments du bloc #hebergement

        // Cible les titres des services (Studio, Chambre unique, etc.)
        document.querySelectorAll(".accordion-item-custom").forEach(item => {
            const toggleButton = item.querySelector("strong").closest("div");
            const serviceList = item.querySelector(".services-list");

            // Pour chaque titre de service cliquable (Studio, Chambre unique...)
            toggleButton.addEventListener("click", () => {
                // Fermer tous les autres services ouverts
                document.querySelectorAll(".accordion-item-custom.active").forEach(activeItem => {
                    if (activeItem !== item) {
                        activeItem.classList.remove("active");
                        activeItem.querySelector(".services-list").style.maxHeight = null;
                    }
                });

                // Ouvrir/Fermer l'élément actuel
                if (item.classList.contains("active")) {
                    item.classList.remove("active");
                    serviceList.style.maxHeight = null;
                } else {
                    item.classList.add("active");
                    // Définir la hauteur en fonction du contenu
                    serviceList.style.maxHeight = serviceList.scrollHeight + "px";
                }
            });
        });

        // Logique pour les accordéons standards (types d'hébergement / conditions)
        document.querySelectorAll(".accordion-button").forEach(button => {
            button.addEventListener("click", (e) => {
                // Cette partie est gérée nativement par Bootstrap, mais je garde
                // votre ancien script en commentaire si jamais vous utilisiez une logique personnalisée.
            });
        });

    });
</script>
