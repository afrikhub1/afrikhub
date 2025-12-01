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

    <title>{{ config('app.name') }}-accueil</title>

    <style>
        /* ------------------------------ EXISTANT ------------------------------ */
        /* ... tout ton CSS existant ... */

        /* ------------------------------ MODIFICATION POUR LISTES HORIZONTALES ------------------------------ */
        .services-list {
            display: flex;
            flex-wrap: wrap;
            gap: 15px; /* espace entre les items */
            padding: 0; /* supprime le padding par défaut de la liste */
            margin: 0;  /* supprime la marge par défaut */
        }

        .services-list li {
            display: flex;
            align-items: center;
            padding: 6px 10px;
            background: #f5f5f5;
            border-radius: 8px;
            list-style: none; /* supprime les puces si présentes */
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <header class="p-1">
        <div class="col-12 row m-0 align-items-center">
            <div class="col-lg-2 col-md-2 col-3">
                <img class="img-fluid" src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo" />
            </div>
            <nav class="col-lg-10 col-md-10 col-9">
                <ul class="d-flex justify-content-end py-2">
                    <ul id="entete">
                        <li><a href="{{ route('login') }}" class="bg-dark" aria-label="connexion"><span class="fa fa-right-to-bracket"></span><span class="badge">Connexion</span></a></li>
                        <li><a href="{{ route('register') }}" class="bg-dark" aria-label="inscription"><span class="fa fa-user-plus"></span><span class="badge">Inscription</span></a></li>
                        <li><a href="#hebergement"><span class="fa fa-home"></span><span class="badge">Herbergement</span></a></li>
                        <li><a href="#location"><span class="fa fa-car"></span><span class="badge">Vehicule</span></a></li>
                        <li><a href="#contact"><span class="fa fa-phone"></span><span class="badge">Contact</span></a></li>
                    </ul>

                    <span class="menu-btn" onclick="toggleSidebar()"><i class="fa fa-bars"></i></span>

                    <div id="sidebar" class="sidebar">
                        <span class="close-btn" onclick="toggleSidebar()">&times;</span>
                        <a href="{{ route('login') }}"><span class="fa fa-right-to-bracket"></span><span class="badge">Connexion</span></a>
                        <a href="{{ route('register') }}"><span class="fa fa-user-plus"></span><span class="badge">Inscription</span></a>
                        <a href="#hebergement"><span class="fa fa-home"></span><span class="badge">Hébergements</span></a>
                        <a href="#location"><span class="fa fa-car"></span><span class="badge">Véhicules</span></a>
                        <a href="#contact"><span class="fa fa-phone"></span><span class="badge">Contact</span></a>
                    </div>
                </ul>
            </nav>
        </div>
    </header>

    <nav class="row col-12 justify-content-center m-0">
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

                        <div class="service-item p-0 mb-1">
                            <button class="type">Studio</button>
                            <ul class="services-list mt-2 p-2 list-unstyled">
                                <li class="d-flex align-items-center mb-1">
                                    <i class="fas fa-wifi text-primary me-2"></i>
                                    <span>WiFi gratuit</span>
                                </li>
                                <li class="d-flex align-items-center mb-1">
                                    <i class="fas fa-fan text-info me-2"></i>
                                    <span>Ventilateur</span>
                                </li>
                                <li class="d-flex align-items-center mb-1">
                                    <i class="fas fa-video text-danger me-2"></i>
                                    <span>Caméra de surveillance</span>
                                </li>
                            </ul>
                        </div>

                        <div class="service-item p-0 mb-1">
                            <button class="type">Chambre unique</button>
                            <ul class="services-list mt-2 p-2 list-unstyled">
                                <li class="d-flex align-items-center mb-1">
                                    <i class="fas fa-wifi text-primary me-2"></i>
                                    <span>WiFi gratuit</span>
                                </li>
                                <li class="d-flex align-items-center mb-1">
                                    <i class="fas fa-snowflake text-info me-2"></i>
                                    <span>Climatisation</span>
                                </li>
                                <li class="d-flex align-items-center mb-1">
                                    <i class="fas fa-coffee text-warning me-2"></i>
                                    <span>Petit déjeuner inclus</span>
                                </li>
                            </ul>
                        </div>

                        <div class="service-item p-0 mb-1">
                            <button class="type">Chambre salon</button>
                            <ul class="services-list mt-2 p-2 list-unstyled">
                                <li class="d-flex align-items-center mb-1">
                                    <i class="fas fa-wifi text-primary me-2"></i>
                                    <span>WiFi gratuit</span>
                                </li>
                                <li class="d-flex align-items-center mb-1">
                                    <i class="fas fa-snowflake text-info me-2"></i>
                                    <span>Climatisation</span>
                                </li>
                                <li class="d-flex align-items-center mb-1">
                                    <i class="fas fa-coffee text-warning me-2"></i>
                                    <span>Petit déjeuner inclus</span>
                                </li>
                            </ul>
                        </div>

                        <div class="service-item p-0 mb-1">
                            <button class="type">Trois pièces et plus</button>
                            <ul class="services-list mt-2 p-2 list-unstyled">
                                <li class="d-flex align-items-center mb-1">
                                    <i class="fas fa-wifi text-primary me-2"></i>
                                    <span>WiFi gratuit</span>
                                </li>
                                <li class="d-flex align-items-center mb-1">
                                    <i class="fas fa-snowflake text-info me-2"></i>
                                    <span>Climatisation</span>
                                </li>
                                <li class="d-flex align-items-center mb-1">
                                    <i class="fas fa-coffee text-warning me-2"></i>
                                    <span>Petit déjeuner inclus</span>
                                </li>
                            </ul>
                        </div>

                        <div class="service-item p-0 mb-1">
                            <button class="type">Villa avec piscine</button>
                            <ul class="services-list mt-2 p-2 list-unstyled">
                                <li class="d-flex align-items-center mb-1">
                                    <i class="fas fa-wifi text-primary me-2"></i>
                                    <span>WiFi gratuit</span>
                                </li>
                                <li class="d-flex align-items-center mb-1">
                                    <i class="fas fa-swimming-pool text-info me-2"></i>
                                    <span>Piscine privée</span>
                                </li>
                                <li class="d-flex align-items-center mb-1">
                                    <i class="fas fa-snowflake text-info me-2"></i>
                                    <span>Climatisation</span>
                                </li>
                                <li class="d-flex align-items-center mb-1">
                                    <i class="fas fa-parking text-warning me-2"></i>
                                    <span>Parking gratuit</span>
                                </li>
                            </ul>
                        </div>

                    </div>

                    <!-- Deuxième item : Conditions de réservation -->
                    <input type="checkbox" id="acc2">
                    <label for="acc2">
                        Conditions de réservation
                        <span class="toggle-services"><i class="fa fa-chevron-down"></i></span>
                    </label>
                    <div class="content">
                        <ul class="list-unstyled">
                            <li class="d-flex align-items-center mb-2">
                                <i class="fas fa-calendar-check text-primary me-2"></i>
                                <span>Réservation préalable requise</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="fas fa-hand-holding-dollar text-success me-2"></i>
                                <span>Acompte de 20% pour confirmation</span>
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <i class="fas fa-ban text-danger me-2"></i>
                                <span>Annulation gratuite jusqu'à 48h avant l'arrivée</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </nav>

    <footer>
        <p id="contact">&copy; 2025 afrik’hub. tous droits réservés.<br />afrikhub@gmail.com</p>
    </footer>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("open");
        }

        document.querySelectorAll('.service-item .type').forEach(btn => {
            btn.addEventListener('click', () => {
                const item = btn.closest('.service-item');
                item.classList.toggle('open');
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>
