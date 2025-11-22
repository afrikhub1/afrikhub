<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre résidence en location - Afrik'Hub</title>
    <!-- Bootstrap 5 CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome (Icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    {{-- liens pour le maps --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


    <style>
        :root {
            --primary-color: #FFA500;
            --primary-dark: #e69500;
        }

        body {
            background-color: #f8f9fa;
            color: #212529;
            font-family: 'Poppins', Arial, sans-serif;
        }

        /* Styles du Header Navbar Bootstrap */
        .navbar {
            background-color: var(--primary-color) !important;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }

        .navbar-brand {
            color: #fff !important;
            font-weight: 700;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand img {
            height: 40px;
            width: auto;
        }

        /* Styles pour les liens du Header sur grand écran */
        .desktop-nav-links .nav-link {
            color: #fff !important;
            font-weight: 500;
            transition: 0.3s;
        }

        .desktop-nav-links .nav-link:hover {
            color: #212529 !important;
        }

        /* Ajustement de la couleur du Toggler (bouton burger) */
        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.5);
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Style spécifique pour les liens dans l'Offcanvas (Sidebar) */
        .offcanvas-header {
            background-color: var(--primary-color);
            color: white;
        }
        .offcanvas-body .nav-link {
            color: #212529;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #eee;
            transition: background-color 0.2s;
        }
        .offcanvas-body .nav-link:hover {
            background-color: #f0f0f0;
            color: var(--primary-dark);
        }
        .offcanvas-body .nav-link i {
            color: var(--primary-color);
            width: 20px; /* Aligner les icônes */
        }
        /* Fin des Styles du Header */


        fieldset {
            background-color: #fff;
            border: 1px solid #dee2e6; /* Lighter border for modern look */
            border-radius: 0.75rem;
            padding: 2rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        legend {
            font-weight: 700;
            color: var(--primary-color);
            padding: 0 1rem;
            font-size: 1.4rem;
            width: inherit; /* Permet à la legend de prendre la taille de son contenu */
            margin-left: -0.5rem;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control, .form-select {
            border: 1px solid #ced4da;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            height: auto;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(255, 165, 0, 0.25);
        }

        /* Styles spécifiques pour l'input group pour les icônes */
        .input-group-text {
            background-color: #fff;
            border: 1px solid #ced4da;
            border-right: none;
            color: var(--primary-color);
            border-radius: 0.5rem 0 0 0.5rem;
        }
        .input-group .form-control {
            border-left: none;
            border-radius: 0 0.5rem 0.5rem 0;
        }
        .input-group .form-control:focus {
            z-index: 10;
        }

        .btn-submit {
            background-color: var(--primary-color);
            color: #fff;
            border: none;
            font-weight: 600;
            padding: 0.8rem 3rem;
            border-radius: 0.5rem;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(255, 165, 0, 0.4);
        }

        .btn-submit:hover {
            background-color: var(--primary-dark);
            color: #fff;
            box-shadow: 0 8px 20px rgba(255, 165, 0, 0.6);
            transform: translateY(-2px);
        }

        .container h2 {
            color: var(--primary-color);
            margin-bottom: 2rem;
            text-align: center;
            font-weight: 700;
            font-size: 2.2rem;
        }

        /* Style des commodités */
        .commodite-item {
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .commodite-item:hover {
            background-color: #ffeccf !important;
            border-color: var(--primary-dark);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* Style pour l'input file */
        #images {
            padding: 1.5rem 1rem;
            border: 2px dashed #ffddaf;
        }

    </style>
</head>

<body>
    <!-- HEADER RESPONSIVE -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
           <h1>
                <img class="h-auto" style="width: 80px;" src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo">
           </h1>

            <!-- Liens pour les grands écrans (affichés en ligne) -->
            <div class="collapse navbar-collapse desktop-nav-links" id="navbarNavDesktop">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" href="{{ route('accueil') }}"><i class="fas fa-home me-1"></i> Accueil</a>
                    @if(Auth::user()->type_compte == 'professionnel')
                        <a class="nav-link" href="{{ route('pro.dashboard') }}"><i class="fas fa-briefcase me-1"></i> Profil</a>
                    @else
                        <a class="nav-link" href="{{ route('clients_historique') }}"><i class="fas fa-briefcase me-1"></i> Profil</a>
                    @endif
                    <a class="nav-link" href="{{ route('recherche') }}"><i class="fas fa-search me-1"></i> Recherche</a>
                    <a class="nav-link" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-1"></i> Déconnexion</a>
                </div>
            </div>

            <!-- Bouton Toggler pour Mobile (Ouvre l'Offcanvas) -->
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <!-- FIN HEADER RESPONSIVE -->

    <!-- OFF-CANVAS (SIDEBAR) pour petits écrans - Positionné à droite (offcanvas-end) -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                <i class="fa-solid fa-house-chimney me-2"></i> Menu Afrik'Hub
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <nav class="nav flex-column">
                <a class="nav-link" href="{{ route('accueil') }}"><i class="fas fa-home me-3"></i> Accueil</a>
                    @if(Auth::user()->type_compte == 'professionnel')
                        <a class="nav-link" href="{{ route('pro.dashboard') }}"><i class="fas fa-briefcase me-3"></i> Profil</a>
                    @else
                        <a class="nav-link" href="{{ route('clients_historique') }}"><i class="fas fa-briefcase me-3"></i> Profil</a>
                    @endif
                    <a class="nav-link" href="{{ route('recherche') }}"><i class="fas fa-search me-1"></i> Recherche</a>
                    <a class="nav-link" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-3"></i> Déconnexion</a>
            </nav>
        </div>
    </div>
    <!-- FIN OFF-CANVAS -->

    <div class="container mt-5 mb-5">
        <h2>Mettre votre résidence en location</h2>

        <form action="{{ route('residences.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Informations générales -->
            <fieldset class="mb-5">
                <legend>Informations générales <i class="fas fa-info-circle"></i></legend>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="nom_residence" class="form-label">Nom de la résidence</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            <input type="text" class="form-control" id="nom_residence" name="nom_residence" placeholder="Nom de votre annonce" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="pays" class="form-label">Pays</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-globe-africa"></i></span>
                            <input type="text" class="form-control" id="pays" name="pays" placeholder="Ex: Côte d'Ivoire" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="ville" class="form-label">Ville</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-city"></i></span>
                            <input type="text" class="form-control" id="ville" name="ville" placeholder="Ex: Abidjan" required>
                        </div>
                    </div>
                </div>
            </fieldset>

            <!-- Détails de la résidence -->
            <fieldset class="mb-5">
                <legend>Détails de la résidence <i class="fas fa-bed"></i></legend>
                <div class="row g-4">
                    <div class="col-md-4">
                        <label for="type_residence" class="form-label">Type de résidence</label>
                        <select class="form-select" id="type_residence" name="type_residence" required>
                            <option value="" disabled selected>Sélectionnez un type</option>
                            <option value="Appartement">Appartement</option>
                            <option value="Maison">Maison basse</option>
                            <option value="Studio">Studio</option>
                            <option value="Villa">Villa</option>
                            <option value="Chalet">Chalet</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="nb_chambres" class="form-label">Nombre de chambres</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-person-booth"></i></span>
                            <input type="number" class="form-control" id="nb_chambres" name="nb_chambres" min="1" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="nb_salons" class="form-label">Nombre de salons</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-couch"></i></span>
                            <input type="number" class="form-control" id="nb_salons" name="nb_salons" min="0" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="prix_jour" class="form-label">Prix par jour (FCFA)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                            <input type="number" class="form-control" id="prix_jour" name="prix_jour" min="1" required>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label for="details_position" class="form-label">Repère proche de la résidence</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                            <input type="text" class="form-control" id="details_position" name="details_position" placeholder="Ex: Cocody derrière la RTI" required>
                        </div>
                    </div>
                </div>

                <!-- Commodités -->
                <div class="mt-5">
                    <label class="form-label fw-semibold">Commodités <i class="fas fa-star"></i></label>
                    <div class="row g-3">
                        @php
                            $commodites = [
                                "Climatisation" => "fa-snowflake",
                                "Wi-Fi" => "fa-wifi",
                                "Télévision" => "fa-tv",
                                "Eau chaude" => "fa-shower",
                                "Parking" => "fa-car",
                                "Cuisine équipée" => "fa-utensils",
                                "Machine à laver" => "fa-washer",
                                "Sécurité 24h/24" => "fa-shield-alt",
                                "Piscine" => "fa-swimming-pool",
                                "Balcon/Terrasse" => "fa-tree",
                                "Générateur" => "fa-bolt",
                                "Caméras de surveillance" => "fa-video",
                                "Animaux autorisés" => "fa-paw"
                            ];
                        @endphp

                        @foreach ($commodites as $c => $icon)
                            @php $id = 'comodite_' . md5($c); @endphp
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <label class="form-check d-flex align-items-center gap-2 p-3 bg-light rounded shadow-sm h-100 mb-0 commodite-item" for="{{ $id }}">
                                    <input
                                        class="form-check-input mt-0"
                                        type="checkbox"
                                        name="autres_details[]"
                                        value="{{ $c }}"
                                        id="{{ $id }}"
                                    >
                                    <i class="fas {{ $icon }}" style="color: var(--primary-color);"></i>
                                    <span class="form-check-label">{{ $c }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-5">
                    <label class="form-label">Coordonnées géographiques (obligatoire pour la carte)</label>

                    <input type="text" id="latitude" name="latitude" placeholder="Latitude" required>
                    <input type="text" id="longitude" name="longitude" placeholder="Longitude" required>

                    <div id="map" style="height: 300px; border-radius: 10px; margin-top:10px;">

                    </div>


                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-compass"></i></span>
                        <input type="text" class="form-control" name="geolocalisation" id="geolocalisation" placeholder="Ex: 5.3170, -4.0101 ou lien Google Maps" required>
                    </div>
                </div>
            </fieldset>

            <!-- Images -->
            <fieldset class="mb-5">
                <legend>Images <i class="fas fa-images"></i></legend>
                <label for="images" class="form-label">Ajouter des images (min. 1, max. 5)</label>
                <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" required>
            </fieldset>

            <div class="d-flex justify-content-center mb-5">
                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-check-circle me-2"></i> Soumettre la résidence
                </button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS Bundle (nécessaire pour le toggler et l'offcanvas) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- affichage de la carte dans le div ciblé --}}
<script>

    // --- INITIALISATION DE LA CARTE ---
    var map = L.map('map').setView([5.345317, -4.024429], 13);

    // Tuiles gratuites OSM
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    var marker;

    // --- FONCTION POUR METTRE À JOUR LE MARQUEUR ---
    function updateMarker(lat, lng) {
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng]).addTo(map);
        }

        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;
        map.setView([lat, lng], 16);
    }


    // --- CLICK SUR LA CARTE : AJOUT DU MARQUEUR ---
    map.on('click', function (e) {
        updateMarker(e.latlng.lat, e.latlng.lng);
    });


    // ----------------------------------------------------
    // 🟧 AJOUT 1 : BOUTON "MA POSITION"
    // ----------------------------------------------------

    var locateBtn = L.control({position: 'topleft'});

    locateBtn.onAdd = function () {
        var btn = L.DomUtil.create('button', 'btn btn-light');
        btn.innerHTML = "<i class='fas fa-location-crosshairs'></i>";
        btn.style.width = "40px";
        btn.style.height = "40px";
        btn.style.borderRadius = "8px";
        btn.style.border = "1px solid #ccc";
        btn.style.cursor = "pointer";

        btn.onclick = function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    let lat = position.coords.latitude;
                    let lng = position.coords.longitude;
                    updateMarker(lat, lng);
                });
            } else {
                alert("La géolocalisation n'est pas supportée par votre appareil.");
            }
        };

        return btn;
    };
    locateBtn.addTo(map);


    // ----------------------------------------------------
    // 🟧 AJOUT 2 : BARRE DE RECHERCHE D’ADRESSE
    // ----------------------------------------------------

    // Création du champ de recherche
    var searchControl = L.control({position: 'topright'});

    searchControl.onAdd = function () {
        var div = L.DomUtil.create('div');
        div.innerHTML = `
            <input id="search_address"
                type="text"
                class="form-control"
                placeholder="Rechercher une adresse..."
                style="width: 230px; border-radius: 8px; padding: 6px 10px;">
        `;
        return div;
    };
    searchControl.addTo(map);


    // --- Fonction de recherche ---
    document.addEventListener("keyup", function (e) {
        if (e.target.id === "search_address" && e.key === "Enter") {
            let query = document.getElementById("search_address").value;
            if (!query) return;

            // Requête vers Nominatim (gratuit)
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        let lat = data[0].lat;
                        let lng = data[0].lon;
                        updateMarker(lat, lng);
                    } else {
                        alert("Aucun résultat trouvé.");
                    }
                });
        }
    });

</script>

</body>
</html>
