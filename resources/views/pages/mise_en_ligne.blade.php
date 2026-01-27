</body>
</html>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre résidence en location - Afrik'Hub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    {{-- liens pour le maps --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        :root {
            /* Palette basée sur votre dégradé */
            --primary-gradient: linear-gradient(135deg, #006d77, #00afb9);
            --primary-color: #006d77;
            --secondary-color: #00afb9;
            --accent-soft: rgba(0, 175, 185, 0.1);
            --text-dark: #2d3436;
        }

        body {
            background-color: #f0f4f5;
            color: var(--text-dark);
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
        }

        /* Navbar avec effet Glassmorphism */
        .navbar {
            background: var(--primary-gradient) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 0.8rem 1rem;
        }

        .navbar-brand img {
            height: 45px;
            filter: brightness(0) invert(1); /* Assure la visibilité du logo si sombre */
        }

        .desktop-nav-links .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin-left: 15px;
            transition: all 0.3s ease;
        }

        .desktop-nav-links .nav-link:hover {
            color: #fff !important;
            transform: translateY(-2px);
        }

        /* Formulaire & Fieldsets */
        fieldset {
            background-color: #fff;
            border: none;
            border-radius: 1.25rem;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            margin-bottom: 2rem;
        }

        legend {
            float: none;
            width: auto;
            font-weight: 700;
            color: var(--primary-color);
            background: var(--accent-soft);
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 500;
            color: #4a5568;
            margin-bottom: 0.6rem;
            font-size: 0.95rem;
        }

        .form-control, .form-select {
            border: 1.5px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 4px rgba(0, 175, 185, 0.15);
        }

        .input-group-text {
            background-color: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-right: none;
            color: var(--primary-color);
        }

        /* Bouton de soumission */
        .btn-submit {
            background: var(--primary-gradient);
            color: #fff;
            border: none;
            font-weight: 600;
            padding: 1rem 3.5rem;
            border-radius: 50px;
            transition: all 0.4s;
            box-shadow: 0 10px 20px rgba(0, 109, 119, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(0, 109, 119, 0.4);
            color: white;
            filter: brightness(1.1);
        }

        /* Carte et Map */
        #map {
            height: 350px;
            border-radius: 1rem;
            border: 2px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .btn-primary { background-color: var(--primary-color); border: none; }
        .btn-primary:hover { background-color: var(--secondary-color); }

        /* Commodités */
        .commodite-item {
            border: 1.5px solid #f1f5f9;
            background: #f8fafc;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 1rem;
        }

        .commodite-item:hover {
            border-color: var(--secondary-color);
            background: #fff !important;
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .form-check-input:checked {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        #images {
            border: 2px dashed #cbd5e1;
            background: #f8fafc;
            padding: 2rem;
            text-align: center;
        }

        h2 {
            font-weight: 800;
            color: var(--primary-color);
            position: relative;
            display: inline-block;
            margin-bottom: 3rem;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--primary-gradient);
            border-radius: 2px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('accueil') }}">
                <img src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo">
            </a>

            <div class="collapse navbar-collapse desktop-nav-links" id="navbarNav">
                <div class="navbar-nav ms-auto align-items-center">
                    <a class="nav-link" href="{{ route('accueil') }}"><i class="fas fa-home me-1"></i> Accueil</a>
                    @if(Auth::user()->type_compte == 'professionnel')
                        <a class="nav-link" href="{{ route('pro.dashboard') }}"><i class="fas fa-user-circle me-1"></i> Profil Pro</a>
                    @else
                        <a class="nav-link" href="{{ route('clients_historique') }}"><i class="fas fa-user-circle me-1"></i> Mon Espace</a>
                    @endif
                    <a class="nav-link" href="{{ route('recherche') }}"><i class="fas fa-search me-1"></i> Recherche</a>
                    <a class="nav-link btn btn-sm btn-light text-dark ms-lg-3 px-3" href="{{ route('logout') }}" style="border-radius: 50px;">Déconnexion</a>
                </div>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar">
        <div class="offcanvas-header" style="background: var(--primary-gradient)">
            <h5 class="offcanvas-title text-white"><i class="fa-solid fa-house-chimney me-2"></i> Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="list-group list-group-flush">
                <a href="{{ route('accueil') }}" class="list-group-item list-group-item-action border-0 p-3"><i class="fas fa-home me-3 text-primary"></i>Accueil</a>
                <a href="{{ route('recherche') }}" class="list-group-item list-group-item-action border-0 p-3"><i class="fas fa-search me-3 text-primary"></i>Recherche</a>
                <a href="{{ route('logout') }}" class="list-group-item list-group-item-action border-0 p-3"><i class="fas fa-sign-out-alt me-3 text-danger"></i>Déconnexion</a>
            </div>
        </div>
    </div>

    <div class="container mt-5 mb-5 text-center">
        <h2>Publier votre annonce</h2>

        <div class="row justify-content-center text-start mt-4">
            <div class="col-lg-10">
                <form action="{{ route('residences.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <fieldset>
                        <legend><i class="fas fa-info-circle me-2"></i> Base</legend>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nom de la résidence</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <input type="text" class="form-control" name="nom_residence" placeholder="Ex: Villa des Almadies" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Pays</label>
                                <input type="text" class="form-control" name="pays" placeholder="Sénégal, CI..." required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Ville</label>
                                <input type="text" class="form-control" name="ville" placeholder="Dakar, Abidjan..." required>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend><i class="fas fa-bed me-2"></i> Caractéristiques</legend>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <label class="form-label">Type de bien</label>
                                <select class="form-select" name="type_residence" required>
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
                                <label class="form-label">Nombre de chambres</label>
                                <input type="number" class="form-control" name="nb_chambres" min="1" required>
                            </div>

                            <div class="col-md-4">
                                <label for="nb_salons" class="form-label">Nombre de salons</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-couch"></i></span>
                                    <input type="number" class="form-control" id="nb_salons" name="nb_salons" min="0" required>
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <label for="details_position" class="form-label">Repère proche de la résidence</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="text" class="form-control" id="details_position" name="details_position" placeholder="Ex: Cocody derrière la RTI" required>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label">Prix / Nuit (FCFA)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" name="prix_jour" required>
                                    <span class="input-group-text">CFA</span>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description détaillée</label>
                                <textarea class="form-control" name="details" rows="4" placeholder="Décrivez les atouts de votre logement..."></textarea>
                            </div>
                        </div>

                        <div class="mt-5">
                            <h6 class="fw-bold mb-3 text-muted">Équipements & Services</h6>
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
                                        "Salon fauteuil nombre de places" => ["icon" => "fa-couch", "type" => "number"],

                                        "lit des chambres" => ["icon" => "fa-bed", "type" => "number"],

                                        "Table basse salon" => ["icon" => "fa-table"],

                                        /* ===== SALLE À MANGER ===== */
                                        "Salle à manger nombre de place" => ["icon" => "fa-chair", "type" => "text"],

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
                                        $id = 'com_' . md5($label);
                                        $type = $data['type'] ?? null;
                                    @endphp

                                    <div class="col-6 col-md-3">
                                        <div class="p-3 commodite-item shadow-sm h-100">
                                            <label class="form-check " for="{{ $id }}">
                                                <input
                                                    class="form-check-input "
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
                    </fieldset>

                    <fieldset>
                        <legend><i class="fas fa-map-marked-alt me-2"></i> Emplacement</legend>
                        <div class="row g-4">
                            <div class="col-md-7">
                                <div class="input-group mb-3">
                                    <input type="text" id="searchLocation" class="form-control" placeholder="Rechercher une adresse...">
                                    <button class="btn btn-primary" type="button" id="btnSearchLocation"><i class="fas fa-search"></i></button>
                                    <button class="btn btn-outline-secondary" type="button" id="btnMyLocation"><i class="fas fa-crosshairs"></i></button>
                                </div>
                                <div id="map"></div>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Adresse précise</label>
                                <textarea class="form-control mb-3" name="geolocalisation" id="geolocalisation" rows="3" readonly placeholder="L'adresse s'affichera ici..."></textarea>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="text" class="form-control form-control-sm" name="latitude" id="latitude" placeholder="Lat" readonly>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" class="form-control form-control-sm" name="longitude" id="longitude" placeholder="Long" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend><i class="fas fa-camera me-2"></i> Galerie</legend>
                        <div class="text-center p-4" id="images-container">
                            <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" required>
                            <p class="text-muted mt-2 small">Sélectionnez jusqu'à 5 photos haute résolution.</p>
                        </div>
                    </fieldset>

                    <div class="text-center mb-5">
                        <button type="submit" class="btn btn-submit btn-lg">
                            <i class="fas fa-paper-plane me-2"></i> Valider mon annonce
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        var map = L.map('map').setView([5.345317, -4.024429], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
        var marker;

        function setMarker(lat, lng) {
            if (marker) marker.setLatLng([lat, lng]);
            else marker = L.marker([lat, lng]).addTo(map);
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

        map.on('click', function (e) { setMarker(e.latlng.lat, e.latlng.lng); });

        document.getElementById("btnMyLocation").addEventListener("click", function () {
            if (!navigator.geolocation) return;
            navigator.geolocation.getCurrentPosition(function (pos) {
                setMarker(pos.coords.latitude, pos.coords.longitude);
            });
        });

        // Logique de recherche simplifiée pour l'exemple
        document.getElementById("btnSearchLocation").addEventListener("click", function() {
            let query = document.getElementById("searchLocation").value;
            fetch(`https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&limit=1`)
                .then(res => res.json())
                .then(data => {
                    if(data[0]) setMarker(data[0].lat, data[0].lon);
                });
        });
    </script>
</body>
</html>
