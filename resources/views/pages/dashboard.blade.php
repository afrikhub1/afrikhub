<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Tableau de Bord - Résidences</title>

    <!-- GLightbox CSS (pour le carrousel d'images) -->
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">

    <!-- Vos Assets Locaux -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome est remplacé ici par le lien local -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* Configuration Tailwind pour utiliser la police Inter et styles globaux */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        :root {
            --primary-color: #4f46e5; /* Indigo 600 */
            --danger-color: #ef4444; /* Red 500 */
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Gray 100 */
            min-height: 100vh;
        }
        /* Style spécifique pour la Sidebar */
        #sidebar {
            transition: transform 0.3s ease-in-out;
            transform: translateX(100%);
            position: fixed;
            top: 0;
            right: 0;
            width: 350px;
            z-index: 50;
            height: 100%;
            background-color: #1f2937; /* Dark Gray 800 */
            padding: 1.5rem;
            box-shadow: -4px 0 12px rgba(0, 0, 0, 0.3);
        }
        #sidebar.active {
            transform: translateX(0);
        }
        /* Style pour la Lightbox (utilisé ici comme référence, mais GLightbox gère la sienne) */
        .lightbox-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        /* Conteneur de défilement pour les albums */
        .image-scroll-wrapper {
            overflow-x: auto;
            white-space: nowrap;
            /* Permet le défilement horizontal */
            scrollbar-width: thin;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- Header & Navigation Bar (FIXE) -->
    <header class="bg-gray-900 shadow-lg fixed top-0 left-0 right-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Top Row: Logo, Title, Toggle Button -->
            <div class="flex items-center justify-between py-3">
                <div class="flex items-center space-x-4">
                    <!-- Placeholder Logo -->
                    <div class="h-10 w-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">A'H</div>
                    <h1 class="text-xl font-semibold text-white">gestionnaire@afrikhub.com</h1>
                </div>

                <!-- Toggle Button (pour ouvrir la Sidebar) -->
                <button id="toggleSidebar" class="p-2 rounded-lg text-white hover:bg-indigo-700 focus:outline-none transition duration-150">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>

            <!-- Bottom Row: Nav Links/Stats -->
            <div class="flex flex-wrap justify-between text-center border-t border-gray-800 py-2 -mx-4">

                <a href="{{ route('residences') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                    <i class="fas fa-home mr-1"></i> Résidences
                    <span class="ml-1 px-2 py-0.5 bg-red-600 text-white text-xs font-bold rounded-full">3</span>
                </a>

                <a href="{{ route('occupees') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                    <i class="fas fa-lock mr-1"></i> Occupées
                    <span class="ml-1 px-2 py-0.5 bg-yellow-500 text-gray-900 text-xs font-bold rounded-full">1</span>
                </a>

                <a href="{{ route('mes_demandes') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                    <i class="fas fa-spinner mr-1"></i> Demandes
                    <span class="ml-1 px-2 py-0.5 bg-gray-600 text-white text-xs font-bold rounded-full">2</span>
                </a>

                <a href="{{ route('historique') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                    <i class="fas fa-clock mr-1"></i> Historique
                    <span class="ml-1 px-2 py-0.5 bg-green-600 text-white text-xs font-bold rounded-full">4</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Sidebar (Off-Canvas Menu) -->
    <div id="sidebar" class="text-white flex flex-col items-center">
        <button id="closeSidebar" class="absolute top-4 right-4 text-gray-400 hover:text-white transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <div class="mt-12 w-full flex flex-col space-y-4">

            <a href="{{ route('accueil') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition"><i class="fas fa-home mr-1"></i> Accueil</a>

            <a href="{{ route('recherche') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Recherche</a>

            <a href="{{ route('historique') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Réservation</a>

            <a href="#" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-user mr-1"></i> Mon Compte
            </a>

            <a href="{{ route('residences') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Mes Residences</a>

            <a href="{{ route('mise_en_ligne') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Mise en ligne</a>

            <a href="{{ route('occupees') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Residence occupées</a>

            <a href="{{ route('mes_demandes') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Demandes de reservations</a>

            <div class="py-2 w-full mx-auto row m-0">
                <a href="{{ route('logout') }}" class="w-full text-center py-2 px-4 bg-red-600 hover:bg-red-700 rounded-lg font-semibold transition shadow-lg">Déconnexion</a>
            </div>
        </div>
    </div>
    <!-- FIN HEADER & SIDEBAR -->

    <!-- Main Content Area (avec votre padding original pour compenser le header) -->
    <div class="container mx-auto px-4 py-8 pt-44 lg:pt-40">

        <!-- Simulation Message d'alerte (Static) -->
        <div id="alert-message" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-8 shadow-lg" role="alert">
            <strong class="font-bold">Succès !</strong>
            <span class="block sm:inline">Résidence marquée comme occupée. (Message statique)</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="document.getElementById('alert-message').classList.add('hidden')">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.697l-2.651 3.152a1.2 1.2 0 1 1-1.697-1.697l3.152-2.651-3.152-2.651a1.2 1.2 0 1 1 1.697-1.697l2.651 3.152 2.651-3.152a1.2 1.2 0 0 1 1.697 1.697l-3.152 2.651 3.152 2.651a1.2 1.2 0 0 1 0 1.697z"/></svg>
            </span>
        </div>

        <main class="bg-white p-6 md:p-8 rounded-xl shadow-2xl border border-gray-200">

            <!-- Résidences Occupées -->
            <section id="occupees" class="mb-10 row m-0">
                <h2 class="text-3xl font-extrabold text-red-600 mb-6 flex items-center border-b pb-2">
                    <i class="fas fa-key text-2xl mr-3"></i> Mes Résidences Occupées (Confirmées)
                </h2>
                <div class="p-2 d-flex">
                    {{-- Filtrage des réservations confirmées directement dans la vue (approche Blade) --}}

                    @if($reservationsConfirmees->isEmpty())
                        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg text-center shadow-inner">
                            <i class="fas fa-info-circle mr-2"></i> Vous n'avez aucune résidence actuellement occupée.
                        </div>
                    @else
                        <div class="flex flex-wrap gap-4">
                            @foreach($reservationsConfirmees as $occupees)
                                <div class="min-w-[320px] bg-red-100 border border-red-400 rounded-xl shadow-lg p-5 transition hover:shadow-2xl">
                                    <h5 class="text-xl font-bold text-red-800 mb-3 flex items-center">
                                        <i class="fas fa-building mr-3 text-2xl"></i> {{ $occupees->nom }}
                                    </h5>
                                    @foreach($reservation as $occupees_details)
                                        <p class="text-sm mb-1"><strong>Client :</strong> {{ $occupees_details->client }}</p>
                                        <p class="text-sm mb-1"><strong>Début :</strong> <span class="text-gray-700">{{ \Carbon\Carbon::parse($occupees_details->date_arrivee)->format('d/m/Y') }}</span></p>
                                        <p class="text-sm mb-3"><strong>Fin :</strong> <span class="text-red-700 font-bold">{{ \Carbon\Carbon::parse($occupees_details->date_depart)->format('d/m/Y') }}</span></p>
                                        <p class="text-xs text-gray-600 mb-2"><strong>Code :</strong> <span class="font-mono bg-red-200 px-1 rounded">{{ $occupees_details->reservation_code }}</span></p>
                                    @endforeach
                                    <!-- Action Button -->
                                    <button class="w-full bg-red-600 text-white p-2 rounded-lg font-semibold mt-3 hover:bg-red-700 transition duration-150">
                                        Libérer la Résidence
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <!-- Historique des Réservations -->
            <section id="historique" class="mb-10">
                <h2 class="text-3xl font-extrabold text-indigo-600 mb-6 flex items-center border-b pb-2">
                    <i class="fas fa-history text-2xl mr-3"></i> Historique des Demandes de Location
                </h2>

                @if($reservation->isEmpty())
                    <div class="bg-blue-100 border border-blue-200 text-blue-700 p-4 rounded-lg text-center shadow-inner">
                        <i class="fas fa-info-circle mr-2"></i> Aucun historique de réservation trouvé.
                    </div>
                @else
                    <ul class="divide-y divide-gray-200 border border-gray-200 rounded-xl overflow-hidden shadow-lg">
                        @foreach($reservation as $reserve)
                        <li class="p-4 bg-white hover:bg-gray-50 transition duration-150">
                            <div class="flex justify-between items-start flex-wrap gap-2">
                                <p class="text-gray-800 font-medium">
                                    <strong class="uppercase text-indigo-700">{{ $reserve->residence->nom }}</strong>
                                    <span class="text-sm text-gray-500">réservée par Mr/Mme <strong>{{ $reserve->client }}</strong>.</span>
                                </p>
                                {{-- Badge de Statut --}}
                                @if($reserve->status === 'confirmée')
                                    <span class="text-sm px-3 py-1 bg-green-500 text-white font-bold rounded-full capitalize shadow-md">Accepté</span>
                                @elseif($reserve->status === 'en_attente')
                                    <span class="text-sm px-3 py-1 bg-yellow-500 text-white font-bold rounded-full capitalize shadow-md">En attente</span>
                                @elseif($reserve->status === 'refusée')
                                    <span class="text-sm px-3 py-1 bg-red-500 text-white font-bold rounded-full capitalize shadow-md">Refusé</span>
                                @else
                                    <span class="text-sm px-3 py-1 bg-gray-500 text-white font-bold rounded-full capitalize shadow-md">Inconnu</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-calendar-alt mr-1"></i> Période : du **{{ \Carbon\Carbon::parse($reserve->date_arrivee)->format('d/m/Y') }}** au **{{ \Carbon\Carbon::parse($reserve->date_depart)->format('d/m/Y') }}**
                            </p>
                            <div class="text-xs text-gray-400 mt-2">
                                Réservée le {{ \Carbon\Carbon::parse($reserve->create_at)->format('d/m/Y') }} | Validée le {{ \Carbon\Carbon::parse($reserve->date_validation)->format('d/m/Y') }}
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @endif
            </section>

            <!-- SECTION PRINCIPALE DES RÉSIDENCES (avec Carrousel GLightbox) -->
            <section id="reservation" class="mb-10 border-t pt-8 border-gray-200">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-8 text-center border-b-4 border-indigo-500 pb-3">
                    <i class="fas fa-home text-indigo-500 mr-3"></i> Toutes Mes Résidences en Gestion
                </h2>

                @if($reservation->isEmpty())
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg shadow-md text-center">
                        <i class="fas fa-info-circle mr-2"></i> Vous n'avez aucune résidence enregistrée.
                    </div>
                @else
                    <div class="album-container flex flex-wrap gap-8 justify-center bg-gray-50 p-6 md:p-8 rounded-2xl shadow-inner border border-gray-100">

                        @foreach($residences as $residences)
                            @php
                                // Vérification et décodage des images (logique conservée)
                                $res = $residences;
                                $images = is_string($res->img) ? json_decode($res->img, true) : (array)$res->img;
                                if (!is_array($images)) { $images = []; }

                                $firstImage = $images[0] ?? 'https://placehold.co/400x200/F0F4FF/1E40AF?text=Pas+d\'image';
                            @endphp

                            <div class="w-full sm:w-[320px] bg-white rounded-2xl shadow-xl p-5 transition duration-500 hover:shadow-indigo-400/50 flex flex-col items-center border border-gray-200">

                                <!-- Image principale cliquable (Couverture du carrousel GLightbox) -->
                                <div class="w-full">
                                    <a href="{{ asset('storage/' . $firstImage) }}" class="glightbox" data-gallery="residence-{{ $res->id }}" data-title="{{ $res->nom }}">
                                        <img class="w-full h-48 object-cover rounded-xl mb-4 ring-4 ring-indigo-100 hover:ring-indigo-400 transition transform hover:scale-[1.02] cursor-pointer"
                                            src="{{ asset('storage/' . $firstImage) }}"
                                            alt="Image de la résidence: {{ $res->nom }}"
                                            onerror="this.onerror=null; this.src='https://placehold.co/400x200/F0F4FF/1E40AF?text=Erreur+Image'">
                                    </a>
                                </div>

                                <!-- Autres images invisibles pour la galerie -->
                                @foreach($images as $key => $image)
                                    @if($key > 0)
                                        <a href="{{ asset('storage/' . $image) }}" class="glightbox hidden" data-gallery="residence-{{ $res->id }}" data-title="{{ $res->nom }}"></a>
                                    @endif
                                @endforeach

                                <div class="text-lg uppercase font-bold text-gray-800 mb-3 border-b border-indigo-300 w-full text-center pb-2 truncate">
                                    {{ $res->nom }}
                                </div>

                                <ul class="text-sm text-gray-700 w-full space-y-1 mb-4">
                                    <li class="flex justify-between items-center"><strong class="text-gray-600">Chambres :</strong> <span>{{ $res->nombre_chambres }} <i class="fas fa-door-closed text-indigo-500"></i></span></li>
                                    <li class="flex justify-between items-center"><strong class="text-gray-600">Salons :</strong> <span>{{ $res->nombre_salons }} <i class="fas fa-couch text-indigo-500"></i></span></li>
                                    <li class="flex justify-between items-center"><strong class="text-gray-600">Prix/Jour :</strong> <span class="text-green-600 font-semibold">{{ $res->prix_journalier }} €</span></li>
                                    <li class="flex justify-between items-center"><strong class="text-gray-600">Ville :</strong> <span>{{ $res->ville }} <i class="fas fa-map-marker-alt text-indigo-500"></i></span></li>
                                </ul>

                                <!-- Badge dynamique (Statut d'occupation général) -->
                                @if(isset($residences->status) && $residences->status === 'occupee')
                                    <span class="bg-red-500 w-full p-3 text-white font-bold rounded-xl text-center shadow-lg transition duration-150">
                                        <i class="fas fa-bed mr-2"></i> Déjà Occupée
                                    </span>
                                @else
                                    <span class="bg-green-500 w-full p-3 text-white font-bold rounded-xl text-center shadow-lg transition duration-150">
                                        <i class="fas fa-check-circle mr-2"></i> Disponible
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialisation de GLightbox pour créer le carrousel/la galerie
            const lightbox = GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
                openEffect: 'zoom',
                closeEffect: 'zoom',
                slideEffect: 'slide',
            });

            // LOGIQUE DE LA SIDEBAR (Nouveau code)
            const toggleButton = document.getElementById('toggleSidebar');
            const closeButton = document.getElementById('closeSidebar');
            const sidebar = document.getElementById('sidebar');

            if (toggleButton && sidebar) {
                toggleButton.addEventListener('click', function() {
                    // Ajoute la classe 'active' pour rendre la sidebar visible
                    sidebar.classList.add('active');
                });
            }

            if (closeButton && sidebar) {
                closeButton.addEventListener('click', function() {
                    // Supprime la classe 'active' pour cacher la sidebar
                    sidebar.classList.remove('active');
                });
            }
        });
    </script>
</body>
</html>
