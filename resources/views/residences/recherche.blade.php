<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de Résidences</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #ff8a00;
            --secondary-color: #0f172a;
            --light-gray: #f8fafc;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }

        /* --- En-tête --- */
        .page-header {
            padding: 60px 0 40px;
            background-color: #ffffff;
        }

        /* --- Formulaire de Recherche (Style Épuré) --- */
        .search-section {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            margin-bottom: 50px;
        }

        .form-label {
            font-weight: 500;
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid var(--border-color);
            padding: 12px;
            background-color: var(--light-gray);
            transition: all 0.2s;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: var(--primary-color);
            box-shadow: none;
        }

        .btn-search {
            background: var(--secondary-color);
            color: white;
            font-weight: 600;
            border-radius: 10px;
            padding: 12px 30px;
            width: 100%;
            transition: all 0.3s;
            border: none;
        }

        .btn-search:hover {
            background: #000;
            transform: translateY(-2px);
        }

        /* --- Cartes Résidences --- */
        .card-residence {
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: #fff;
        }

        .card-residence:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
            border-color: transparent;
        }

        .img-container {
            position: relative;
            height: 220px;
        }

        .card-residence img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .price-badge {
            position: absolute;
            bottom: 15px;
            left: 15px;
            background: #ffffff;
            color: var(--secondary-color);
            padding: 5px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.95rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .card-body {
            padding: 20px;
        }

        .residence-title {
            font-size: 1.15rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--secondary-color);
        }

        .location-text {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 15px;
        }

        .amenities {
            display: flex;
            gap: 15px;
            padding: 12px 0;
            border-top: 1px solid var(--light-gray);
            margin-bottom: 15px;
        }

        .amenity-item {
            font-size: 0.85rem;
            color: #475569;
            font-weight: 500;
        }

        .amenity-item i {
            color: var(--primary-color);
            margin-right: 5px;
        }

        .btn-view {
            background: var(--light-gray);
            color: var(--secondary-color);
            text-align: center;
            text-decoration: none;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            display: block;
            transition: all 0.2s;
        }

        .btn-view:hover {
            background: var(--secondary-color);
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container">

    <header class="page-header text-center">
        <h1 class="fw-bold">Nos Résidences</h1>
        <p class="text-muted">Explorez nos meilleures offres de logements meublés</p>
         <a class="d-flex text-decoration-none justify-content-center" href="{{route('accueil')}}"><button class="btn btn-outline-dark" > Retour à l'accueil </button></a>
    </header>

    <div class="search-section">
        <form method="GET" action="{{ route('residences.recherche') }}">
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">Chambres</label>
                    <input type="number" name="chambres" class="form-control" placeholder="0" value="{{ request('chambres') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Salons</label>
                    <input type="number" name="salons" class="form-control" placeholder="0" value="{{ request('salons') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Ville ou Quartier</label>
                    <input type="text" name="ville" class="form-control" placeholder="Où allez-vous ?" value="{{ request('ville') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Prix Max</label>
                    <input type="number" name="prix" class="form-control" placeholder="FCFA" value="{{ request('prix') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Type de bien</label>
                    <select name="type" class="form-select">
                        <option value="">Tous les types</option>
                        @foreach(['studio','appartement','villa','duplex'] as $type)
                            <option value="{{ $type }}" {{ request('type')==$type?'selected':'' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mt-4">
                    <button class="btn btn-search text-uppercase">
                        <i class="fa fa-search me-2"></i> Filtrer les résultats
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
        @forelse ($residences as $residence)
            @php
                $images = is_string($residence->img) ? json_decode($residence->img, true) : ($residence->img ?? []);
                $firstImage = $images[0] ?? asset('assets/images/placeholder.jpg');
                $dateDispo = $residence->date_disponible_apres ? \Carbon\Carbon::parse($residence->date_disponible_apres) : null;
                
            @endphp

            <div class="col-lg-4 col-md-6 mb-4">
                <article class="card-residence h-100">
                    <div class="img-container">
                        <img src="{{ $firstImage }}" alt="{{ $residence->nom }}" loading="lazy">
                        <div class="price-badge">
                            {{ number_format($residence->prix_journalier, 0, ',', ' ') }} FCFA
                        </div>
                    </div>

                    <div class="card-body">
                        @if(!$dateDispo || $dateDispo->isPast())
                            <div class="badge-dispo">
                                <i class="far fa-calendar-alt me-1 bg-success"></i> Disponible
                            </div>
                        @elseif ($dateDispo->isToday())
                            <div class="badge-dispo">
                                <i class="far fa-calendar-alt me-1 bg-success"></i> Disponible aujourd'hui
                            </div>
                        @else
                            <div class="badge-dispo bg">
                                <i class="far fa-calendar-alt me-1 bg-danger"></i> Libre le {{ $dateDispo->translatedFormat('d M Y') }}
                            </div>
                        @endif

                        <h2 class="residence-title">{{ $residence->nom }}</h2>
                        <p class="location-text">
                            <i class="fas fa-map-marker-alt me-1"></i> {{ $residence->ville }}, {{ $residence->quartier }}
                        </p>

                        <div class="amenities">
                            <div class="amenity-item">
                                <i class="fa fa-bed"></i> {{ $residence->nombre_chambres }} Ch.
                            </div>
                            <div class="amenity-item">
                                <i class="fa fa-couch"></i> {{ $residence->nombre_salons }} Sal.
                            </div>
                        </div>

                        <a href="{{ route('details', $residence->id) }}" class="btn btn-view">
                            Voir la fiche complète
                        </a>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12 py-5 text-center">
                <p class="text-muted">Aucune résidence trouvée pour ces critères.</p>
                <a href="{{ url()->current() }}" class="btn btn-outline-secondary btn-sm">Réinitialiser</a>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center py-5">
        {{ $residences->withQueryString()->links() }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
