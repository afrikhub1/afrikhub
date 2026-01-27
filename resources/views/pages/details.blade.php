<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Détails — {{ $residences_details->nom ?? 'Résidence' }}</title>

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

    .site-header { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000; }
    .btn-header { background: var(--gradient); color: white !important; border-radius: 12px; padding: 10px 24px; font-weight: 700; border: none; }

    /* Sidebar Style */
    #sidebar { position: fixed; top: 0; right: -320px; width: 320px; height: 100vh; background: white; z-index: 1100; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: -10px 0 30px rgba(0,0,0,0.1); display: flex; flex-direction: column; padding: 30px 20px; }
    #sidebar.active { right: 0; }
    #sidebar-overlay { position: fixed; inset: 0; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px); z-index: 1050; opacity: 0; visibility: hidden; transition: 0.3s; }
    #sidebar-overlay.active { opacity: 1; visibility: visible; }
    .sidebar-link { display: flex; align-items: center; padding: 14px 18px; color: var(--dark); text-decoration: none; font-weight: 600; border-radius: 12px; margin-bottom: 8px; transition: 0.2s; }
    .sidebar-link i { width: 24px; margin-right: 12px; color: var(--primary); }
    .sidebar-link:hover { background: #f1f5f9; }

    /* Layout & Galerie */
    .res-card { display: grid; grid-template-columns: 1fr 420px; gap: 32px; margin-top: 2rem; }
    @media (max-width: 992px) { .res-card { grid-template-columns: 1fr; } }
    .res-card__visual { border-radius: 32px; overflow: hidden; box-shadow: var(--shadow); background: #fff; position: relative; }
    .res-card__media { width: 100%; height: 550px; object-fit: cover; }
    .res-card__thumbs { display: flex; gap: 12px; padding: 12px; background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(8px); position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%); border-radius: 24px; }
    .res-card__thumbs img { width: 60px; height: 60px; border-radius: 14px; cursor: pointer; object-fit: cover; opacity: 0.7; }
    .res-card__thumbs img.active { opacity: 1; box-shadow: 0 0 0 3px var(--accent); }

    .res-details { background: white; border-radius: 32px; padding: 40px; box-shadow: var(--shadow); }
    .res-meta span { background: #f1f5f9; padding: 8px 16px; border-radius: 12px; font-weight: 600; font-size: 0.85rem; margin-bottom: 8px; display: inline-block; }
    .res-price { font-size: 2rem; font-weight: 800; color: var(--primary); margin: 24px 0; }
    
    .prefacture { background: #f0fdfa; border-radius: 20px; padding: 20px; border: 1px solid #ccfbf1; margin-bottom: 20px; }
    .btn-reserver { background: var(--gradient) !important; border: none !important; border-radius: 16px !important; padding: 18px !important; font-weight: 800 !important; color: white; transition: 0.3s; }
    .btn-reserver:disabled { background: #cbd5e1 !important; transform: none !important; }

    .modal-content { border-radius: 32px; border: none; }
    .form-control { border-radius: 14px; padding: 12px; background: #f8fafc; border: 2px solid #f1f5f9; }
    #dateError { font-size: 0.85rem; font-weight: 600; display: none; }
  </style>
</head>
<body>

  <header class="site-header">
    <nav class="container d-flex align-items-center justify-content-between py-3">
      <a class="brand" href="{{ route('accueil') }}">
        <img src="{{ asset('assets/images/logo_01.png') }}" style="width: 80px;" alt="Logo" />
      </a>
      <div class="d-flex align-items-center">
        <button id="btnToggle" class="btn btn-light rounded-circle shadow-sm" style="width: 45px; height: 45px;">
          <i class="fas fa-bars-staggered"></i>
        </button>
      </div>
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
        <a class="sidebar-link" href="{{ route('recherche') }}"><i class="fas fa-search"></i> Résidences</a>
      @endauth
      <a class="sidebar-link" href="javascript:history.back()"><i class="fas fa-arrow-left"></i> Retour</a>
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
      <h1 class="display-5 fw-bolder">{{ $residences_details->nom ?? 'Résidence' }}</h1>
    </section>

    <article class="res-card">
      <div class="res-card__visual">
        <img id="mainPreview" class="res-card__media" src="{{ is_array($images = is_string($residences_details->img) ? json_decode($residences_details->img, true) : ($residences_details->img ?? [])) ? ($images[0] ?? asset('assets/images/placeholder.jpg')) : asset('assets/images/placeholder.jpg') }}" alt="Aperçu">
        @if(count($images) > 1)
          <div class="res-card__thumbs">
            @foreach($images as $i => $img)
              <img src="{{ $img }}" data-index="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" onclick="changeMainImage(this, '{{ $img }}')">
            @endforeach
          </div>
        @endif
      </div>

      <div class="res-details">
        <div class="res-meta">
          <span><i class="fas fa-location-dot"></i> {{ $residences_details->ville }}</span>
          <span><i class="fas fa-bed"></i> {{ $residences_details->chambres }} Ch.</span>
        </div>

        <div class="res-price">
          {{ number_format($residences_details->prix_journalier ?? 0, 0, ',', ' ') }} <small style="font-size: 1rem">FCFA / nuit</small>
        </div>

        <div id="prefacture" class="prefacture d-none">
          <div class="d-flex justify-content-between small">
            <span>Durée du séjour</span>
            <span class="fw-bold"><span id="jours">0</span> nuit(s)</span>
          </div>
          <div class="d-flex justify-content-between mt-2 pt-2 border-top border-success border-opacity-10">
            <span class="fw-bold">Total</span>
            <span class="fw-bold text-primary"><span id="total">0</span> FCFA</span>
          </div>
        </div>

        <div id="dateError" class="alert alert-danger p-2 mb-3">
          <i class="fas fa-triangle-exclamation me-2"></i> <span id="errorText"></span>
        </div>

        <div class="d-grid gap-3">
          @auth
            <button class="btn btn-reserver" data-bs-toggle="modal" data-bs-target="#reservationModal">Réserver maintenant</button>
          @endauth
          @guest
            <a href="{{ route('login') }}" class="btn btn-outline-dark rounded-4 py-3 fw-bold">Se connecter pour réserver</a>
          @endguest
        </div>
      </div>
    </article>
  </main>

  <div class="modal fade" id="reservationModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content p-4">
        <h4 class="fw-bold mb-4">Dates de séjour</h4>
        <form id="reservationForm" method="POST" action="{{ route('reservation.store', $residences_details->id) }}">
          @csrf
          <div class="row g-3">
            <div class="col-6">
              <label class="form-label small fw-bold">ARRIVÉE</label>
              <input type="date" id="date_arrivee" name="date_arrivee" class="form-control" required>
            </div>
            <div class="col-6">
              <label class="form-label small fw-bold">DÉPART</label>
              <input type="date" id="date_depart" name="date_depart" class="form-control" required>
            </div>
          </div>
          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-reserver" id="btnConfirmer" disabled>Confirmer la réservation</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    function toggleSidebar(){
      document.getElementById('sidebar').classList.toggle('active');
      document.getElementById('sidebar-overlay').classList.toggle('active');
    }
    document.getElementById('btnToggle')?.addEventListener('click', toggleSidebar);

    function changeMainImage(el, src) {
      document.getElementById('mainPreview').src = src;
      document.querySelectorAll('.res-card__thumbs img').forEach(img => img.classList.remove('active'));
      el.classList.add('active');
    }

    // --- LOGIQUE DE VALIDATION DES DATES ---
    (function(){
      const prix = Number(@json($residences_details->prix_journalier ?? 0));
      const d1 = document.getElementById('date_arrivee');
      const d2 = document.getElementById('date_depart');
      const errorDiv = document.getElementById('dateError');
      const errorText = document.getElementById('errorText');
      const pref = document.getElementById('prefacture');
      const btn = document.getElementById('btnConfirmer');

      function validate() {
        const start = new Date(d1.value);
        const end = new Date(d2.value);
        const today = new Date();
        today.setHours(0,0,0,0);

        errorDiv.style.display = 'none';
        btn.disabled = true;
        pref.classList.add('d-none');

        if (!d1.value || !d2.value) return;

        // 1. Vérification date passée
        if (start < today) {
          showError("La date d'arrivée ne peut pas être dans le passé.");
          return;
        }

        // 2. Vérification chronologique
        if (end <= start) {
          showError("La date de départ doit être après la date d'arrivée.");
          return;
        }

        // Si tout est OK
        const nights = Math.round((end - start) / (1000*60*60*24));
        document.getElementById('jours').textContent = nights;
        document.getElementById('total').textContent = (nights * prix).toLocaleString('fr-FR');
        pref.classList.remove('d-none');
        btn.disabled = false;
      }

      function showError(msg) {
        errorText.textContent = msg;
        errorDiv.style.display = 'block';
        pref.classList.add('d-none');
        btn.disabled = true;
      }

      d1.addEventListener('change', validate);
      d2.addEventListener('change', validate);
    })();
  </script>
</body>
</html>