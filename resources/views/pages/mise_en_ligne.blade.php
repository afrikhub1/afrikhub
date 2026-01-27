<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre résidence en location - Afrik'Hub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        :root {
            --primary-color: #FFA500; /* Ta couleur de base exacte */
            --primary-dark: #cc8400;
            --text-dark: #212529;
        }

        body {
            background-color: #ffffff; /* Suppression du mode sombre/grisé */
            color: var(--text-dark);
            font-family: 'Poppins', sans-serif;
        }

        /* --- NAVBAR --- */
        .navbar {
            background-color: var(--primary-color) !important;
        }

        /* --- FORMULAIRE --- */
        fieldset {
            background-color: #ffffff;
            border: 1px solid #eee;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 2.5rem;
        }

        legend {
            font-weight: 700;
            color: var(--primary-color);
            float: none;
            width: auto;
            padding: 0 10px;
            font-size: 1.3rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(255, 165, 0, 0.25);
        }

        .input-group-text {
            color: var(--primary-color);
            background-color: #fff;
            border-right: none;
        }

        .input-group .form-control {
            border-left: none;
        }

        /* --- COMMODITÉS --- */
        .commodite-item {
            border: 1px solid #f0f0f0;
            border-radius: 8px;
            transition: 0.2s;
            background: #fff;
        }

        .commodite-item:hover {
            border-color: var(--primary-color);
            background-color: #fff9f0 !important;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* --- BOUTON --- */
        .btn-submit {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            padding: 12px 40px;
            border-radius: 8px;
            border: none;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background-color: var(--primary-dark);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 165, 0, 0.3);
        }

        #map {
            border: 2px solid #f0f0f0;
            border-radius: 12px;
        }

        #images {
            border: 2px dashed var(--primary-color);
            background: #fff9f0;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('assets/images/logo_01.png') }}" alt="Logo" style="width: 70px;">
            </a>
            <div class="navbar-nav ms-auto d-none d-lg-flex">
                <a class="nav-link text-white" href="{{ route('accueil') }}">Accueil</a>
                <a class="nav-link text-white" href="{{ route('logout') }}">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-5 fw-bold" style="color: var(--text-dark);">Ajouter une résidence</h2>

        <form action="{{ route('residences.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <fieldset>
                <legend><i class="fas fa-home"></i> Détails de l'annonce</legend>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nom de la résidence</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-heading"></i></span>
                            <input type="text" class="form-control" name="nom_residence" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Prix / jour (FCFA)</label>
                        <input type="number" class="form-control" name="prix_jour" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Type</label>
                        <select class="form-select" name="type_residence" required>
                            <option value="Appartement">Appartement</option>
                            <option value="Villa">Villa</option>
                            <option value="Studio">Studio</option>
                        </select>
                    </div>
                </div>
            </fieldset>

            <fieldset>
                <legend><i class="fas fa-star"></i> Commodités</legend>
                <div class="row g-3">
                    <div class="col-6 col-md-3">
                        <div class="p-3 commodite-item">
                            <div class="form-check">
                                <input class="form-check-input commodite-checkbox" type="checkbox" id="wifi" data-target="field_wifi">
                                <label class="form-check-label" for="wifi"><i class="fas fa-wifi me-2 text-warning"></i> Wi-Fi</label>
                            </div>
                            <input type="text" class="form-control form-control-sm mt-2 d-none" id="field_wifi" placeholder="Détails...">
                        </div>
                    </div>
                    </div>
            </fieldset>

            <fieldset>
                <legend><i class="fas fa-map-marker-alt"></i> Localisation</legend>
                <div class="row g-3">
                    <div class="col-md-8">
                        <div id="map" style="height: 300px;"></div>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control mb-2" id="latitude" name="latitude" placeholder="Lat" readonly>
                        <input type="text" class="form-control mb-2" id="longitude" name="longitude" placeholder="Lng" readonly>
                        <textarea class="form-control" name="geolocalisation" id="geolocalisation" placeholder="Adresse" rows="4" readonly></textarea>
                    </div>
                </div>
            </fieldset>

            <div class="text-center mb-5">
                <button type="submit" class="btn btn-submit">
                    <i class="fas fa-paper-plane me-2"></i> Enregistrer la résidence
                </button>
            </div>
        </form>
    </div>

    <script>
        // Ton script de géolocalisation Leaflet reste identique ici
        // Ton script pour afficher/masquer les champs commodités aussi
    </script>
</body>
</html>