<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Détails de la résidence</title>

  <!-- Icônes / Bootstrap / Font -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/css/glightbox.min.css" rel="stylesheet">

  <style>
    :root{--primary:#ff7a00;--dark:#1a1a1a;--light:#f7f7f7}
    body{font-family:'Poppins',sans-serif;background:var(--light);color:var(--dark);padding-top:80px}

    /* NAVBAR */
    .navbar{background:var(--dark);box-shadow:0 4px 10px rgba(0,0,0,.08)}
    .navbar-brand{color:var(--primary)!important;font-weight:700}
    .nav-link{color:#fff!important}
    .btn-header{background:var(--primary);color:#fff;border-radius:25px;padding:8px 18px}

    /* SIDEBAR (off-canvas simple) */
    #sidebar{position:fixed;top:0;right:0;height:100%;width:320px;max-width:90%;background:var(--dark);z-index:1060;transform:translateX(100%);transition:transform .28s;overflow:auto;padding:1.5rem}
    #sidebar.active{transform:translateX(0)}
    #sidebar-overlay{position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:1050;display:none}
    #sidebar-overlay.active{display:block}

    .sidebar-link{color:#e6e6e6;display:block;padding:.6rem .8rem;border-radius:8px;text-decoration:none}
    .sidebar-link:hover{background:#343a40;color:#fff}

    /* CARD */
    .card.custom{border-radius:14px;box-shadow:0 8px 25px rgba(0,0,0,.06);max-width:900px;margin:0 auto;overflow:hidden}
    .residence-img{width:100%;height:460px;object-fit:cover;cursor:pointer;transition:transform .25s}
    .residence-img:hover{transform:scale(1.02)}
    .price{color:var(--primary);font-weight:700;font-size:1.2rem}

    .btn-back{background:var(--dark);color:#fff;border-radius:30px;padding:9px 22px;text-decoration:none}
    .btn-reserver{background:var(--primary);color:#fff;border-radius:30px;padding:9px 22px;font-weight:600}

    /* Thumbnails */
    #thumbs{display:flex;gap:10px;justify-content:center;margin-top:18px;flex-wrap:wrap}
    #thumbs img{width:84px;height:60px;object-fit:cover;border-radius:6px;cursor:pointer;opacity:.65;transition:all .25s}
    #thumbs img.active,#thumbs img:hover{opacity:1;transform:scale(1.06);box-shadow:0 6px 18px rgba(0,0,0,.25)}

    @media (max-width:576px){
      .residence-img{height:320px}
    }
  </style>
</head>
<body>

  @php
    // liens partagés partout
    $navLinks = [
      ['label'=>'Accueil','route'=>route('accueil'),'icon'=>'fa-home'],
      ['label'=>'Résidences','route'=>route('recherche'),'icon'=>'fa-search'],
      ['label'=>'Mon compte','route'=>route('dashboard'),'icon'=>'fa-user'],
      ['label'=>'Historique','route'=>route('historique'),'icon'=>'fa-history'],
    ];
  @endphp

  <!-- NAVBAR -->
  <nav class="navbar fixed-top d-flex align-items-center px-3">
    <a class="navbar-brand me-2" href="{{ route('accueil') }}">🏠 Afrik'Hub</a>

    <!-- desktop links -->
    <div class="d-none d-lg-flex align-items-center ms-3">
      @foreach($navLinks as $link)
        <a class="nav-link me-3" href="{{ $link['route'] }}">{{ $link['label'] }}</a>
      @endforeach
      <a class="btn btn-header ms-2" href="{{ route('login') }}">Se connecter</a>
    </div>

    <!-- mobile menu button -->
    <button id="btnToggle" class="btn btn-link text-white ms-auto d-lg-none" aria-label="menu" type="button">
      <i class="fas fa-bars fa-lg"></i>
    </button>
  </nav>

  <!-- SIDEBAR + OVERLAY -->
  <div id="sidebar-overlay" onclick="toggleSidebar()"></div>
  <aside id="sidebar" aria-hidden="true">
    <button class="btn btn-close btn-close-white mb-3" onclick="toggleSidebar()" aria-label="Fermer"></button>
    <div class="mb-4 text-center">
      <i class="fas fa-bars fa-2x" style="color:var(--primary)"></i>
      <h5 class="fw-bold text-white mt-2">MENU</h5>
    </div>
    @foreach($navLinks as $link)
      <a class="sidebar-link" href="{{ $link['route'] }}">
        <i class="fas {{ $link['icon'] }} me-2"></i>{{ $link['label'] }}
      </a>
    @endforeach
    <div class="mt-4">
      <a class="btn btn-header w-100" href="{{ route('logout') }}"><i class="fa fa-sign-out me-2"></i>Déconnexion</a>
    </div>
  </aside>

  <!-- CONTENU -->
  <main class="container py-4">
    <div class="text-center mb-4">
      <h1 class="fw-bold" style="color:var(--primary)">Détails de la résidence</h1>
      <p class="text-muted">Découvrez cette propriété en images</p>
    </div>

    @php
      $images = is_string($residence->img) ? json_decode($residence->img,true) : $residence->img;
      if(!is_array($images)) $images = [];
      $first = $images[0] ?? 'https://placehold.co/900x500?text=Aucune+image';
    @endphp

    <article class="card custom mb-5">
      <img src="{{ $first }}" alt="{{ $residence->nom }}" class="residence-img" id="mainPreview" />
      <div class="card-body text-center">
        <h2 class="fw-bold">{{ $residence->nom }}</h2>
        <p class="price mb-2">{{ number_format($residence->prix_journalier,0,',',' ') }} FCFA / nuit</p>
        <p class="text-start">{!! nl2br(e($residence->description)) !!}</p>

        <div class="d-flex justify-content-center gap-3 mt-4">
          <a href="{{ route('accueil') }}" class="btn btn-back">🏠 Retour Accueil</a>
          <a href="{{ route('recherche') }}" class="btn btn-back">⬅ Retour Résidences</a>
          <button class="btn btn-reserver" data-bs-toggle="modal" data-bs-target="#reservationModal">Réserver</button>
        </div>
      </div>
    </article>

    <!-- Thumbnails -->
    @if(count($images) > 1)
      <div id="thumbs" class="mb-4 text-center">
        @foreach($images as $i=>$img)
          <img src="{{ $img }}" data-index="{{ $i }}" class="{{ $i===0?'active':'' }}" alt="thumb-{{ $i }}">
        @endforeach
      </div>
    @endif

    <!-- Hidden links for GLightbox -->
    @foreach($images as $i=>$img)
      <a href="{{ $img }}" class="glightbox" data-gallery="res-{{ $residence->id }}" style="display:none;"></a>
    @endforeach

  </main>

  <!-- RESERVATION MODAL et CONFIRMATION MODAL -->
  @include('partials.reservation-modal') <!-- si tu as le code séparé -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/js/glightbox.min.js"></script>

  <script>
    const btnToggle = document.getElementById('btnToggle');
    btnToggle?.addEventListener('click', toggleSidebar);
    function toggleSidebar(){
      document.getElementById('sidebar').classList.toggle('active');
      document.getElementById('sidebar-overlay').classList.toggle('active');
    }

    document.addEventListener('DOMContentLoaded', () => {
      const lightbox = GLightbox({ selector: '.glightbox', loop:true, touchNavigation:true });
      const mainPreview = document.getElementById('mainPreview');
      const anchors = Array.from(document.querySelectorAll('a.glightbox'));
      if(mainPreview && anchors.length){
        mainPreview.addEventListener('click', e => { e.preventDefault(); lightbox.openAt(0); });
      }
      document.querySelectorAll('#thumbs img').forEach(img => {
        img.addEventListener('click', () => {
          const idx = Number(img.dataset.index||0);
          lightbox.openAt(idx);
          document.querySelector('#thumbs img.active')?.classList.remove('active');
          img.classList.add('active');
        });
      });
    });
  </script>
</body>
</html>
