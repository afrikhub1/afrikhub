<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Réserver à nouveau</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Poppins', sans-serif;
            color: #1a1a1a;
            padding-top: 80px;
        }
        .navbar {
            background-color: #1a1a1a;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            color: #ff7a00 !important;
            font-weight: 700;
            font-size: 1.4rem;
        }
        .nav-link {
            color: #fff !important;
            margin-right: 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            color: #ff7a00 !important;
            transform: scale(1.05);
        }
        .btn-header {
            background-color: #ff7a00;
            color: #fff;
            border-radius: 25px;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }
        .btn-header:hover {
            background-color: #fff;
            color: #1a1a1a;
        }
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .page-header h1 {
            color: #ff7a00;
            font-weight: 700;
        }
        .form-container {
            max-width: 600px;
            background: #fff;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            margin: 0 auto;
        }
        label {
            font-weight: 600;
        }
        .btn-submit {
            background-color: #ff7a00;
            border: none;
            padding: 12px 30px;
            color: white;
            font-weight: 700;
            border-radius: 25px;
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #e06a00;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">🏠 Afrik'Hub</a>
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item"><a class="nav-link" href="#">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Résidences</a></li>
                <li class="nav-item">
                    <a href="#" class="btn btn-header">Se connecter</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="page-header">
        <h1>Réserver à nouveau</h1>
        <p class="text-muted">Modifiez les détails de votre réservation et confirmez</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-container">
        <form action="{{ route('reservation.store', $reservation->residence_id) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="residence" class="form-label">Résidence</label>
                <input type="text" class="form-control" id="residence" name="residence"
                       value="{{ $reservation->residence->nom ?? 'N/A' }}" readonly />
            </div>

            <div class="mb-3">
                <label for="date_arrivee" class="form-label">Date d'arrivée</label>
                <input type="date" class="form-control" id="date_arrivee" name="date_arrivee"
                       value="{{ old('date_arrivee', $reservation->date_arrivee->format('Y-m-d')) }}" required />
            </div>

            <div class="mb-3">
                <label for="date_depart" class="form-label">Date de départ</label>
                <input type="date" class="form-control" id="date_depart" name="date_depart"
                       value="{{ old('date_depart', $reservation->date_depart->format('Y-m-d')) }}" required />
            </div>

            <div class="mb-3">
                <label for="personnes" class="form-label">Nombre de personnes</label>
                <input type="number" class="form-control" id="personnes" name="personnes" min="1"
                       value="{{ old('personnes', $reservation->personnes) }}" required />
            </div>

            <button type="submit" class="btn btn-submit w-100">Confirmer la réservation</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
