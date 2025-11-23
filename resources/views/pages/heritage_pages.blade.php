<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ config('app.name') }} - @yield('title')</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">


<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');

    /* Police et taille globale */
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f3f4f6;
        font-size: 16px; /* Taille par défaut */
        line-height: 1.6;
    }

    /* Sidebar (menu latéral) */
    #sidebar {
        transition: transform 0.3s ease-in-out;
        transform: translateX(100%);
        position: fixed;
        top: 0;
        right: 0;
        width: 80%;       /* plus responsive */
        max-width: 350px;
        height: 100%;
        z-index: 50;
        padding: 1.5rem;
        box-shadow: -4px 0 12px rgba(0, 0, 0, 0.3);
        overflow-y: auto;
        font-size: 16px;  /* uniforme pour les liens */
    }
    #sidebar.active {
        transform: translateX(0);
    }

    /* Header statistiques responsive */
    .header-stats {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        text-align: center;
        margin-top: 0.5rem;
        font-size: 10px; /* un peu plus petit que le body */
    }
    @env()

    @endenva {
        flex: 1 1 48%;
        margin: 0.25rem;
    }

    @media (min-width: 768px) {
        .a {
            flex: 1 1 22%;
            margin: 0.25rem;
            font-size: 10px;
        }
    }

    /* Header boutons responsive */
    .header-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        font-size: 10px;
    }
    .header-buttons a, .header-buttons button {
        flex: 1 1 auto;
    }

    /* Main content padding */
    main {
        padding-top: 8rem;
        padding-left: 1rem;
        padding-right: 1rem;
        font-size: 10px;
    }
    @media (min-width: 1024px) {
        main {
            padding-left: 2rem;
            padding-right: 2rem;
        }
    }

    /* Footer spacing et texte */
    footer {
        padding: 1rem 0;
        font-size: 10px;
    }
</style>

</head>

