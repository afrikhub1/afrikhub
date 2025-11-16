<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre résidence en location - Afrik'Hub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            background-color: #F5F5F5;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #FFA500;
            color: black;
            padding: 1rem 2rem;
        }

        header a { color: black; font-weight: 600; margin-left: 15px; text-decoration: none; }
        header a:hover { color: white; }

        h2.section-title {
            text-align: center;
            color: #FFA500;
            margin-bottom: 20px;
            font-weight: bold;
        }

        fieldset {
            background: white;
            border: 2px solid #FFA500;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        legend {
            font-size: 1.25rem;
            color: #FFA500;
            font-weight: bold;
            padding: 0 10px;
        }

        .form-control, .form-select {
            border-color: #FFA500;
        }

        .form-control:focus, .form-select:focus {
            border-color: #FFA500;
            box-shadow: 0 0 5px rgba(255,165,0,0.45);
        }

        .btn-submit {
            background: #FFA500;
            color: white;
            font-weight: bold;
        }

        .btn-submit:hover {
            background: #e08c00;
        }

        .check-group label { margin-right: 15px; }
    </style>
</head>

<body>

<header class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="fw-bold">Afrik'Hub</h1>
    <nav>
        <a href="#">Accueil</a>
        <a href="#">Pro</a>
        <a href="#">Utilisateur</a>
        <a href="#">Recherche</a>
        <a href="#">Déconnexion</a>
    </nav>
</header>

<div class="container mt-4">

    <h2 class="section-title">Mettre votre résidence en location</h2>

    <form action="{{ route('residences.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 🟧 Informations Générales -->
        <fieldset>
            <legend>Informations Générales</legend>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nom de la résidence</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Pays</label>
                    <input type="text" name="pays" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Ville</label>
                    <input type="text" name="ville" class="form-control" required>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3" class="form-control" required></textarea>
                </div>
            </div>
        </fieldset>

        <!-- 🟧 Détails de la résidence -->
        <fieldset>
            <legend>Détails de la résidence</legend>

            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label">Type de résidence</label>
                    <select name="type_residence" class="form-select" required>
                        <option disabled selected>Sélectionner</option>
                        <option>Appartement</option>
                        <option>Maison basse</option>
                        <option>Studio</option>
                        <option>Villa</option>
                        <option>Chalet</option>
                        <option>Autre</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Chambres</label>
                    <input type="number" name="nombre_chambres" class="form-control" min="1" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Salles d'eau</label>
                    <input type="number" name="nombre_salles_eau" class="form-control" min="1" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Nombre de salons</label>
                    <input type="number" name="nb_salons" class="form-control" min="0" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Prix par jour (FCFA)</label>
                    <input type="number" name="prix_journalier" class="form-control" min="1" required>
                </div>

                <div class="col-md-4 d-flex align-items-center">
                    <div class="form-check mt-3">
                        <input type="checkbox" name="disponible" value="1" class="form-check-input" checked>
                        <label class="form-check-label">Disponible</label>
                    </div>
                </div>

                <div class="col-md-12">
                    <label class="form-label">Repère / Position</label>
                    <input type="text" name="details_position" class="form-control" placeholder="Ex: Cocody derrière la RTI">
                </div>

            </div>
        </fieldset>

        <!-- 🟧 Extérieurs, Parking, Confort -->
        <fieldset>
            <legend>Commodités & Confort</legend>

            <div class="row g-4">

                <!-- Parking -->
                <div class="col-md-6">
                    <label class="form-label">Parking</label>
                    <div class="check-group">
                        <label><input type="checkbox" name="parking[]" value="externe"> Externe</label>
                        <label><input type="checkbox" name="parking[]" value="interne"> Interne</label>
                    </div>
                </div>

                <!-- Extérieurs -->
                <div class="col-md-6">
                    <label class="form-label">Extérieurs</label>
                    <div class="check-group">
                        <label><input type="checkbox" name="exterieurs[]" value="terrasse"> Terrasse</label>
                        <label><input type="checkbox" name="exterieurs[]" value="balcon"> Balcon</label>
                        <label><input type="checkbox" name="exterieurs[]" value="jardin"> Jardin</label>
                        <label><input type="checkbox" name="exterieurs[]" value="piscine"> Piscine</label>
                    </div>
                </div>

                <!-- Eau chaude & split -->
                <div class="col-md-6">
                    <label class="form-label">Eau chaude</label>
                    <select name="eau_chaude" class="form-select">
                        <option value="oui">Oui</option>
                        <option value="non">Non</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Climatisation / Split</label>
                    <select name="split" class="form-select">
                        <option value="toutes">Toutes les chambres + salon</option>
                        <option value="chambres_seules">Toutes les chambres sauf salon</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>

                <!-- Services -->
                <div class="col-md-6">
                    <label class="form-label">Surveillance</label>
                    <div><input type="checkbox" name="surveillance" value="1"> 24/24</div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Service ménager</label>
                    <div><input type="checkbox" name="service_menager" value="1"> Oui</div>
                </div>

                <!-- Salon -->
                <div class="col-md-6">
                    <label class="form-label">Salon (Places)</label>
                    <div class="check-group">
                        @foreach(range(1,6) as $i)
                            <label><input type="radio" name="salon" value="{{ $i }}"> {{ $i }} places</label>
                        @endforeach
                    </div>
                </div>

                <!-- Salle à manger -->
                <div class="col-md-6">
                    <label class="form-label">Salle à manger</label>
                    <div class="check-group">
                        @foreach([2,3,4,6] as $i)
                            <label><input type="radio" name="salle_a_manger" value="{{ $i }}"> {{ $i }} places</label>
                        @endforeach
                        <label><input type="radio" name="salle_a_manger" value="autre"> Autre</label>
                    </div>
                </div>

                <!-- Electro -->
                <div class="col-md-12">
                    <label class="form-label">Électroménager</label>
                    <div class="row">
                        @php
                        $items = [
                            'refrigerateur_combine' => 'Réfrigérateur / Congélateur combiné',
                            'four' => 'Four',
                            'gaziniere' => 'Grande gazinière',
                            'micro_ondes' => 'Micro-ondes',
                            'mixeur' => 'Mixeur',
                            'bouilloire' => 'Bouilloire électrique',
                            'couverts' => 'Couverts & ustensiles',
                            'machine_laver' => 'Machine à laver (6kg)',
                            'television' => 'Télévision 50 pouces',
                            'canal_plus' => 'Canal+ / chaînes internationales',
                            'wifi' => 'Wi-Fi'
                        ];
                        @endphp

                        @foreach($items as $val => $label)
                        <div class="col-md-6">
                            <label><input type="checkbox" name="electromenager[]" value="{{ $val }}"> {{ $label }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </fieldset>

        <!-- 🟧 Localisation -->
        <fieldset>
            <legend>Localisation</legend>

            <label class="form-label">Coordonnées (Google Maps ou Latitude,Longitude)</label>
            <input type="text" name="geolocalisation" class="form-control" required>
        </fieldset>

        <!-- 🟧 Images -->
        <fieldset>
            <legend>Images</legend>

            <label class="form-label">Images (min. 1)</label>
            <input type="file" name="images[]" class="form-control" multiple required accept="image/*">
        </fieldset>

        <div class="text-center mb-5">
            <button class="btn btn-submit px-5 py-2">Soumettre</button>
        </div>

    </form>

</div>

</body>
</html>
