<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Accueil</title>
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* ---------------- GENERAL ---------------- */
        body { font-family: 'Inter', sans-serif; margin: 0; padding: 0; }
        h2 { font-weight: 800; }
        a { text-decoration: none; }

        /* ---------------- HEADER ---------------- */
        header {
            background: linear-gradient(135deg, #006d77, #00afb9);
            color: white;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        header img { max-height: 60px; object-fit: contain; }

        nav ul { list-style: none; display: flex; gap: 1rem; margin: 0; padding: 0; align-items: center; }
        nav ul li a {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-weight: 600;
            color: white;
            padding: 8px 12px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        nav ul li a:hover { background-color: rgba(255,255,255,0.2); }

        nav ul li a .fa { font-size: 20px; }
        nav ul li a .badge { font-size: 12px; margin-top: 3px; text-transform: capitalize; }

        /* ---------------- SECTION ACCUEIL ---------------- */
        #accueil {
            background: linear-gradient(rgba(0,91,107,0.7), rgba(0,91,107,0.5)), url('{{ asset("assets/images/bg.jpg") }}') no-repeat center center/cover;
            height: 700px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            padding: 0 1rem;
        }
        #accueil h2 { font-size: clamp(2.5rem, 6vw, 5rem); text-shadow: 3px 3px 10px rgba(0,0,0,0.6); }
        #accueil span.fs-6 { font-size: clamp(1rem, 2vw, 1.25rem); text-shadow: 2px 2px 8px rgba(0,0,0,0.5); }

        .btn-reserver {
            display: inline-block;
            padding: 12px 28px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            background: #007bff;
            border-radius: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            transition: background 0.3s ease;
            animation: bounce 2s infinite;
        }
        .btn-reserver:hover { background: #0056b3; }
        @keyframes bounce { 0%,100%{ transform: translateY(0);} 50%{ transform: translateY(-10px); } }

        /* ---------------- SECTION HÉBERGEMENT ---------------- */
        #hebergement {
            padding: 3rem 1rem;
            background: #e0f2f1;
            color: #004d40;
            border-radius: 20px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            margin: 3rem auto;
        }
        #hebergement h2 {
            font-size: 2.8rem;
            text-align: center;
            text-transform: uppercase;
            color: #006d77;
            letter-spacing: 2px;
            margin-bottom: 2rem;
        }
        #hebergement img { border-radius: 15px; box-shadow: 0 8px 18px rgba(0,0,0,0.2); width: 100%; height: auto; object-fit: cover; transition: transform 0.3s ease;}
        #hebergement img:hover { transform: scale(1.05); }

        /* ---------------- ACCORDION CSS PUR ---------------- */
        .accordion-css {
            border-radius: 12px;
            overflow: hidden;
            margin-top: 2rem;
        }
        .accordion-css input { display: none; }
        .accordion-css label {
            display: block;
            padding: 15px 20px;
            background: linear-gradient(135deg, #006d77, #00afb9);
            color: #fff;
            font-weight: 700;
            cursor: pointer;
            border-radius: 12px;
            margin-bottom: 5px;
            transition: background 0.3s ease;
        }
        .accordion-css label:hover { background: linear-gradient(135deg, #004d55, #007f7a); }
        .accordion-css .content {
            max-height: 0;
            overflow: hidden;
            background: #e0f2f1;
            transition: max-height 0.35s ease, padding 0.35s ease;
            padding: 0 20px;
        }
        .accordion-css input:checked + label + .content {
            max-height: 500px;
            padding: 15px 20px;
        }
        .accordion-css .services-list li {
            padding: 6px 0;
            font-weight: 600;
        }
        .toggle-services i {
            float: right;
            transition: transform 0.3s ease;
        }
        .accordion-css input:checked + label .toggle-services i {
            transform: rotate(180deg);
        }

        /* ---------------- RESIDENCES ---------------- */
        .card { border-radius: 12px; overflow: hidden; box-shadow: 0 8px 18px rgba(0,0,0,0.15); transition: transform 0.3s ease; display: flex; flex-direction: column; }
        .card:hover { transform: translateY(-5px); }
        .card img { object-fit: cover; width: 100%; border-radius: 12px; }
        .card-body { padding: 15px; display: flex; flex-direction: column; flex: 1; }
        .card-title { font-weight: 700; color: #004d40; }
        .card-text-truncate { overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; }

        /* ---------------- FOOTER ---------------- */
        footer {
            background: linear-gradient(135deg, #006d77, #00afb9);
            color: white;
            padding: 1.5rem;
            text-align: center;
            font-size: 0.95rem;
            letter-spacing: 1px;
        }

        /* ---------------- RESPONSIVE ---------------- */
        @media (max-width: 768px) {
            #hebergement { padding: 2rem 1rem; }
            #hebergement h2 { font-size: 2rem; }
            .btn-reserver { font-size: 1rem; padding: 12px 28px; }
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <header>
        <div class="flex w-full justify-between items-center">
            <img src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo">
            <nav>
                <ul>
                    <li><a href="{{ route('login') }}" class="bg-dark"><span class="fa fa-sign-in"></span><span class="badge">Connexion</span></a></li>
                    <li><a href="{{ route('register') }}" class="bg-dark"><span class="fa fa-user-plus"></span><span class="badge">Inscription</span></a></li>
                    <li><a href="{{ route('admin.login') }}" class="bg-danger"><span class="fa fa-user-shield"></span><span class="badge">Admin</span></a></li>
                    <li><a href="#hebergement"><span class="fa fa-home"></span><span class="badge">Hébergement</span></a></li>
                    <li><a href="#location"><span class="fa fa-car"></span><span class="badge">Véhicule</span></a></li>
                    <li><a href="#contact"><span class="fa fa-phone"></span><span class="badge">Contact</span></a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- SECTION ACCUEIL -->
    <section id="accueil">
        <div>
            @include('includes.messages')
            <h2>Bienvenue</h2>
            <span class="fs-6">Explorez l'Afrique autrement avec Afrik’Hub</span><br><br>
            <a href="{{ route('recherche') }}" class="btn-reserver me-2">Réserver</a>
            <a href="{{ route('mise_en_ligne') }}" class="btn-reserver">Ajouter un bien</a>
        </div>
    </section>

    <!-- SECTION HÉBERGEMENT -->
    <section id="hebergement" class="mx-auto">
        <h2>Hébergements</h2>
        <div class="grid md:grid-cols-2 gap-6 items-center">
            <img src="{{ asset('assets/images/hebergement.jpg') }}" alt="Hébergement">

            <!-- ACCORDION CSS PUR -->
            <div class="accordion-css">
                <input type="checkbox" id="acc1" checked>
                <label for="acc1">Types d'hébergements <span class="toggle-services"><i class="fa fa-chevron-down"></i></span></label>
                <div class="content">
                    <div><strong>Studio</strong>
                        <ul class="services-list"><li>wifi gratuit</li><li>ventilateur</li><li>caméra de surveillance</li></ul>
                    </div>
                    <div><strong>Chambre unique</strong>
                        <ul class="services-list"><li>wifi gratuit</li><li>climatisation</li><li>petit déjeuner inclus</li></ul>
                    </div>
                    <div><strong>Villa avec piscine</strong>
                        <ul class="services-list"><li>wifi gratuit</li><li>piscine privée</li><li>climatisation</li><li>parking gratuit</li></ul>
                    </div>
                </div>

                <input type="checkbox" id="acc2">
                <label for="acc2">Conditions de réservation <span class="toggle-services"><i class="fa fa-chevron-down"></i></span></label>
                <div class="content">
                    <ul>
                        <li>réservation préalable requise</li>
                        <li>acompte de 20% pour confirmation</li>
                        <li>annulation gratuite jusqu'à 48h avant l'arrivée</li>
                    </ul>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('recherche') }}" class="btn-reserver">Réserver</a>
            </div>
        </div>
    </section>

    <!-- SECTION RESIDENCES -->
    <section class="container mx-auto my-8">
        @if ($residences->isEmpty())
            <div class="bg-yellow-100 text-center text-yellow-800 font-bold rounded p-4">
                <i class="fas fa-exclamation-triangle"></i> Désolé, aucune résidence trouvée pour cette recherche.
            </div>
        @else
            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($residences as $residence)
                    @php
                        $images = is_string($residence->img) ? json_decode($residence->img, true) : ($residence->img ?? []);
                        $firstImage = $images[0] ?? asset('assets/images/placeholder.jpg');
                    @endphp
                    <div class="card">
                        <a href="javascript:void(0)" class="glightbox-trigger-{{ $residence->id }}">
                            <img src="{{ $firstImage }}" alt="{{ $residence->nom }}">
                        </a>
                        @foreach($images as $key => $image)
                            <a href="{{ $image }}" class="glightbox" data-gallery="gallery-{{ $residence->id }}" data-title="{{ $residence->nom }} - Image {{ $key+1 }}" style="display:none;" data-trigger=".glightbox-trigger-{{ $residence->id }}"></a>
                        @endforeach
                        <div class="card-body">
                            <h5 class="card-title">{{ $residence->nom }}</h5>
                            <p class="card-text card-text-truncate" title="{{ $residence->description }}">{{ Str::limit($residence->description,100) }}</p>
                            <ul class="list-none text-sm mt-2">
                                <li><i class="fas fa-bed text-primary"></i> Chambres: {{ $residence->nombre_chambres ?? '-' }}</li>
                                <li><i class="fas fa-couch text-primary"></i> Salon: {{ $residence->nombre_salons ?? '-' }}</li>
                                <li><i class="fas fa-map-marker-alt text-primary"></i> {{ $residence->pays ?? '-' }}/{{ $residence->ville ?? '-' }}</li>
                                <li class="font-bold text-green-600 mt-2"><i class="fas fa-money-bill-wave"></i> {{ number_format($residence->prix_journalier ?? 0,0,',',' ') }} FCFA/jour</li>
                                <li class="font-bold text-red-600 mt-2"><i class="fas fa-calendar-check"></i> {{ \Carbon\Carbon::parse($residence->date_disponible)->translatedFormat('d F Y') }}</li>
                            </ul>
                            <a href="{{ route('details',$residence->id) }}" class="btn-reserver mt-auto">Voir Détails <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- FOOTER -->
    <footer>
        <p id="contact">&copy; 2025 Afrik’Hub. Tous droits réservés.<br>afrikhub@gmail.com</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        const lightbox = GLightbox({ selector: '.glightbox' });
    </script>
</body>
</html>
