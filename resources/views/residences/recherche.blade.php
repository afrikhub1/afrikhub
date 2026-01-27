<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de Résidences - Afrik'Hub</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            /* Ta couleur de base appliquée partout */
            --primary-gradient: linear-gradient(135deg, #006d77, #00afb9);
            --primary-color: #006d77;
            --secondary-color: #1e293b; /* Remplacement du noir par un bleu ardoise */
            --light-gray: #f8fafc;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            color: #334155;
            margin: 0;
            padding: 0;
        }

        /* --- En-tête --- */
        .page-header {
            padding: 60px 0 40px;
            background-color: #ffffff;
        }

        .text-gradient {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* --- Formulaire de Recherche --- */
        .search-section {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 109, 119, 0.05);
            margin-bottom: 50px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 109, 119, 0.1);
        }

        .btn-search {
            background: var(--primary-gradient);
            color: white;
            font-weight: 600;
            border-radius: 12px;
            padding: 14px 30px;
            width: 100%;
            transition: all 0.3s;
            border: none;
        }

        .btn-search:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            color: white;
        }

        /* --- Cartes Résidences --- */
        .card-residence {
            border: 1px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: #fff;
        }

        .card-residence:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 109, 119, 0.1);
            border-color: transparent;
        }

        .img-container {
            position: relative;
            height: 230px;
        }

        .price-badge {
            position: absolute;
            bottom: 15px;
            left: 15px;
            background: #ffffff;
            color: var(--primary-color);
            padding: 6px 14px;
            border-radius: 10px;
            font-weight: 700;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .residence-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--secondary-color);
        }

        .amenity-item i {
            color: var(--primary-color);
        }

        .btn-view {
            background: var(--light-gray);
            color: var(--primary-color);
            text-align: center;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            display: block;
            transition: all 0.2s;
            border: 1px solid var(--border-color);
        }

        .btn-view:hover {
            background: var(--primary-gradient);
            color: #fff;
            border-color: transparent;
        }

        /* Badges de disponibilité harmonisés */
        .badge-dispo {
            font-size: 0.75rem;
            padding: 5px 12px;
            border-radius: 8px;
            display: inline-block;
            margin-bottom: 12px;
            font-weight: 600;
        }
        .dispo-ok { background-color: #dcfce7; color: #166534; }
        .dispo-soon { background-color: #fff7ed; color: #9a3412; }
        .dispo-today { background-color: #e0f2fe; color: #075985; }

    </style>
</head>
<body>

<div class="container">

    <header class="page-header text-center">
        <h1 class="fw-bold mb-2">Nos <span class="text-gradient">Résidences</span></h1>
        <p class="text-muted">Trouvez le confort qui vous ressemble</p>
         <a class="mt-3 d-inline-block text-decoration-none" href="{{route('accueil')}}">
            <button class="btn btn-sm btn-outline-secondary rounded-pill px-4"> 
                <i class="fas fa-arrow-left me-2"></i> Retour à l'accueil 
            </button>
        </a>
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
                    <label class="form-label">Où allez-vous ?</label>
                    <input type="text" name="ville" class="form-control" placeholder="Ville ou Quartier" value="{{ request('ville') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Prix Max (J)</label>
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
                    <button class="btn btn-search">
                        <i class="fa fa-search me-2"></i> RECHERCHER MA RÉSIDENCE
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
                // Protection contre le null pour éviter l'erreur isToday()
                $dateDispo = $residence->date_disponible_apres ? \Carbon\Carbon::parse($residence->date_disponible_apres) : null;
            @endphp

            <div class="col-lg-4 col-md-6 mb-5">
                <article class="card-residence h-100">
                    <div class="img-container">
                        <img src="{{ $firstImage }}" alt="{{ $residence->nom }}" loading="lazy">
                        <div class="price-badge">
                            {{ number_format($residence->prix_journalier, 0, ',', ' ') }} <small>FCFA/j</small>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- GESTION SÉCURISÉE DES DATES --}}
                        @if(!$dateDispo || $dateDispo->isPast())
                            <div class="badge-dispo dispo-ok">
                                <i class="fas fa-check-circle me-1"></i> Disponible immédiatement
                            </div>
                        @elseif ($dateDispo->isToday())
                            <div class="badge-dispo dispo-today">
                                <i class="fas fa-clock me-1"></i> Disponible aujourd'hui
                            </div>
                        @else
                            <div class="badge-dispo dispo-soon">
                                <i class="far fa-calendar-alt me-1"></i> Libre le {{ $dateDispo->translatedFormat('d M Y') }}
                            </div>
                        @endif

                        <h2 class="residence-title mb-1">{{ $residence->nom }}</h2>
                        <p class="location-text mb-3">
                            <i class="fas fa-map-marker-alt me-1"></i> {{ $residence->ville }}, {{ $residence->quartier }}
                        </p>

                        <div class="amenities">
                            <div class="amenity-item">
                                <i class="fa fa-bed"></i> {{ $residence->nombre_chambres }} Ch.
                            </div>
                            <div class="amenity-item">
                                <i class="fa fa-couch"></i> {{ $residence->nombre_salons }} Sal.
                            </div>
                            <div class="amenity-item">
                                <i class="fa fa-shield-alt"></i> Sécurisé
                            </div>
                        </div>

                        <a href="{{ route('details', $residence->id) }}" class="btn btn-view mt-2 text-decoration-none">
                            Détails de l'offre
                        </a>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12 py-5 text-center">
                <div class="mb-3"><i class="fas fa-search fa-3x text-light-gray"></i></div>
                <p class="text-muted">Aucune résidence ne correspond à vos critères actuels.</p>
                <a href="{{ route('residences.recherche') }}" class="btn btn-link text-primary">Effacer tous les filtres</a>
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