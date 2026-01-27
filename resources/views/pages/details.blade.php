<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Détails — {{ $residences_details->nom ?? 'Résidence' }}</title>

  {{-- Assets principaux --}}
  <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">

  {{-- GLightbox CSS --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/css/glightbox.min.css" rel="stylesheet">

  <style>
    :root {
      --primary: #006d77;
      --accent: #00afb9;
      --gradient: linear-gradient(135deg, #006d77, #00afb9);
      --bg: #f8fafc;
      --dark: #0f172a;
      --shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bg);
      color: var(--dark);
    }

    /* Navbar Premium */
    .site-header {
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(0,0,0,0.05);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .btn-header {
      background: var(--gradient);
      color: white !important;
      border-radius: 12px;
      padding: 10px 24px;
      font-weight: 700;
      border: none;
      box-shadow: 0 4px 12px rgba(0, 109, 119, 0.2);
    }

    /* ======= SIDEBAR PRO STYLE ======= */
    #sidebar {
      position: fixed;
      top: 0;
      right: -320px; /* Caché à droite */
      width: 320px;
      height: 100vh;
      background: white;
      z-index: 1100;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      box-shadow: -10px 0 30px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: column;
      padding: 30px 20px;
    }

    #sidebar.active {
      right: 0;
    }

    #sidebar-overlay {
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.5);
      backdrop-filter: blur(4px);
      z-index: 1050;
      opacity: 0;
      visibility: hidden;
      transition: 0.3s;
    }

    #sidebar-overlay.active {
      opacity: 1;
      visibility: visible;
    }

    .sidebar-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 40px;
      padding-bottom: 20px;
      border-bottom: 1px solid #f1f5f9;
    }

    .sidebar-link {
      display: flex;
      align-items: center;
      padding: 14px 18px;
      color: var(--dark);
      text-decoration: none;
      font-weight: 600;
      border-radius: 12px;
      margin-bottom: 8px;
      transition: 0.2s;
    }

    .sidebar-link i {
      width: 24px;
      margin-right: 12px;
      font-size: 1.1rem;
      color: var(--slate-500);
      transition: 0.2s;
    }

    .sidebar-link:hover {
      background: #f1f5f9;
      color: var(--primary);
    }

    .sidebar-link:hover i {
      color: var(--primary);
      transform: translateX(3px);
    }

    .sidebar-link.active {
      background: rgba(0, 109, 119, 0.08);
      color: var(--primary);
    }

    /* Titre & Typo */
    .page-title h1 { 
      font-weight: 800; 
      letter-spacing: -0.02em;
      background: var(--gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    /* Layout Carte */
    .res-card {
      display: grid;
      grid-template-columns: 1fr 420px;
      gap: 32px;
      margin-top: 2rem;
    }

    @media (max-width: 992px) { .res-card { grid-template-columns: 1fr; } }

    /* Galerie */
    .res-card__visual {
      border-radius: 32px;
      overflow: hidden;
      box-shadow: var(--shadow);
      background: #fff;
      position: relative;
    }

    .res-card__media { 
      width: 100%; 
      height: 550px; 
      object-fit: cover; 
      transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .res-card__thumbs { 
      display: flex; 
      gap: 12px; 
      padding: 12px; 
      background: rgba(255, 255, 255, 0.7);
      backdrop-filter: blur(8px);
      position: absolute;
      bottom: 24px;
      left: 50%;
      transform: translateX(-50%);
      border-radius: 24px;
      border: 1px solid rgba(255,255,255,0.4);
    }

    .res-card__thumbs img { 
      width: 60px; height: 60px; 
      border-radius: 14px; 
      cursor: pointer; 
      opacity: 0.7; 
      transition: 0.3s; 
      object-fit: cover;
    }

    .res-card__thumbs img.active { 
      opacity: 1; 
      transform: scale(1.1); 
      box-shadow: 0 0 0 3px var(--accent);
    }

    /* Sidebar de détails (Fiche de prix) */
    .res-details {
      background: white;
      border-radius: 32px;
      padding: 40px;
      box-shadow: var(--shadow);
      display: flex;
      flex-direction: column;
    }

    .res-meta span {
      background: #f1f5f9;
      padding: 8px 16px;
      border-radius: 12px;
      font-weight: 600;
      font-size: 0.9rem;
      display: inline-block;
      margin-bottom: 8px;
    }

    .res-meta i { color: var(--primary); margin-right: 8px; }

    .res-price { 
      font-size: 2rem; 
      font-weight: 800; 
      color: var(--primary);
      margin: 24px 0;
    }

    .prefacture {
      background: #f8fafc;
      border-radius: 20px;
      padding: 24px;
      border: 1px solid #e2e8f0;
      margin-bottom: 24px;
    }

    .btn-reserver {
      background: var(--gradient) !important;
      border: none !important;
      border-radius: 16px !important;
      padding: 18px !important;
      font-weight: 800 !important;
      font-size: 1.1rem;
      box-shadow: 0 10px 15px -3px rgba(0, 175, 185, 0.4);
      transition: 0.3s;
    }

    .btn-reserver:hover:not(:disabled) {
      transform: translateY(-2px);
      box-shadow: 0 20px 25px -5px rgba(0, 175, 185, 0.4);
    }

    .modal-content { border-radius: 32px; border: none; padding: 10px; }
    .form-control { 
      border-radius: 14px; 
      padding: 12px 16px; 
      border: 2px solid #f1f5f9;
      background: #f8fafc;
    }
    .form-control:focus { border-color: var(--accent); box-shadow: none; background: #fff; }
  </style>
</head>
<body>

  <header class="site-header">
    <nav class="container d-flex align-items-center justify-content-between py-3">
      <a class="brand d-flex align-items-center" href="{{ route('accueil') }}">
        <img src="{{ asset('assets/images/logo_01.png') }}" style="width: 80px;" alt="Afrik'Hub" />
      </a>

      <div class="d-flex align-items-center">
        <div class="nav-links d-none d-lg-flex align-items-center me-4">
          @auth
            <a class="nav-link fw-bold px-3" href="{{ route('recherche') }}">Résidences</a>
            <a class="nav-link fw-bold px-3" href="{{ Auth::user()->type_compte == 'professionnel' ? route('pro.dashboard') : route('clients_historique') }}">Mon Profil</a>
          @endauth
        </div>

        <a class="btn btn-light rounded-pill me-2 d-none d-lg-inline fw-bold" href="javascript:history.back()"><i class="fas fa-arrow-left me-2"></i>Retour</a>
        @auth
          <a class="btn btn-header d-none d-lg-inline" href="{{ route('logout') }}">Déconnexion</a>
        @endauth

        <button id="btnToggle" class="btn btn-light rounded-circle ms-2" style="width: 45px; height: 45px;">
          <i class="fas fa-bars-staggered"></i>
        </button>
      </div>
    </nav>
  </header>

  <div id="sidebar-overlay" onclick="toggleSidebar()"></div>
  <aside id="sidebar">
    <div class="sidebar-header">
      <h4 class="fw-bold mb-0">Navigation</h4>
      <button class="btn btn-light rounded-circle" onclick="toggleSidebar()"><i class="fas fa-times"></i></button>
    </div>
    
    <div class="sidebar-menu">
      <a class="sidebar-link" href="{{ route('accueil') }}">
        <i class="fas fa-house"></i> Accueil
      </a>
      
      @if(Auth::check() && Auth::user()->type_compte === 'professionnel')
        <a class="sidebar-link" href="{{ route('pro.dashboard') }}">
          <i class="fas fa-user-tie"></i> Mon Profil Pro
        </a>
        <a class="sidebar-link" href="{{ route('recherche') }}">
          <i class="fas fa-search"></i> Parcourir
        </a>
        <a class="sidebar-link" href="{{ route('mes_demandes') }}">
          <i class="fas fa-envelope-open-text"></i> Mes Demandes
        </a>
        <a class="sidebar-link" href="{{ route('reservationRecu') }}">
          <i class="fas fa-calendar-check"></i> Réservations reçues
        </a>
      @elseif(Auth::check() && Auth::user()->type_compte === 'client')
        <a class="sidebar-link" href="{{ route('clients_historique') }}">
          <i class="fas fa-user-circle"></i> Mon Profil
        </a>
        <a class="sidebar-link" href="{{ route('recherche') }}">
          <i class="fas fa-magnifying-glass"></i> Trouver un logement
        </a>
      @endif

      <a class="sidebar-link" href="javascript:history.back()">
        <i class="fas fa-chevron-left"></i> Page précédente
      </a>
    </div>

    <div class="mt-auto">
      <hr class="text-muted opacity-25">
      @auth
        <a class="btn btn-header w-100 py-3" href="{{ route('logout') }}">
          <i class="fas fa-right-from-bracket me-2"></i> Déconnexion
        </a>
      @else
        <a class="btn btn-header w-100 py-3" href="{{ route('login') }}">
          <i class="fas fa-user me-2"></i> Connexion
        </a>
      @endauth
    </div>
  </aside>

  <main class="container py-5">
    <section class="page-title text-center mb-5">
      <h1 class="display-5 fw-bolder">{{ $residences_details->nom ?? 'Résidence' }}</h1>
      <p class="text-muted fw-semibold">Réservez votre séjour en quelques clics</p>
    </section>

    @if($errors->any())
      <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4">
        @foreach($errors->all() as $err)<div><i class="fas fa-circle-exclamation me-2"></i>{{ $err }}</div>@endforeach
      </div>
    @endif

    @php
      $images = is_string($residences_details->img) ? json_decode($residences_details->img, true) : ($residences_details->img ?? []);
      if(!is_array($images)) $images = [];
      $first = $images[0] ?? asset('assets/images/placeholder-900x500.png');
    @endphp

    <article class="res-card">
      <div class="res-card__visual">
        <img id="mainPreview" class="res-card__media" src="{{ $first }}" alt="{{ $residences_details->nom }}" loading="lazy" role="button">
        
        @if(count($images) > 1)
          <div class="res-card__thumbs" id="thumbs">
            @foreach($images as $i => $img)
              <img src="{{ $img }}" data-index="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" alt="Miniature">
            @endforeach
          </div>
        @endif
      </div>

      <div class="res-details">
        <div class="res-meta mb-3">
          <span><i class="fas fa-location-dot"></i> {{ $residences_details->ville }}, {{ $residences_details->pays }}</span>
          <div class="d-flex gap-2 mt-2">
            <span><i class="fas fa-bed"></i> {{ $residences_details->chambres ?? 1 }} Ch.</span>
            <span><i class="fas fa-couch"></i> {{ $residences_details->salons ?? 1 }} Salons</span>
          </div>
        </div>

        <h4 class="fw-bold mb-3">Description</h4>
        <p class="text-muted small mb-4" style="line-height: 1.6;">{!! nl2br(e(Str::limit($residences_details->details ?? '-', 600))) !!}</p>

        <h4 class="fw-bold mb-3">Commodités</h4>
        <p class="text-muted small mb-4">{!! nl2br(e(Str::limit($residences_details->commodites ?? '-', 600))) !!}</p>
        
        <div class="res-price">
          {{ number_format($residences_details->prix_journalier ?? 0, 0, ',', ' ') }} <small class="text-muted" style="font-size: 1rem;">FCFA / nuit</small>
        </div>

        <div id="prefacture" class="prefacture d-none">
          <div class="d-flex justify-content-between mb-2">
            <span class="text-muted">Séjour de</span>
            <span class="fw-bold"><span id="jours">0</span> nuit(s)</span>
          </div>
          <div class="d-flex justify-content-between pt-2 border-top">
            <span class="fw-bold">Total estimé</span>
            <span class="fw-bold text-primary"><span id="total">0</span> FCFA</span>
          </div>
        </div>

        <div class="d-grid gap-3">
          @auth
            <button class="btn btn-reserver" data-bs-toggle="modal" data-bs-target="#reservationModal" id="openReserve">Vérifier la disponibilité</button>
          @endauth
          @guest
            <button onclick="saveResidenceAndLogin({{ $residences_details->id }})" class="btn btn-outline-dark rounded-4 py-3 fw-bold">Se connecter pour réserver</button>
          @endguest
          <a class="btn btn-link text-muted fw-bold text-decoration-none" href="{{ route('recherche') }}">Parcourir d'autres offres</a>
        </div>
      </div>
    </article>

    <div style="display:none">
      @foreach($images as $i => $img)
        <a href="{{ $img }}" class="glightbox" data-gallery="res-{{ $residences_details->id }}" data-title="{{ $residences_details->nom }}"></a>
      @endforeach
    </div>
  </main>

  <div class="modal fade" id="reservationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow-lg">
        <div class="modal-header border-0 pb-0">
          <h4 class="fw-bold mb-0">Réserver votre séjour</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <div id="validationMessage" class="alert alert-danger d-none rounded-4"></div>
          <form id="reservationForm" method="POST" action="{{ route('reservation.store', $residences_details->id) }}">
            @csrf
            <div class="row g-3">
              <div class="col-6">
                <label class="form-label fw-bold small text-muted">DATE D'ARRIVÉE</label>
                <input type="date" id="date_arrivee" name="date_arrivee" class="form-control" required />
              </div>
              <div class="col-6">
                <label class="form-label fw-bold small text-muted">DATE DE DÉPART</label>
                <input type="date" id="date_depart" name="date_depart" class="form-control" required />
              </div>
              <div class="col-12">
                <label class="form-label fw-bold small text-muted">NOMBRE DE VOYAGEURS</label>
                <input type="number" id="personnes" name="personnes" class="form-control" min="1" value="1" required />
              </div>
            </div>
            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-reserver" id="btnConfirmer" disabled>Réserver maintenant</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="confirmationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center p-4">
        <div class="mb-4">
           <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
              <i class="fas fa-calendar-check fa-2x"></i>
           </div>
           <h3 class="fw-bold">Presque fini !</h3>
           <p id="confirmationMessage" class="text-muted"></p>
        </div>
        <div class="d-grid gap-2">
          <button type="button" class="btn btn-reserver" id="btnFinalSubmit">Confirmer la demande</button>
          <button type="button" class="btn btn-light rounded-4 py-3 fw-bold" data-bs-dismiss="modal">Modifier</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/js/glightbox.min.js"></script>
  
  <script>
    function toggleSidebar(){
      document.getElementById('sidebar').classList.toggle('active');
      document.getElementById('sidebar-overlay').classList.toggle('active');
    }
    document.getElementById('btnToggle')?.addEventListener('click', toggleSidebar);

    document.addEventListener('DOMContentLoaded', function(){
      const lightbox = GLightbox({ selector: '.glightbox', loop: true });
      const mainPreview = document.getElementById('mainPreview');
      
      if(mainPreview) {
        mainPreview.addEventListener('click', () => lightbox.openAt(0));
      }
      
      document.querySelectorAll('#thumbs img').forEach(img => {
        img.addEventListener('click', function(){
          const idx = parseInt(this.dataset.index);
          lightbox.openAt(idx);
          document.querySelector('#thumbs img.active')?.classList.remove('active');
          this.classList.add('active');
        });
      });
    });

    function saveResidenceAndLogin(id) {
      document.cookie = "residence_to_reserve=" + id + "; max-age=3600; path=/";
      window.location.href = "{{ route('login') }}";
    }

    (function(){
      const prix = Number(@json($residences_details->prix_journalier ?? 0));
      const d1 = document.getElementById('date_arrivee');
      const d2 = document.getElementById('date_depart');
      const pref = document.getElementById('prefacture');
      const joursEl = document.getElementById('jours');
      const totalEl = document.getElementById('total');
      const btnConf = document.getElementById('btnConfirmer');
      const form = document.getElementById('reservationForm');
      const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
      const reservationModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('reservationModal'));

      function calc(){
        if(!d1.value || !d2.value) { pref.classList.add('d-none'); btnConf.disabled = true; return; }
        const start = new Date(d1.value);
        const end = new Date(d2.value);
        if(end <= start) { btnConf.disabled = true; return; }
        
        const nights = Math.round((end - start) / (1000*60*60*24));
        joursEl.textContent = nights;
        totalEl.textContent = (nights * prix).toLocaleString('fr-FR');
        pref.classList.remove('d-none');
        btnConf.disabled = false;
        return nights;
      }

      [d1, d2].forEach(el => el?.addEventListener('change', calc));

      form?.addEventListener('submit', (ev) => {
        ev.preventDefault();
        const n = calc();
        document.getElementById('confirmationMessage').innerHTML = `Vous souhaitez réserver pour <strong>${n} nuits</strong>.<br>Montant total : <strong>${(n * prix).toLocaleString('fr-FR')} FCFA</strong>`;
        reservationModal.hide();
        confirmationModal.show();
      });

      document.getElementById('btnFinalSubmit')?.addEventListener('click', () => form.submit());
    })();
  </script>
</body>
</html>