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
      color: #000000;
      font-family: Arial, sans-serif;
    }

    header {
      background-color: #FFA500;
      color: #000000;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    header h1 {
      margin: 0;
      font-weight: bold;
    }

    .menu-links a {
      text-decoration: none;
      color: #000000;
      font-weight: 600;
      margin: 0 0.5rem;
    }

    .menu-links a:hover {
      color: #FFFFFF;
    }

    fieldset {
      background-color: #FFFFFF;
      border: 2px solid #FFA500;
    }

    legend {
      font-weight: bold;
      color: #FFA500;
    }

    .form-label {
      font-weight: 600;
      color: #000000;
    }

    .form-control, .form-select {
      border: 1px solid #FFA500;
    }

    .form-control:focus, .form-select:focus {
      border-color: #FFA500;
      box-shadow: 0 0 5px rgba(255,165,0,0.5);
    }

    .btn-submit {
      background-color: #FFA500;
      color: #FFFFFF;
      border: none;
    }

    .btn-submit:hover {
      background-color: #e69500;
    }

    .container h2 {
      color: #FFA500;
      margin-bottom: 1.5rem;
      text-align: center;
    }

    .form-check-label {
      color: #000000;
    }
  </style>
</head>

<body>
  <header class="container-fluid">
    <h1>Afrik'Hub</h1>
    <div class="menu-links">
      <a href="#">Accueil</a>
      <a href="#">Pro</a>
      <a href="#">Utilisateur</a>
      <a href="#">Recherche</a>
      <a href="#">Déconnexion</a>
    </div>
  </header>

  <div class="container mt-5">
    <h2>Mettre votre résidence en location</h2>

    <form action="{{ route('residences.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

      <fieldset class="mb-4 p-3 rounded">
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

      <fieldset class="mb-4 p-3 rounded">
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

        <div class="mt-3">
          <label class="form-label">Commodités</label>
          <div class="row g-2">
            <div class="col-md-4"><div class="form-check"><input class="form-check-input" type="checkbox" id="climatisation"><label class="form-check-label" for="climatisation">Climatisation</label></div></div>
            <div class="col-md-4"><div class="form-check"><input class="form-check-input" type="checkbox" id="wifi"><label class="form-check-label" for="wifi">Wi-Fi</label></div></div>
            <div class="col-md-4"><div class="form-check"><input class="form-check-input" type="checkbox" id="television"><label class="form-check-label" for="television">Télévision</label></div></div>
            <!-- Ajoutez d'autres commodités si nécessaire -->
          </div>
        </div>

        <div class="mt-4">
          <label class="form-label">Coordonnées géographiques</label>
          <input type="text" class="form-control" name="geolocalisation" id="geolocalisation" placeholder="Latitude, Longitude ou lien Google Maps" required>
        </div>
      </fieldset>

      <fieldset class="mb-4 p-3 rounded">
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
