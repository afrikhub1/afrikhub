{{-- resources/views/pages/messages.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Message</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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

        @if(session('info'))
            <div class="alert alert-info shadow-sm rounded">
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
