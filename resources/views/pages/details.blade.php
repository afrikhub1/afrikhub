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
  --primary: #ff7a00;
  --dark: #1a1a1a;
  --light: #f7f7f7;
}
body {
  font-family: 'Poppins', sans-serif;
  background: var(--light);
  color: var(--dark);
  padding-top: 80px;
}

/* Navbar */
.navbar {
  background: var(--dark);
  box-shadow: 0 4px 10px rgba(0,0,0,.08);
}
.navbar-brand { color: var(--primary)!important; font-weight:700; }
.nav-link { color:#fff!important; margin-right:15px; }
.btn-header { background: var(--primary); color:#fff; border-radius:25px; padding:8px 18px; }

/* Sidebar */
#sidebar {
  position: fixed;
  top:0; right:0; width:320px; max-width:90%; height:100%;
  background: var(--dark);
  z-index:1060;
  transform: translateX(100%);
  transition: transform .28s;
  overflow:auto; padding:1.5rem;
}
#sidebar.active { transform: translateX(0); }
#sidebar-overlay { position:fixed; inset:0; background:rgba(0,0,0,.45); z-index:1050; display:none; }
#sidebar-overlay.active { display:block; }

.sidebar-link { color:#e6e6e6; display:block; padding:.6rem .8rem; border-radius:8px; text-decoration:none; margin-bottom:4px; }
.sidebar-link:hover { background:#343a40; color:#fff; }

/* Card */
.card.custom { border-radius:14px; box-shadow:0 8px 25px rgba(0,0,0,.06); max-width:900px; margin:0 auto; overflow:hidden; }
.residence-img { width:100%; height:460px; object-fit:cover; cursor:pointer; transition: transform .25s; }
.residence-img:hover { transform: scale(1.02); }
.price { color: var(--primary); font-weight:700; font-size:1.2rem; }

.btn-back { background: var(--dark); color:#fff; border-radius:30px; padding:9px 22px; text-decoration:none; }
.btn-reserver { background: var(--primary); color:#fff; border-radius:30px; padding:9px 22px; font-weight:600; }

/* Lightbox / GLightbox */
.modal-content.modal-light { background: rgba(0,0,0,.95); border:none; }
.light-img { max-height:78vh; max-width:92vw; object-fit:contain; border-radius:10px; }
.light-close { position:absolute; top:18px; right:18px; background:transparent; border:0; color:#fff; font-size:34px; cursor:pointer; }
#thumbs { display:flex; gap:10px; justify-content:center; margin-top:18px; flex-wrap:wrap; }
#thumbs img { width:84px; height:60px; object-fit:cover; border-radius:6px; cursor:pointer; opacity:.65; transition:all .25s; }
#thumbs img.active,#thumbs img:hover { opacity:1; transform:scale(1.06); box-shadow:0 6px 18px rgba(0,0,0,.25); }

@media (max-width:576px) { .residence-img { height:320px; } .light-img{ max-height:70vh; } }
</style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar fixed-top d-flex align-items-center px-3">
  <a class="navbar-brand me-2" href="{{ route('accueil') }}">🏠 Afrik'Hub</a>
  <div class="d-none d-lg-flex align-items-center ms-3">
    <a class="nav-link" href="{{ route('recherche') }}">Résidences</a>
    <a class="nav-link" href="{{ route('dashboard') }}">Mon Espace</a>
    <a class="nav-link" href="{{ route('historique') }}">Historique</a>
    <a class="btn btn-header ms-2" href="{{ route('login') }}">Se connecter</a>
  </div>
  <button id="btnToggle" class="btn btn-link text-white ms-auto d-lg-none" aria-label="menu" type="button">
    <i class="fas fa-bars fa-lg"></i>
  </button>
</nav>

<!-- Sidebar -->
<div id="sidebar-overlay" onclick="toggleSidebar()"></div>
<aside id="sidebar" aria-hidden="true">
  <button class="btn btn-close btn-close-white mb-3" onclick="toggleSidebar()" aria-label="Fermer"></button>
  <div class="mb-4 text-center">
    <i class="fas fa-bars fa-2x" style="color:var(--primary)"></i>
    <h5 class="fw-bold text-white mt-2">MENU</h5>
  </div>
  <!-- Liens identiques à la navbar -->
  <a class="sidebar-link" href="{{ route('accueil') }}"><i class="fas fa-home me-2"></i>Accueil</a>
  <a class="sidebar-link" href="{{ route('recherche') }}"><i class="fas fa-search me-2"></i>Recherche</a>
  <a class="sidebar-link" href="{{ route('dashboard') }}"><i class="fas fa-user me-2"></i>Mon compte</a>
  <a class="sidebar-link" href="{{ route('historique') }}"><i class="fas fa-history me-2"></i>Réservation</a>
  <div class="mt-4">
    <a class="btn btn-header w-100" href="{{ route('logout') }}"><i class="fa fa-sign-out me-2"></i>Déconnexion</a>
  </div>
</aside>

<!-- Contenu -->
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
    <img src="{{ $first }}" alt="{{ $residence->nom }}" class="residence-img" data-bs-toggle="modal" data-bs-target="#lightboxModal" />
    <div class="card-body text-center">
      <h2 class="fw-bold">{{ $residence->nom }}</h2>
      <p class="price mb-2">{{ number_format($residence->prix_journalier,0,',',' ') }} FCFA / nuit</p>
      <p class="text-start">{!! nl2br(e($residence->description)) !!}</p>
      <div class="d-flex justify-content-center gap-3 mt-4">
        <a href="{{ route('accueil') }}" class="btn btn-back">⬅ Accueil</a>
        <a href="{{ route('recherche') }}" class="btn btn-back">⬅ Résidences</a>
        <button class="btn btn-reserver" data-bs-toggle="modal" data-bs-target="#reservationModal">Réserver</button>
      </div>
    </div>
  </article>

  <!-- Galerie invisible pour lightbox -->
  @if(is_array($images))
    @foreach($images as $key=>$img)
      @if($key>0)
        <a href="{{ $img }}" class="glightbox" data-gallery="residence-{{ $residence->id }}" data-title="{{ $residence->nom }}" style="display:none;"></a>
      @endif
    @endforeach
  @endif
</main>

<!-- Lightbox Modal (GLightbox) -->
<div class="modal fade" id="lightboxModal" tabindex="-1">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content modal-light position-relative">
      <button class="light-close" data-bs-dismiss="modal">&times;</button>
      <div id="carouselLightbox" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner py-5">
          @if(!empty($images))
            @foreach($images as $index=>$img)
              <div class="carousel-item {{ $index===0?'active':'' }}">
                <img src="{{ $img }}" class="d-block mx-auto light-img" alt="Image {{ $index+1 }}">
              </div>
            @endforeach
          @else
            <div class="carousel-item active">
              <img src="https://placehold.co/900x500?text=Aucune+image" class="d-block mx-auto light-img">
            </div>
          @endif
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselLightbox" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselLightbox" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Reservation Modal -->
<div class="modal fade" id="reservationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 rounded-4">
      <h4 class="text-center fw-bold mb-3" style="color:var(--primary)">Réserver cette résidence</h4>
      <div id="validationMessage" class="alert alert-danger d-none"></div>
      <form id="reservationForm" action="{{ route('reservation.store', $residence->id) }}" method="POST">
        @csrf
        <div class="mb-3">
          <label class="form-label fw-semibold">Date d'arrivée</label>
          <input type="date" id="date_arrivee" name="date_arrivee" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Date de départ</label>
          <input type="date" id="date_depart" name="date_depart" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Nombre de personnes</label>
          <input type="number" id="personnes" name="personnes" class="form-control" min="1" value="1" required>
        </div>
        <div id="prefacture" class="border rounded-3 p-3 mt-3 bg-light d-none">
          <h6 class="fw-bold text-center mb-3">🧾 Préfacture</h6>
          <p class="mb-1"><strong>Durée :</strong> <span id="jours">0</span> nuit(s)</p>
          <p class="mb-1"><strong>Prix journalier :</strong> {{ number_format($residence->prix_journalier,0,',',' ') }} FCFA</p>
          <p class="mt-2 pt-2 border-top fw-bold"><strong>Total estimé :</strong> <span id="total">0</span> FCFA</p>
        </div>
        <div class="d-flex justify-content-between mt-4">
          <button type="button" class="btn btn-back" data-bs-dismiss="modal">Annuler</button>
          <button type="submit" class="btn btn-reserver" id="btnConfirmer" disabled>Confirmer la réservation</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 p-3 text-center">
      <h5 class="fw-bold text-primary">Confirmation de Réservation</h5>
      <p id="confirmationMessage" class="my-3"></p>
      <div class="d-flex justify-content-around">
        <button type="button" class="btn btn-back" data-bs-dismiss="modal">Modifier</button>
        <button type="button" class="btn btn-reserver" id="btnFinalSubmit">Confirmer et Continuer</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/glightbox.min.js"></script>

<script>
// Sidebar toggle
document.getElementById('btnToggle')?.addEventListener('click', toggleSidebar);
function toggleSidebar(){
  document.getElementById('sidebar').classList.toggle('active');
  document.getElementById('sidebar-overlay').classList.toggle('active');
}

// GLightbox init
document.addEventListener('DOMContentLoaded', function() {
  GLightbox({ selector: '.glightbox', touchNavigation:true, loop:true });
});

// Reservation logic
(function(){
  const prix = {{ $residence->prix_journalier ?? 55000 }};
  const d1 = document.getElementById('date_arrivee');
  const d2 = document.getElementById('date_depart');
  const pref = document.getElementById('prefacture');
  const joursEl = document.getElementById('jours');
  const totalEl = document.getElementById('total');
  const btnConf = document.getElementById('btnConfirmer');
  const validation = document.getElementById('validationMessage');
  const form = document.getElementById('reservationForm');
  const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
  const reservationModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('reservationModal'));
  const confirmationMessage = document.getElementById('confirmationMessage');
  const btnFinal = document.getElementById('btnFinalSubmit');

  function formatFCFA(v){ return v.toLocaleString('fr-FR'); }
  function calc(){
    validation.classList.add('d-none');
    if(!d1.value || !d2.value){ pref.classList.add('d-none'); btnConf.disabled=true; return; }
    const start=new Date(d1.value);
    const end=new Date(d2.value);
    const today=new Date(); today.setHours(0,0,0,0);
    if(start<today){ validation.textContent="La date d'arrivée ne peut pas être antérieure à aujourd'hui."; validation.classList.remove('d-none'); pref.classList.add('d-none'); btnConf.disabled=true; return; }
    if(end<=start){ validation.textContent="La date de départ doit être strictement postérieure à la date d'arrivée."; validation.classList.remove('d-none'); pref.classList.add('d-none'); btnConf.disabled=true; return; }
    const nights = Math.round((end-start)/(1000*60*60*24));
    joursEl.textContent = nights;
    totalEl.textContent = formatFCFA(nights*prix);
    pref.classList.remove('d-none');
    btnConf.disabled = false;
  }

  d1?.addEventListener('change', calc);
  d2?.addEventListener('change', calc);

  form?.addEventListener('submit', ev=>{
    ev.preventDefault();
    calc();
    if(btnConf.disabled) return;
    const nights = Number(joursEl.textContent||0);
    confirmationMessage.innerHTML = `Vous réservez <strong>${nights}</strong> nuit(s) pour <strong>${formatFCFA(nights*prix)} FCFA</strong>. Confirmez-vous ?`;
    reservationModal.hide();
    confirmationModal.show();
  });

  btnFinal?.addEventListener('click', ()=>{
    confirmationModal.hide();
    form.submit();
  });

})();
</script>
</body>
</html>
