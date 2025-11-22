<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise en ligne résidence</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            background: #f5f5f5;
        }
        .card {
            border-radius: 12px;
        }
        #map {
            height: 300px;
            border-radius: 10px;
        }
    </style>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>

<body>

<div class="container mt-4 mb-5">
    <div class="card shadow p-4">
        <h3 class="mb-4 text-center">Mettre une résidence en ligne</h3>

        <form action="mise_en_ligne.php" method="POST" enctype="multipart/form-data">

            <!-- Nom résidence -->
            <div class="mb-3">
                <label class="form-label">Nom de la résidence</label>
                <input type="text" name="nom_residence" class="form-control" required>
            </div>

            <!-- Pays -->
            <div class="mb-3">
                <label class="form-label">Pays</label>
                <input type="text" name="pays" class="form-control" required>
            </div>

            <!-- Ville -->
            <div class="mb-3">
                <label class="form-label">Ville</label>
                <input type="text" name="ville" class="form-control" required>
            </div>

            <!-- Type résidence -->
            <div class="mb-3">
                <label class="form-label">Type</label>
                <select name="type" class="form-control" required>
                    <option value="" disabled selected>Choisir</option>
                    <option>Appartement</option>
                    <option>Studio</option>
                    <option>Villa</option>
                </select>
            </div>

            <!-- Chambres -->
            <div class="mb-3">
                <label class="form-label">Nombre de chambres</label>
                <input type="number" name="nb_chambres" class="form-control" required>
            </div>

            <!-- Salons -->
            <div class="mb-3">
                <label class="form-label">Nombre de salons</label>
                <input type="number" name="nb_salons" class="form-control" required>
            </div>

            <!-- Prix -->
            <div class="mb-3">
                <label class="form-label">Prix par nuit</label>
                <input type="number" name="prix" class="form-control" required>
            </div>

            <!-- Description -->
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>

            <!-- Images -->
            <div class="mb-3">
                <label class="form-label">Images de la résidence</label>
                <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
            </div>

            <hr>

            <!-- Adresse auto -->
            <div class="mb-3">
                <label class="form-label">Adresse complète</label>
                <input type="text" id="adresse" name="adresse" class="form-control" readonly required>
            </div>

            <!-- Repère auto -->
            <div class="mb-3">
                <label class="form-label">Repère proche</label>
                <input type="text" id="details_position" name="details_position" class="form-control" readonly required>
            </div>

            <!-- Latitude/Longitude hidden -->
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">

            <!-- Carte -->
            <label class="form-label mb-1">Clique sur la carte pour sélectionner l’emplacement</label>
            <div id="map"></div>

            <hr>

            <button type="submit" class="btn btn-primary w-100 mt-3">Mettre en ligne</button>

        </form>
    </div>
</div>

<!-- JS Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
// Initialisation carte (Abidjan par défaut)
var map = L.map('map').setView([5.345317, -4.024429], 13);

// OpenStreetMap Tiles
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19
}).addTo(map);

var marker;

// Mise à jour automatique des champs
function updateFields(lat, lng) {
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;

    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json&accept-language=fr`)
        .then(response => response.json())
        .then(data => {
            if (data && data.address) {
                document.getElementById('adresse').value = data.display_name;

                let repere =
                    data.address.neighbourhood ||
                    data.address.suburb ||
                    data.address.village ||
                    data.address.town ||
                    data.address.city ||
                    "Repère non disponible";

                document.getElementById('details_position').value = repere;
            }
        });
}

// Clic sur la carte
map.on('click', function(e) {
    var lat = e.latlng.lat;
    var lng = e.latlng.lng;

    if (marker) {
        map.removeLayer(marker);
    }

    marker = L.marker([lat, lng]).addTo(map);
    updateFields(lat, lng);
});
</script>

</body>
</html>
