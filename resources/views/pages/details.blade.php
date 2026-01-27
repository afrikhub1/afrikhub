<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Détails — {{ $residences_details->nom ?? 'Résidence' }}</title>

  {{-- Assets --}}
  <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/css/glightbox.min.css" rel="stylesheet">

  <style>
    :root {
      --primary: #006d77;
      --accent: #00afb9;
      --gradient: linear-gradient(135deg, #006d77, #00afb9);
      --bg: #f8fafc;
      --dark: #0f172a;
      --shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }

    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg); color: var(--dark); }

    /* Navbar */
    .site-header { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000; }
    .btn-header { background: var(--gradient); color: white !important; border-radius: 12px; padding: 10px 24px; font-weight: 700; border: none; box-shadow: 0 4px 12px rgba(0, 109, 119, 0.2); }

    /* Sidebar Pro Style */
    #sidebar { position: fixed; top: 0; right: -320px; width: 320px; height: 100vh; background: white; z-index: 1100; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: -10px 0 30px rgba(0,0,0,0.1); display: flex; flex-direction: column; padding: 30px 20px; }
    #sidebar.active { right: 0; }
    #sidebar-overlay { position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px); z-index: 1050; opacity: 0; visibility: hidden; transition: 0.3s; }
    #sidebar-overlay.active { opacity: 1; visibility: visible; }
    .sidebar-link { display: flex; align-items: center; padding: 14px 18px; color: var(--dark); text-decoration: none; font-weight: 600; border-radius: 12px; margin-bottom: 8px; transition: 0.2s; }
    .sidebar-link i { width: 24px; margin-right: 12px; color: var(--primary); }
    .sidebar-link:hover { background: #f1f5f9; color: var(--primary); }

    /* Layout & Cards */
    .res-card { display: grid; grid-template-columns: 1fr 420px; gap: 32px; margin-top: 2rem; }
    @media (max-width: 992px) { .res-card { grid-template-columns: 1fr; } }
    
    .res-card__visual { border-radius: 32px; overflow: hidden; box-shadow: var(--shadow); background: #fff; position: relative; }
    .res-card__media { width: 100%; height: 550px; object-fit: cover; cursor: pointer; transition: 0.5s; }
    .res-card__media:hover { transform: scale(1.02); }
    
    .res-card__thumbs { display: flex; gap: 12px; padding: 12px; background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(8px); position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); border-radius: 24px; border: 1px solid rgba(255,255,255,0.4); }
    .res-card__thumbs img { width: 60px; height: 60px; border-radius: 14px; cursor: pointer; opacity: 0.7; transition: 0.3s; object-fit: cover; }
    .res-card__thumbs img.active { opacity: 1; transform: scale(1.1); box-shadow: 0 0 0 3px var(--accent); }

    .res-details { background: white; border-radius: 32px; padding: 40px; box-shadow: var(--shadow); }
    .res-meta span { background: #f1f5f9; padding: 8px 16px; border-radius: 12px; font-weight: 600; font-size: 0.9rem; display: inline-block; margin-bottom: 8px; margin-right: 5px; }
    .res-price { font-size: 2rem; font-weight: 800; color: var(--primary); margin: 24px 0; }

    .prefacture { background: #f0fdfa; border-radius: 20px; padding: 24px; border: 1px solid #ccfbf1; margin-bottom: 24px; }
    .btn-reserver { background: var(--gradient) !important; border: none !important; border-radius: 16px !important; padding: 18px !important; font-weight: 800 !important; font-size: 1.1rem; color: white !important; transition: 0.3s; box-shadow: 0 10px 15px -3px rgba(0, 175, 185, 0.4); }
    .btn-reserver:disabled { background: #cbd5e1 !important; box-shadow: none; cursor: not-allowed; }

    /* Modals */
    .modal-content { border-radius: 32px; border: none; padding: 10px; }
    .form-control { border-radius: 14px; padding: 12px 16px; border: 2px solid #f1f5f9; background: #f8fafc; }
  </style>
</head>
<body>

  <header class="site-header">
    <nav class="container d-flex align-items-center justify-content-between py-3">
      <a class="brand" href="{{ route('accueil') }}">
        <img src="{{ asset('assets/images/logo_01.png') }}" style="width: 80px;" alt="Logo" />
      </a>
      <button id="btnToggle" class="btn btn-light rounded-circle shadow-sm" style="width: 45px; height: 45px;">
        <i class="fas fa-bars-staggered"></i>
      </button>
    </nav>
  </header>

  <div id="sidebar-overlay" onclick="toggleSidebar()"></div>
  <aside id="sidebar">
    <div class="sidebar-header">
      <h4 class="fw-bold mb-0">Menu</h4>
      <button class="btn btn-light rounded-circle" onclick="toggleSidebar()"><i class="fas fa-times"></i></button>
    </div>
    <div class="sidebar-menu">
      <a class="sidebar-link" href="{{ route('accueil') }}"><i class="fas fa-house"></i> Accueil</a>
      @auth
        <a class="sidebar-link" href="{{ Auth::user()->type_compte == 'professionnel' ? route('pro.dashboard') : route('clients_historique') }}"><i class="fas fa-user-circle"></i> Profil</a>
        <a class="sidebar-link" href="{{ route('recherche') }}"><i class="fas fa-search"></i> Résidences</a>
      @endauth
      <a class="sidebar-link" href="javascript:history.back()"><i class="fas fa-chevron-left"></i> Retour</a>
    </div>
    <div class="mt-auto">
      @auth
        <a class="btn btn-header w-100" href="{{ route('logout') }}">Déconnexion</a>
      @else
        <a class="btn btn-header w-100" href="{{ route('login') }}">Connexion</a>
      @endauth
    </div>
  </aside>

  <main class="container py-5">
    <section class="text-center mb-5">
      <h1 class="display-5 fw-bolder">{{ $residences_details->nom }}</h1>
      <p class="text-muted fw-semibold">Réservez votre séjour en quelques clics</p>
    </section>

    @php
      $images = is_string($residences_details->img) ? json_decode($residences_details->img, true) : ($residences_details->img ?? []);
      $first = $images[0] ?? asset('assets/images/placeholder.png');
    @endphp

    <article class="res-card">
      <div class="res-card__visual">
        <img id="mainPreview" class="res-card__media" src="{{ $first }}" alt="Preview" role="button">
        @if(count($images) > 1)
          <div class="res-card__thumbs" id="thumbs">
            @foreach($images as $i => $img)
              <img src="{{ $img }}" data-index="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}">
            @endforeach
          </div>
        @endif
      </div>

      <div class="res-details">
        <div class="res-meta">
          <span><i class="fas fa-location-dot"></i> {{ $residences_details->ville }}</span>
          <span><i class="fas fa-bed"></i> {{ $residences_details->chambres }} Ch.</span>
        </div>

        <h4 class="fw-bold mt-4 mb-2">Description</h4>
        <p class="text-muted small">{!! nl2br(e(Str::limit($residences_details->details, 400))) !!}</p>

        <div class="res-price">
          {{ number_format($residences_details->prix_journalier, 0, ',', ' ') }} <small class="text-muted" style="font-size: 1rem">FCFA / nuit</small>
        </div>

        <div id="prefacture" class="prefacture d-none">
          <div class="d-flex justify-content-between mb-2">
            <span>Séjour de</span>
            <span class="fw-bold"><span id="jours">0</span> nuit(s)</span>
          </div>
          <div class="d-flex justify-content-between pt-2 border-top border-success border-opacity-10">
            <span class="fw-bold">Total estimé</span>
            <span class="fw-bold text-primary"><span id="total">0</span> FCFA</span>
          </div>
        </div>

        <div class="d-grid gap-3">
          @auth
            <button class="btn btn-reserver" data-bs-toggle="modal" data-bs-target="#reservationModal">Vérifier la disponibilité</button>
          @else
            <button onclick="saveResidenceAndLogin({{ $residences_details->id }})" class="btn btn-outline-dark rounded-4 py-3 fw-bold">Se connecter pour réserver</button>
          @endauth
        </div>
      </div>
    </article>

    {{-- GLightbox hidden anchors --}}
    <div style="display:none">
      @foreach($images as $i => $img)
        <a href="{{ $img }}" class="glightbox" data-gallery="res-gallery"></a>
      @endforeach
    </div>
  </main>

  {{-- Modal 1 : Saisie --}}
  <div class="modal fade" id="reservationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content shadow-lg">
        <div class="modal-header border-0 pb-0">
          <h4 class="fw-bold">Réserver</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <div id="jsDateAlert" class="alert alert-danger d-none rounded-4 mb-3 small fw-bold"></div>
          <form id="reservationForm" method="POST" action="{{ route('reservation.store', $residences_details->id) }}">
            @csrf
            <div class="row g-3">
              <div class="col-6">
                <label class="form-label small fw-bold">ARRIVÉE</label>
                <input type="date" id="date_arrivee" name="date_arrivee" class="form-control" required />
              </div>
              <div class="col-6">
                <label class="form-label small fw-bold">DÉPART</label>
                <input type="date" id="date_depart" name="date_depart" class="form-control" required />
              </div>
              <div class="col-12">
                <label class="form-label small fw-bold">VOYAGEURS</label>
                <input type="number" name="personnes" class="form-control" min="1" value="1" required />
              </div>
            </div>
            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-reserver" id="btnConfirmer" disabled>Suivant</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal 2 : Confirmation --}}
  <div class="modal fade" id="confirmationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center p-4">
        <div class="mb-4">
           <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
              <i class="fas fa-calendar-check fa-2x"></i>
           </div>
           <h3 class="fw-bold">Confirmer ?</h3>
           <p id="confirmationMessage" class="text-muted"></p>
        </div>
        <div class="d-grid gap-2">
          <button type="button" class="btn btn-reserver" id="btnFinalSubmit">Oui, confirmer la demande</button>
          <button type="button" class="btn btn-light rounded-4 py-3 fw-bold" data-bs-dismiss="modal">Modifier</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/js/glightbox.min.js"></script>
  
  <script>
    // Sidebar
    function toggleSidebar(){
      document.getElementById('sidebar').classList.toggle('active');
      document.getElementById('sidebar-overlay').classList.toggle('active');
    }
    document.getElementById('btnToggle')?.addEventListener('click', toggleSidebar);

    // Galerie
    const lightbox = GLightbox({ selector: '.glightbox', loop: true });
    document.getElementById('mainPreview').addEventListener('click', () => lightbox.openAt(0));
    document.querySelectorAll('#thumbs img').forEach(img => {
      img.addEventListener('click', function(){
        const idx = parseInt(this.dataset.index);
        lightbox.openAt(idx);
        document.querySelector('#thumbs img.active')?.classList.remove('active');
        this.classList.add('active');
      });
    });

    // Validation & Calcul
    (function(){
      const prix = Number(@json($residences_details->prix_journalier));
      const d1 = document.getElementById('date_arrivee');
      const d2 = document.getElementById('date_depart');
      const alertBox = document.getElementById('jsDateAlert');
      const pref = document.getElementById('prefacture');
      const btn = document.getElementById('btnConfirmer');
      const form = document.getElementById('reservationForm');
      const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
      const reservationModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('reservationModal'));

      function checkDates(){
        alertBox.classList.add('d-none');
        btn.disabled = true;
        pref.classList.add('d-none');

        if(!d1.value || !d2.value) return;

        const start = new Date(d1.value);
        const end = new Date(d2.value);
        const today = new Date(); today.setHours(0,0,0,0);

        if(start < today){
          alertBox.textContent = "La date d'arrivée ne peut pas être passée.";
          alertBox.classList.remove('d-none');
          return;
        }
        if(end <= start){
          alertBox.textContent = "La date de départ doit être après l'arrivée.";
          alertBox.classList.remove('d-none');
          return;
        }

        const nights = Math.round((end - start) / (1000*60*60*24));
        document.getElementById('jours').textContent = nights;
        document.getElementById('total').textContent = (nights * prix).toLocaleString('fr-FR');
        pref.classList.remove('d-none');
        btn.disabled = false;
        return nights;
      }

      [d1, d2].forEach(el => el.addEventListener('change', checkDates));

      form.addEventListener('submit', (e) => {
        e.preventDefault();
        const n = checkDates();
        document.getElementById('confirmationMessage').innerHTML = `Séjour de <strong>${n} nuits</strong>.<br>Total : <strong>${(n * prix).toLocaleString('fr-FR')} FCFA</strong>`;
        reservationModal.hide();
        confirmationModal.show();
      });

      document.getElementById('btnFinalSubmit').addEventListener('click', () => form.submit());
    })();

    function saveResidenceAndLogin(id) {
      document.cookie = "residence_to_reserve=" + id + "; max-age=3600; path=/";
      window.location.href = "{{ route('login') }}";
    }
  </script>
</body>
</html>