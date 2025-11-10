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

        .navbar { background-color: var(--dark-color); }
        .navbar-brand { color: var(--primary-color) !important; font-weight: 700; }
        .nav-link { color: #fff !important; margin-right: 18px; }

        /* Sidebar */
        #sidebar { transform: translateX(100%); transition: .3s; position: fixed; right: 0; width: 300px; height: 100%; background: var(--dark-color); z-index: 1060; padding: 25px; }
        #sidebar.active { transform: translateX(0); }
        #sidebar-overlay { position: fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,.5); display:none; z-index:1050; }
        #sidebar-overlay.active { display:block; }

        /* Lightbox */
        #lightboxModal .modal-content { background: rgba(0,0,0,0.95); border: none; }
        #lightboxModal img { max-height: 85vh; border-radius: 12px; }
        .close-btn { position:absolute; top:20px; right:30px; font-size:45px; color:white; border:none; background:none; cursor:pointer; }

        .residence-img { width: 100%; height: 450px; object-fit: cover; cursor:pointer; }

        .btn-back { background: var(--dark-color); color:#fff; border-radius:25px; padding:10px 25px; }
        .btn-reserver { background: var(--primary-color); color:#fff; border-radius:25px; padding:12px 30px; font-weight:600; }
    </style>
</head>
<body>

<nav class="navbar fixed-top px-4">
    <a class="navbar-brand" href="{{ route('accueil') }}">🏠 Afrik'Hub</a>
    <button class="navbar-menu-toggler text-white fs-3" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
</nav>

<div id="sidebar-overlay" onclick="toggleSidebar()"></div>
<div id="sidebar">
    <button onclick="toggleSidebar()" class="text-white fs-2 border-0 bg-transparent mb-4"><i class="fas fa-times"></i></button>
    <a href="{{ route('accueil') }}" class="sidebar-link d-block text-white mb-3">Accueil</a>
    <a href="{{ route('recherche') }}" class="sidebar-link d-block text-white mb-3">Recherche</a>
    <a href="{{ route('dashboard') }}" class="sidebar-link d-block text-white mb-3">Mon compte</a>
    <a href="{{ route('historique') }}" class="sidebar-link d-block text-white mb-4">Historique</a>
    <a href="{{ route('logout') }}" class="btn btn-header w-100">Déconnexion</a>
</div>

<div class="container">
    <div class="text-center my-5">
        <h1 class="fw-bold" style="color:var(--primary-color);">Détails de la résidence</h1>
    </div>

    @php
        $images = is_string($residence->img) ? json_decode($residence->img,true) : $residence->img;
        $imagePath = $images[0] ?? "https://placehold.co/800x450?text=Aucune+image";
    @endphp

    <div class="card shadow-lg border-0 rounded-4 mb-5">
        <img src="{{ $imagePath }}" class="residence-img" data-bs-toggle="modal" data-bs-target="#lightboxModal">

        <div class="card-body text-center">
            <h2 class="fw-bold">{{ $residence->nom }}</h2>
            <p class="text-orange fw-bold fs-4">{{ number_format($residence->prix_journalier, 0, ',', ' ') }} FCFA / nuit</p>

            <p class="text-muted">{!! nl2br(e($residence->description)) !!}</p>

            <div class="mt-4 d-flex justify-content-center gap-3">
                <a href="{{ route('recherche') }}" class="btn btn-back">⬅ Retour</a>
                <button class="btn btn-reserver" data-bs-toggle="modal" data-bs-target="#reservationModal">Réserver</button>
            </div>
        </div>
    </div>
</div>

<!-- Lightbox -->
<div class="modal fade" id="lightboxModal" tabindex="-1">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content position-relative text-center">
      <button class="close-btn" data-bs-dismiss="modal">&times;</button>
      <div id="carouselLightbox" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
        @foreach($images as $i => $img)
          <div class="carousel-item {{ $i===0 ? 'active' : '' }}">
            <img src="{{ $img }}" class="d-block mx-auto">
          </div>
        @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

@include('reservation-modal') <!-- Je peux aussi te l’intégrer si tu veux -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function toggleSidebar(){
    document.getElementById("sidebar").classList.toggle("active");
    document.getElementById("sidebar-overlay").classList.toggle("active");
}
</script>

</body>
</html>
