<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Détails — {{ $residences_details->nom ?? 'Résidence' }}</title>

  {{-- Assets principaux --}}
  <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

  {{-- GLightbox CSS --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/css/glightbox.min.css" rel="stylesheet">

  {{-- ======= Styles locaux (Version Whaoooo / Sans retrait) ======= --}}
  <style>
    :root {
      --primary-gradient: linear-gradient(135deg, #006d77, #00afb9);
      --primary-color: #006d77;
      --accent-color: #00afb9;
      --bg-light: #f8fafc;
      --dark-navy: #0f172a;
      --card-shadow: 0 20px 40px -12px rgba(0,0,0,0.08);
      --radius-xl: 24px;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--bg-light);
      color: var(--dark-navy);
      margin: 0;
    }

    /* ============================
       HEADER & NAV (Gradient Style)
    ============================ */
    .site-header {
      background: white;
      border-bottom: 1px solid rgba(0,0,0,0.05);
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    .site-header .brand img { width: 75px; height: auto; }
    
    .btn-header {
      background: var(--primary-gradient);
      color: white !important;
      border-radius: 50px;
      padding: 10px 24px;
      font-weight: 700;
      border: none;
      transition: transform 0.3s ease;
    }
    .btn-header:hover { transform: translateY(-2px); box-shadow: 0 8px 15px rgba(0, 109, 119, 0.2); }

    .btn-ghost {
      color: var(--dark-navy);
      font-weight: 600;
      text-decoration: none;
    }

    /* ============================
       LAYOUT & CARDS
    ============================ */
    main.container { padding: 3rem 1rem; max-width: 1200px; }

    .page-title h1 { 
      font-weight: 800; 
      font-size: 2.25rem; 
      background: var(--primary-gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .res-card {
      display: grid;
      grid-template-columns: 1fr 400px;
      gap: 30px;
      margin-top: 2rem;
    }

    @media (max-width: 992px) { .res-card { grid-template-columns: 1fr; } }

    .res-card__visual {
      background: white;
      border-radius: var(--radius-xl);
      overflow: hidden;
      box-shadow: var(--card-shadow);
      position: relative;
    }

    .res-card__media { 
      width: 100%; 
      height: 500px; 
      object-fit: cover; 
      cursor: zoom-in;
      transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .res-card__media:hover { transform: scale(1.03); }

    .res-card__thumbs { 
      display: flex; 
      gap: 12px; 
      padding: 15px; 
      background: rgba(255,255,255,0.8);
      backdrop-filter: blur(10px);
      position: absolute;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      border-radius: 20px;
      border: 1px solid white;
    }
    .res-card__thumbs img { 
      width: 70px; height: 50px; 
      object-fit: cover; 
      border-radius: 10px; 
      cursor: pointer; 
      opacity: 0.6; 
      transition: 0.3s; 
    }
    .res-card__thumbs img.active, .res-card__thumbs img:hover { 
      opacity: 1; 
      transform: scale(1.1); 
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .res-details {
      background: white;
      border-radius: var(--radius-xl);
      padding: 30px;
      box-shadow: var(--card-shadow);
      border: 1px solid rgba(255,255,255,0.5);
    }

    .res-details h2 { font-weight: 800; font-size: 1.5rem; margin-bottom: 1rem; color: var(--dark-navy); }
    .res-meta { color: var(--muted); margin-bottom: 1.5rem; display: flex; flex-direction: column; gap: 8px; }
    .res-meta i { color: var(--accent-color); width: 20px; }

    .res-price { 
      font-size: 1.75rem; 
      font-weight: 800; 
      color: var(--primary-color);
      padding: 20px 0;
      border-top: 1px solid #f1f5f9;
    }

    /* PREFACTURE BOX */
    .prefacture {
      background: #f1f5f9;
      border-radius: 16px;
      padding: 20px;
      border-left: 5px solid var(--accent-color);
      margin: 15px 0;
    }

    /* BUTTONS */
    .btn-reserver {
      background: var(--primary-gradient) !important;
      border: none !important;
      border-radius: 50px !important;
      padding: 15px 30px !important;
      font-weight: 700 !important;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: all 0.3s ease;
    }
    .btn-reserver:hover { transform: scale(1.05); box-shadow: 0 10px 20px rgba(0,175,185,0.3); }

    /* SIDEBAR MOBILE */
    #sidebar { background: var(--dark-navy); }
    .sidebar-link { font-weight: 600; transition: 0.3s; }
    .sidebar-link:hover { background: var(--primary-gradient); }

    /* MODALS */
    .modal-content { border-radius: 30px; border: none; overflow: hidden; }
    .form-control { border-radius: 12px; padding: 12px; border: 2px solid #f1f5f9; }
    .form-control:focus { border-color: var(--accent-color); box-shadow: none; }
  </style>
</head>
<body>

  <header class="site-header">
    <nav class="container d-flex align-items-center justify-content-between py-2">
      <a class="brand d-flex align-items-center" href="{{ route('accueil') }}">
        <img src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub" />
      </a>

      <div class="d-flex align-items-center">
        <div class="nav-links d-none d-lg-flex align-items-center me-3">
          @auth
            <a class="nav-link text-dark" href="{{ route('recherche') }}">Résidences</a>
            <a class="nav-link text-dark" href="{{ Auth::user()->type_compte == 'professionnel' ? route('pro.dashboard') : route('clients_historique') }}">Profil</a>
          @endauth
        </div>

        <a class="btn btn-ghost me-3 d-none d-lg-inline" href="javascript:history.back()"> <i class="fas fa-arrow-left"></i> Retour</a>
        @auth
          <a class="btn btn-header d-none d-lg-inline" href="{{ route('logout') }}">Quitter</a>
        @endauth

        <button id="btnToggle" class="btn btn-ghost d-lg-none">
          <i class="fas fa-bars-staggered fa-lg"></i>
        </button>
      </div>
    </nav>
  </header>

  {{-- Sidebar Mobile --}}
  <div id="sidebar-overlay" onclick="toggleSidebar()"></div>
  <aside id="sidebar">
    <div class="sidebar-header">
      <h4 class="fw-bold">Menu</h4>
      <button class="btn btn-close btn-close-white" onclick="toggleSidebar()"></button>
    </div>
    @if(Auth::check() && Auth::user()->type_compte === 'professionnel')
      <a class="sidebar-link" href="{{ route('pro.dashboard') }}">Profil</a>
      <a class="sidebar-link" href="{{ route('recherche') }}">Recherche</a>
      <a class="sidebar-link" href="{{ route('mes_demandes') }}">Demandes</a>
      <a class="sidebar-link" href="{{ route('reservationRecu') }}">Réservations</a>
    @elseif(Auth::check() && Auth::user()->type_compte === 'client')
      <a class="sidebar-link" href="{{ route('clients_historique') }}">Mon Profil</a>
    @endif
    <a class="sidebar-link" href="javascript:history.back()">Retour</a>
    <a class="sidebar-link" href="{{ route('accueil') }}">Accueil</a>
    <div class="mt-4 px-3">
      <a class="btn btn-header w-100" href="{{ route('logout') }}">Déconnexion</a>
    </div>
  </aside>

  <main class="container">
    <section class="page-title text-center">
      <h1>{{ $residences_details->nom ?? 'Nom de la résidence' }}</h1>
      <p class="text-muted"><i class="fas fa-sparkles text-warning me-2"></i> Une expérience unique sélectionnée par Afrik'Hub</p>
    </section>

    @if($errors->any())
      <div class="alert alert-danger rounded-4 border-0 shadow-sm mt-4">
        <ul class="mb-0">
          @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
        </ul>
      </div>
    @endif

    @php
      $images = is_string($residences_details->img) ? json_decode($residences_details->img, true) : ($residences_details->img ?? []);
      if(!is_array($images)) $images = [];
      $first = $images[0] ?? asset('assets/images/placeholder-900x500.png');
    @endphp

    <article class="res-card">
      {{-- Visuel --}}
      <div class="res-card__visual">
        <img id="mainPreview" class="res-card__media" src="{{ $first }}" alt="{{ $residences_details->nom }}" loading="lazy" role="button" tabindex="0">
        
        @if(count($images) > 1)
          <div class="res-card__thumbs" id="thumbs">
            @foreach($images as $i => $img)
              <img src="{{ $img }}" data-index="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" alt="Thumb">
            @endforeach
          </div>
        @endif
      </div>

      {{-- Détails --}}
      <div class="res-details">
        <h2>À propos de ce lieu</h2>
        <div class="res-meta">
          <span><i class="fas fa-location-dot"></i> {{ $residences_details->ville }}, {{ $residences_details->pays }}</span>
          <span><i class="fas fa-bed"></i> {{ $residences_details->chambres ?? 1 }} Chambres spacieuses</span>
          <span><i class="fas fa-couch"></i> {{ $residences_details->salons ?? 1 }} Salons confortables</span>
        </div>

        <div class="description mb-4">
          <p class="small text-muted" style="line-height: 1.8;">{!! nl2br(e(Str::limit($residences_details->details ?? '-', 600))) !!}</p>
        </div>

        <h2 class="mt-4">Équipements</h2>
        <p class="small text-muted mb-4">{!! nl2br(e(Str::limit($residences_details->commodites ?? '-', 600))) !!}</p>
        
        <div class="res-price">
          {{ number_format($residences_details->prix_journalier ?? 0, 0, ',', ' ') }} <small class="text-muted" style="font-size: 14px;">FCFA / nuit</small>
        </div>

        <div id="prefacture" class="prefacture d-none">
          <h6 class="fw-bold mb-3"><i class="fas fa-file-invoice-dollar me-2"></i>Estimation de votre séjour</h6>
          <div class="d-flex justify-content-between mb-1"><span>Durée :</span> <span id="jours" class="fw-bold">0</span> nuit(s)</div>
          <div class="d-flex justify-content-between pt-2 border-top mt-2"><strong>Total :</strong> <strong id="total" class="text-primary">0</strong> <strong>FCFA</strong></div>
        </div>

        <div class="res-actions mt-auto d-grid gap-3">
          @auth
            <button class="btn btn-reserver" data-bs-toggle="modal" data-bs-target="#reservationModal" id="openReserve">Réserver maintenant</button>
          @endauth
          @guest
            <button onclick="saveResidenceAndLogin({{ $residences_details->id }})" class="btn btn-outline-dark rounded-pill py-3 fw-bold">Se connecter pour réserver</button>
          @endguest
          <a class="btn btn-link text-dark fw-bold text-decoration-none" href="{{ route('recherche') }}">Voir d'autres résidences</a>
        </div>
      </div>
    </article>

    {{-- GLightbox anchors cachés --}}
    <div style="display:none">
      @foreach($images as $i => $img)
        <a href="{{ $img }}" class="glightbox" data-gallery="res-{{ $residences_details->id }}" data-title="{{ $residences_details->nom }}"></a>
      @endforeach
    </div>
  </main>

  {{-- MODAL RESERVATION --}}
  <div class="modal fade" id="reservationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header border-0 px-4 pt-4">
          <h5 class="fw-black">Dates de séjour</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body px-4">
          <div id="validationMessage" class="alert alert-danger d-none"></div>
          <form id="reservationForm" method="POST" action="{{ route('reservation.store', $residences_details->id) }}">
            @csrf
            <div class="mb-3">
              <label class="form-label">Arrivée</label>
              <input type="date" id="date_arrivee" name="date_arrivee" class="form-control" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Départ</label>
              <input type="date" id="date_depart" name="date_depart" class="form-control" required />
            </div>
            <div class="mb-3">
              <label class="form-label">Voyageurs</label>
              <input type="number" id="personnes" name="personnes" class="form-control" min="1" value="1" required />
            </div>
            <div class="d-grid gap-2 mt-4 mb-3">
              <button type="submit" class="btn btn-reserver" id="btnConfirmer" disabled>Suivant</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- MODAL CONFIRMATION --}}
  <div class="modal fade" id="confirmationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center p-4">
        <div class="py-3">
           <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
           <h4 class="fw-bold">Confirmer mon séjour</h4>
           <p id="confirmationMessage" class="text-muted"></p>
        </div>
        <div class="d-grid gap-2">
          <button type="button" class="btn btn-reserver" id="btnFinalSubmit">Confirmer et payer</button>
          <button type="button" class="btn btn-link text-muted" data-bs-dismiss="modal">Modifier les dates</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/js/glightbox.min.js"></script>
  <script>
    // Sidebar
    function toggleSidebar(){
      const sb = document.getElementById('sidebar');
      const ov = document.getElementById('sidebar-overlay');
      sb.classList.toggle('active');
      ov.classList.toggle('active');
    }
    document.getElementById('btnToggle')?.addEventListener('click', toggleSidebar);

    // GLightbox
    document.addEventListener('DOMContentLoaded', function(){
      const lightbox = GLightbox({ selector: '.glightbox', loop: true });
      const mainPreview = document.getElementById('mainPreview');
      if(mainPreview) {
        mainPreview.addEventListener('click', () => lightbox.openAt(0));
      }
      document.querySelectorAll('#thumbs img').forEach(img => {
        img.addEventListener('click', function(){
          lightbox.openAt(Number(this.dataset.index));
          document.querySelector('#thumbs img.active')?.classList.remove('active');
          this.classList.add('active');
        });
      });
    });

    // Login logic
    function saveResidenceAndLogin(id) {
      document.cookie = "residence_to_reserve=" + id + "; max-age=3600; path=/";
      window.location.href = "{{ route('login') }}";
    }

    // Reservation Logic
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

      d1?.addEventListener('change', calc);
      d2?.addEventListener('change', calc);

      form?.addEventListener('submit', (ev) => {
        ev.preventDefault();
        const n = calc();
        document.getElementById('confirmationMessage').innerHTML = `Vous réservez <strong>${n} nuits</strong>. <br> Montant total : <strong>${(n * prix).toLocaleString('fr-FR')} FCFA</strong>`;
        reservationModal.hide();
        confirmationModal.show();
      });

      document.getElementById('btnFinalSubmit')?.addEventListener('click', () => form.submit());
    })();
  </script>

</body>
</html>