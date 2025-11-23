@extends('heritage')
@section('titre', 'accueil')

@section('contenu')

<style>
    /* ---------------- HEADER ---------------- */
    header {
        position: relative;
        background: linear-gradient(135deg, #006d77, #00afb9);
        color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        z-index: 10;
        padding: 0.5rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    header img { max-height: 60px; object-fit: contain; }

    nav ul {
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        padding: 0;
        margin: 0;
        align-items: center;
    }

    nav ul li a {
        color: white;
        text-decoration: none;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        transition: all 0.3s ease;
        font-weight: 600;
        text-align: center;
        position: relative;
    }

    nav ul li a:hover { background-color: rgba(255,255,255,0.2); }

    /* ---------------- SECTION ACCUEIL ---------------- */
    #accueil {
        background: linear-gradient(rgba(0,91,107,0.7), rgba(0,91,107,0.5)), url('../images/bg.jpg') no-repeat center center / cover;
        height: 700px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 0 1rem;
        color: white;
        position: relative;
    }
    #accueil h2 { font-size: clamp(2.5rem, 6vw, 5rem); font-weight: 900; margin-bottom: 0.3rem; text-shadow: 3px 3px 10px rgba(0,0,0,0.6); }
    #accueil span.fs-6 { font-size: clamp(1rem, 2vw, 1.25rem); font-weight: 400; text-shadow: 2px 2px 8px rgba(0,0,0,0.5); }

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
        font-weight: 800;
        margin-bottom: 2rem;
        text-align: center;
        font-size: 2.8rem;
        color: #006d77;
        text-transform: uppercase;
        letter-spacing: 2px;
    }
    #hebergement img {
        border-radius: 15px;
        box-shadow: 0 8px 18px rgba(0,0,0,0.2);
        width: 100%;
        height: auto;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    #hebergement img:hover { transform: scale(1.05); }

    /* ---------------- ACCORDION CSS ---------------- */
    .accordion-css { border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .accordion-css input { display: none; }
    .accordion-css label {
        display: block;
        padding: 15px 20px;
        background: linear-gradient(135deg, #006d77, #00afb9);
        color: #fff;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.3s ease;
    }
    .accordion-css label:hover { background: linear-gradient(135deg, #004d55, #007f7a); }
    .accordion-css .content {
        max-height: 0;
        overflow: hidden;
        background: #e0f2f1;
        transition: max-height 0.35s ease;
        padding: 0 20px;
    }
    .accordion-css input:checked ~ .content { max-height: 500px; padding: 15px 20px; }
    .accordion-css .content ul { padding-left: 20px; margin: 0; }
    .accordion-css .content li { margin-bottom: 8px; font-weight: 600; }

    .toggle-services i { margin-left: 8px; }

    /* Bouton réserver */
    .btn-reserver {
        display: inline-block;
        padding: 12px 28px;
        font-size: 18px;
        font-weight: bold;
        color: #fff;
        background: #007bff;
        border-radius: 30px;
        text-decoration: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        transition: background 0.3s ease;
        animation: bounce 2s infinite;
    }
    .btn-reserver:hover { background: #0056b3; }
    @keyframes bounce { 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-10px); } }

    /* Responsive */
    @media (max-width: 768px) {
        #hebergement { padding: 2rem 1rem; }
        #hebergement h2 { font-size: 2rem; }
        .btn-reserver { font-size: 1rem; padding: 12px 28px; }
    }
</style>

<!-- HEADER -->
<header class="p-1">
    <div class="col-12 row m-0 align-items-center">
        <div class="col-lg-2 col-md-2 col-3">
            <img class="img-fluid" src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo" />
        </div>
        <nav class="col-lg-10 col-md-10 col-9">
            <ul class="d-flex justify-content-end py-2" id="entete">
                <li><a href="{{ route('login') }}" class="bg-dark"><span class="fa fa-sign-in"></span><span class="badge">connexion</span></a></li>
                <li><a href="{{ route('register') }}" class="bg-dark"><span class="fa fa-sign-in"></span><span class="badge">inscription</span></a></li>
                <li><a href="{{ route('admin.login') }}" class="bg-danger"><span class="fa fa-user-shield"></span><span class="badge">admin</span></a></li>
                <li><a href="#hebergement"><span class="fa fa-home"></span><span class="badge">hébergement</span></a></li>
                <li><a href="#location"><span class="fa fa-car"></span><span class="badge">véhicule</span></a></li>
                <li><a href="#contact"><span class="fa fa-phone"></span><span class="badge">contact</span></a></li>
            </ul>
        </nav>
    </div>
</header>

<!-- SECTION ACCUEIL -->
<section id="accueil" class="text-center py-5">
    <div>
        @include('includes.messages')
        <h2>Bienvenue</h2>
        <span class="fs-6">Explorez l'Afrique autrement avec Afrik’Hub</span><br><br>
        <a href="{{ route('recherche') }}" class="btn-reserver me-2">Réserver</a>
        <a href="{{ route('mise_en_ligne') }}" class="btn-reserver">Ajouter un bien</a>
    </div>
</section>

<!-- SECTION HÉBERGEMENT -->
<section id="hebergement" class="my-2 col-12 row m-0 justify-content-center">
    <h2>hébergements</h2>

    <div class="row g-4 align-items-center col-12 col-md-8 col-lg-6 mx-4">
        <img class="w-20 md:w-28 lg:w-32 h-auto" src="{{ asset('assets/images/hebergement.jpg') }}" alt="Afrik'Hub Logo"/>
    </div>

    <div class="col-12 col-md-8 col-lg-6">
        <div class="accordion-css">
            <!-- Types d'hébergements -->
            <input type="checkbox" id="acc1" checked>
            <label for="acc1">Types d'hébergements</label>
            <div class="content">
                <div><strong>Studio</strong> <span class="toggle-services"><i class="fa fa-chevron-down"></i></span>
                    <ul><li>wifi gratuit</li><li>ventilateur</li><li>caméra de surveillance</li></ul>
                </div>
                <div><strong>Chambre unique</strong> <span class="toggle-services"><i class="fa fa-chevron-down"></i></span>
                    <ul><li>wifi gratuit</li><li>climatisation</li><li>petit déjeuner inclus</li></ul>
                </div>
                <div><strong>Villa avec piscine</strong> <span class="toggle-services"><i class="fa fa-chevron-down"></i></span>
                    <ul><li>wifi gratuit</li><li>piscine privée</li><li>climatisation</li><li>parking gratuit</li></ul>
                </div>
            </div>

            <!-- Conditions de réservation -->
            <input type="checkbox" id="acc2">
            <label for="acc2">Conditions de réservation</label>
            <div class="content">
                <ul>
                    <li>réservation préalable requise</li>
                    <li>acompte de 20% pour confirmation</li>
                    <li>annulation gratuite jusqu'à 48h avant l'arrivée</li>
                </ul>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('recherche') }}" class="btn-reserver">réserver</a>
        </div>
    </div>
</section>

<!-- SECTION RÉSIDENCES DYNAMIQUES -->
<div class="row">
    <div class="col-12 main-content">
        @if ($residences->isEmpty())
            <div class="alert alert-warning text-center fw-bold rounded-3 p-4">
                <i class="fas fa-exclamation-triangle me-2"></i> Désolé, aucune résidence trouvée pour cette recherche.
            </div>
        @else
            <div class="row g-4 justify-content-center mb-4">
                @foreach($residences as $residence)
                    @php
                        $images = is_string($residence->img) ? json_decode($residence->img, true) : ($residence->img ?? []);
                        $firstImage = $images[0] ?? asset('assets/images/placeholder.jpg');
                    @endphp

                    <div class="col-sm-6 col-md-4 col-lg-3 d-flex">
                        <div class="card shadow h-100 border-0 rounded-4 overflow-hidden w-100">
                            <a href="javascript:void(0)" class="glightbox-trigger-{{ $residence->id }}">
                                <img src="{{ $firstImage }}" alt="Image de la résidence {{ $residence->nom }}" class="card-img-top" loading="lazy">
                            </a>
                            @foreach($images as $key => $image)
                                <a href="{{ $image }}" class="glightbox" data-gallery="gallery-{{ $residence->id }}" data-title="{{ $residence->nom }} - Image {{ $key + 1 }}" style="display: none;" data-index="{{ $key }}" data-trigger=".glightbox-trigger-{{ $residence->id }}"></a>
                            @endforeach

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold text-dark">{{ $residence->nom }}</h5>
                                <p class="card-text text-muted card-text-truncate" title="{{ $residence->description }}">{{ Str::limit($residence->description, 100) }}</p>
                                <ul class="list-unstyled small mb-3 mt-2">
                                    <li><i class="fas fa-bed me-2 text-primary"></i> <strong>Chambres :</strong> {{ $residence->nombre_chambres ?? '-' }}</li>
                                    <li><i class="fas fa-bed me-2 text-primary"></i> <strong>Salon :</strong> {{ $residence->nombre_salons ?? '-' }}</li>
                                    <li><i class="fas fa-map-marker-alt me-2 text-primary"></i> <strong>Situation :</strong> {{ $residence->pays ?? '-' }}/{{ $residence->ville ?? '-' }}</li>
                                    <li class="fw-bold mt-2"><i class="fas fa-money-bill-wave me-2 text-success"></i>Prix/jour : {{ number_format($residence->prix_journalier ?? 0, 0, ',', ' ') }} FCFA</li>
                                    <li class="fw-bold mt-2 text-danger fw-600"><i class="fas fa-calendar-check me-2"></i>Prochaine disponibilité : {{ \Carbon\Carbon::parse($residence->date_disponible)->translatedFormat('d F Y') }}</li>
                                </ul>
                                <a href="{{ route('details', $residence->id) }}" class="btn btn-dark rounded mt-auto">
                                    Voir les Détails <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection

@section('footer')
<footer>
    <p id="contact">&copy; 2025 afrik’hub. tous droits réservés.<br />afrikhub@gmail.com</p>
</footer>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
@endsection
