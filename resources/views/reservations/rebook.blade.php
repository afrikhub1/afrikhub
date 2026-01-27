<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Réserver à nouveau — Afrik'Hub</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        :root {
            --brand-primary: #006d77;
            --brand-secondary: #00afb9;
            --brand-light: #f0fdfa;
            --slate-800: #1e293b;
            --slate-500: #64748b;
        }

        body {
            background-color: #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--slate-800);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .form-container {
            max-width: 550px;
            width: 100%;
            background: #ffffff;
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 109, 119, 0.1);
            border: 1px solid rgba(0, 109, 119, 0.05);
        }

        .header-icon {
            width: 70px;
            height: 70px;
            background: var(--brand-light);
            color: var(--brand-primary);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 20px;
        }

        h1 {
            font-weight: 800;
            font-size: 1.8rem;
            text-align: center;
            color: var(--slate-800);
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: var(--slate-500);
            font-size: 0.95rem;
            margin-bottom: 35px;
        }

        label {
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--slate-500);
            margin-bottom: 8px;
            display: block;
            margin-left: 5px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group-custom i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--brand-secondary);
            font-size: 1.1rem;
            z-index: 10;
        }

        .form-control {
            border-radius: 15px;
            padding: 14px 15px 14px 50px;
            border: 2px solid #f1f5f9;
            background-color: #f8fafc;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: var(--brand-secondary);
            box-shadow: 0 0 0 4px rgba(0, 175, 185, 0.1);
            outline: none;
        }

        .form-control[readonly] {
            background-color: #f1f5f9;
            color: var(--slate-500);
            cursor: not-allowed;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
            border: none;
            padding: 16px;
            color: white;
            font-weight: 800;
            font-size: 1rem;
            border-radius: 18px;
            width: 100%;
            margin-top: 20px;
            box-shadow: 0 10px 20px -5px rgba(0, 109, 119, 0.3);
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px -5px rgba(0, 109, 119, 0.4);
            filter: brightness(1.1);
        }

        .alert-custom {
            border-radius: 15px;
            border: none;
            background-color: #fff1f2;
            color: #be123c;
            font-size: 0.85rem;
            padding: 15px;
            margin-bottom: 25px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: var(--slate-500);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            transition: color 0.3s;
        }

        .back-link:hover { color: var(--brand-primary); }
    </style>
</head>
<body>

<div class="form-container">
    <div class="header-icon">
        <i class="fas fa-arrows-rotate"></i>
    </div>
    
    <h1>Réserver à nouveau</h1>
    <p class="subtitle">Ajustez vos informations pour ce nouveau séjour.</p>

    @if($errors->any())
        <div class="alert alert-custom">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-circle-exclamation me-2"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reservation.store', $reservation->residence_id) }}" method="POST">
        @csrf

        <label>Résidence</label>
        <div class="input-group-custom">
            <i class="fas fa-hotel"></i>
            <input type="text" class="form-control" value="{{ $reservation->residence->nom ?? 'N/A' }}" readonly />
        </div>

        <div class="row">
            <div class="col-md-6">
                <label>Date d'arrivée</label>
                <div class="input-group-custom">
                    <i class="fas fa-calendar-check"></i>
                    <input type="date" class="form-control" name="date_arrivee" 
                           value="{{ old('date_arrivee', $reservation->date_arrivee->format('Y-m-d')) }}" required />
                </div>
            </div>
            <div class="col-md-6">
                <label>Date de départ</label>
                <div class="input-group-custom">
                    <i class="fas fa-calendar-xmark"></i>
                    <input type="date" class="form-control" name="date_depart" 
                           value="{{ old('date_depart', $reservation->date_depart->format('Y-m-d')) }}" required />
                </div>
            </div>
        </div>

        <label>Nombre de personnes</label>
        <div class="input-group-custom">
            <i class="fas fa-user-group"></i>
            <input type="number" class="form-control" name="personnes" min="1"
                   value="{{ old('personnes', $reservation->personnes) }}" required />
        </div>

        <button type="submit" class="btn btn-submit">
            CONFIRMER LA RÉSERVATION
        </button>

        <a href="javascript:history.back()" class="back-link">
            <i class="fas fa-arrow-left me-1"></i> Retourner en arrière
        </a>
    </form>
</div>

</body>
</html>