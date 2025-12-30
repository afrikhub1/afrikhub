<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Détails — {{ $residences_details->nom ?? 'Résidence' }}</title>

  {{-- Assets principaux --}}
  <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  {{-- GLightbox CSS --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/css/glightbox.min.css" rel="stylesheet">

  {{-- ======= Styles locaux (version optimisée / premium) ======= --}}
  <style>
    /* ============================
       VARIABLES & BASE
       (simple, facile à personnaliser)
    ============================ */
    :root{
      --bg: #f7f8fb;
      --card-bg: #ffffff;
      --muted: #6b7280;
      --dark: #0f1724;
      --primary: #ff8a00; /* accent chaud */
      --accent-2: #00b4a2; /* secondaire */
      --glass: rgba(255,255,255,0.7);
      --radius: 14px;
      --shadow-soft: 0 10px 30px rgba(15,23,36,0.06);
    }

    html,body{height:100%}
    body{
      font-family: 'Poppins', sans-serif;
      background: var(--bg);
      color: var(--dark);
      margin:0;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      -webkit-tap-highlight-color: transparent;
    }

    /* ============================
       HEADER / NAV
    ============================ */
    .site-header{
      background: linear-gradient(90deg,#081126 0%, #0b1220 100%);
      color:#fff;
      box-shadow: 0 6px 18px rgba(2,6,23,0.15);
    }
    .site-header .brand img{ width:92px; height:auto; display:block; }
    .site-header .nav-links a{ color:#fff; margin-right:1rem; font-weight:600; text-decoration:none; }
    .site-header .nav-links a:hover{ opacity:.9; text-decoration:underline; }

    .btn-header{
      background: var(--primary);
      color:#fff;
      border-radius: 28px;
      padding:8px 18px;
      font-weight:700;
      border:none;
    }
    .btn-ghost{
      background: transparent;
      color: #fff;
      border: 1px solid rgba(255,255,255,0.06);
    }

    /* ============================
       OFFCANVAS SIDEBAR (mobile)
    ============================ */
    #sidebar{ position:fixed; right:0; top:0; height:100%; width:320px; max-width:92%; background:#0b1220; color:#fff; transform:translateX(110%); transition:transform .28s ease; z-index:2200; padding:20px; }
    #sidebar.active{ transform:translateX(0); }
    #sidebar-overlay{ position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:2100; display:none; }
    #sidebar-overlay.active{ display:block; }

    .sidebar-header{ display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem; }
    .sidebar-link{ display:block; color:#e6eef0; padding:.7rem; border-radius:10px; text-align:center; text-decoration:none; margin-bottom:.5rem; }
    .sidebar-link:hover{ background: rgba(255,255,255,0.03); color:#fff; }

    /* ============================
       MAIN LAYOUT
    ============================ */
    main.container{
      padding: 2.5rem 1rem;
      max-width:1100px;
    }

    .page-title{
      text-align:center;
      margin-bottom:1.25rem;
    }
    .page-title h1{ font-size:1.8rem; margin-bottom:.25rem; }
    .page-title p{ color:var(--muted); margin:0; font-size:.98rem; }

    /* ============================
       residences_details CARD (grid)
    ============================ */
    .res-card{
      display:grid;
      grid-template-columns: 1fr 420px;
      gap: 28px;
      align-items:start;
      margin-bottom:2rem;
    }
    /* responsive -> stacked */
    @media (max-width: 992px){
      .res-card{ grid-template-columns: 1fr; }
    }

    .res-card__visual{
      background:var(--card-bg);
      border-radius: var(--radius);
      overflow:hidden;
      box-shadow: var(--shadow-soft);
    }
    .res-card__media{ width:100%; height:460px; object-fit:cover; display:block; cursor:pointer; transition:transform .28s; }
    .res-card__media:hover{ transform:scale(1.02); }

    .res-card__thumbs{ display:flex; gap:10px; flex-wrap:wrap; padding:12px; justify-content:center; background:linear-gradient(180deg, rgba(0,0,0,0.02), transparent); }
    .res-card__thumbs img{ width:90px; height:64px; object-fit:cover; border-radius:8px; cursor:pointer; opacity:.68; transition:all .2s; }
    .res-card__thumbs img.active, .res-card__thumbs img:hover{ opacity:1; transform:scale(1.05); box-shadow: 0 8px 20px rgba(2,6,23,0.12); }

    /* Right column: details / actions */
    .res-details{
      background:var(--card-bg);
      border-radius: var(--radius);
      padding:22px;
      box-shadow: var(--shadow-soft);
      display:flex;
      flex-direction:column;
      gap:14px;
      height:100%;
    }
    .res-details h2{ margin:0; font-size:1.35rem; }
    .res-meta{ color:var(--muted); font-size:.95rem; margin-bottom:.5rem; }

    .res-price{ font-weight:800; color:var(--primary); font-size:1.25rem; margin-top:6px; }

    .res-actions{ margin-top:auto; display:flex; gap:12px; flex-wrap:wrap; justify-content:center; }
    .res-actions .btn{ min-width:150px; }

    /* small utilities */
    .muted { color:var(--muted); font-size:.95rem; }
    .small-note{ font-size:.9rem; color:var(--muted); }

    /* PREFATURE (estimate box) */
    .prefacture{
      border-radius:10px;
      padding:14px;
      background: linear-gradient(180deg, rgba(0,0,0,0.02), rgba(255,255,255,0.02));
      border:1px solid rgba(2,6,23,0.03);
    }

    /* ============================
       MODALS — reservation + confirmation
    ============================ */
    .modal .modal-content{ border-radius:14px; padding:1.25rem; }
    .modal .modal-header{ border-bottom:none; padding-bottom:0; }
    .modal .btn-reserver{ background:var(--primary); border:none; color:#fff; }
    .modal .btn-back{ background:#0b1220; color:#fff; border:none; }

    /* ============================
       FORM STYLING (inside modal)
    ============================ */
    .form-control{ border-radius:10px; border:1px solid rgba(2,6,23,0.06); height:44px; }
    label{ font-weight:600; font-size:.95rem; }

    /* ============================
       RESPONSIVE ADJUSTMENTS
    ============================ */
    @media (max-width:576px){
      main.container{ padding:1rem; }
      .res-card__media{ height:320px; }
      .res-card{ gap:18px; }
      .res-actions{ flex-direction:column; }
      .res-actions .btn{ width:100%; }
    }
  </style>
  {{-- ======= end CSS ======= --}}
</head>
    <body>

        {{-- ============================
        HEADER (clean & accessible)
        ============================ --}}
        <header class="site-header">
            <nav class="container d-flex align-items-center justify-content-between py-2">
            <a class="brand d-flex align-items-center" href="{{ route('accueil') }}" aria-label="Retour à l'accueil">
                <img src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub" />
            </a>

            <div class="d-flex align-items-center">
                {{-- Desktop links --}}
                <div class="nav-links d-none d-lg-flex align-items-center me-3">
                    <a class="nav-link" href="{{ route('recherche') }}">Résidences</a>
                    @auth
                        <a class="nav-link" href="{{ Auth::user()->type_compte == 'professionnel' ? route('pro.dashboard') : route('clients_historique') }}">
                            Profil
                        </a>
                    @endauth

                </div>

                {{-- Quick actions --}}
                <a class="btn btn-ghost me-2 d-none d-lg-inline" href="javascript:history.back()" aria-label="Retour">Retour</a>
                <a class="btn btn-header me-2 d-none d-lg-inline" href="{{ route('logout') }}">Déconnexion</a>

                {{-- Mobile: sidebar toggle --}}
                <button id="btnToggle" class="btn btn-ghost d-lg-none" aria-expanded="false" aria-controls="sidebar" title="Menu">
                <i class="fas fa-bars"></i>
                </button>
            </div>
            </nav>
        </header>

        {{-- Sidebar overlay + panel (mobile) --}}
        <div id="sidebar-overlay" aria-hidden="true" onclick="toggleSidebar()"></div>

        <aside id="sidebar" role="dialog" aria-modal="true" aria-hidden="true">
            <div class="sidebar-header">
            <strong>Menu</strong>
            <button class="btn btn-close btn-close-white" aria-label="Fermer" onclick="toggleSidebar()"></button>
            </div>

            {{-- Menu adapté selon le type de compte (sécurité côté backend) --}}
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
            <div class="mt-3">
            <a class="btn btn-header w-100" href="{{ route('logout') }}">Déconnexion</a>
            </div>
        </aside>

        {{-- ============================
        MAIN — contenu principal
            ============================ --}}
        <main class="container">

            {{-- Page title --}}
            <section class="page-title">
            <h1 class="fw-bold">Residence - {{ $residences_details->nom ?? 'Nom de la résidence' }}</h1>
            <p class="small-note">Découvrez la propriété — photos, description et réservation</p>
            </section>

            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
                </ul>
            </div>
            @endif

            {{-- Decode images safely --}}
            @php
            $images = is_string($residences_details->img) ? json_decode($residences_details->img, true) : ($residences_details->img ?? []);
            if(!is_array($images)) $images = [];
            $first = $images[0] ?? asset('assets/images/placeholder-900x500.png');
            @endphp

            {{-- residences_details card: visual + details --}}
            <article class="res-card" aria-labelledby="res-title-{{ $residences_details->id }}">
            {{-- Left: media --}}
            <div class="res-card__visual" aria-hidden="false">
                {{-- main preview (opens GLightbox) --}}
                <img
                id="mainPreview"
                class="res-card__media"
                src="{{ $first }}"
                alt="{{ $residences_details->nom ?? 'Résidence' }}"
                loading="lazy"
                role="button"
                tabindex="0"
                aria-label="Ouvrir la galerie de la résidence"
                />

                {{-- thumbnails (if multiple images) --}}
                @if(count($images) > 1)
                <div class="res-card__thumbs" id="thumbs" aria-hidden="false">
                    @foreach($images as $i => $img)
                    <img src="{{ $img }}"
                        data-index="{{ $i }}"
                        class="{{ $i === 0 ? 'active' : '' }}"
                        alt="Image {{ $i+1 }} de {{ $residences_details->nom }}" />
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Right: details & actions --}}
            <div class="res-details" id="details-{{ $residences_details->id }}">
                <h2 id="res-title-{{ $residences_details->id }}">{{ $residences_details->nom }}</h2>
                <div class="res-meta">
                <span class="me-3"><i class="fas fa-map-marker-alt me-1"></i> {{ $residences_details->ville ?? 'Ville' }}, {{ $residences_details->pays ?? 'Pays' }}</span> <br>
                <span class="me-3"><i class="fas fa-bed me-1"></i> {{ $residences_details->chambres ?? 1 }} chambres</span>
                <span><i class="fas fa-user-friends me-1"></i> {{ $residences_details->salons ?? 1 }} salons</span>
                </div>

                <p class="small-note">{!! nl2br(e(Str::limit($residences_details->details ?? '-', 600))) !!}</p>

                <h2>Comodités</h2>
                <p class="small-note">{!! nl2br(e(Str::limit($residences_details->commodites ?? '-', 600))) !!}</p>
                <div class="res-price">
                {{ number_format($residences_details->prix_journalier ?? 0, 0, ',', ' ') }} FCFA / nuit
                </div>

                {{-- Prefacture quick info (hidden until dates selected) --}}
                <div id="prefacture" class="prefacture d-none" aria-hidden="true">
                <h6 class="fw-bold text-center mb-2">Pré-facture</h6>
                <p class="mb-1"><strong>Durée :</strong> <span id="jours">0</span> nuit(s)</p>
                <p class="mb-1"><strong>Prix journalier :</strong> {{ number_format($residences_details->prix_journalier ?? 0,0,',',' ') }} FCFA</p>
                <p class="mt-2 pt-2 border-top fw-bold"><strong>Total estimé :</strong> <span id="total">0</span> FCFA</p>
                </div>

                {{-- Actions: Reserve / Back --}}
                <div class="res-actions mt-3">
                    <a class="btn btn-outline-dark" href="{{ route('recherche') }}" aria-label="Retour aux résidences">⬅ Retour</a>

                    @auth
                        <button class="btn btn-reserver btn-outline-success" data-bs-toggle="modal" data-bs-target="#reservationModal" id="openReserve">
                            Réserver
                        </button>
                    @endauth
                    @guest
                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf
                            <input type="hidden" name="residence" value="{{ request()->query('residence') }}">
                            <input type="email" name="email" ...>
                            <input type="password" name="password" ...>
                            <button type="submit">Se connecter</button>
                        </form>

                    @endguest


                </div>
            </div>
            </article>

            {{-- Hidden GLightbox anchors (one per image) — used by GLightbox, kept hidden from layout --}}
            <div style="display:none" aria-hidden="true">
            @foreach($images as $i => $img)
                <a href="{{ $img }}" class="glightbox" data-gallery="res-{{ $residences_details->id }}" data-title="{{ $residences_details->nom }}" data-index="{{ $i }}"></a>
            @endforeach
            </div>

        </main>

        {{-- ============================
        RESERVATION MODAL
        (accessible + validated in JS)
        ============================ --}}
        <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="resModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header border-0 pb-0">
                <h5 id="resModalLabel" class="modal-title">Réserver : {{ $residences_details->nom }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <div class="modal-body">
                <div id="validationMessage" class="alert alert-danger d-none" role="alert"></div>

                <form id="reservationForm" method="POST" action="{{ route('reservation.store', $residences_details->id) }}">
                    @csrf

                    <div class="mb-3">
                    <label for="date_arrivee" class="form-label">Date d'arrivée</label>
                    <input type="date" id="date_arrivee" name="date_arrivee" class="form-control" required />
                    </div>

                    <div class="mb-3">
                    <label for="date_depart" class="form-label">Date de départ</label>
                    <input type="date" id="date_depart" name="date_depart" class="form-control" required />
                    </div>

                    <div class="mb-3">
                    <label for="personnes" class="form-label">Nombre de personnes</label>
                    <input type="number" id="personnes" name="personnes" class="form-control" min="1" value="1" required />
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-reserver" id="btnConfirmer" disabled>Confirmer</button>
                    </div>
                </form>
                </div>

            </div>
            </div>
        </div>

        {{-- Confirmation Modal (final before actual submit) --}}
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-3">
                <h5 class="fw-bold">Confirmer la réservation</h5>
                <p id="confirmationMessage" class="my-3"></p>
                <div class="d-flex justify-content-center gap-3">
                <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Modifier</button>
                <button type="button" class="btn btn-reserver" id="btnFinalSubmit">Confirmer et payer</button>
                </div>
            </div>
            </div>
        </div>

        {{-- ============================
            SCRIPTS (Bootstrap + GLightbox)
            ============================ --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/js/glightbox.min.js"></script>

        {{-- ======= Page JS (optimisé, commenté) ======= --}}
        <script>
            // -------------------------
            // Sidebar toggle (mobile)
            // -------------------------
            function toggleSidebar(){
            const sb = document.getElementById('sidebar');
            const ov = document.getElementById('sidebar-overlay');
            const expanded = sb.classList.toggle('active');
            ov.classList.toggle('active', expanded);
            // Update aria
            sb.setAttribute('aria-hidden', String(!expanded));
            document.getElementById('btnToggle')?.setAttribute('aria-expanded', String(expanded));
            }
            document.getElementById('btnToggle')?.addEventListener('click', toggleSidebar);

            // -------------------------
            // GLightbox init (gallery)
            // -------------------------
            document.addEventListener('DOMContentLoaded', function(){
            const lightbox = GLightbox({
                selector: '.glightbox',
                loop: true,
                touchNavigation: true,
                slideEffect: 'slide'
            });

            // Main image opens the lightbox at the clicked index (0 by default)
            const anchors = Array.from(document.querySelectorAll('a.glightbox'));
            const mainPreview = document.getElementById('mainPreview');

            if(mainPreview && anchors.length){
                mainPreview.addEventListener('click', function(e){
                e.preventDefault();
                lightbox.openAt(0);
                });
                // allow keyboard 'Enter' to open gallery when focused
                mainPreview.addEventListener('keydown', function(e){
                if(e.key === 'Enter' || e.key === ' '){
                    e.preventDefault();
                    lightbox.openAt(0);
                }
                });
            }

            // Thumbnails: open at specific index and toggle active class
            document.querySelectorAll('#thumbs img').forEach(img => {
                img.addEventListener('click', function(){
                const idx = Number(this.dataset.index || 0);
                lightbox.openAt(idx);
                document.querySelector('#thumbs img.active')?.classList.remove('active');
                this.classList.add('active');
                });
            });
            });

            // -------------------------
            // Reservation logic (client-side)
            // - calc nights / total
            // - validation messages
            // - confirmation modal flow
            // -------------------------
            (function(){
            const prix = Number(@json($residences_details->prix_journalier ?? 0));
            document.addEventListener('DOMContentLoaded', () => {
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

                // helper: format FCFA
                function formatFCFA(v){ return v.toLocaleString('fr-FR'); }

                // Calc nights & total, return true if valid
                function calc(){
                validation.classList.add('d-none');
                if(!d1.value || !d2.value){ pref?.classList.add('d-none'); btnConf.disabled = true; return false; }

                const start = new Date(d1.value);
                const end = new Date(d2.value);
                const today = new Date(); today.setHours(0,0,0,0);

                if(start < today){
                    validation.textContent = "La date d'arrivée ne peut pas être antérieure à aujourd'hui.";
                    validation.classList.remove('d-none');
                    pref?.classList.add('d-none');
                    btnConf.disabled = true;
                    return false;
                }
                if(end <= start){
                    validation.textContent = "La date de départ doit être strictement postérieure à la date d'arrivée.";
                    validation.classList.remove('d-none');
                    pref?.classList.add('d-none');
                    btnConf.disabled = true;
                    return false;
                }

                const ms = end - start;
                const nights = Math.round(ms / (1000*60*60*24));
                const total = nights * prix;

                joursEl.textContent = nights;
                totalEl.textContent = formatFCFA(total);
                pref?.classList.remove('d-none');
                btnConf.disabled = false;
                return true;
                }

                d1?.addEventListener('change', calc);
                d2?.addEventListener('change', calc);

                // On form submit -> show confirmation modal first
                form?.addEventListener('submit', (ev) => {
                ev.preventDefault();
                if(!calc()) return;
                const nights = Number(joursEl.textContent || 0);
                const total = nights * prix;
                confirmationMessage.innerHTML = `Vous réservez <strong>${nights}</strong> nuit(s) pour <strong>${formatFCFA(total)} FCFA</strong>. Confirmez-vous ?`;
                reservationModal.hide();
                confirmationModal.show();
                });

                // Final submit after confirmation
                btnFinal?.addEventListener('click', function(){
                confirmationModal.hide();
                // submit the original form (progressive enhancement)
                form.submit();
                });
            });
            })();
        </script>

    </body>
</html>
