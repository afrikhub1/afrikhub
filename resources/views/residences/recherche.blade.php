<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>recherche de résidences</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
            url('/images/bg.jpg') center/cover no-repeat;
        }

        .search-form {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(10px);
            border-radius: 18px;
        }

        .card-residence img {
            height: 220px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <!-- FORMULAIRE -->
    <div class="search-form p-4 shadow mb-5">
        <form method="GET" action="{{ route('residences.recherche') }}">
            <div class="row g-3">

                <div class="col-md-2">
                    <label class="form-label">chambres</label>
                    <input type="number" name="chambres" class="form-control" value="{{ request('chambres') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">salons</label>
                    <input type="number" name="salons" class="form-control" value="{{ request('salons') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">ville</label>
                    <input type="text" name="ville" class="form-control" value="{{ request('ville') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">quartier / commune</label>
                    <input type="text" name="quartier" class="form-control" value="{{ request('quartier') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">prix max</label>
                    <input type="number" name="prix" class="form-control" value="{{ request('prix') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">type</label>
                    <select name="type" class="form-select">
                        <option value="">tous</option>
                        @foreach(['studio','appartement','villa','duplex'] as $type)
                            <option value="{{ $type }}" {{ request('type')==$type?'selected':'' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 text-end">
                    <button class="btn btn-primary px-4">
                        <i class="fa fa-search"></i> rechercher
                    </button>
                </div>

            </div>
        </form>
    </div>

    <!-- RESULTATS -->
    <div class="row">

        @forelse ($residences as $residence)

            @php
                // Si img est une chaîne JSON, on la décode
                $images = is_string($residence->img) ? json_decode($residence->img, true) : ($residence->img ?? []);

                // Première image : S3 ou placeholder
                $firstImage = count($images)
                    ? \Illuminate\Support\Facades\Storage::disk('s3')->url($images[0])
                    : asset('assets/images/placeholder.jpg');

                // Date de disponibilité
                $dateDispo = $residence->date_disponible_apres
                    ? \Carbon\Carbon::parse($residence->date_disponible_apres)
                    : null;
            @endphp


            <div class="col-md-4 mb-4">
                <div class="card card-residence shadow border-0 h-100">

                    <img src="{{ $firstImage }}"
                         alt="image {{ $residence->nom }}"
                         loading="lazy">

                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold">{{ $residence->nom }}</h5>

                        <p class="text-muted mb-1">
                            {{ $residence->ville }} - {{ $residence->quartier }}
                        </p>

                        <p class="mb-1">
                            {{ $residence->nombre_chambres }} chambres ·
                            {{ $residence->nombre_salons }} salons
                        </p>

                        <p class="small text-muted">
                            {{ Str::limit($residence->details, 80) }}
                        </p>

                        <strong class="text-primary mb-2">
                            {{ number_format($residence->prix_journalier, 0, ',', ' ') }} FCFA / jour
                        </strong>

                        @if($dateDispo)
                            <span class="badge bg-info mb-3">
                                dispo le {{ $dateDispo->translatedFormat('d F Y') }}
                            </span>
                        @endif

                        <a href="{{ route('details', $residence->id) }}"
                           class="btn btn-outline-dark mt-auto rounded-pill">
                            voir détails <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>

                </div>
            </div>

        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    aucune résidence trouvée
                </div>
            </div>
        @endforelse

    </div>

    <!-- PAGINATION -->
    <div class="d-flex justify-content-center mt-4">
        {{ $residences->withQueryString()->links() }}
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
