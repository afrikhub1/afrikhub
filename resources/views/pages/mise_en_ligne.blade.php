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
            <!-- Logo et Nom de l'application -->
            <a class="navbar-brand" href="#">
                <!-- Utilisation d'une icône Font Awesome pour le logo, en l'absence de l'image -->
                <i class="fa-solid fa-house-chimney" style="font-size: 1.5em;"></i>
                Afrik'Hub
            </a>

            <!-- Liens pour les grands écrans (affichés en ligne) -->
            <div class="collapse navbar-collapse desktop-nav-links" id="navbarNavDesktop">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" href="#"><i class="fas fa-home me-1"></i> Accueil</a>
                    <a class="nav-link" href="#"><i class="fas fa-briefcase me-1"></i> Pro</a>
                    <a class="nav-link" href="#"><i class="fas fa-user-circle me-1"></i> Utilisateur</a>
                    <a class="nav-link" href="#"><i class="fas fa-search me-1"></i> Recherche</a>
                    <a class="nav-link" href="#"><i class="fas fa-sign-out-alt me-1"></i> Déconnexion</a>
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
                <a class="nav-link" href="#"><i class="fas fa-home me-3"></i> Accueil</a>
                <a class="nav-link" href="#"><i class="fas fa-briefcase me-3"></i> Pro</a>
                <a class="nav-link" href="#"><i class="fas fa-user-circle me-3"></i> Utilisateur</a>
                <a class="nav-link" href="#"><i class="fas fa-search me-3"></i> Recherche</a>
                <a class="nav-link" href="#"><i class="fas fa-sign-out-alt me-3"></i> Déconnexion</a>
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
</body>
</html>
