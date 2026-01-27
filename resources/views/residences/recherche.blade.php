<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de Résidences</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary: #006d77;
            --accent: #00afb9;
            --gradient: linear-gradient(135deg, #006d77, #00afb9);
            --dark: #0f172a;
            --slate-500: #64748b;
            --slate-100: #f1f5f9;
            --radius-lg: 18px;
            --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: var(--dark);
            margin: 0;
            padding: 0;
        }

        /* --- En-tête --- */
        .page-header {
            padding: 80px 0 40px;
            background: radial-gradient(circle at top right, #e2e8f0, transparent);
        }

        .page-header h1 {
            font-weight: 800;
            letter-spacing: -0.02em;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
        }

        .btn-outline-dark {
            border-radius: 12px;
            padding: 10px 24px;
            font-weight: 600;
            border: 2px solid var(--dark);
            transition: 0.3s;
        }

        .btn-outline-dark:hover {
            background: var(--dark);
            transform: translateY(-2px);
        }

        /* --- Formulaire de Recherche --- */
        .search-section {
            background: #ffffff;
            border: none;
            border-radius: 24px;
            padding: 35px;
            box-shadow: var(--shadow-xl);
            margin-top: -20px;
            margin-bottom: 60px;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--slate-500);
            margin-bottom: 10px;
        }

        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid var(--slate-100);
            padding: 12px 16px;
            background-color: var(--slate-100);
            font-weight: 500;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-control:focus, .form-select:focus {
            background-color: #fff;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(0, 175, 185, 0.1);
        }

        .btn-search {
            background: var(--gradient);
            color: white;
            font-weight: 700;
            border-radius: 14px;
            padding: 16px;
            width: 100%;
            transition: 0.3s;
            border: none;
            box-shadow: 0 10px 15px -3px rgba(0, 109, 119, 0.3);
        }

        .btn-search:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 25px -5px rgba(0, 109, 119, 0.4);
            color: white;
        }

        /* --- Cartes Résidences --- */
        .card-residence {
            border: none;
            border-radius: 24px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: #fff;
            box-shadow: var(--shadow-sm);
        }

        .card-residence:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-xl);
        }

        .img-container {
            position: relative;
            height: 240px;
            overflow: hidden;
        }

        .card-residence img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.6s;
        }

        .card-residence:hover img {
            transform: scale(1.1);
        }

        .price-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            color: var(--primary);
            padding: 8px 16px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }

        .card-body {
            padding: 25px;
        }

        .residence-title {
            font-size: 1.25rem;
            font-weight: 800;
            margin-bottom: 8px;
            color: var(--dark);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .location-text {
            font-size: 0.9rem;
            color: var(--slate-500);
            margin-bottom: 20px;
            font-weight: 500;
        }

        .amenities {
            display: flex;
            gap: 12px;
            padding: 15px 0;
            border-top: 1px solid var(--slate-100);
            margin-bottom: 20px;
        }

        .amenity-item {
            font-size: 0.85rem;
            color: var(--dark);
            font-weight: 700;
            background: var(--slate-100);
            padding: 6px 12px;
            border-radius: 8px;
        }

        .amenity-item i {
            color: var(--accent);
            margin-right: 6px;
        }

        .btn-view {
            background: var(--dark);
            color: #fff;
            text-align: center;
            text-decoration: none;
            padding: 14px;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 700;
            display: block;
            transition: 0.3s;
        }

        .btn-view:hover {
            background: var(--primary);
            color: #fff;
            transform: scale(1.02);
        }

        .badge-dispo {
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background-color: #dcfce7;
            color: #166534;
            padding: 6px 12px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            margin-bottom: 12px;
        }
        
        .badge-dispo.today { background: #fef9c3; color: #854d0e; }
        .badge-dispo.future { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>

<div class="container">

    <header class="page-header text-center">
        <h1 class="display-5">Nos Résidences</h1>
        <p class="text-muted fw-medium">L'exceptionnel à portée de clic pour vos séjours meublés</p>
         <a class="d-flex text-decoration-none justify-content-center mt-3" href="{{route('accueil')}}">
            <button class="btn btn-outline-dark">
                <i class="fas fa-arrow-left me-2"></i> Retour à l'accueil 
            </button>
        </a>
    </header>

    <div class="search-section">
        <form method="GET" action="{{ route('residences.recherche') }}">
            <div class="row g-3 align-items-end">
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
                    <div class="input-group">
                        <span class="input-group-text border-0 bg-transparent ps-0"><i class="fas fa-location-dot text-accent"></i></span>
                        <input type="text" name="ville" class="form-control" placeholder="Où allez-vous ?" value="{{ request('ville') }}">
                    </div>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Prix Max (FCFA)</label>
                    <input type="number" name="prix" class="form-control" placeholder="Illimité" value="{{ request('prix') }}">
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
                        <i class="fa fa-sliders me-2"></i> FILTRER LES RÉSULTATS
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

            <div class="col-lg-4 col-md-6 mb-5">
                <article class="card-residence h-100">
                    <div class="img-container">
                        <img src="{{ $firstImage }}" alt="{{ $residence->nom }}" loading="lazy">
                        <div class="price-badge">
                            {{ number_format($residence->prix_journalier, 0, ',', ' ') }} <small style="font-size: 0.6rem">FCFA</small>
                        </div>
                    </div>

                    <div class="card-body">
                        @if(!$dateDispo || $dateDispo->isPast())
                            <div class="badge-dispo">
                                <i class="fas fa-check-circle me-2"></i> Disponible
                            </div>
                        @elseif ($dateDispo->isToday())
                            <div class="badge-dispo today">
                                <i class="fas fa-clock me-2"></i> Libre aujourd'hui
                            </div>
                        @else
                            <div class="badge-dispo future">
                                <i class="fas fa-calendar-days me-2"></i> Libre le {{ $dateDispo->translatedFormat('d M') }}
                            </div>
                        @endif

                        <h2 class="residence-title">{{ $residence->nom }}</h2>
                        <p class="location-text">
                            <i class="fas fa-map-marker-alt me-1 text-accent"></i> {{ $residence->ville }}, {{ $residence->quartier }}
                        </p>

                        <div class="amenities">
                            <div class="amenity-item">
                                <i class="fa fa-bed"></i> {{ $residence->nombre_chambres }}
                            </div>
                            <div class="amenity-item">
                                <i class="fa fa-couch"></i> {{ $residence->nombre_salons }}
                            </div>
                            <div class="amenity-item">
                                <i class="fa fa-shield-halved"></i> Sécurisé
                            </div>
                        </div>

                        <a href="{{ route('details', $residence->id) }}" class="btn btn-view">
                            Voir les détails <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12 py-5 text-center">
                <div class="mb-4">
                    <i class="fas fa-house-circle-exclamation fa-4x text-slate-100"></i>
                </div>
                <h4 class="fw-bold">Aucun résultat</h4>
                <p class="text-muted">Essayez d'élargir vos critères de recherche.</p>
                <a href="{{ url()->current() }}" class="btn btn-dark rounded-pill px-4 mt-2">Réinitialiser</a>
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