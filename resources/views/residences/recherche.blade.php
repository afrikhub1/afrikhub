<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de Résidences</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #ff8a00;
            --secondary-color: #0b1220;
            --glass-bg: rgba(255, 255, 255, 0.9);
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(rgba(11, 18, 32, 0.7), rgba(11, 18, 32, 0.7)),
            url('/images/bg.jpg') center/cover no-repeat fixed;
            color: #333;
        }

        /* --- Formulaire de Recherche --- */
        .search-container {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin-top: -20px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--secondary-color);
            margin-left: 5px;
        }

        .form-control, .form-select {
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(255, 138, 0, 0.15);
        }

        .btn-search {
            background: var(--primary-color);
            border: none;
            color: white;
            font-weight: 700;
            border-radius: 12px;
            transition: transform 0.2s;
        }

        .btn-search:hover {
            background: #e67e00;
            transform: translateY(-2px);
        }

        /* --- Cartes Résidences --- */
        .card-residence {
            transition: all 0.3s cubic-bezier(.25,.8,.25,1);
            border-radius: 20px !important;
            overflow: hidden;
            background: white;
        }

        .card-residence:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2) !important;
        }

        .img-container {
            position: relative;
            overflow: hidden;
        }

        .card-residence img {
            height: 240px;
            width: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .card-residence:hover img {
            transform: scale(1.1);
        }

        .price-tag {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--primary-color);
            color: white;
            padding: 6px 15px;
            border-radius: 30px;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .residence-type {
            color: var(--primary-color);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .card-body {
            padding: 1.5rem;
        }

        .info-icons {
            font-size: 0.9rem;
            color: #666;
            margin: 10px 0;
        }

        .btn-details {
            border: 2px solid var(--secondary-color);
            color: var(--secondary-color);
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s;
        }

        .btn-details:hover {
            background: var(--secondary-color);
            color: white;
        }

        /* Badge dispo */
        .badge-dispo {
            background-color: rgba(0, 180, 162, 0.1);
            color: #00b4a2;
            border: 1px solid #00b4a2;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <div class="text-center text-white mb-5">
        <h1 class="fw-bold display-4">Trouvez votre séjour idéal</h1>
        <p class="lead opacity-75">Découvrez nos résidences de luxe et appartements meublés</p>
    </div>

    <div class="search-container p-4 shadow-lg mb-5">
        <form method="GET" action="{{ route('residences.recherche') }}">
            <div class="row g-3">
                <div class="col-md-2 col-6">
                    <label class="form-label"><i class="fa fa-bed me-1"></i> Chambres</label>
                    <input type="number" name="chambres" class="form-control" placeholder="Ex: 2" value="{{ request('chambres') }}">
                </div>

                <div class="col-md-2 col-6">
                    <label class="form-label"><i class="fa fa-couch me-1"></i> Salons</label>
                    <input type="number" name="salons" class="form-control" placeholder="Ex: 1" value="{{ request('salons') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label"><i class="fa fa-map-marker-alt me-1"></i> Ville</label>
                    <input type="text" name="ville" class="form-control" placeholder="Abidjan..." value="{{ request('ville') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label"><i class="fa fa-location-arrow me-1"></i> Quartier</label>
                    <input type="text" name="quartier" class="form-control" placeholder="Ex: Cocody" value="{{ request('quartier') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label"><i class="fa fa-tag me-1"></i> Prix Max</label>
                    <input type="number" name="prix" class="form-control" placeholder="FCFA" value="{{ request('prix') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label"><i class="fa fa-home me-1"></i> Type</label>
                    <select name="type" class="form-select">
                        <option value="">Tous les types</option>
                        @foreach(['studio','appartement','villa','duplex'] as $type)
                            <option value="{{ $type }}" {{ request('type')==$type?'selected':'' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mt-4 text-center">
                    <button class="btn btn-search px-5 py-2 text-uppercase">
                        <i class="fa fa-search me-2"></i> Lancer la recherche
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
                <div class="card card-residence shadow-sm border-0 h-100">
                    <div class="img-container">
                        <img src="{{ $firstImage }}" alt="{{ $residence->nom }}" loading="lazy">
                        <div class="price-tag">
                            {{ number_format($residence->prix_journalier, 0, ',', ' ') }} <small>FCFA</small>
                        </div>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <div class="residence-type mb-1">{{ $residence->type ?? 'Résidence' }}</div>
                        <h5 class="fw-bold mb-1 text-dark">{{ $residence->nom }}</h5>

                        <p class="text-muted small mb-2">
                            <i class="fa fa-map-marker-alt text-danger me-1"></i> {{ $residence->ville }}, {{ $residence->quartier }}
                        </p>

                        <div class="info-icons d-flex justify-content-between border-top border-bottom py-2 my-2">
                            <span><i class="fa fa-bed me-1"></i> {{ $residence->nombre_chambres }} Ch.</span>
                            <span><i class="fa fa-couch me-1"></i> {{ $residence->nombre_salons }} Sal.</span>
                            <span><i class="fa fa-expand me-1"></i> {{ $residence->superficie ?? '--' }}m²</span>
                        </div>

                        <p class="small text-muted mb-3">
                            {{ Str::limit($residence->details, 70) }}
                        </p>

                        @if($dateDispo)
                            <div class="mb-3">
                                <span class="badge badge-dispo p-2 w-100">
                                    <i class="fa fa-calendar-check me-1"></i> Disponible le {{ $dateDispo->translatedFormat('d F Y') }}
                                </span>
                            </div>
                        @endif

                        <a href="{{ route('details', $residence->id) }}" class="btn btn-details mt-auto">
                            Voir les détails <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="bg-white p-5 rounded-4 shadow-sm text-center">
                    <i class="fa fa-search-minus fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Aucune résidence ne correspond à vos critères</h4>
                    <a href="{{ url()->current() }}" class="btn btn-link text-primary">Réinitialiser les filtres</a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $residences->withQueryString()->links() }}
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
