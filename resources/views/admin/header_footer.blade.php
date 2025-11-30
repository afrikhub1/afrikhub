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
    /* -------------------------------------- */
    /*             BASE : Mobile              */
    /* -------------------------------------- */
    body {
        font-size: 15px;
        line-height: 1.6;
        font-family: Arial, sans-serif;
    }

    h1 { font-size: 1.6rem; }
    h2 { font-size: 1.4rem; }
    h3 { font-size: 1.2rem; }
    h4 { font-size: 1rem; }
    h5 { font-size: 8.05rem; }
    h6 { font-size: 8rem; }

    p, a, li, span,th,td, button[type="submit"],
    input[type="submit"] {
        font-size: 0.8rem;
    }

    /* -------------------------------------- */
    /*            TABLETTE ≥ 640px            */
    /* -------------------------------------- */
    @media (min-width: 640px) {
        body { font-size: 10px; }

        h1 { font-size: 2rem; }
        h2 { font-size: 1.75rem; }
        h3 { font-size: 1.5rem; }
        h4 { font-size: 1.3rem; }

        button[type="submit"],
        input[type="submit"],a,th,td,span,li, p {
            font-size: 0.8rem;
        }
    }

    /* -------------------------------------- */
    /*           LAPTOP ≥ 1024px              */
    /* -------------------------------------- */
    @media (min-width: 1024px) {
        body { font-size: 10px; }

        h1 { font-size: 2.3rem; }
        h2 { font-size: 2rem; }
        h3 { font-size: 1.7rem; }
        h4 { font-size: 1.4rem; }

        button[type="submit"],
        input[type="submit"],a,th,td {
            font-size: 0.8rem;
        }
    }

    /* -------------------------------------- */
    /*       GRAND ÉCRAN ≥ 1440px             */
    /* -------------------------------------- */
    @media (min-width: 1440px) {
        body { font-size: 10px; }

        h1 { font-size: 2.6rem; }
        h2 { font-size: 2.2rem; }
        h3 { font-size: 1.9rem; }

        button[type="submit"],
        input[type="submit"],a, th, td {
            font-size: 0.8rem;
        }
    }
</style>


<body class="bg-gray-50 font-sans antialiased flex flex-col min-h-screen">

    {{-- Header global --}}
    @include('includes.admin_header')

    {{-- Contenu principal de la page --}}
    <main class="flex-grow p-0">
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
