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
            background: linear-gradient(
                rgba(0,0,0,0.4),
                rgba(0,0,0,0.4)
            ),
            url('/images/bg.jpg') center/cover no-repeat;
        }

        .search-form {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(10px);
            border-radius: 18px;
        }

        .search-form label {
            font-size: 0.9rem;
            color: #333;
        }

        .card-residence img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <!-- FORMULAIRE DE RECHERCHE -->
    <div class="search-form p-4 shadow mb-5">

        <form method="GET" action="{{ route('residences.recherche') }}">

            <div class="row g-3">

                <div class="col-md-2">
                    <label class="form-label">chambres</label>
                    <input type="number" name="chambres" class="form-control"
                           value="{{ request('chambres') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">salons</label>
                    <input type="number" name="salons" class="form-control"
                           value="{{ request('salons') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">ville</label>
                    <input type="text" name="ville" class="form-control"
                           value="{{ request('ville') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">quartier / commune</label>
                    <input type="text" name="quartier" class="form-control"
                           value="{{ request('quartier') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">prix max</label>
                    <input type="number" name="prix" class="form-control"
                           value="{{ request('prix') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label">type de maison</label>
                    <select name="type" class="form-select">
                        <option value="">tous</option>
                        <option value="studio" {{ request('type')=='studio' ? 'selected' : '' }}>studio</option>
                        <option value="appartement" {{ request('type')=='appartement' ? 'selected' : '' }}>appartement</option>
                        <option value="villa" {{ request('type')=='villa' ? 'selected' : '' }}>villa</option>
                        <option value="duplex" {{ request('type')=='duplex' ? 'selected' : '' }}>duplex</option>
                    </select>
                </div>

                <div class="col-12 text-end mt-3">
                    <button class="btn btn-primary px-4">
                        <i class="fa fa-search"></i> rechercher
                    </button>
                </div>

            </div>

        </form>

    </div>

    <!-- RESULTATS -->
    <div class="row">

        @forelse ($residences as $res)
            <div class="col-md-4 mb-4">
                <div class="card card-residence shadow border-0">

                    <img src="{{ asset('storage/'.$res->image_principale) }}" alt="image résidence">

                    <div class="card-body">
                        <h5 class="mb-1">{{ $res->nom_residence }}</h5>

                        <p class="text-muted mb-1">
                            {{ $res->ville }} - {{ $res->quartier }}
                        </p>

                        <p class="mb-1">
                            {{ $res->nombre_chambres }} chambres ·
                            {{ $res->nombre_salons }} salons
                        </p>

                        <strong class="text-primary">
                            {{ number_format($res->prix) }} FCFA
                        </strong>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
