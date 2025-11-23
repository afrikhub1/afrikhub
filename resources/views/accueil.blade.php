<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Accueil</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- AOS Animation -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <!-- GLightbox -->
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">

    <!-- ======================  CSS OPTIMISÉ  ====================== -->
    <style>
        /* GENERAL */
        body {
            scroll-behavior: smooth;
            background: #f9fafb;
        }

        /* HEADER */
        .header {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 50;
            height: 65px;
        }

        .header-logo img {
            height: 45px;
        }

        /* SIDEBAR */
        #sidebar {
            position: fixed;
            top: 0;
            left: -260px;
            width: 260px;
            height: 100vh;
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.15);
            transition: 0.3s ease-in-out;
            z-index: 100;
            padding-top: 80px;
        }

        #sidebar.open {
            left: 0;
        }

        #sidebar a {
            display: block;
            padding: 15px 20px;
            font-size: 16px;
            color: #111827;
            font-weight: 500;
            border-bottom: 1px solid #f3f4f6;
        }

        #sidebar a:hover {
            background: #f3f4f6;
        }

        /* HERO SECTION */
        .hero {
            padding-top: 120px;
        }

        /* ACCORDION */
        details summary {
            cursor: pointer;
            padding: 12px;
            background: #e5e7eb;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        details[open] summary {
            background: #d1d5db;
        }

        /* CARDS */
        .card {
            background: white;
            border-radius: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
            padding: 20px;
            transition: transform .2s, box-shadow .2s;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        }

        .card img {
            border-radius: 12px;
        }

        /* BUTTONS */
        .btn {
            background: #2563eb;
            color: white;
            padding: 10px 18px;
            border-radius: 10px;
            transition: 0.2s;
            font-size: 15px;
        }

        .btn:hover {
            background: #1e40af;
        }
    </style>
</head>

<body class="font-sans text-gray-800">

    <!-- ====================== HEADER ====================== -->
    <header class="header flex items-center justify-between px-4">
        <div class="header-logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo">
        </div>

        <button onclick="toggleSidebar()" class="md:hidden text-gray-800 text-3xl">
            ☰
        </button>
    </header>

    <!-- ====================== SIDEBAR ====================== -->
    <div id="sidebar">
        <a href="{{ route('accueil') }}">Accueil</a>
        <a href="{{ route('reservation') }}">Réservations</a>
        <a href="{{ route('factures') }}">Factures</a>
        <a href="{{ route('logout') }}">Déconnexion</a>
    </div>

    <!-- ====================== HERO ====================== -->
    <section class="hero text-center px-6">
        <h1 class="text-4xl font-bold" data-aos="fade-up">Bienvenue sur notre plateforme</h1>
        <p class="mt-3 text-lg text-gray-600" data-aos="fade-up" data-aos-delay="150">
            Trouvez les meilleures résidences pour votre séjour.
        </p>
    </section>

    <!-- ====================== RÉSIDENCES ====================== -->
    <section class="px-6 mt-10">
        <h2 class="text-2xl font-bold mb-4">Nos résidences disponibles</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($residences as $residence)
            <div class="card" data-aos="zoom-in">
                @php
                $images = json_decode($residence->images, true);
                $firstImage = $images[0] ?? null;
                @endphp

                @if($firstImage)
                <a href="{{ asset($firstImage) }}" class="glightbox">
                    <img src="{{ asset($firstImage) }}" alt="Image résidence">
                </a>
                @endif

                <h3 class="text-xl font-bold mt-3">{{ $residence->nom }}</h3>
                <p class="text-gray-600">{{ $residence->ville }}, {{ $residence->pays }}</p>
                <p class="font-bold text-lg mt-2">{{ $residence->prix }} CFA / nuit</p>

                <a href="{{ route('reservation.form', $residence->id) }}" class="btn mt-3 block text-center">
                    Réserver
                </a>
            </div>
            @endforeach

        </div>
    </section>

    <!-- ====================== ACCORDÉON ====================== -->
    <section class="px-6 mt-10 mb-16">
        <h2 class="text-2xl font-bold mb-4">Informations utiles</h2>

        <details>
            <summary>Conditions de réservation</summary>
            <div class="p-3">
                <p>Voici les conditions complètes de réservation...</p>
            </div>
        </details>

        <details>
            <summary>Types d'hébergements</summary>
            <div class="p-3">
                <p>Nous proposons plusieurs types d’hébergements...</p>
            </div>
        </details>
    </section>

    <!-- GLIGHTBOX -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <!-- AOS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    <!-- ====================== JS GLOBAL ====================== -->
    <script>
        AOS.init();

        const sidebar = document.getElementById("sidebar");

        function toggleSidebar() {
            sidebar.classList.toggle("open");
        }

        const lightbox = GLightbox({
            touchNavigation: true,
            loop: true,
        });
    </script>

</body>

</html>
