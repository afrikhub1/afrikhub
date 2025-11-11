{{-- resources/views/pages/messages.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Message</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body, html {
            height: 100%;
        }
        .message-container {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }
        .alert {
            font-size: 1.3rem;
            max-width: 400px;
        }
        .btn-return {
            margin-top: 30px;
            padding: 10px 40px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="container message-container">
        @if(session('success'))
            <div class="alert alert-success shadow-sm rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger shadow-sm rounded">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ url('/') }}" class="btn btn-primary btn-return">Retour à l'accueil</a>
    </div>
</body>
</html>
