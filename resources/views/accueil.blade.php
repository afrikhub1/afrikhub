<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
        {{-- Utilisation de la version FontAwesome 6 (fa-solid) --}}
        <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

        <title> {{ config('app.name')}}-accueil</title>
    </head>
    <body>

        <style>
            /* --- CONSOLIDATION CSS --- */
            header {
            position: relative;
            background: linear-gradient(135deg, #006d77, #00afb9);
            color: white;
            z-index: 10;
            padding: 0.5rem 1rem;
            align-items: center;
            justify-content: space-between;
            }

            header img {
            max-height: 60px;
            object-fit: contain; /* Nettoyé/Conservé */
            }

            /* NETTOYAGE CSS : Conserve uniquement le style des ancres pour la surbrillance */
            nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            }

            /* Amélioration de la liste de l'entête (Desktop) */
            #entete {
                /* Classes Bootstrap gèrent déjà display:flex, justify-content, etc. */
                list-style: none;
                padding: 0;
                margin: 0;
                gap: 10px; /* Conserver le gap pour l'espacement */
            }

            #entete li a {
                display: flex; /* Assure que icône et texte sont un bloc */
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 8px 12px;
                text-decoration: none;
                color: white;
                border-radius: 8px;
                transition: background 0.3s ease;
                font-size: 0.85rem; /* Rendre le texte plus petit */
            }

            #entete li a:hover {
                background-color: rgba(255,255,255,0.2); /* Ajouté un hover propre */
                color: white;
            }

            #entete li a .fa-solid {
                font-size: 20px;
                margin-bottom: 2px;
            }

            #entete .badge {
                font-size: 12px;
                text-transform: capitalize;
                background: none; /* Rendre le badge transparent */
                color: inherit;
                padding: 0;
            }


            /* ---------------- SIDEBAR MOBILE ---------------- */
            .sidebar {
                position: fixed;
                top: 0;
                right: -260px; /* cachée */
                width: 260px;
                height: 100vh;
                background: linear-gradient(135deg, #006d77, #00afb9);
                backdrop-filter: blur(6px);
                padding-top: 80px;
                box-shadow: 4px 0 15px rgba(0,0,0,0.25);
                transition: 0.35s ease-in-out;
                display: flex;
                flex-direction: column;
                z-index: 2000;
            }

            .sidebar.open {
                right: 0;
            }

            .sidebar a {
                color: white;
                padding: 15px 20px;
                text-decoration: none;
                font-weight: 600;
                border-bottom: 1px solid rgba(255,255,255,0.25);
            }
            /* Ajout d'icônes à la sidebar */
            .sidebar a .fa-solid {
                margin-right: 10px;
            }

            .sidebar a:hover {
                background: rgba(255,255,255,0.15);
            }

            /* Bouton menu */
            .menu-btn {
                font-size: 22px;
                padding: 8px 12px;
                border-radius: 8px;
                cursor: pointer;
                color: white;
                background: rgba(255,255,255,0.15);
                display: none;
            }

            /* Mobile */
            @media screen and (max-width: 768px) {
                #entete {
                    display: none !important;
                }

                .menu-btn {
                    display: inline-block !important;
                }

                .nav-item.dropdown {
                    display: none !important; /* supprimé */
                }
            }

            /* Bouton fermer */
            .sidebar .close-btn {
                position: absolute;
                top: 15px;
                right: 15px;
                font-size: 24px;
                color: white;
                cursor: pointer;
                padding: 5px;
                background: rgba(255,255,255,0.2);
                border-radius: 50%;
                width: 34px;
                height: 34px;
                display: flex;
                justify-content: center;
                align-items: center;
                transition: 0.3s;
            }

            .sidebar .close-btn:hover {
                background: rgba(255,255,255,0.35);
            }


            /* ---------------- SECTION ACCUEIL ---------------- */
            #accueil {
            background: linear-gradient(rgba(0,91,107,0.7), rgba(0,91,107,0.5)), url('{{ asset('assets/images/bg.jpg') }}') no-repeat center center / cover;
            height: 620px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
            }

            #accueil h2 {
            font-size: clamp(2.5rem, 6vw, 5rem);
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 0.3rem;
            text-shadow: 3px 3px 10px rgba(0,0,0,0.6);
            }

            #accueil span.fs-6 {
            font-size: clamp(1rem, 2vw, 1.25rem);
            font-weight: 400;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
            }

            /* ---------------- SECTION HÉBERGEMENT ---------------- */
            #hebergement {
            padding: 3rem 1rem;
            background-color: #e0f2f1;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            margin: 3rem auto;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            #hebergement:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 32px rgba(0,0,0,0.25);
            }

            #hebergement h2 {
            font-weight: 800;
            margin-bottom: 2rem;
            text-align: center;
            font-size: 2.8rem;
            color: #008a73;
            text-transform: uppercase;
            letter-spacing: 2px;
            }

            #hebergement img {
            border-radius: 15px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.2);
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
            }

            #hebergement img:hover { transform: scale(1.05); }

            .accordion-css {
                border-radius: 12px;
                overflow: hidden;
                margin-top: 2rem;
                max-width: 600px;
            }

            .accordion-css input { display: none; }

            .accordion-css label {
                display: block;
                padding: 15px 20px;
                background: linear-gradient(135deg, #006d77, #00afb9);
                color: #fff;
                font-weight: 700;
                cursor: pointer;
                border-radius: 12px;
                margin-bottom: 5px;
                transition: background 0.3s ease;
            }

            .accordion-css label:hover {
                background: linear-gradient(135deg, #004d55, #007f7a);
            }

            .accordion-css .content {
                max-height: 0;
                overflow-y: scroll;
                background: #e0f2f1;
                transition: max-height 0.35s ease, padding 0.35s ease;
                padding: 0 20px;
            }

            .accordion-css input:checked + label + .content {
                max-height: 500px; /* ajustable selon le contenu */
                padding: 15px 20px;
            }

            /* AMÉLIORATION LISTES DE SERVICES */
            .accordion-css .services-list li {
                padding: 8px 0; /* Espacement amélioré */
                font-weight: 500;
                border-bottom: 1px dashed rgba(0,0,0,0.1);
            }
            .accordion-css .services-list li:last-child {
                border-bottom: none;
            }

            .toggle-services i {
                float: right;
                transition: transform 0.3s ease;
            }

            .accordion-css input:checked + label .toggle-services i {
                transform: rotate(180deg);
            }

            .btn-reserver {
                display: inline-block;
                padding: 12px 28px;
                font-size: 18px;
                font-weight: bold;
                color: #fff;
                background: #007bff;
                border-radius: 30px;
                text-decoration: none;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
                transition: background 0.3s ease;
                animation: bounce 2s infinite;
            }

            .btn-reserver:hover {
                background: #0056b3;
            }

            @keyframes bounce {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-10px);
                }
            }

            /* Les styles #entete ont été consolidés plus haut */


            /* ---------------- FOOTER ---------------- */
            footer {
            background: linear-gradient(135deg, #006d77, #00afb9);
            color: white;
            padding: 1.5rem;
            text-align: center;
            font-size: 0.95rem;
            letter-spacing: 1px;
            }

            /* ---------------- RESPONSIVE ---------------- */
            @media (max-width: 768px) {
            #hebergement { padding: 2rem 1rem; }
            #hebergement h2 { font-size: 2rem; }
            .accordion-button { font-size: 1rem !important; padding: 0.75rem 1rem !important; }
            .btn-reserver { font-size: 1rem; padding: 12px 28px; }
            }

            .service-item{
                margin: 0px !important;
            }

            .services-list {
                max-height: 0;
                overflow-y: scroll;
                opacity: 0;
                transition: max-height 0.4s ease, opacity 0.3s ease;
                background-color: rgb(250, 250, 250);
                border-radius: 5px;
            }

            /* ouverte */
            .service-item.open .services-list {
                max-height: 500px; /* assez large */
                opacity: 1;
            }

            /* bouton stylé */
            .type {
                font-weight: 600;
                transition: background 0.3s ease;
                cursor: pointer;
                background: none; /* Rendre le bouton plus discret */
                border: none;
                padding: 10px 0;
                width: 100%;
                text-align: left;
                color: #006d77;
            }
            .type:hover {
                background: rgba(0,0,0,0.05);
            }

            /* effet visuel quand c'est ouvert */
            .service-item.open .type {
                color: #09008d !important;
            }

            .trailer-container {
                width: 100%;
                overflow: hidden;
                background: linear-gradient(135deg, #006d77, #00afb9);
                padding: 15px 0;
                }
                .trailer-track {
                display: inline-block;
                white-space: nowrap;
                animation: scroll-left 35s linear infinite;
                font-size: 1.2rem;
                color: #fff;
                font-weight: 500;
                }

                .trailer-track span {
                margin-right: 40px;
                }

                @keyframes scroll-left {
                0% {
                    transform: translateX(100%);
                }
                100% {
                    transform: translateX(-100%);
                }

            }
            .trailer-container:hover .trailer-track {
            animation-play-state: paused;
            }


        </style>
        <header class="p-1">
            <div class="col-12 row m-0 align-items-center">
                <div class="col-lg-2 col-md-2 col-3">
                    <img class="img-fluid" src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo" />
                </div>

                <div class="col-lg-10 col-md-10 col-9 d-flex justify-content-end align-items-center position-relative">
                    <!-- Menu desktop -->
                    <ul id="entete" class="d-flex justify-content-end py-2 m-0">
                        <li><a href="{{ route('login') }}"><span class="fa-solid fa-right-to-bracket"></span><span class="badge">Connexion</span></a></li>
                        <li><a href="{{ route('register') }}"><span class="fa-solid fa-user-plus"></span><span class="badge">Inscription</span></a></li>
                        <li><a href="#hebergement"><span class="fa-solid fa-hotel"></span><span class="badge">Hébergement</span></a></li>
                        <li><a href="#location"><span class="fa-solid fa-car-side"></span><span class="badge">Véhicule</span></a></li>
                        <li><a href="#contact"><span class="fa-solid fa-phone"></span><span class="badge">Contact</span></a></li>
                    </ul>

                    <!-- Bouton menu mobile -->
                    <span class="menu-btn position-absolute end-0 me-2 py-0 px-2" onclick="toggleSidebar()">
                        <i class="fa-solid fa-bars"></i>
                    </span>

                    <!-- Sidebar -->
                    <div id="sidebar" class="sidebar">
                        <span class="close-btn" onclick="toggleSidebar()">&times;</span>
                        <a href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket"></i>Connexion</a>
                        <a href="{{ route('register') }}"><i class="fa-solid fa-user-plus"></i>Inscription</a>
                        <a href="#hebergement"><i class="fa-solid fa-hotel"></i>Hébergements</a>
                        <a href="#location"><i class="fa-solid fa-car-side"></i>Véhicules</a>
                        <a href="#contact"><i class="fa-solid fa-phone"></i>Contact</a>
                    </div>
                </div>
            </div>
        </header>

        <div class="trailer-container">
            <div class="trailer-track">
                @php
                    $iconeColors = [
                        'fa-bell' => 'orange',
                        'fa-home' => 'blue',
                        'fa-exclamation' => 'red',
                        'fa-check' => 'green',
                        'fa-star' => 'gold',
                        'fa-info' => 'skyblue',
                        'fa-heart' => 'red',
                        'fa-smile' => 'yellowgreen',
                        'fa-fire' => 'orangered',
                        'fa-envelope' => 'purple',
                        'fa fa-star' => 'yellow',
                        // ajoute ici toutes les icônes de ton select
                    ];
                @endphp

                @if($publicites->isEmpty())
                    <div class="alert alert-info d-flex align-items-center gap-2 m-0 py-0 px-2">
                        <i class="fas fa-info-circle"></i>
                        <span class="m-0 p-0">
                             Pour toutes vos affiches et annonces publicitaires,
                             contactez-nous au +225  0103090616 / +225 0789363442 / +225 0594480796
                        </span>
                        <a href="mailto:afrikhub1@gmail.com" class="ms-2 text-decoration-underline">
                            cliquez ici pour laisser un mail
                        </a>
                    </div>
                @else
                    @foreach($publicites as $pub)
                        @php
                            $color = $iconeColors[$pub->icone] ?? 'red';
                        @endphp
                        <span class="ms-5 my-0 p-0">
                            <i class="fas {{ $pub->icone }}" style="color: {{ $color }};"></i>
                        </span>
                        <span class="m-0 p-0">{{ $pub->titre }} -</span>
                        <span class="m-0 p-0">
                            <a href="{{ $pub->lien }}" class="text-light fw-lighter">{{ $pub->lien }}</a>
                        </span>
                    @endforeach
                @endif
            </div>
        </div>



        <nav class="row col-12 justify-content-center m-0">
            <section id="accueil" class="text-center py-1 row m-0 justify-content-center align-items-center ">

                <div class="col-10 col-md-6 col-lg-6 m-0">
                    @include('includes.messages')
                    <h2>Bienvenue</h2>
                    <span class="fs-6">Explorez l'Afrique autrement avec Afrik’Hub</span><br><br>
                    <a href="{{ route('recherche') }}" class="btn-reserver me-2">Réserver</a>
                    <a href="{{ route('mise_en_ligne') }}" class="btn-reserver">Ajouter un bien</a>
                </div>

                <div id="carouselExample" class="carousel slide col-10 col-md-6 col-lg-6 m-0" data-bs-ride="carousel">
                    {{-- Indicateurs --}}
                    <div class="carousel-indicators">
                        @foreach($carousels as $key => $carousel)
                            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="{{ $key }}"
                                    class="{{ $key == 0 ? 'active' : '' }}" aria-current="{{ $key == 0 ? 'true' : 'false' }}"
                                    aria-label="Slide {{ $key + 1 }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner rounded" style="max-height: 400px; height: 400px;">
                        @forelse($carousels as $key => $carousel)
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }} p-0" style="max-height: 400px; height: 400px;">
                                <div>
                                    @if($carousel->lien)
                                        {{-- On vérifie si le lien commence par http, sinon on peut l'ajouter ou s'assurer que la donnée en BD est propre --}}
                                        <a href="{{ str_starts_with($carousel->lien, 'http') ? $carousel->lien : 'https://' . $carousel->lien }}" target="_blank">
                                    @endif

                                    <img src="{{ $carousel->image_url }}" class="d-block w-100" alt="Publicité"
                                        style="object-fit: cover;">
                                    @if($carousel->lien)
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="carousel-item active">
                                <img src="{{ asset('assets/images/flyer.jpeg') }}" class="d-block w-100" alt="Bienvenue"
                                    style="height: 400px; object-fit: cover;">
                                <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
                                    <h5>Bienvenue sur Afrikhub</h5>
                                    <p>Découvrez nos services d'hébergement.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    {{-- Boutons précédent / suivant --}}
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Précédent</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Suivant</span>
                    </button>
                </div>

            </section>
            <section id="hebergement" class="my-2 px-0 py-6">
                <h2 class="text-3xl font-extrabold text-center text-teal-800 uppercase mb-8">Hébergements</h2>

                <div class="accordion-css mx-auto max-w-2xl">
                    <input type="checkbox" id="acc1">
                    <label for="acc1">
                        Types d'hébergements
                        <span class="toggle-services"><i class="fa-solid fa-chevron-down"></i></span>
                    </label>
                    <div class="content my-2">
                        <div class="space-y-4">
                            <div class="service-item p-0">
                                <button class="type">Studio</button>
                                <ul class="services-list mt-2 p-2 list-none space-y-2">
                                    <li class="flex items-center"><i class="fa-solid fa-wifi text-primary me-2"></i>WiFi gratuit</li>
                                    <li class="flex items-center"><i class="fa-solid fa-fan text-info me-2"></i>Ventilateur</li>
                                    <li class="flex items-center"><i class="fa-solid fa-video text-danger me-2"></i>Caméra de surveillance</li>
                                </ul>
                            </div>

                            <div class="service-item p-0">
                                <button class="type"><i class="fa-solid fa-bed me-2"></i>Chambre unique</button>
                                <ul class="services-list mt-2 p-2 list-none space-y-2">
                                    <li class="flex items-center"><i class="fa-solid fa-wifi text-primary me-2"></i>WiFi gratuit</li>
                                    <li class="flex items-center"><i class="fa-solid fa-snowflake text-info me-2"></i>Climatisation</li>
                                    <li class="flex items-center"><i class="fa-solid fa-mug-hot text-warning me-2"></i>Petit déjeuner inclus</li>
                                </ul>
                            </div>

                            <div class="service-item p-0">
                                <button class="type"><i class="fa-solid fa-couch me-2"></i>Chambre salon</button>
                                <ul class="services-list mt-2 p-2 list-none space-y-2">
                                    <li class="flex items-center"><i class="fa-solid fa-wifi text-primary me-2"></i>WiFi gratuit</li>
                                    <li class="flex items-center"><i class="fa-solid fa-snowflake text-info me-2"></i>Climatisation</li>
                                    <li class="flex items-center"><i class="fa-solid fa-mug-hot text-warning me-2"></i>Petit déjeuner inclus</li>
                                </ul>
                            </div>

                            <div class="service-item p-0">
                                <button class="type"><i class="fa-solid fa-house-chimney me-2"></i>Trois pièces et plus</button>
                                <ul class="services-list mt-2 p-2 list-none space-y-2">
                                    <li class="flex items-center"><i class="fa-solid fa-wifi text-primary me-2"></i>WiFi gratuit</li>
                                    <li class="flex items-center"><i class="fa-solid fa-snowflake text-info me-2"></i>Climatisation</li>
                                    <li class="flex items-center"><i class="fa-solid fa-mug-hot text-warning me-2"></i>Petit déjeuner inclus</li>
                                </ul>
                            </div>

                            <div class="service-item p-0">
                                <button class="type"><i class="fa-solid fa-house-water me-2"></i>Villa avec piscine</button>
                                <ul class="services-list mt-2 p-2 list-none space-y-2">
                                    <li class="flex items-center"><i class="fa-solid fa-wifi text-primary me-2"></i>WiFi gratuit</li>
                                    <li class="flex items-center"><i class="fa-solid fa-water-ladder text-info me-2"></i>Piscine privée</li>
                                    <li class="flex items-center"><i class="fa-solid fa-snowflake text-info me-2"></i>Climatisation</li>
                                    <li class="flex items-center"><i class="fa-solid fa-square-parking text-warning me-2"></i>Parking gratuit</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <input type="checkbox" id="acc2">
                    <label for="acc2">
                        Conditions de réservation
                        <span class="toggle-services"><i class="fa-solid fa-chevron-down"></i></span>
                    </label>
                    <div class="content">
                        <ul class="list-none space-y-2 p-2">
                            <li class="flex items-center"><i class="fa-solid fa-calendar-check text-primary me-2"></i>Réservation préalable requise</li>
                            <li class="flex items-center"><i class="fa-solid fa-hand-holding-dollar text-success me-2"></i>Acompte de 20% pour confirmation</li>
                            <li class="flex items-center"><i class="fa-solid fa-ban text-danger me-2"></i>Annulation gratuite jusqu'à 48h avant l'arrivée</li>
                        </ul>
                    </div>
                </div>

                <!-- Résidences -->
                <div class="mt-8 bg-light rounded p-2">
                    @if ($residences->isEmpty())
                        <div class="text-center bg-yellow-100 text-yellow-800 font-bold rounded-xl p-6 shadow">
                            <i class="fa-solid fa-triangle-exclamation mr-2"></i>Aucune résidence trouvée pour cette recherche.
                        </div>
                    @else
                        <div class="row m-0 p-0 justify-content-start">
                            <!-- RECHERCHE -->
                            <div class="col-8 col-md-6 col-lg-4">
                                <input id="searchInput" type="text"
                                    placeholder="Rechercher par nom ou status..."
                                    class="w-full py-2 pl-10 pr-4 bg-gray-800 text-white rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <!-- OPTION -->
                             <div class="col-4 col-md-3 col-lg-2">
                                <select id="searchOption" class="py-2 px-3 bg-gray-800 text-white rounded-lg">
                                    <option value="name">Nom</option>
                                    <option value="ville">Ville</option>
                                    <option value="prix_journalier">prix</option>
                                    <option value="salon">salon</option>
                                    <option value="chambre">chambre</option>
                                </select>
                             </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mt-4">
                            @foreach($residences as $residence)
                                @php
                                    $images = $residence->img;
                                    if (is_string($images)) $images = json_decode($images, true) ?? [];
                                    $firstImage = $images[0] ?? null;
                                    $imagePath = $firstImage ?: 'https://placehold.co/400x250/E0E7FF/4F46E5?text=Pas+d\'image';
                                @endphp

                                <div class="search-row bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-indigo-300/50 transition transform hover:scale-[1.01]"
                                    data-name="{{ $residence->nom }}" data-prix_journalier="{{ $residence->prix_journalier }}"
                                    data-ville="{{ $residence->ville }}" data-nombre_chambres="{{ $residence->nombre_chambres }}"
                                    data-nombre_salons="{{ $residence->nombre_salons }}">

                                    <a href="{{ $imagePath }}"
                                        class="glightbox block relative"
                                        data-gallery="residence-{{ $residence->id }}"
                                        data-title="{{ $residence->nom }}">

                                            <!-- Conteneur qui fixe la hauteur -->
                                            <div class="w-full h-[200px] overflow-hidden rounded-xl p-2">
                                                <img src="{{ $imagePath }}"
                                                    class="transition duration-300 hover:opacity-90"
                                                    alt="Image de la résidence" style="min-heigth:200px;">
                                            </div>
                                        </a>

                                    @if(is_array($images))
                                        @foreach($images as $key => $image)
                                            @if($key > 0)
                                                <a href="{{ $image }}" class="glightbox" data-gallery="residence-{{ $residence->id }}" data-title="{{ $residence->nom }}" style="display:none;"></a>
                                            @endif
                                        @endforeach
                                    @endif

                                    <div class="p-6 flex flex-col flex-grow border-t border-gray-200">
                                        <h5 class="font-extrabold text-indigo-800 mb-2 border-b border-gray-100 pb-2 truncate">{{ $residence->nom }} - {{ $residence->id }}</h5>
                                        <ul class="space-y-2 text-gray-700 flex-grow">
                                            <li class="flex justify-between items-center">
                                                <span class="text-gray-500"><i class="fas fa-tag mr-2 text-green-500"></i>Prix / Jour :</span>
                                                <span class="text-green-600 font-extrabold">{{ number_format($residence->prix_journalier, 0, ',', ' ') }} FCFA</span>
                                            </li>
                                            <li class="flex justify-between items-center">
                                                <span class="text-gray-500"><i class="fas fa-map-marker-alt mr-2 text-indigo-400"></i>Ville :</span>
                                                <span class="text-gray-900">{{ $residence->ville }} ({{ $residence->pays }})</span>
                                            </li>
                                            <li class="flex justify-between items-center">
                                                <span class="text-gray-500"><i class="fas fa-user-tie mr-2 text-indigo-400"></i>Nombre de chambres :</span>
                                                <span class="text-gray-900 font-bold">{{ $residence->nombre_chambres ?? 'N/A' }}</span>
                                            </li>
                                            <li class="flex justify-between items-center">
                                                <span class="text-gray-500"><i class="fas fa-user-tie mr-2 text-indigo-400"></i>Nombre de salons :</span>
                                                <span class="text-gray-900 font-bold">{{ $residence->nombre_salons ?? 'N/A' }}</span>
                                            </li>
                                            <li class="flex justify-between items-center">
                                                <span class="text-gray-500"><i class="fas fa-city mr-2 text-indigo-400"></i>Disponibilité :</span>
                                                @if($residence->disponible == 0)
                                                    <span class="text-gray-900">Indisponible</span>
                                                @else
                                                    <span class="text-green-600 font-semibold"> {{ $residence->date_disponible }}</span>
                                                @endif
                                            </li>
                                        </ul>

                                        <div class="mt-4 border-t pt-4">
                                            <a href="{{ route('details', $residence->id) }}" class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
                                                <i class="fas fa-edit mr-1"></i> Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </section>
        </nav>

        <div class="row m-0">

        </div>


        <footer>
            <div class="max-w-7xl mx-auto px-4 py-8">

                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 border-b border-gray-700 pb-6 mb-0">
                    {{-- Colonne 1 : Logo / Slogan (Ajouté) --}}
                    <div class="col-span-2 md:col-span-1">
                        <h3 class="text-xl font-bold text-indigo-400">Afrikhub</h3>
                        <p class="text-sm text-white-400 mt-2">Votre Hub de Résidences en Afrique.</p>

                        {{-- Réseaux Sociaux (Ajouté) --}}
                        <div class="flex space-x-4 mt-4">
                            <a href="https://www.facebook.com/share/1KgiASzTSe/" class="text-white-400 hover:text-indigo-400 transition" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-white-400 hover:text-indigo-400 transition" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-white-400 hover:text-indigo-400 transition" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-white-400 hover:text-indigo-400 transition" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="{{ route('newsletters.create') }}" class="text-white-400 hover:text-indigo-400 transition" aria-label="Email"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>

                    {{-- Colonne 2 : Liens Rapides (Exemple) --}}
                    <div class="col-span-1">
                        <h4 class="text-lg font-semibold mb-3 text-indigo-300">Navigation</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('accueil') }}" class="text-white-400 hover:text-white transition">Accueil</a></li>
                            <li><a href="{{ route('recherche') }}" class="text-white-400 hover:text-white transition">Rechercher</a></li>
                            <li><a href="{{ route('clients_historique') }}" class="text-white-400 hover:text-white transition">Mes Réservations</a></li>
                        </ul>
                    </div>

                    {{-- Colonne 3 : Support & Aide --}}
                    <div class="col-span-1">
                        <h4 class="text-lg font-semibold mb-3 text-indigo-300">Aide</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('faq') }}" class="text-white-400 hover:text-white transition">FAQ</a></li>
                            <li><a href="https://wa.me/2250769480232" class="text-white-400 hover:text-white transition">Support Technique</a></li>
                            <li><a href="https://wa.me/2250769480232" class="text-white-400 hover:text-white transition">Déposer une annonce</a></li>
                        </ul>
                    </div>

                    {{-- Colonne 4 : Légal --}}
                    <div class="col-span-1">
                        <h4 class="text-lg font-semibold mb-3 text-indigo-300">Légal</h4>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('mentions_legales')}}" class="text-white-400 hover:text-white transition">Mentions Légales</a></li>
                            <li><a href="{{ route('politique_confidentialite') }}" class="text-white-400 hover:text-white transition">Politique de Confidentialité</a></li>
                            <li><a href="{{ route('conditions_generales') }}" class="text-white-400 hover:text-white transition">Conditions Générales</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Barre d'Information Basse --}}
                <div class="flex flex-col md:flex-row justify-between items-center text-white-500 pt-2">
                    <p class="text-sm order-2 md:order-1 mt-3 md:mt-0">
                        &copy; {{ date('Y') }} Afrikhub. Tous droits réservés.
                    </p>
                    <p class="text-sm order-1 md:order-2">
                        <i class="fas fa-map-marker-alt mr-2 text-indigo-500"></i> Basé en Afrique de l'Ouest
                    </p>
                </div>
            </div>
        </footer>
        <script>
            function toggleSidebar() {
                document.getElementById("sidebar").classList.toggle("open");
            }
        </script>

        <script>
            document.querySelectorAll('.service-item .type').forEach(btn => {
                btn.addEventListener('click', () => {
                    const item = btn.closest('.service-item');
                    item.classList.toggle('open');
                });
            });

        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
        {{-- Ajout de la librairie GLightbox pour que l'ouverture des images fonctionne --}}
           {{-- GLightbox pour que l'ouverture des images fonctionne --}}
        <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
            const lightbox = GLightbox({ selector: '.glightbox', touchNavigation: true, loop: true, autoplayVideos: true }); });
        </script>


        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const searchInput = document.getElementById("searchInput");
                const searchOption = document.getElementById("searchOption");
                const rows = document.querySelectorAll(".search-row");

                // Fonction pour normaliser texte (minuscules + accents)
                function normalizeText(text) {
                    return text
                        .toLowerCase()
                        .normalize("NFD")
                        .replace(/[\u0300-\u036f]/g, "");
                }

                searchInput.addEventListener("keyup", () => {
                    const query = normalizeText(searchInput.value.trim());
                    const option = searchOption.value;

                    rows.forEach(row => {
                        let value = "";

                        switch(option) {
                            case "name":
                                value = normalizeText(row.dataset.name || "");
                                break;

                            case "status":
                                value = normalizeText(row.dataset.status || "");
                                break;

                            case "ville":
                                value = normalizeText(row.dataset.ville || "");
                                break;

                            case "prix_journalier": // 🔥 correction pour trier par prix
                                value = Number(row.dataset.prix_journalier || 0);
                                break;

                            case "salon": // 🔥 correction pour trier par salons
                                value = Number(row.dataset.nombre_salons || 0);
                                break;

                            case "chambre": // 🔥 correction pour trier par chambres
                                value = Number(row.dataset.nombre_chambres || 0);
                                break;

                            default:
                                value = "";
                        }

                        // 🔥 Recherche numérique → convertir query aussi
                        if(option === "prix" || option === "salon" || option === "chambre") {
                            const numQuery = Number(query);
                            if(!isNaN(numQuery) && value === numQuery) {
                                row.style.display = "";
                            } else {
                                row.style.display = "none";
                            }
                        } else {
                            // Recherche textuelle
                            if(normalizeText(value.toString()).includes(query)) {
                                row.style.display = "";
                            } else {
                                row.style.display = "none";
                            }
                        }
                    });
                });
            });
        </script>

    </body>
</html>
