<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre résidence en location - Afrik'Hub</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    {{-- liens pour le maps --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        :root {
            /* Palette harmonisée avec ton dégradé */
            --brand-gradient: linear-gradient(135deg, #006d77, #00afb9);
            --brand-dark: #006d77;
            --brand-light: #00afb9;
        }

        body {
            background-color: #f1f5f9;
            color: #1e293b;
            font-family: 'Inter', sans-serif;
        }

        /* NAVBAR */
        .navbar {
            background: var(--brand-gradient) !important;
            box-shadow: 0 4px 12px rgba(0, 109, 119, 0.2);
            padding: 0.75rem 1rem;
        }

        .desktop-nav-links .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            transition: 0.3s;
        }

        .desktop-nav-links .nav-link:hover {
            color: #fff !important;
            transform: translateY(-1px);
        }

        /* FORMULAIRE & FIELDSET */
        fieldset {
            background-color: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 2.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }

        legend {
            font-weight: 800;
            color: var(--brand-dark);
            padding: 0 1.5rem;
            font-size: 1.25rem;
            width: auto;
            float: none;
            margin-bottom: 0;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .container h2 {
            color: var(--brand-dark);
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: 2.5rem;
        }

        /* CHAMPS DE SAISIE */
        .form-label {
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--brand-light);
            box-shadow: 0 0 0 0.25rem rgba(0, 175, 185, 0.15);
        }

        .input-group-text {
            background-color: #f8fafc;
            color: var(--brand-dark);
            border-right: none;
        }

        /* COMMODITÉS */
        .commodite-item {
            border: 1px solid #f1f5f9;
            background-color: #f8fafc;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
        }

        .commodite-item:hover {
            background-color: #fff !important;
            border-color: var(--brand-light);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .form-check-input:checked {
            background-color: var(--brand-dark);
            border-color: var(--brand-dark);
        }

        /* BOUTON SOUMETTRE */
        .btn-submit {
            background: var(--brand-gradient);
            color: #fff;
            border: none;
            font-weight: 700;
            padding: 1rem 3.5rem;
            border-radius: 0.75rem;
            transition: all 0.3s;
            box-shadow: 0 10px 20px rgba(0, 109, 119, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(0, 109, 119, 0.4);
            color: #fff;
        }

        /* MAP & UPLOAD */
        #map { border: 2px solid #e2e8f0; }
        
        #images {
            padding: 2rem;
            border: 2px dashed #cbd5e1;
            background-color: #f8fafc;
        }
        #images:focus {
            border-color: var(--brand-light);
            background-color: #fff;
        }

        .offcanvas-header {
            background: var(--brand-gradient);
            color: white;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a href="{{ route('accueil') }}">
                <img src="{{ asset('assets/images/logo_01.png') }}" alt="Logo" style="height: 50px; width: auto;" />
            </a>

            <div class="collapse navbar-collapse desktop-nav-links" id="navbarNavDesktop">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" href="{{ route('accueil') }}"><i class="fas fa-home me-1"></i> Accueil</a>
                    <a class="nav-link" href="{{ route(Auth::user()->type_compte == 'professionnel' ? 'pro.dashboard' : 'clients_historique') }}">
                        <i class="fas fa-user-circle me-1"></i> Profil
                    </a>
                    <a class="nav-link" href="{{ route('recherche') }}"><i class="fas fa-search me-1"></i> Recherche</a>
                    <a class="nav-link text-white font-bold" href="{{ route('logout') }}"><i class="fas fa-power-off me-1"></i></a>
                </div>
            </div>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title font-bold">MENU AFRIK'HUB</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <nav class="nav flex-column">
                <a class="nav-link p-4 border-bottom text-dark" href="{{ route('accueil') }}"><i class="fas fa-home me-3 text-[#006d77]"></i> Accueil</a>
                <a class="nav-link p-4 border-bottom text-dark" href="{{ route('recherche') }}"><i class="fas fa-search me-3 text-[#006d77]"></i> Recherche</a>
                <a class="nav-link p-4 border-bottom text-dark text-danger" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-3"></i> Déconnexion</a>
            </nav>
        </div>
    </div>

    <div class="container mt-5">
        <h2 class="text-center">Mettre votre résidence en location</h2>

        <form action="{{ route('residences.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <fieldset class="mb-5">
                <legend><i class="fas fa-info-circle me-2"></i> Informations générales</legend>
                <div class="row g-4 mt-1">
                    <div class="col-md-6">
                        <label class="form-label">Nom de la résidence</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-tag"></i></span>
                            <input type="text" class="form-control" name="nom_residence" placeholder="Ex: Villa Horizon" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Pays</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-globe-africa"></i></span>
                            <input type="text" class="form-control" name="pays" placeholder="Ex: Côte d'Ivoire" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Ville</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-city"></i></span>
                            <input type="text" class="form-control" name="ville" placeholder="Ex: Abidjan" required>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="mb-5">
                <legend><i class="fas fa-bed me-2"></i> Détails de la résidence</legend>
                <div class="row g-4 mt-1">
                    <div class="col-md-4">
                        <label class="form-label">Type</label>
                        <select class="form-select" name="type_residence" required>
                            <option value="Appartement">Appartement</option>
                            <option value="Villa">Villa</option>
                            <option value="Studio">Studio</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Prix / Jour (FCFA)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                            <input type="number" class="form-control" name="prix_jour" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description détaillée</label>
                        <textarea class="form-control" name="details" rows="3" placeholder="Décrivez les atouts de votre logement..." required></textarea>
                    </div>
                </div>

                <div class="mt-5">
                    <label class="form-label fw-bold mb-3">Commodités disponibles :</label>
                    <div class="row g-3">
                        @foreach ($commodites as $label => $data)
                            @php $id = 'comodite_' . md5($label); @endphp
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="p-3 commodite-item h-100">
                                    <label class="form-check d-flex align-items-center gap-2 mb-0" for="{{ $id }}">
                                        <input class="form-check-input commodite-checkbox" type="checkbox" 
                                               name="commodites[{{ $label }}][active]" value="1" id="{{ $id }}" data-target="field_{{ $id }}">
                                        <i class="fas {{ $data['icon'] }} text-[#006d77]"></i>
                                        <span class="small fw-medium">{{ $label }}</span>
                                    </label>
                                    @if (isset($data['type']))
                                        <input type="{{ $data['type'] }}" class="form-control form-control-sm mt-2 d-none commodite-field" 
                                               name="commodites[{{ $label }}][value]" id="field_{{ $id }}" placeholder="Préciser...">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </fieldset>

            <fieldset class="mb-5">
                <legend><i class="fas fa-map-marked-alt me-2"></i> Localisation précise</legend>
                <div class="row g-4 mt-1">
                    <div class="col-md-7">
                        <div class="input-group mb-3">
                            <input type="text" id="searchLocation" class="form-control" placeholder="Rechercher un quartier ou lieu...">
                            <button class="btn btn-dark" type="button" id="btnSearchLocation"><i class="fas fa-search"></i></button>
                            <button class="btn btn-outline-secondary" type="button" id="btnMyLocation"><i class="fas fa-crosshairs"></i></button>
                        </div>
                        <div id="map" style="height: 350px; border-radius: 1rem;"></div>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Adresse générée</label>
                        <textarea class="form-control bg-light mb-3" id="geolocalisation" name="geolocalisation" readonly rows="3"></textarea>
                        <div class="row">
                            <div class="col-6"><input type="text" class="form-control form-control-sm" id="latitude" name="latitude" placeholder="Latitude" required></div>
                            <div class="col-6"><input type="text" class="form-control form-control-sm" id="longitude" name="longitude" placeholder="Longitude" required></div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="mb-5">
                <legend><i class="fas fa-camera me-2"></i> Photos de la résidence</legend>
                <div class="text-center">
                    <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" required>
                    <p class="text-muted small mt-2">Format suggéré : Paysage. Max 5 photos.</p>
                </div>
            </fieldset>

            <div class="text-center mb-5">
                <button type="submit" class="btn btn-submit btn-lg">
                    <i class="fas fa-cloud-upload-alt me-2"></i> PUBLIER MON ANNONCE
                </button>
            </div>
        </form>
    </div>

    @include('includes.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Garde tes scripts JS Leaflet ici, ils fonctionneront parfaitement avec le nouveau design --}}

</body>
</html>