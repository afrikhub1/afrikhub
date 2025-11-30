<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

        <title> {{ config('app.name')}}-accueil</title>
    </head>
    <body>

        <style>
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
            }

            nav ul {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            padding: 0;
            margin: 0;
            align-items: center;
            }

            nav ul li a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            transition: all 0.3s ease;
            font-weight: 600;
            text-align: center;
            }

            nav ul li a::after {
            content: '';
            display: block;
            height: 2px;
            background: #ffddd2;
            width: 0;
            transition: width 0.3s;
            position: absolute;
            bottom: 0;
            left: 0;
            }

            nav ul li a:hover::after {
            width: 100%;
            }

            nav ul li a.bg-danger { background-color: #dc3545; }
            nav ul li a.bg-dark { background-color: #343a40; }

            nav ul li a:hover {
            background-color: rgba(255,255,255,0.2);
            color: #fff;
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
            @media screen and (max-width: 978px) {
                #entete {
                    display: none;
                }

                .menu-btn {
                    display: inline-block;
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

            .accordion-css .services-list li {
                padding: 6px 0;
                font-weight: 600;
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

            header img {
                max-height: 60px;
                object-fit: contain;
            }

                #entete li {
                    list-style: none;
                    display: inline-block;
                    margin: 0 10px;
                }

            #entete li a {
                display: flex;
                flex-direction: column;
                align-items: center;
                font-size: 14px;
                font-weight: 600;
                text-decoration: none;
                padding: 8px 12px;
                border-radius: 8px;
                transition: all 0.3s ease;
            }

            #entete li a .fa {
                font-size: 20px;
            }

            #entete li a:hover {
                color: black;
            }

            #entete .badge {
                font-size: 12px;
                margin-top: 3px;
                text-transform: capitalize;
            }

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
                display: none;
            }

            .type:hover + .services-list {
                display: inline-block;
            }



        </style>
        <!-- HEADER -->
        <header class="p-1">
        <div class="col-12 row m-0 align-items-center">
            <div class="col-lg-2 col-md-2 col-3">
            <img class="img-fluid" src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo" />
            </div>
            <nav class="col-lg-10 col-md-10 col-9">
            <ul class="d-flex justify-content-end py-2">
                <ul id="entete">
                <li><a href="{{ route('login') }}" class="bg-dark" aria-label="connexion"><span class="fa fa-right-to-bracket"></span><span class="badge">connexion</span></a></li>
                <li><a href="{{ route('register') }}" class="bg-dark" aria-label="inscription"><span class="fa fa-user-plus"></span><span class="badge">inscription</span></a></li>
                <li><a href="#hebergement"><span class="fa fa-home"></span><span class="badge">herbergement</span></a></li>
                <li><a href="#location"><span class="fa fa-car"></span><span class="badge">vehicule</span></a></li>
                <li><a href="#contact"><span class="fa fa-phone"></span><span class="badge">contact</span></a></li>
                </ul>

                <span class="menu-btn" onclick="toggleSidebar()"><i class="fa fa-bars"></i></span>

                <div id="sidebar" class="sidebar">

                    <span class="close-btn" onclick="toggleSidebar()">&times;</span>

                    <a href="{{ route('login') }}"><span class="fa fa-right-to-bracket"></span><span class="badge">connexion</span></a>
                    <a href="{{ route('register') }}"><span class="fa fa-user-plus"></span><span class="badge">inscription</span></a>
                    <a href="#hebergement"><span class="fa fa-home"></span><span class="badge">Hébergements</span></a>
                    <a href="#location"><span class="fa fa-car"></span><span class="badge">éhicules</span></a>
                    <a href="#contact"><span class="fa fa-phone"></span><span class="badge">Contact</span></a>
                </div>
            </ul>
            </nav>
        </div>
        </header>
        <nav class="row col-12 justify-content-center">

                <!-- Section accueil -->
            <section id="accueil" class="text-center py-5">
            <div>
                @include('includes.messages')
                <h2>Bienvenue</h2>
                <span class="fs-6">Explorez l'Afrique autrement avec Afrik’Hub</span><br><br>
                <a href="{{ route('recherche') }}" class="btn-reserver me-2">Réserver</a>
                <a href="{{ route('mise_en_ligne') }}" class="btn-reserver">Ajouter un bien</a>
            </div>
            </section>
            <!-- Section hébergement -->
            <section id="hebergement" class="my-2 col-12 row m-0 justify-content-center">
            <h2>hébergements</h2>
            <div class="row m-0 col-12 justify-content-center">
                    <div class="row g-4 align-items-center col-12 col-md-8 col-lg-6 mx-4">
                        <img class="w-20 md:w-28 lg:w-32 h-auto" src="{{ asset('assets/images/hebergement.jpg') }}" alt="Afrik'Hub Logo"/>
                    </div>
                </div>
                <div class="row m-0 col-12 justify-content-center">
                    <div class="accordion-css">
                        <!-- Premier item -->
                        <input type="checkbox" id="acc1" checked>
                        <label for="acc1">
                            Types d'hébergements
                            <span class="toggle-services"><i class="fa fa-chevron-down"></i></span>
                        </label>
                        <div class="content">
                            <div class="service-item border">
                                <button class="type btn btn-ouline-success">Studio</button>
                                <ul class="services-list border">
                                    <li>wifi gratuit</li>
                                    <li>ventilateur</li>
                                    <li>caméra de surveillance</li>
                                </ul>
                            </div>
                            <div class="service-item border">
                                <button class="type btn btn-ouline-success">Chambre unique</button>
                                <ul class="services-list border">
                                    <li>wifi gratuit</li>
                                    <li>climatisation</li>
                                    <li>petit déjeuner inclus</li>
                                </ul>
                            </div>
                            <div class="service-item border">
                                <button class="type btn btn-ouline-success">Villa avec piscine</button>
                                <ul class="services-list border">
                                    <li>wifi gratuit</li>
                                    <li>piscine privée</li>
                                    <li>climatisation</li>
                                    <li>parking gratuit</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Deuxième item -->
                        <input type="checkbox" id="acc2">
                        <label for="acc2">
                            Conditions de réservation
                            <span class="toggle-services"><i class="fa fa-chevron-down"></i></span>
                        </label>
                        <div class="content">
                            <ul>
                                <li>réservation préalable requise</li>
                                <li>acompte de 20% pour confirmation</li>
                                <li>annulation gratuite jusqu'à 48h avant l'arrivée</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </nav>

        <div class="row">
            <div class="col-12 main-content">
                @if ($residences->isEmpty())
                    <div class="alert alert-warning text-center fw-bold rounded-3 p-4">
                        <i class="fas fa-exclamation-triangle me-2"></i> Désolé, aucune résidence trouvée pour cette recherche.
                    </div>
                @else
                    <div class="row g-4 justify-content-center mb-4">
                        @foreach($residences as $residence)
                            @php
                                $images = is_string($residence->img) ? json_decode($residence->img, true) : ($residence->img ?? []);
                                // Fallback pour la première image
                                $firstImage = $images[0] ?? asset('assets/images/placeholder.jpg');
                            @endphp

                            <div class="col-sm-6 col-md-4 col-lg-3 d-flex">
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
                                            <i class="fas fa-bed me-2 text-primary"></i> <strong>Salon :</strong> {{ $residence->nombre_salons ?? '-' }}</li>
                                            <li><i class="fas fa-map-marker-alt me-2 text-primary"></i> <strong>Situation :</strong> {{ $residence->pays ?? '-' }}/{{ $residence->ville ?? '-' }}</li>
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

                                        <a href="{{ route('details', $residence->id) }}" class="btn btn-dark rounded mt-auto">
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


        <footer>
            <p id="contact">&copy; 2025 afrik’hub. tous droits réservés.<br />afrikhub@gmail.com</p>
        </footer>
        <script>
            function toggleSidebar() {
                document.getElementById("sidebar").classList.toggle("open");
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

    </body>
</html>
