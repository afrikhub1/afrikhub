<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la résidence</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #ff7a00;
            --dark-color: #1a1a1a;
            --light-bg: #f7f7f7;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Poppins', sans-serif;
            color: var(--dark-color);
            padding-top: 80px;
        }

        /* ===== HEADER ===== */
        .navbar {
            background-color: var(--dark-color);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand { color: var(--primary-color) !important; font-weight: 700; }
        .nav-link { color: #fff !important; transition: .3s; }
        .nav-link:hover { color: var(--primary-color) !important; }

        .btn-header {
            background-color: var(--primary-color);
            color: #fff !important;
            border-radius: 25px;
            padding: 8px 20px;
            transition: .3s;
        }
        .btn-header:hover { background: #fff; color: var(--dark-color) !important; }

        /* ===== SIDEBAR ===== */
        #sidebar {
            transform: translateX(100%);
            transition: .3s;
            position: fixed; top: 0; right: 0;
            width: 90%; max-width: 320px; height: 100%;
            background-color: var(--dark-color);
            z-index: 1060; padding: 1.5rem; overflow-y: auto;
        }
        #sidebar.active { transform: translateX(0); }
        #sidebar-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5);
            display: none; z-index: 1050;
        }
        #sidebar-overlay.active { display: block; }

        .sidebar-link { color: #d6d6d6; padding: 10px; border-radius: 8px; display: block; }
        .sidebar-link:hover { background: #343a40; color: #fff; }

        /* ===== CONTENU ===== */
        .residence-header h1 { color: var(--primary-color); font-weight: 700; }

        .card {
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .residence-img {
            height: 450px; width: 100%; object-fit: cover; cursor: zoom-in; transition: .3s;
        }
        .residence-img:hover { transform: scale(1.04); }

        .price { color: var(--primary-color); font-weight: 700; }

        .btn-back, .btn-reserver {
            border-radius: 30px; padding: 10px 25px; transition: .3s;
        }
        .btn-back { background: var(--dark-color); color: #fff; }
        .btn-back:hover { background: var(--primary-color); }
        .btn-reserver { background: var(--primary-color); color: #fff; }
        .btn-reserver:hover { background: var(--dark-color); }

        /* ===== MODAL LIGHTBOX ===== */
        .modal-content-custom { background: rgba(0,0,0,0.95); border: none; }
        .close-btn {
            position: absolute; top:20px; right:20px;
            border: none; background: rgba(255,255,255,0.3); color:#fff;
            width:40px; height:40px; border-radius:50%; font-size:1.5rem;
        }
        .carousel-item { height:100vh; display:flex; justify-content:center; align-items:center; }
        .carousel-item img { max-height:90vh; max-width:90vw; object-fit:contain; }
    </style>
</head>

<body>

    @include('components.navbar_mobile') <!-- ✅ Si tu veux, sinon retire -->

    <!-- HEADER -->
    <nav class="navbar fixed-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand" href="{{ route('accueil') }}">🏠 Afrik'Hub</a>

            <div class="d-none d-lg-flex align-items-center">
                <a class="nav-link" href="{{ route('recherche') }}">Résidences</a>
                <a class="nav-link" href="{{ route('dashboard') }}">Mon Espace</a>
                <a class="nav-link" href="{{ route('historique') }}">Historique</a>
                <a href="{{ route('login') }}" class="btn-header ms-3">Se connecter</a>
            </div>

            <button class="navbar-menu-toggler d-lg-none" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
        </div>
    </nav>

    <!-- SIDEBAR MOBILE -->
    <div id="sidebar-overlay" onclick="toggleSidebar()"></div>
    <div id="sidebar">
        <button class="close-btn" onclick="toggleSidebar()">&times;</button>
        <a href="{{ route('accueil') }}" class="sidebar-link">Accueil</a>
        <a href="{{ route('recherche') }}" class="sidebar-link">Recherche</a>
        <a href="{{ route('dashboard') }}" class="sidebar-link">Mon compte</a>
        <a href="{{ route('historique') }}" class="sidebar-link">Historique</a>
        <a href="{{ route('logout') }}" class="btn btn-header w-100 mt-3">Déconnexion</a>
    </div>

    <div class="container">
        <div class="residence-header text-center my-4">
            <h1>Détails de la résidence</h1>
            <p class="text-muted">Découvrez cette propriété en images</p>
        </div>

        <div class="card mb-5">
            @php $images = is_string($residence->img) ? json_decode($residence->img, true) : $residence->img; @endphp
            <img src="{{ $images[0] ?? 'https://placehold.co/600x400' }}" class="residence-img" data-bs-toggle="modal" data-bs-target="#lightboxModal">

            <div class="card-body text-center">
                <h3 class="fw-bold">{{ $residence->nom }}</h3>
                <p class="price">{{ number_format($residence->prix_journalier,0,',',' ') }} FCFA / nuit</p>

                <p class="text-start">
                    <b>Pays :</b> {{ $residence->pays }} <br>
                    <b>Adresse :</b> {{ $residence->adresse }} <br><br>
                    {!! nl2br(e($residence->description)) !!}
                </p>

                <div class="mt-4">
                    <a href="{{ route('recherche') }}" class="btn-back">⬅ Retour</a>
                    <button class="btn-reserver" data-bs-toggle="modal" data-bs-target="#reservationModal">Réserver</button>
                </div>
            </div>
        </div>
    </div>

    <!-- LIGHTBOX -->
    <div class="modal fade" id="lightboxModal">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content modal-content-custom">
                <button class="close-btn" data-bs-dismiss="modal">&times;</button>
                <div id="carouselLightbox" class="carousel slide">
                    <div class="carousel-inner">
                        @foreach($images as $i => $img)
                            <div class="carousel-item @if($i==0) active @endif">
                                <img src="{{ $img }}">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" data-bs-target="#carouselLightbox" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" data-bs-target="#carouselLightbox" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL RÉSERVATION (inchangé, fonctionnel) -->
    @include('components.reservation_modal')

<script>
function toggleSidebar(){
    document.getElementById('sidebar').classList.toggle('active');
    document.getElementById('sidebar-overlay').classList.toggle('active');
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
