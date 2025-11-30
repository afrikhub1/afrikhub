<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }} - @yield('titre')</title>

    {{-- Section pour styles spécifiques aux pages --}}
    @yield('style')

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- GLightbox CSS -->
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>

    <style>
        /* Taille de texte globale */
        body {
            font-size: 16px;   /* Base */
        }

        /* Titres */
        h1 { font-size: 1.5rem; }      /* 32px */
        h2 { font-size: 1.4rem; }   /* 28px */
        h3 { font-size: 1rem; }    /* 24px */
        h4 { font-size: 0.8rem; }   /* 20px */
        h5 { font-size: 0.7rem; }    /* 17.6px */
        h6 { font-size: 0.5rem; }      /* 16px */

        /* Paragraphes */
        p {
            font-size: 0.3rem;   /* 16px */
        }

        /* Liens */
        a {
            font-size: 0.3rem;
        }

        /* Listes */
        li {
            font-size: 0.3rem;
        }

    </style>

<body class="bg-gray-50 font-sans antialiased flex flex-col min-h-screen">

    {{-- Header global --}}
    @include('includes.admin_header')

    {{-- Contenu principal de la page --}}
    <main class="flex-grow">
        @yield('main')
    </main>

    {{-- Footer global --}}
    @include('includes.admin_footer')

    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    {{-- Section pour scripts spécifiques aux pages --}}
    @yield('scripts')
</body>
</html>
