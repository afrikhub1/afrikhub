<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la résidence</title>

    <!-- Font Awesome pour les icônes (utilisé dans le nouveau menu) -->
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

        /* ===== HEADER / NAVBAR MODIFIÉE ===== */
        .navbar {
            background-color: var(--dark-color);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            color: var(--primary-color) !important;
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: 0.5px;
        }

        .nav-link {
            color: #fff !important;
            margin-right: 20px;
            font-weight: 500;
            transition: all 0.3s ease;
            white-space: nowrap; /* Empêche les liens du header de passer à la ligne */
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            transform: scale(1.05);
        }

        .btn-header {
            background-color: var(--primary-color);
            color: #fff;
            border-radius: 25px;
            padding: 8px 20px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-header:hover {
            background-color: #fff;
            color: var(--dark-color);
        }

        /* ===== SIDEBAR / OFF-CANVAS MENU (Nouveau) ===== */
        #sidebar {
            transition: transform 0.3s ease-in-out;
            transform: translateX(100%); /* Initialement caché à droite */
            position: fixed;
            top: 0;
            right: 0;
            width: 90%;
            max-width: 320px;
            z-index: 1060;
            height: 100%;
            background-color: var(--dark-color);
            padding: 1.5rem;
            box-shadow: -4px 0 12px rgba(0, 0, 0, 0.5);
            overflow-y: auto;
        }
        #sidebar.active {
            transform: translateX(0); /* Fait apparaître la sidebar */
        }
        /* Liens de la sidebar */
        .sidebar-link {
            color: #dee2e6;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 8px;
            transition: background-color 0.2s;
            text-align: left;
            font-weight: 500;
        }
        .sidebar-link:hover {
            background-color: #343a40;
            color: white;
        }
        /* Overlay pour cacher le contenu */
        #sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1050;
            display: none;
            transition: opacity 0.3s;
        }
        #sidebar-overlay.active {
            display: block;
        }

        /* Ajustement du bouton de menu pour être toujours visible */
        .navbar-menu-toggler {
             color: white;
             font-size: 1.5rem;
             border: none;
             background: transparent;
             cursor: pointer;
             padding: 0;
        }
        /* Fin du nouveau menu */

        /* ===== CONTENU PRINCIPAL (Styles originaux conservés) ===== */
        .residence-header {
            text-align: center;
            margin: 50px 0 30px;
        }

        .residence-header h1 {
            font-weight: 700;
            color: var(--primary-color);
        }

        .card {
            background-color: #fff;
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            max-width: 800px;
            margin: 0 auto;
        }

        .residence-img {
            width: 100%;
            height: 450px;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .residence-img:hover {
            transform: scale(1.03);
        }

        .card-body {
            padding: 30px;
            text-align: center;
        }

        .card-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .price {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .card-text {
            text-align: left;
            line-height: 1.6;
            color: #555;
        }

        .btn-back {
            background-color: var(--dark-color);
            color: #fff;
            border-radius: 30px;
            padding: 10px 25px;
            transition: all 0.3s ease;
            margin-right: 10px;
            text-decoration: none;
        }

        .btn-back:hover {
            background-color: var(--primary-color);
            color: #fff;
            transform: scale(1.05);
        }

        .btn-reserver {
            background-color: var(--primary-color);
            color: #fff;
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-reserver:hover {
            background-color: var(--dark-color);
            color: #fff;
            transform: scale(1.05);
        }

        /* MODALS pour remplacer alert/confirm */
        .modal-content-custom {
            background-color: rgba(0, 0, 0, 0.95);
            border: none;
        }
        /* ... autres styles de modal ... */
    </style>
</head>
<body>

    <!-- ===== HEADER MODIFIÉ ===== -->
    <nav class="navbar fixed-top">
        <div class="container-fluid d-flex justify-content-between align-items-center px-3 px-md-4">
            <a class="navbar-brand" href="{{ route('accueil') }}">🏠 Afrik'Hub</a>

            <!-- Liens supplémentaires pour les grands écrans (lg) -->
            <div class="d-none d-lg-flex align-items-center me-auto ms-5">
                <a class="nav-link" href="{{ route('recherche') }}">Résidences</a>
                <a class="nav-link" href="{{ route('dashboard') }}">Mon Espace</a>
                <a class="nav-link" href="{{ route('historique') }}">Historique</a>
                <a href="{{ route('login') }}" class="btn btn-header ms-3">Se connecter</a>
            </div>

            <!-- Bouton Menu (TOUJOURS VISIBLE) -->
            <button id="toggleSidebar" class="navbar-menu-toggler ms-auto" type="button" aria-label="Menu" onclick="toggleSidebar()">
                 <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>
    <!-- FIN HEADER -->

    {{-- SIDEBAR COULISSANTE --}}
    <div id="sidebar-overlay" onclick="toggleSidebar()"></div>
    <div id="sidebar" class="text-white d-flex flex-column">

        <button id="closeSidebar" class="btn text-white align-self-end p-0 mb-4" type="button" aria-label="Fermer" onclick="toggleSidebar()">
            <i class="fas fa-times fa-2x"></i>
        </button>

        <div class="w-100 d-flex flex-column gap-3">

            <div class="text-center mb-4 pb-3 border-bottom border-secondary">
                 <i class="fas fa-bars fa-2x mb-2" style="color: var(--primary-color);"></i>
                 <h4 class="fw-bold">MENU PRINCIPAL</h4>
            </div>

            <a href="{{ route('accueil') }}" class="sidebar-link"><i class="fas fa-home me-2"></i> Accueil</a>

            <a href="{{ route('recherche') }}" class="sidebar-link"><i class="fas fa-search me-2"></i> Recherche</a>

            <a href="{{ route('dashboard') }}" class="sidebar-link"><i class="fas fa-user me-2"></i> Mon Compte</a>

            <a href="{{ route('historique') }}" class="sidebar-link"><i class="fas fa-history me-2"></i> Réservation</a>

            <div class="mt-4 pt-3 border-top border-secondary">
                <a href="{{ route('logout') }}" class="btn btn-header rounded-pill w-100 shadow">
                    <i class="fa fa-sign-out me-2"></i> Déconnexion
                </a>
            </div>
        </div>
    </div>
    <!-- FIN SIDEBAR -->


    <!-- ===== CONTENU PRINCIPAL (Code original conservé) ===== -->
    <div class="container">
        <div class="residence-header">
            <h1>Détails de la résidence</h1>
            <p class="text-muted">Découvrez cette propriété en images</p>
        </div>

        <div class="card mb-5">
            {{-- Images --}}
            @php
                // Utilisation des données réelles de Laravel ou fallback pour l'exemple
                $images = json_decode($residence->img, true);
                $firstImage = $images[0] ?? 'https://placehold.co/400x250/E0E7FF/4F46E5?text=Pas+d\'image';
            @endphp

            <img src="{{ $firstImage }}" alt="{{ $residence->nom }}" class="residence-img" data-bs-toggle="modal" data-bs-target="#lightboxModal">

            <div class="card-body">
                <h5 class="card-title">{{ $residence->nom }}</h5>
                <p class="price">{{ number_format($residence->prix_journalier, 0, ',', ' ') }} FCFA / nuit</p>

                <p class="card-text">
                    <strong>Pays :</strong> {{ $residence->pays }} <br>
                    <strong>Adresse :</strong> {{ $residence->adresse }} <br><br>
                    <strong>Description :</strong><br>
                    {!! nl2br(e($residence->description)) !!}
                </p>

                <div class="d-flex justify-content-center mt-4">
                    <a href="{{ route('recherche') }}" class="btn btn-back">⬅ Retour</a>
                    <button class="btn btn-reserver" data-bs-toggle="modal" data-bs-target="#reservationModal">Réserver maintenant</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== MODAL LIGHTBOX ===== -->
    <div class="modal fade" id="lightboxModal" tabindex="-1" aria-labelledby="lightboxLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content modal-content-custom">
                <button type="button" class="close-btn" data-bs-dismiss="modal">&times;</button>
                <div id="carouselLightbox" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner py-5">
                        @foreach ($images as $index => $img)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $img) }}" class="d-block mx-auto" alt="Image {{ $index + 1 }}">
                            </div>
                        @endforeach

                        @if (empty($images))
                            <div class="carousel-item active">
                                <img src="https://placehold.co/800x450?text=Aucune+image+disponible" class="d-block mx-auto" alt="Aucune image">
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

    <!-- ===== MODAL DE RÉSERVATION ===== -->
    <div class="modal fade" id="reservationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-4 rounded-4">
                <h4 class="text-center fw-bold mb-3" style="color:var(--primary-color);">Réserver cette résidence</h4>

                <!-- Message d'erreur/validation (remplace alert()) -->
                <div id="validationMessage" class="alert alert-danger d-none" role="alert"></div>

                <form action="{{ route('reservation.store', $residence->id) }}" method="POST" id="reservationForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Date d'arrivée</label>
                        <input type="date" name="date_arrivee" id="date_arrivee" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Date de départ</label>
                        <input type="date" name="date_depart" id="date_depart" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre de personnes</label>
                        <input type="number" name="personnes" id="personnes" class="form-control" min="1" value="1" required>
                    </div>

                    <!-- Section de préfacture -->
                    <div id="prefacture" class="border rounded-3 p-3 mt-3 bg-light d-none">
                        <h6 class="fw-bold text-center mb-3">🧾 Préfacture</h6>
                        <p class="mb-1"><strong>Durée :</strong> <span id="jours">0</span> nuit(s)</p>
                        <p class="mb-1"><strong>Prix journalier :</strong> {{ number_format($residence->prix_journalier, 0, ',', ' ') }} FCFA</p>
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

    <!-- MODAL DE CONFIRMATION (Remplace confirm()) -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 p-3 text-center">
                <h5 class="fw-bold text-primary">Confirmation de Réservation</h5>
                <p class="my-3" id="confirmationMessage"></p>
                <div class="d-flex justify-content-around">
                    <button type="button" class="btn btn-back" data-bs-dismiss="modal">Modifier</button>
                    <!-- Ce bouton déclenchera la soumission finale -->
                    <button type="button" class="btn btn-reserver" id="btnFinalSubmit">Confirmer et Continuer</button>
                </div>
            </div>
        </div>
    </div>


    <!-- ===== SCRIPT DE CALCUL DYNAMIQUE ET LOGIQUE ===== -->
    <script>
        // --- Code simulant la variable $residence pour le fonctionnement en mode preview ---
        const residenceData = {
            id: 1,
            prix_journalier: {{ $residence->prix_journalier ?? 55000 }}, // 55000 FCFA par défaut
        };

        function formatFCFA(amount) {
            // Fonction pour formater l'argent
            return amount.toLocaleString('fr-FR');
        }

        // --- Logique de la Sidebar ---
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        function toggleSidebar() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
            document.body.classList.toggle('overflow-hidden');
        }

        // --- Logique de Réservation ---
        document.addEventListener('DOMContentLoaded', function() {
            const dateArrivee = document.getElementById('date_arrivee');
            const dateDepart = document.getElementById('date_depart');
            const prefacture = document.getElementById('prefacture');
            const joursEl = document.getElementById('jours');
            const totalEl = document.getElementById('total');
            const btnConfirmer = document.getElementById('btnConfirmer');
            const reservationForm = document.getElementById('reservationForm');
            const validationMessage = document.getElementById('validationMessage');

            // Références Modals
            const reservationModalInstance = bootstrap.Modal.getOrCreateInstance(document.getElementById('reservationModal'));
            const confirmationModalInstance = new bootstrap.Modal(document.getElementById('confirmationModal'));
            const confirmationMessageEl = document.getElementById('confirmationMessage');
            const btnFinalSubmit = document.getElementById('btnFinalSubmit');

            const prixJournalier = residenceData.prix_journalier;

            function calculerPrefacture() {
                validationMessage.classList.add('d-none'); // Cache le message d'erreur

                const debut = new Date(dateArrivee.value);
                const fin = new Date(dateDepart.value);
                const aujourdhui = new Date();
                aujourdhui.setHours(0, 0, 0, 0);

                if (!dateArrivee.value || !dateDepart.value) {
                    prefacture.classList.add('d-none');
                    btnConfirmer.disabled = true;
                    return;
                }

                if (fin <= debut) {
                    validationMessage.textContent = "La date de départ doit être strictement postérieure à la date d'arrivée.";
                    validationMessage.classList.remove('d-none');
                    prefacture.classList.add('d-none');
                    btnConfirmer.disabled = true;
                    return;
                }

                if (debut < aujourdhui) {
                    validationMessage.textContent = "La date d'arrivée ne peut pas être antérieure à aujourd'hui.";
                    validationMessage.classList.remove('d-none');
                    prefacture.classList.add('d-none');
                    btnConfirmer.disabled = true;
                    return;
                }

                const diffTemps = fin - debut;
                const nbJours = diffTemps / (1000 * 60 * 60 * 24);
                const total = nbJours * prixJournalier;

                joursEl.textContent = nbJours;
                totalEl.textContent = formatFCFA(total);
                prefacture.classList.remove('d-none');
                btnConfirmer.disabled = false;
            }

            // Calcul dynamique au changement des dates
            dateArrivee.addEventListener('change', calculerPrefacture);
            dateDepart.addEventListener('change', calculerPrefacture);

            // 1. Étape de soumission (Ouvrir la confirmation)
            reservationForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Assurez-vous que les dates sont valides avant de continuer
                calculerPrefacture();
                if (btnConfirmer.disabled) return;

                const debut = new Date(dateArrivee.value);
                const fin = new Date(dateDepart.value);
                const diffTemps = fin - debut;
                const nbJours = diffTemps / (1000 * 60 * 60 * 24);
                const total = nbJours * prixJournalier;

                // Remplir le modal de confirmation
                confirmationMessageEl.innerHTML = `Vous allez réserver pour <strong>${nbJours} nuit(s)</strong> pour un montant total de <strong>${formatFCFA(total)} FCFA</strong>. Confirmez-vous ?`;

                // Afficher le modal de confirmation
                reservationModalInstance.hide();
                confirmationModalInstance.show();
            });

            // 2. Étape de soumission finale (Remplace la soumission par le code Blade/Laravel)
            btnFinalSubmit.addEventListener('click', function() {
                // Fermer la modal de confirmation
                confirmationModalInstance.hide();

                // Soumettre le formulaire réel
                reservationForm.submit();
            });

        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
