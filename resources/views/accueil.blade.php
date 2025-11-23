<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afrik'Hub - Accueil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">
    <style>
        /* ===== RESET ===== */
        * { box-sizing: border-box; margin:0; padding:0; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; color:#0f172a; padding-top:80px; }

        /* ===== HEADER ===== */
        header { display:flex; justify-content:space-between; align-items:center; padding:0.75rem 1rem; background:#006d77; color:#fff; position:fixed; top:0; left:0; right:0; z-index:100; box-shadow:0 4px 12px rgba(0,0,0,0.1);}
        header img { height:56px; object-fit:contain; }
        nav ul { display:flex; gap:0.5rem; list-style:none; align-items:center; flex-wrap:wrap; }
        nav a { color:#fff; text-decoration:none; font-weight:600; padding:6px 10px; border-radius:6px; transition:0.2s; }
        nav a:hover { background: rgba(255,255,255,0.15); }
        nav .dropdown-menu { min-width: auto; }

        /* ===== HERO ===== */
        #accueil { min-height:500px; display:flex; align-items:center; justify-content:center; text-align:center; padding:2rem 1rem; background: linear-gradient(rgba(0,91,107,0.6), rgba(0,91,107,0.4)), url('assets/images/bg.jpg') center/cover no-repeat; color:#fff; }
        #accueil h2 { font-size:2.5rem; margin-bottom:0.5rem; }
        #accueil span { font-size:1.2rem; }
        .btn-reserver { background:#006d77; color:#fff; padding:0.5rem 1.5rem; border-radius:8px; margin:0.25rem; display:inline-block; text-decoration:none; transition:0.3s; }
        .btn-reserver:hover { background:#014f56; }

        /* ===== SECTIONS ===== */
        section h2 { text-transform:capitalize; text-align:center; margin:1rem 0; }
        .accordion-button:not(.collapsed) { background:#006d77; color:#fff; }
        .accordion-button { background:#e0f2f1; color:#0f172a; }

        /* ===== CARDS ===== */
        .card img { height:200px; object-fit:cover; }
        .card-body .card-text-truncate { overflow:hidden; white-space:nowrap; text-overflow:ellipsis; }

        /* ===== FOOTER ===== */
        footer { background:#006d77; color:#fff; text-align:center; padding:1rem; margin-top:2rem; }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header class="p-1">
      <div class="col-12 row m-0 align-items-center">
        <div class="col-lg-2 col-md-2 col-3">
          <img class="img-fluid" src="assets/images/logo_01.png" alt="Afrik'Hub Logo" />
        </div>
        <nav class="col-lg-10 col-md-10 col-9">
          <ul class="d-flex justify-content-end py-2">
            <li><a href="#" class="bg-dark"><span class="fa fa-sign-in"></span> Connexion</a></li>
            <li><a href="#" class="bg-dark"><span class="fa fa-user-plus"></span> Inscription</a></li>
            <li><a href="#" class="bg-danger"><span class="fa fa-user-shield"></span> Admin</a></li>
            <li><a href="#hebergement"><span class="fa fa-home"></span> Hébergement</a></li>
            <li><a href="#location"><span class="fa fa-car"></span> Véhicule</a></li>
            <li><a href="#contact"><span class="fa fa-phone"></span> Contact</a></li>
            <li class="nav-item dropdown">
              <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">Menu</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Connexion</a></li>
                <li><a class="dropdown-item" href="#">Inscription</a></li>
                <li><a class="dropdown-item" href="#">Admin</a></li>
                <li><a class="dropdown-item" href="#hebergement">Hébergements</a></li>
                <li><a class="dropdown-item" href="#location">Véhicules</a></li>
                <li><a class="dropdown-item" href="#circuits">Circuits</a></li>
                <li><a class="dropdown-item" href="#reservation">Réservation</a></li>
                <li><a class="dropdown-item" href="#contact">Contact</a></li>
              </ul>
            </li>
          </ul>
        </nav>
      </div>
    </header>

    <!-- HERO -->
    <section id="accueil" class="text-center py-5">
        <div>
            <h2>Bienvenue</h2>
            <span>Explorez l'Afrique autrement avec Afrik’Hub</span><br><br>
            <a href="#" class="btn-reserver me-2">Réserver</a>
            <a href="#" class="btn-reserver">Ajouter un bien</a>
        </div>
    </section>

    <!-- HÉBERGEMENT -->
    <section id="hebergement" class="my-2 col-12 row m-0 justify-content-center">
      <h2>hébergements</h2>
      <div class="row g-4 align-items-center col-12 col-md-8 col-lg-6 mx-4">
        <img class="w-100 h-auto" src="assets/images/hebergement.jpg" alt="Afrik'Hub Hébergement"/>
      </div>

      <div class="col-12 col-md-8 col-lg-6">
        <div class="accordion" id="accordionHebergement">
          <div class="accordion-item border-0">
            <h2 class="accordion-header mt-5" id="headingTypes">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTypes" aria-expanded="true" aria-controls="collapseTypes">
                Types d'hébergements
              </button>
            </h2>
            <div id="collapseTypes" class="accordion-collapse collapse show" aria-labelledby="headingTypes" data-bs-parent="#accordionHebergement">
              <div class="accordion-body">
                <div class="mb-3">
                  <strong>Studio</strong>
                  <ul><li>Wifi gratuit</li><li>Ventilateur</li><li>Caméra de surveillance</li></ul>
                </div>
                <div class="mb-3">
                  <strong>Chambre unique</strong>
                  <ul><li>Wifi gratuit</li><li>Climatisation</li><li>Petit déjeuner inclus</li></ul>
                </div>
                <div class="mb-3">
                  <strong>Villa avec piscine</strong>
                  <ul><li>Wifi gratuit</li><li>Piscine privée</li><li>Climatisation</li><li>Parking gratuit</li></ul>
                </div>
              </div>
            </div>
          </div>

          <div class="accordion-item border-0">
            <h2 class="accordion-header" id="headingConditions">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseConditions" aria-expanded="false" aria-controls="collapseConditions">
                Conditions de réservation
              </button>
            </h2>
            <div id="collapseConditions" class="accordion-collapse collapse" aria-labelledby="headingConditions" data-bs-parent="#accordionHebergement">
              <div class="accordion-body">
                <ul>
                  <li>Réservation préalable requise</li>
                  <li>Acompte de 20% pour confirmation</li>
                  <li>Annulation gratuite jusqu'à 48h avant l'arrivée</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="text-center mt-3">
            <a href="#" class="btn-reserver">Réserver</a>
        </div>
      </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <p id="contact">&copy; 2025 Afrik’hub. Tous droits réservés.<br>afrikhub@gmail.com</p>
    </footer>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
      // Accordion toggle
      document.querySelectorAll(".accordion-button").forEach(button => {
        button.addEventListener("click", e => {
          const parent = button.closest(".accordion-item");
          const content = parent.querySelector(".accordion-collapse");
          parent.classList.toggle("active");
        });
      });

      // Initialisation GLightbox si tu ajoutes des galeries
      const lightbox = GLightbox();
    </script>
</body>
</html>
