<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Détails de la résidence</title>
    <!-- Icônes / Bootstrap / Font -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- GLightbox (lightbox léger et mobile-friendly) -->
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

    /* mini-thumbnails (optionnel) */
    #thumbs{display:flex;gap:10px;justify-content:center;margin-top:18px;flex-wrap:wrap}
    #thumbs img{width:84px;height:60px;object-fit:cover;border-radius:6px;cursor:pointer;opacity:.65;transition:all .25s}
    #thumbs img.active,#thumbs img:hover{opacity:1;transform:scale(1.06);box-shadow:0 6px 18px rgba(0,0,0,.25)}

    /* responsive small tweaks */
    @media (max-width:576px){
      .residence-img{height:320px}
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
    <nav class="navbar fixed-top bg-dark text-white p-3 shadow-lg">
        <div class="container-fluid d-flex justify-content-between align-items-center px-3 px-md-4">

            <div class="flex items-center">
                <a class="navbar-brand" href="{{ route('accueil') }}">
                    <img class="w-20 md:w-28 lg:w-32 h-auto" src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo"/>
                </a>
            </div>

            <!-- desktop links -->
            <div class="d-none d-lg-flex align-items-center ms-3">
            <a class="nav-link me-3" href="{{ route('recherche') }}">Résidences</a>
            <a class="nav-link me-3" href="{{ route('dashboard') }}">Profil</a>
            <a class="nav-link me-3" href="{{ route('mes_demandes') }}">Demandes</a>
            <a class="nav-link me-3" href="{{ route('historique') }}">Reservations</a>
            <a class="nav-link me-3" href="{{ route('accueil') }}">Accueil</a>
            <a class="btn btn-header ms-2" href="{{ route('logout') }}">Quitterr</a>
            </div>
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
      <h5 class="fw-bold text-white mt-2">MENU</h5>
    </div>
    <a class="sidebar-link" href="{{ route('dashboard') }}"><i class="fas fa-user me-2"></i>Profil</a>
    <a class="sidebar-link" href="{{ route('recherche') }}"><i class="fas fa-search me-2"></i>Recherche</a>
    <a class="sidebar-link" href="{{ route('recherche') }}"><i class="fas fa-home me-2"></i>Résidences</a>
    <a class="sidebar-link" href="{{ route('mes_demandes') }}"><i class="fas fa-home me-2"></i>Demandes</a>
    <a class="sidebar-link" href="{{ route('historique') }}"><i class="fas fa-history me-2"></i>Réservation</a>
    <a class="sidebar-link" href="{{ route('accueil') }}"><i class="fas fa-home me-2"></i>Accueil</a>
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
      // décoder images (sécurisé pour Blade)
      $images = is_string($residence->img) ? json_decode($residence->img, true) : $residence->img;
      if(!is_array($images)) $images = [];
      $first = $images[0] ?? 'https://placehold.co/900x500?text=Aucune+image';
    @endphp

    <article class="card custom mb-5">
      <!-- Main image: ouvre GLightbox sur #gallery -->
      <img src="{{ $first }}" alt="{{ $residence->nom }}" class="residence-img" id="mainPreview" data-glightbox="title: {{ addslashes($residence->nom) }}; description: " />

      <div class="card-body text-center">
        <h2 class="fw-bold">{{ $residence->nom }}</h2>
        <p class="price mb-2">{{ number_format($residence->prix_journalier,0,',',' ') }} FCFA / nuit</p>

        <p class="text-start">{!! nl2br(e($residence->description)) !!}</p>

        <div class="d-flex justify-content-center gap-3 mt-4">
          <a href="{{ route('recherche') }}" class="btn btn-back">⬅ Retour</a>
          <button class="btn btn-reserver" data-bs-toggle="modal" data-bs-target="#reservationModal">Réserver</button>
        </div>
      </div>
    </article>

    <!-- Visible thumbnails (optionnel) -->
    @if(count($images) > 1)
      <div id="thumbs" class="mb-4">
        @foreach($images as $i => $img)
          <img src="{{ $img }}" data-index="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}" alt="thumb-{{ $i }}">
        @endforeach
      </div>
    @endif

    <!-- Hidden links for GLightbox gallery (one link per image) -->
    @if(count($images))
      @foreach($images as $i => $img)
        <a href="{{ $img }}" class="glightbox" data-glightbox="description: {{ addslashes($residence->nom) }}; index: {{ $i }}" style="display:none;" data-gallery="res-{{ $residence->id }}"></a>
      @endforeach
    @endif

  </main>

  <!-- RESERVATION MODAL (tout inclus ici, pas d'include) -->
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

  <!-- CONFIRMATION MODAL -->
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

  <!-- SCRIPTS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/glightbox/3.2.0/js/glightbox.min.js"></script>

  <script>
    // Sidebar toggle
    const btnToggle = document.getElementById('btnToggle');
    btnToggle?.addEventListener('click', toggleSidebar);
    function toggleSidebar(){
      document.getElementById('sidebar').classList.toggle('active');
      document.getElementById('sidebar-overlay').classList.toggle('active');
    }

    document.addEventListener('DOMContentLoaded', () => {
      // Init GLightbox for all hidden anchors with .glightbox
      const lightbox = GLightbox({ selector: '.glightbox', loop: true, touchNavigation: true, slideEffect: 'slide' });

      // make the main preview image open the lightbox at index 0
      const mainPreview = document.getElementById('mainPreview');
      const anchors = Array.from(document.querySelectorAll('a.glightbox'));
      if(mainPreview && anchors.length){
        mainPreview.addEventListener('click', (e) => {
          e.preventDefault();
          // open at index 0 (GLightbox indexes from 0)
          lightbox.openAt(0);
        });
      }

      // Thumbnails: when clicked, open GLightbox at the proper index
      document.querySelectorAll('#thumbs img').forEach(img => {
        img.addEventListener('click', () => {
          const idx = Number(img.dataset.index || 0);
          lightbox.openAt(idx);
          document.querySelector('#thumbs img.active')?.classList.remove('active');
          img.classList.add('active');
        });
      });
    });

        (function(){
            const prix = Number({{ $residence->prix_journalier ?? 55000 }});
            const residenceId = {{ $residence->id }};

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

                function formatFCFA(v){ return v.toLocaleString('fr-FR'); }

                // Vérifie la disponibilité via endpoint serveur
                async function checkDisponibiliteViaModel() {
                    if(!d1.value) return true;

                    try {
                        const res = await fetch("{{ route('residence.date-disponible', $residence->id) }}")

                        const data = await res.json();

                        const dateDisponible = new Date(data.date_disponible);
                        const arrivee = new Date(d1.value);

                        if(arrivee < dateDisponible){
                            validation.textContent = `Cette résidence n'est pas disponible avant le ${dateDisponible.toLocaleDateString()}`;
                            validation.classList.remove('d-none');
                            btnConf.disabled = true;
                            return false;
                        }

                        validation.classList.add('d-none');
                        btnConf.disabled = false;
                        return true;

                    } catch(e){
                        console.error(e);
                        btnConf.disabled = true;
                        return false;
                    }
                }


                async function calc() {
                    // Vérifie la date minimale disponible
                    const dispoOk = await checkDisponibiliteViaModel();
                    if(!dispoOk) return;

                    if(!d1.value || !d2.value){
                        pref.classList.add('d-none');
                        btnConf.disabled = true;
                        return;
                    }

                    const start = new Date(d1.value + 'T00:00:00');
                    const end = new Date(d2.value + 'T00:00:00');
                    const today = new Date(); today.setHours(0,0,0,0);

                    if(start < today){
                        validation.textContent = "La date d'arrivée ne peut pas être antérieure à aujourd'hui.";
                        validation.classList.remove('d-none');
                        pref.classList.add('d-none');
                        btnConf.disabled = true;
                        return;
                    }
                    if(end <= start){
                        validation.textContent = "La date de départ doit être strictement postérieure à la date d'arrivée.";
                        validation.classList.remove('d-none');
                        pref.classList.add('d-none');
                        btnConf.disabled = true;
                        return;
                    }

                    const nights = Math.round((end - start)/(1000*60*60*24));
                    const total = nights * prix;

                    joursEl.textContent = nights;
                    totalEl.textContent = formatFCFA(total);
                    pref.classList.remove('d-none');

                    btnConf.disabled = false;
                    validation.classList.add('d-none');
                }


                d1?.addEventListener('change', calc);
                d2?.addEventListener('change', calc);

                // Soumission formulaire
                form?.addEventListener('submit', async (ev) => {
                    ev.preventDefault();
                    await calc();
                    if(btnConf.disabled) return;

                    const nights = Number(joursEl.textContent || 0);
                    const total = nights * prix;
                    confirmationMessage.innerHTML = `Vous réservez <strong>${nights}</strong> nuit(s) pour <strong>${formatFCFA(total)} FCFA</strong>. Confirmez-vous ?`;

                    reservationModal.hide();
                    confirmationModal.show();
                });

                btnFinal?.addEventListener('click', () => {
                    confirmationModal.hide();
                    form.submit();
                });
            });
        })();
  </script>
</body>
</html>