<body class="bg-gray-50">

    <!-- HEADER FIXE -->
    <header class="bg-gray-900 shadow-lg fixed top-0 left-0 right-0 z-40">
        <div class="max-w-7xl mx-auto px-4">

            <!-- Première ligne : Logo, nom, bouton menu -->
            <div class="flex items-center justify-between py-3">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('accueil') }}" class="block">
                        <img src="{{ asset('assets/images/logo_01.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto" />
                    </a>
                    <div>
                        <h1 class="text-xl font-semibold text-white">
                            {{ Auth::user()->name ?? 'Utilisateur' }}
                        </h1>
                    </div>
                </div>




                <!-- Zone recherche + icône utilisateur -->
                <div class="flex items-center space-x-4">

                    <!-- Bouton Ajouter une résidence -->
                    <a href="{{ route('mise_en_ligne') }}" class="w-full text-center py-2 px-4 hover:bg-gray-700 rounded-lg flex items-center justify-center gap-2 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Ajouter
                    </a>

                    <a href="{{ route('clients_historique') }}" class="w-full text-center py-2 px-4 hover:bg-gray-700 rounded-lg flex items-center justify-center gap-2 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Réservations
                    </a>

                     <a href="{{ route('recherche') }}" class="text-gray-300 hover:text-white p-2 rounded-lg hover:bg-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M16.65 16.65A7.5 7.5 0 1110 3a7.5 7.5 0 016.65 13.65z"/>
                        </svg>
                    </a>

                    <!-- Icône utilisateur -->
                    <a href="{{ route('pro.dashboard') }}" class="w-full text-center py-2 px-4 hover:bg-gray-700 rounded-lg flex items-center justify-center gap-2 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9.966 9.966 0 0112 15c2.21 0 4.21.72 5.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Profil
                    </a>

                    <!-- Bouton toggle sidebar -->
                    <button id="toggleSidebar" class="p-2 rounded-lg text-white hover:bg-indigo-700 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Ligne des statistiques -->
            <div class="flex flex-wrap justify-between text-center border-t border-gray-800 py-2 -mx-4">

                <a href="{{ route('pro.residences') }}" class="flex-1 min-w-[25%] p-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    <i class="fas fa-home mr-1"></i> Résidences
                    <span class="ml-1 px-2 bg-red-600 text-xs font-bold rounded-full">{{ $totalResidences }}</span>
                </a>

                <a href="{{ route('occupees') }}" class="flex-1 min-w-[25%] p-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    <i class="fas fa-lock mr-1"></i> Occupées
                    <span class="ml-1 px-2 bg-yellow-500 text-xs font-bold rounded-full">{{ $totalResidencesOccupees }}</span>
                </a>

                <a href="{{ route('mes_demandes') }}" class="flex-1 min-w-[25%] p-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    <i class="fas fa-spinner mr-1"></i> Demandes
                    <span class="ml-1 px-2 bg-gray-600 text-xs font-bold rounded-full">{{ $totalDemandesEnAttente }}</span>
                </a>

                <a href="{{ route('reservationRecu') }}" class="flex-1 min-w-[25%] p-2 text-gray-300 hover:bg-gray-800 rounded-lg">
                    <i class="fas fa-clock mr-1"></i> Historique
                    <span class="ml-1 px-2 bg-green-600 text-xs font-bold rounded-full">{{ $totalReservationsRecu }}</span>
                </a>

            </div>
        </div>
    </header>

    <!-- SIDEBAR (Menu latéral) -->
    <aside id="sidebar" class="bg-gray-900 text-white flex flex-col items-center">

        <!-- Bouton fermer -->
        <button id="closeSidebar" class="absolute top-4 right-4 text-gray-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Liens -->
        <div class="mt-12 w-full flex flex-col space-y-4">

            <a href="{{ route('accueil') }}" class="w-full text-center py-2 hover:bg-gray-700 rounded-lg flex items-center justify-center gap-2">
                <!-- House SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 576 512">
                    <path d="M280.37 148.26L96 300.11V464a16 16 0 0016 16l112-.3a16 16 0 0016-15.7V368a16 16 0 0116-16h64a16 16 0 0116 16v96.1a16 16 0 0016 15.9l112 .3a16 16 0 0016-16V300L295.67 148.3a12.19 12.19 0 00-15.3 0zM571.6 251.47L488 182.54V44a12 12 0 00-12-12h-56a12 12 0 00-12 12v72.61L318.47 43.28c-27.6-23.4-68.3-23.4-95.9 0L4.34 251.47a12 12 0 00-1.6 16.9l25.5 31a12 12 0 0016.9 1.6L64 271.69V464a48 48 0 0048 48h112a48 48 0 0048-48V368h64v96a48 48 0 0048 48l112-.3a48 48 0 0048-48V271.69l18.9 16.3a12 12 0 0016.9-1.6l25.5-31a12 12 0 00-1.7-16.92z"/>
                </svg>
                Accueil
            </a>

            <a href="{{ route('recherche') }}" class="w-full text-center py-2 hover:bg-gray-700 rounded-lg flex items-center justify-center gap-2">
                <!-- Magnifying Glass -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 3a7.5 7.5 0 006.15 13.65z"/>
                </svg>
                Recherche
            </a>

            <a href="{{ route('reservationRecu') }}" class="w-full text-center py-2 hover:bg-gray-700 rounded-lg flex items-center justify-center gap-2">
                <!-- Clock Rotate Left -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Réservation
            </a>

            <a href="{{ route('pro.dashboard') }}" class="w-full text-center py-2 hover:bg-gray-700 rounded-lg flex items-center justify-center gap-2">
                <!-- User -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9.966 9.966 0 0112 15c2.21 0 4.21.72 5.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Profil
            </a>

            <a href="{{ route('pro.residences') }}" class="w-full text-center py-2 hover:bg-gray-700 rounded-lg flex items-center justify-center gap-2">
                <!-- Building -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18V7H3v14zM3 3h18v4H3V3z"/>
                </svg>
                Mes Résidences
            </a>

            <a href="{{ route('mise_en_ligne') }}" class="w-full text-center py-2 hover:bg-gray-700 rounded-lg flex items-center justify-center gap-2">
                <!-- Cloud Upload -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l5-5 5 5M12 11v10M20 16.58A5.002 5.002 0 0016 7h-1.26a8 8 0 10-11.48 9.36"/>
                </svg>
                Mise en ligne
            </a>

            <a href="{{ route('occupees') }}" class="w-full text-center py-2 hover:bg-gray-700 rounded-lg flex items-center justify-center gap-2">
                <!-- Lock -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.104 0 2 .896 2 2v4h-4v-4c0-1.104.896-2 2-2zm-6 0h12V7a6 6 0 00-12 0v4z"/>
                </svg>
                Résidences occupées
            </a>

            <a href="{{ route('mes_demandes') }}" class="w-full text-center py-2 hover:bg-gray-700 rounded-lg flex items-center justify-center gap-2">
                <!-- Envelope Open -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l9 6 9-6M21 8v10a2 2 0 01-2 2H5a2 2 0 01-2-2V8"/>
                </svg>
                Demandes
            </a>

            <a href="{{ route('logout') }}" class="w-full text-center py-2 bg-red-600 hover:bg-red-700 rounded-lg font-semibold shadow-lg flex items-center justify-center gap-2">
                <!-- Logout -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                </svg>
                Déconnexion
            </a>
        </div>
    </aside>

    <!-- CONTENU PRINCIPAL -->
    <main class="pt-32 mb-16 px-O mx-O">
        <div class="m-0 p-4">
            @include('includes.messages')
            @yield('main')
        </div>
    </main>
    <!-- FOOTER -->
    <footer class="text-center text-sm text-gray-500 mt-12 mb-8">
        © {{ date('Y') }} {{ config('app.name') }} — Tous droits réservés
    </footer>

    <!-- SCRIPT : ouverture / fermeture sidebar -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleSidebar = document.getElementById('toggleSidebar');
        const closeSidebar = document.getElementById('closeSidebar');

        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.add('active');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('active');
        });
    </script>

    @stack('scripts')

        <!-- GLightbox JS -->
        <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

        <script>
            // Initialise GLightbox une fois le DOM chargé
            document.addEventListener('DOMContentLoaded', function () {
                GLightbox({
                    selector: '.glightbox',
                    touchNavigation: true,
                    loop: true,
                    zoomable: true,
                });
            });
        </script>

    @yield('script')
</body>
</html>
