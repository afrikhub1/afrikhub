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

        .desktop-nav-links .nav-link {
            color: #fff !important;
            font-weight: 500;
            transition: 0.3s;
        }

        .desktop-nav-links .nav-link:hover {
            color: #212529 !important;
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.5);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

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
            width: 20px;
        }

        fieldset {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 0.75rem;
            padding: 2rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        legend {
            font-weight: 700;
            color: var(--primary-color);
            padding: 0 1rem;
            font-size: 1.4rem;
            width: inherit;
            margin-left: -0.5rem;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border: 1px solid #ced4da;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            height: auto;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(255, 165, 0, 0.25);
        }

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

        .commodite-item {
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .commodite-item:hover {
            background-color: #ffeccf !important;
            border-color: var(--primary-dark);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

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

            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

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
                    <div class="col-12 mt-3">
                        <label for="details" class="form-label">Description détaillée de la résidence</label>
                        <textarea class="form-control" id="details" name="details" rows="4"
                                placeholder="Ex: Appartement lumineux de 3 chambres, cuisine équipée, proche des commerces et transports..." required></textarea>
                    </div>

                </div>

                <!-- Commodités -->
                <div class="mt-5">
                    <label class="form-label fw-semibold">
                        Commodités <i class="fas fa-star"></i>
                    </label>

                    <div class="row g-3">
                        @php
                            $commodites = [

                                /* ===== BÂTIMENT / ACCÈS ===== */
                                "Niveau d’étage" => ["icon" => "fa-building", "type" => "number"],
                                "Ascenseur" => ["icon" => "fa-elevator"],
                                "Accès PMR" => ["icon" => "fa-wheelchair"],
                                "Gardien / Concierge" => ["icon" => "fa-user-shield"],
                                "Surveillance 24/24" => ["icon" => "fa-shield-alt"],

                                /* ===== STATIONNEMENT ===== */
                                "Parking interne" => ["icon" => "fa-parking"],
                                "Parking externe" => ["icon" => "fa-car"],
                                "Nombre de places de parking" => ["icon" => "fa-car-side", "type" => "number"],

                                /* ===== EXTÉRIEUR ===== */
                                "Balcon" => ["icon" => "fa-tree"],
                                "Terrasse" => ["icon" => "fa-tree"],
                                "Jardin" => ["icon" => "fa-seedling"],
                                "Piscine" => ["icon" => "fa-swimming-pool"],

                                /* ===== COUCHAGE / SANITAIRES ===== */
                                "Nombre de chambres" => ["icon" => "fa-bed", "type" => "number"],
                                "Nombre de salles d’eau" => ["icon" => "fa-shower", "type" => "number"],
                                "Eau chaude" => ["icon" => "fa-water"],

                                /* ===== CLIMATISATION ===== */
                                "Split toutes les chambres et salon" => ["icon" => "fa-snowflake"],
                                "Split toutes les chambres sauf salon" => ["icon" => "fa-snowflake"],
                                "Split salon uniquement" => ["icon" => "fa-snowflake"],
                                "Split autre (à préciser)" => ["icon" => "fa-snowflake", "type" => "text"],

                                /* ===== SALON ===== */
                                "Salon fauteuil 1 place" => ["icon" => "fa-couch", "type" => "number"],
                                "Salon canapé 2 places" => ["icon" => "fa-couch", "type" => "number"],
                                "Salon canapé 3 places" => ["icon" => "fa-couch", "type" => "number"],
                                "Salon canapé 4 places" => ["icon" => "fa-couch", "type" => "number"],
                                "Salon canapé 5 places" => ["icon" => "fa-couch", "type" => "number"],
                                "Salon canapé 6 places" => ["icon" => "fa-couch", "type" => "number"],
                                "Table basse salon" => ["icon" => "fa-table"],

                                /* ===== SALLE À MANGER ===== */
                                "Salle à manger 2 places" => ["icon" => "fa-chair"],
                                "Salle à manger 4 places" => ["icon" => "fa-chair"],
                                "Salle à manger 6 places" => ["icon" => "fa-chair"],
                                "Salle à manger 8 places" => ["icon" => "fa-chair"],
                                "Salle à manger autre" => ["icon" => "fa-chair", "type" => "text"],

                                /* ===== CUISINE ===== */
                                "Réfrigérateur" => ["icon" => "fa-box"],
                                "Congélateur combiné" => ["icon" => "fa-box"],
                                "Four" => ["icon" => "fa-fire"],
                                "Gazinière" => ["icon" => "fa-fire"],
                                "Micro-ondes" => ["icon" => "fa-microchip"],
                                "Mixeur" => ["icon" => "fa-blender"],
                                "Bouilloire électrique" => ["icon" => "fa-blender"],
                                "Machine à laver linge" => ["icon" => "fa-washer"],
                                "Fer à repasser" => ["icon" => "fa-shirt"],

                                /* ===== MULTIMÉDIA ===== */
                                "Télévision salon (pouces)" => ["icon" => "fa-tv", "type" => "number"],
                                "Télévision chambre (pouces)" => ["icon" => "fa-tv", "type" => "number"],
                                "Abonnement chaînes internationales" => ["icon" => "fa-tv"],
                                "Canal +" => ["icon" => "fa-tv"],
                                "Wi-Fi" => ["icon" => "fa-wifi"],

                                /* ===== SERVICES ===== */
                                "Service ménager" => ["icon" => "fa-broom"],
                                "Changement de draps" => ["icon" => "fa-bed"],
                                "Nettoyage hebdomadaire" => ["icon" => "fa-calendar-check"],

                                /* ===== SÉCURITÉ ===== */
                                "Porte blindée" => ["icon" => "fa-door-closed"],
                                "Coffre-fort" => ["icon" => "fa-lock"],
                                "Caméras de surveillance" => ["icon" => "fa-video"],
                            ];
                        @endphp

                        @foreach ($commodites as $label => $data)
                            @php
                                $id = 'comodite_' . md5($label);
                                $type = $data['type'] ?? null;
                            @endphp

                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="p-3 bg-light rounded shadow-sm h-100 commodite-item">
                                    <label class="form-check d-flex align-items-center gap-2 mb-2" for="{{ $id }}">
                                        <input
                                            class="form-check-input commodite-checkbox"
                                            type="checkbox"
                                            name="commodites[{{ $label }}][active]"
                                            value="1"
                                            id="{{ $id }}"
                                            data-target="field_{{ $id }}"
                                        >
                                        <i class="fas {{ $data['icon'] }}" style="color: var(--primary-color);"></i>
                                        <span>{{ $label }}</span>
                                    </label>

                                    @if ($type)
                                        <input
                                            type="{{ $type }}"
                                            class="form-control d-none commodite-field"
                                            name="commodites[{{ $label }}][value]"
                                            id="field_{{ $id }}"
                                            placeholder="Préciser {{ strtolower($label) }}"
                                        >
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-5 row">

                    <!-- Carte -->
                    <div class="col-md-6">
                        <label class="form-label">Coordonnées géographiques</label>

                        <!-- 🔎 Recherche + Ma position (ICI EXACTEMENT) -->
                        <div class="d-flex gap-2 mb-2">
                            <input
                                type="text"
                                id="searchLocation"
                                class="form-control"
                                placeholder="Rechercher un lieu (ex: Cocody, Plateau...)"
                            >
                            <button type="button" id="btnMyLocation" class="btn btn-outline-primary">
                                <i class="fas fa-location-crosshairs"></i>
                            </button>
                        </div>

                        <!-- 🗺️ Carte -->
                        <div id="map" style="height: 300px; border-radius: 10px;"></div>
                    </div>

                    <!-- Champs Latitude / Longitude -->
                    <div class="col-md-6 d-flex flex-column justify-content-start">
                        <label class="form-label invisible">Lat/Lng</label>
                        <input class="form-control mb-3" type="text" id="latitude" name="latitude" placeholder="Latitude" required>
                        <input class="form-control mb-3" type="text" id="longitude" name="longitude" placeholder="Longitude" required>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-compass"></i></span>
                            <input type="text" class="form-control" name="geolocalisation" id="geolocalisation"
                                placeholder="Ex: Cocody Angré, Abidjan" required>
                        </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Script Leaflet et remplissage automatique de l'adresse --}}
    <script>
        var map = L.map('map').setView([5.345317, -4.024429], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(map);

        var marker;

        function setMarker(lat, lng) {
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map);
            }

            map.setView([lat, lng], 15);

            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;

            updateAddress(lat, lng);
        }

        function updateAddress(lat, lng) {
            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json&accept-language=fr`)
                .then(res => res.json())
                .then(data => {
                    if (data && data.display_name) {
                        document.getElementById("geolocalisation").value = data.display_name;
                    }
                });
        }

        /* ===== CLIC SUR LA CARTE ===== */
        map.on('click', function (e) {
            setMarker(e.latlng.lat, e.latlng.lng);
        });

        /* ===== RECHERCHE DE LIEU ===== */
        document.getElementById("searchLocation").addEventListener("keyup", function (e) {
            if (e.key === "Enter") {
                let query = this.value;
                if (!query) return;

                fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&limit=1&accept-language=fr`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.length > 0) {
                            setMarker(data[0].lat, data[0].lon);
                        } else {
                            alert("Lieu non trouvé");
                        }
                    });
            }
        });

        /* ===== MA POSITION ACTUELLE ===== */
        document.getElementById("btnMyLocation").addEventListener("click", function () {
            if (!navigator.geolocation) {
                alert("La géolocalisation n'est pas supportée");
                return;
            }

            navigator.geolocation.getCurrentPosition(
                function (position) {
                    let lat = position.coords.latitude;
                    let lng = position.coords.longitude;
                    setMarker(lat, lng);
                },
                function () {
                    alert("Impossible d'obtenir votre position");
                },
                {
                    enableHighAccuracy: true
                }
            );
        });
    </script>


    {{-- js comodite --}}
    <script>
        document.querySelectorAll('.commodite-checkbox').forEach(cb => {
            cb.addEventListener('change', function () {
                const field = document.getElementById(this.dataset.target);
                if (!field) return;

                if (this.checked) {
                    field.classList.remove('d-none');
                    field.focus();
                } else {
                    field.classList.add('d-none');
                    field.value = '';
                }
            });
        });
    </script>

</body>
</html>
