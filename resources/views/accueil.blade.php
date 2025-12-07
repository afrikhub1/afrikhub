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
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
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
            height: 700px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 1rem;
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
            background: #e0f2f1;
            color: #004d40;
            border-radius: 20px;
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
            color: #006d77;
            text-transform: uppercase;
            letter-spacing: 2px;
            }

            #hebergement img {
            border-radius: 15px;
            box-shadow: 0 8px 18px rgba(0,0,0,0.2);
            width: 100%;
            height: auto;
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
                overflow: hidden;
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

            .services-list {
                max-height: 0;
                overflow: hidden;
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
                    <span class="menu-btn position-absolute end-0 me-2" onclick="toggleSidebar()">
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

        <nav class="row col-12 justify-content-center m-0">

            <section id="accueil" class="text-center py-5">
                <div>
                    @include('includes.messages')
                    <h2>Bienvenue</h2>
                    <span class="fs-6">Explorez l'Afrique autrement avec Afrik’Hub</span><br><br>
                    <a href="{{ route('recherche') }}" class="btn-reserver me-2">Réserver</a>
                    <a href="{{ route('mise_en_ligne') }}" class="btn-reserver">Ajouter un bien</a>
                </div>
                </section>
                <section id="hebergement" class="my-2 col-12 row m-0 justify-content-center">
                <h2>Hébergements</h2>
                <div class="mb-4 d-flex flex-wrap gap-2">

                    <button class="btn btn-outline-primary" onclick="filtreStudio()">Appartement Studio</button>

                    <button class="btn btn-outline-primary" onclick="filtreChambreSalon()">Chambre + Salon</button>

                    <div class="dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown">
                            Avec 1 Salon
                        </button>
                        <ul class="dropdown-menu">
                            @for ($i=1;$i<=10;$i++)
                                <li>
                                    <button type="button" class="dropdown-item"
                                        onclick="filtreSalonEtChambres(1, {{ $i }})">
                                        {{ $i }} chambre(s)
                                    </button>
                                </li>
                            @endfor
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown">
                            Avec 2 Salons
                        </button>
                        <ul class="dropdown-menu">
                            @for ($i=1;$i<=10;$i++)
                                <li>
                                    <button type="button" class="dropdown-item"
                                        onclick="filtreSalonEtChambres(2, {{ $i }})">
                                        {{ $i }} chambre(s)
                                    </button>
                                </li>
                            @endfor
                        </ul>
                    </div>

                    <button class="btn btn-secondary" onclick="resetFiltre()">Réinitialiser</button>

                </div>

                <div class="row m-0 col-12 justify-content-center">
                    <div class="accordion-css">
                        <input type="checkbox" id="acc1" checked>
                        <label for="acc1">
                            Types d'hébergements
                            <span class="toggle-services"><i class="fa-solid fa-chevron-down"></i></span>
                        </label>
                        <div class="content my-2">

                            <div class="service-item p-0 mb-1">
                                <button class="type">Studio</button>
                                <ul class="services-list mt-2 p-2 list-unstyled">
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-wifi text-primary me-2"></i>
                                        <span>WiFi gratuit</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-fan text-info me-2"></i>
                                        <span>Ventilateur</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-video text-danger me-2"></i>
                                        <span>Caméra de surveillance</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="service-item p-0 mb-1">
                                <button class="type">
                                    <i class="fa-solid fa-bed me-2"></i> Chambre unique
                                </button>
                                <ul class="services-list mt-2 p-2 list-unstyled">
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-wifi text-primary me-2"></i>
                                        <span>WiFi gratuit</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-snowflake text-info me-2"></i>
                                        <span>Climatisation</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-mug-hot text-warning me-2"></i>
                                        <span>Petit déjeuner inclus</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="service-item p-0 mb-1">
                                <button class="type">
                                    <i class="fa-solid fa-couch me-2"></i> Chambre salon
                                </button>
                                <ul class="services-list mt-2 p-2 list-unstyled">
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-wifi text-primary me-2"></i>
                                        <span>WiFi gratuit</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-snowflake text-info me-2"></i>
                                        <span>Climatisation</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-mug-hot text-warning me-2"></i>
                                        <span>Petit déjeuner inclus</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="service-item p-0 mb-1">
                                <button class="type">
                                    <i class="fa-solid fa-house-chimney me-2"></i> Trois pièces et plus
                                </button>
                                <ul class="services-list mt-2 p-2 list-unstyled">
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-wifi text-primary me-2"></i>
                                        <span>WiFi gratuit</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-snowflake text-info me-2"></i>
                                        <span>Climatisation</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-mug-hot text-warning me-2"></i>
                                        <span>Petit déjeuner inclus</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="service-item p-0 mb-1">
                                <button class="type">
                                    <i class="fa-solid fa-house-water me-2"></i> Villa avec piscine
                                </button>
                                <ul class="services-list mt-2 p-2 list-unstyled">
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-wifi text-primary me-2"></i>
                                        <span>WiFi gratuit</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-water-ladder text-info me-2"></i>
                                        <span>Piscine privée</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-snowflake text-info me-2"></i>
                                        <span>Climatisation</span>
                                    </li>
                                    <li class="d-flex align-items-center">
                                        <i class="fa-solid fa-square-parking text-warning me-2"></i>
                                        <span>Parking gratuit</span>
                                    </li>
                                </ul>
                            </div>

                        </div>

                        <input type="checkbox" id="acc2">
                        <label for="acc2">
                            Conditions de réservation
                            <span class="toggle-services"><i class="fa-solid fa-chevron-down"></i></span>
                        </label>
                        <div class="content">
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fa-solid fa-calendar-check text-primary me-2"></i>
                                    <span>Réservation préalable requise</span>
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fa-solid fa-hand-holding-dollar text-success me-2"></i>
                                    <span>Acompte de 20% pour confirmation</span>
                                </li>
                                <li class="d-flex align-items-center mb-2">
                                    <i class="fa-solid fa-ban text-danger me-2"></i>
                                    <span>Annulation gratuite jusqu'à 48h avant l'arrivée</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </nav>

        <div class="row m-0">
            <div class="col-12 main-content">
                @if ($residences->isEmpty())
                    <div class="alert alert-warning text-center fw-bold rounded-3 p-4">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i> Désolé, aucune résidence trouvée pour cette recherche.
                    </div>
                @else
                    <div class="row g-4 justify-content-center mb-4">
                        @foreach($residences as $residence)
                            @php
                                $images = is_string($residence->img) ? json_decode($residence->img, true) : ($residence->img ?? []);
                                // Fallback pour la première image
                                $firstImage = $images[0] ?? asset('assets/images/placeholder.jpg');
                            @endphp

                           <div class="col-sm-6 col-md-4 col-lg-3 d-flex residence-card"
                                data-chambres="{{ $residence->nombre_chambres ?? 0 }}"
                                data-salons="{{ $residence->nombre_salons ?? 0 }}"
                            >

                                <div class="card shadow h-100 border-0 rounded-4 overflow-hidden w-100">
                                    <a href="{{ $firstImage }}" class="glightbox" data-gallery="gallery-{{ $residence->id }}">
                                        <img src="{{ $firstImage }}"
                                            alt="Image de la résidence {{ $residence->nom }}"
                                            class="card-img-top"
                                            loading="lazy">
                                    </a>

                                    {{-- Liens supplémentaires pour la galerie (cachés) --}}
                                    @foreach($images as $key => $image)
                                        @if($key > 0)
                                            <a href="{{ $image }}" class="glightbox" data-gallery="gallery-{{ $residence->id }}" style="display:none;"></a>
                                        @endif
                                    @endforeach

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title fw-bold text-dark">{{ $residence->nom }}</h5>
                                        <p class="card-text text-muted card-text-truncate" title="{{ $residence->description }}">
                                            {{ Str::limit($residence->description, 100) }}
                                        </p>
                                        <ul class="list-unstyled small mb-3 mt-2">
                                            <li><i class="fa-solid fa-bed me-2 text-primary"></i> <strong>Chambres :</strong> {{ $residence->nombre_chambres ?? '-' }}</li>
                                            {{-- L'élément suivant était un <li> mal formé, corrigé en <li> --}}
                                            <li><i class="fa-solid fa-couch me-2 text-primary"></i> <strong>Salon :</strong> {{ $residence->nombre_salons ?? '-' }}</li>
                                            <li><i class="fa-solid fa-location-dot me-2 text-primary"></i> <strong>Situation :</strong> {{ $residence->pays ?? '-' }}/{{ $residence->ville ?? '-' }}</li>
                                            <li class="fw-bold mt-2">
                                                <i class="fa-solid fa-money-bill-wave me-2 text-success"></i>
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

                                        <a href="{{ route('details', $residence->id) }}" class="btn btn-dark rounded mt-auto">
                                            Voir les Détails <i class="fa-solid fa-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>


        <footer>
            <p id="contact">&copy; 2025 afrik’hub. tous droits réservés.<br />afrikhub@gmail.com</p>
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

        {{-- GLightbox pour que l'ouverture des images fonctionne --}}
        <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
            const lightbox = GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
                autoplayVideos: true
            });
        });

        </script>

        <script>
            // --- Filtrage des résidences ---
            document.addEventListener('DOMContentLoaded', () => {
                const residences = document.querySelectorAll('.residence-card');

                function filtreSalonEtChambres(nbSalons, nbChambres) {
                    residences.forEach(card => {
                        const salons = parseInt(card.dataset.salons) || 0;
                        const chambres = parseInt(card.dataset.chambres) || 0;
                        card.style.display = (salons === nbSalons && chambres === nbChambres) ? 'block' : 'none';
                    });
                }

                function filtreChambreSalon() {
                    residences.forEach(card => {
                        const salons = parseInt(card.dataset.salons) || 0;
                        const chambres = parseInt(card.dataset.chambres) || 0;
                        card.style.display = (salons >= 1 && chambres >= 1) ? 'block' : 'none';
                    });
                }

                function filtreStudio() {
                    residences.forEach(card => {
                        const salons = parseInt(card.dataset.salons) || 0;
                        const chambres = parseInt(card.dataset.chambres) || 0;
                        card.style.display = (salons === 0 && chambres === 1) ? 'block' : 'none';
                    });
                }

                function resetFiltre() {
                    residences.forEach(card => card.style.display = 'block');
                }

                // Rendre les fonctions accessibles globalement pour les boutons HTML
                window.filtreSalonEtChambres = filtreSalonEtChambres;
                window.filtreChambreSalon = filtreChambreSalon;
                window.filtreStudio = filtreStudio;
                window.resetFiltre = resetFiltre;

                // --- Debug : affichage dataset ---
                residences.forEach(card => {
                    console.log("Card:", card, "Salons:", card.dataset.salons, "Chambres:", card.dataset.chambres);
                });
            });
        </script>
    </body>
</html>
