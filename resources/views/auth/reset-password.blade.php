<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialiser le mot de passe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            border-radius: 1rem;
            padding: 2rem;
            max-width: 450px;
            width: 100%;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            background-color: #ffffff;
        }
        h2 {
            color: #333;
        }
        .btn-primary {
            background: #667eea;
            border: none;
        }
        .btn-primary:hover {
            background: #5a67d8;
        }
        .btn-back {
            margin-bottom: 1rem;
            color: #667eea;
            text-decoration: none;
        }
        .btn-back:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="card">
    <!-- Bouton retour -->
    <a href="{{ url('/login') }}" class="btn-back">&larr; Retour à la connexion</a>

    <h2 class="text-center mb-4">Réinitialiser le mot de passe</h2>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <!-- On utilise les variables passées depuis le controller -->
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                id="email"
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                name="email"
                value="{{ old('email', $email) }}"
                required
                autofocus
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nouveau mot de passe</label>
            <input
                id="password"
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                name="password"
                required
            >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
            <input
                id="password_confirmation"
                type="password"
                class="form-control"
                name="password_confirmation"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary w-100">Réinitialiser le mot de passe</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
