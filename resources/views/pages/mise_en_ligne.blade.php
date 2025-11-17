<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mettre résidence en location - Afrik'Hub</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

  <style>
    body {
      background-color: #f8f9fa;
      color: #212529;
      font-family: 'Poppins', Arial, sans-serif;
    }

    header {
      background-color: #FFA500;
      color: #fff;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    header h1 {
      margin: 0;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-weight: 700;
      font-size: 1.8rem;
    }

    header h1 img {
      height: 40px;
      width: auto;
    }

    .menu-links a {
      text-decoration: none;
      color: #fff;
      font-weight: 500;
      margin: 0 0.5rem;
      transition: 0.3s;
    }

    .menu-links a:hover {
      color: #212529;
    }

    fieldset {
      background-color: #fff;
      border: 2px solid #FFA500;
      border-radius: 0.5rem;
      padding: 1.5rem;
    }

    legend {
      font-weight: 700;
      color: #FFA500;
      padding: 0 0.5rem;
      font-size: 1.2rem;
    }

    .form-label {
      font-weight: 600;
    }

    .form-control, .form-select {
      border: 1px solid #FFA500;
      border-radius: 0.375rem;
    }

    .form-control:focus, .form-select:focus {
      border-color: #ff8c00;
      box-shadow: 0 0 8px rgba(255,165,0,0.3);
    }

    .btn-submit {
      background-color: #FFA500;
      color: #fff;
      border: none;
      font-weight: 600;
      padding: 0.6rem 2rem;
      border-radius: 0.5rem;
      transition: 0.3s;
    }

    .btn-submit:hover {
      background-color: #e69500;
      color: #fff;
    }

    .container h2 {
      color: #FFA500;
      margin-bottom: 2rem;
      text-align: center;
      font-weight: 700;
      font-size: 2rem;
    }

    .form-check-label {
      color: #212529;
      font-weight: 500;
    }

    .form-check {
      cursor: pointer;
    }

    .form-check-input:checked {
      background-color: #FFA500;
      border-color: #FFA500;
    }

    .form-check-input {
      cursor: pointer;
    }

    .shadow-sm {
      transition: 0.3s;
    }

    .shadow-sm:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
  </style>
</head>

<body>
  <header class="container-fluid">
    <h1>
      <img src="{{ asset('css/images/logo_01.png') }}" alt="Afrik'Hub Logo">
      Afrik'Hub
    </h1>
    <div class="menu-links">
      <a href="#">Accueil</a>
      <a href="#">Pro</a>
      <a href="#">Utilisateur</a>
      <a href="#">Recherche</a>
      <a href="#">Déconnexion</a>
    </div>
  </header>

  <div class="container mt-5 mb-5">
    <h2>Mettre votre résidence en location</h2>

    <form action="{{ route('residences.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Informations générales -->
      <fieldset class="mb-4">
        <legend>Informations générales</legend>
        <div class="row g-3">
          <div class="col-md-6">
            <label for="nom_residence" class="form-label">Nom de la résidence</label>
            <input type="text" class="form-control" id="nom_residence" name="nom_residence" required>
          </div>
          <div class="col-md-3">
            <label for="pays" class="form-label">Pays</label>
            <input type="text" class="form-control" id="pays" name="pays" required>
          </div>
          <div class="col-md-3">
            <label for="ville" class="form-label">Ville</label>
            <input type="text" class="form-control" id="ville" name="ville" required>
          </div>
        </div>
      </fieldset>

      <!-- Détails de la résidence -->
      <fieldset class="mb-4">
        <legend>Détails de la résidence</legend>
        <div class="row g-3">
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
            <input type="number" class="form-control" id="nb_chambres" name="nb_chambres" min="1" required>
          </div>
          <div class="col-md-4">
            <label for="nb_salons" class="form-label">Nombre de salons</label>
            <input type="number" class="form-control" id="nb_salons" name="nb_salons" min="0" required>
          </div>
          <div class="col-md-4">
            <label for="prix_jour" class="form-label">Prix par jour (FCFA)</label>
            <input type="number" class="form-control" id="prix_jour" name="prix_jour" min="1" required>
          </div>
          <div class="col-md-8">
            <label for="details_position" class="form-label">Repère proche de la résidence</label>
            <input type="text" class="form-control" id="details_position" name="details_position" placeholder="Ex: Cocody derrière la RTI" required>
          </div>
        </div>

        <!-- Commodités -->
        <div class="mt-4">
          <label class="form-label fw-semibold">Commodités</label>
          <div class="row g-3">
            @php
              $commodites = [
                  "Climatisation","Wi-Fi","Télévision","Eau chaude","Parking",
                  "Cuisine équipée","Machine à laver","Sécurité 24h/24","Piscine",
                  "Balcon/Terrasse","Générateur","Caméras de surveillance","Animaux autorisés"
              ];
            @endphp

            @foreach ($commodites as $c)
              @php $id = 'comodite_' . md5($c); @endphp
              <div class="col-12 col-sm-6 col-md-4">
                <div class="form-check d-flex align-items-center gap-2 p-2 shadow-sm rounded bg-light">
                  <input
                    class="form-check-input mt-0"
                    type="checkbox"
                    name="autres_details[]"
                    value="{{ $c }}"
                    id="{{ $id }}"
                  >
                  <label class="form-check-label" for="{{ $id }}">
                    {{ $c }}
                  </label>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="mt-4">
          <label class="form-label">Coordonnées géographiques</label>
          <input type="text" class="form-control" name="geolocalisation" id="geolocalisation" placeholder="Latitude, Longitude ou lien Google Maps" required>
        </div>
      </fieldset>

      <!-- Images -->
      <fieldset class="mb-4">
        <legend>Images</legend>
        <label for="images" class="form-label">Ajouter des images (min. 1)</label>
        <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" required>
      </fieldset>

      <div class="d-flex justify-content-center mb-5">
        <button type="submit" class="btn btn-submit">Soumettre</button>
      </div>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
