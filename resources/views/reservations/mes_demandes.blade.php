<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Demandes de Réservation</title>

    <!-- Vos Assets Locaux (Simulés) -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

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

                <a href="{{ route('dashboard') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-white bg-gray-800 transition duration-150 rounded-lg">
                    <i class="fas fa-user mr-1"></i> Profil
                </a>

                <a href="{{ route('residences') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                    <i class="fas fa-home mr-1"></i> Résidences
                    <span class="ml-1 px-2 py-0.5 bg-red-600 text-white text-xs font-bold rounded-full">3</span>
                </a>

                <a href="{{ route('occupees') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                    <i class="fas fa-lock mr-1"></i> Occupées
                    <span class="ml-1 px-2 py-0.5 bg-yellow-500 text-gray-900 text-xs font-bold rounded-full">1</span>
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

    <!-- Main Content Area (Ajusté pour le Header) -->
    <div class="container mx-auto px-4 py-8 pt-44 lg:pt-40">

        <!-- Titre Principal de la Page -->
        <h1 class="text-3xl lg:text-4xl font-extrabold text-indigo-700 mb-8 text-center border-b-4 border-indigo-500 pb-3">
            <i class="fas fa-spinner mr-3 text-3xl"></i> Demandes de Réservation
        </h1>

        @if($demandes->isEmpty())
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-6 rounded-lg text-center shadow-lg mx-auto max-w-lg">
                <i class="fas fa-bell-slash text-2xl mb-2 block"></i>
                <p class="font-semibold text-lg">Aucune nouvelle demande de réservation en attente.</p>
                <p class="text-sm mt-1">Revenez plus tard pour de nouvelles demandes.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 lg:grid-cols-3 gap-3">
                @foreach($demandes as $res)
                    @php
                        // Assurez-vous que le modèle Reservation a la relation 'residence' chargée
                        $residence = $res->residence;
                        $images = json_decode($residence->img);
                        $firstImage = $images[0] ?? 'https://placehold.co/400x250/E0E7FF/4F46E5?text=EN+ATTENTE';
                    @endphp

                    <div class="bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col border-2
                        @if($res->status == 'en_attente') border-indigo-500/50 hover:shadow-indigo-300/50
                        @elseif($res->status == 'confirmée') border-green-500
                        @elseif($res->status == 'annulée') border-yellow-500
                        @else border-red-500 @endif
                        transition duration-300 transform hover:scale-[1.01]">

                        <img src="{{ $firstImage}}" class="w-full h-48 object-cover"
                            onerror="this.onerror=null;this.src='https://placehold.co/400x250/E0E7FF/4F46E5?text=DEMANDE';" alt="Image de la résidence">

                        <div class="p-6 flex flex-col flex-grow text-center">
                            <h5 class="text-2xl font-extrabold text-gray-800 mb-1 truncate">{{ $residence->nom }}</h5>
                            <p class="text-sm text-gray-500 mb-4">📍 {{ $residence->ville }}</p>

                            <ul class="space-y-2 text-base text-gray-700 font-medium border-t pt-4 border-gray-100">
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-500"><i class="fas fa-plane-arrival mr-2 text-indigo-400"></i> Arrivée :</span>
                                    <span class="text-gray-900 font-bold">{{ $res->date_arrivee->format('d/m/Y') }}</span>
                                </li>
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-500"><i class="fas fa-plane-departure mr-2 text-indigo-400"></i> Départ :</span>
                                    <span class="text-gray-900 font-bold">{{ $res->date_depart->format('d/m/Y') }}</span>
                                </li>
                            </ul>

                            <!-- AFFICHAGE DU STATUT -->
                            <div class="mt-4 mb-5">
                                @if($res->status == 'en_attente')
                                    <span class="inline-block px-4 py-1.5 text-sm font-bold bg-indigo-600 text-white rounded-full shadow-md">En attente de votre validation</span>
                                @elseif($res->status == 'confirmée')
                                    <span class="inline-block px-4 py-1.5 text-sm font-bold bg-green-600 text-white rounded-full">Confirmée</span>
                                @elseif($res->status == 'annulée')
                                    <span class="inline-block px-4 py-1.5 text-sm font-bold bg-yellow-500 text-gray-900 rounded-full">Annulée (Client)</span>
                                @else
                                    <span class="inline-block px-4 py-1.5 text-sm font-bold bg-red-600 text-white rounded-full">Refusée (Vous)</span>
                                @endif
                            </div>

                            <!-- LOGIQUE D'ACTION : ACCEPT/REFUS -->
                            @if($res->status == 'en_attente')
                                <div class="flex gap-3 justify-center mt-auto">
                                    <form action="{{ route('reservation.accepter', $res->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full px-5 py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition duration-150 shadow-md">
                                            <i class="fas fa-check mr-1"></i> Accepter
                                        </button>
                                    </form>

                                    <form action="{{ route('reservation.refuser', $res->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full px-5 py-2.5 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-150 shadow-md">
                                            <i class="fas fa-times mr-1"></i> Refuser
                                        </button>
                                    </form>
                                </div>
                            @endif

                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // LOGIQUE DE LA SIDEBAR
            const toggleButton = document.getElementById('toggleSidebar');
            const closeButton = document.getElementById('closeSidebar');
            const sidebar = document.getElementById('sidebar');

            if (toggleButton && sidebar) {
                toggleButton.addEventListener('click', function() {
                    sidebar.classList.add('active');
                });
            }

            if (closeButton && sidebar) {
                closeButton.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                });
            }
        });
    </script>
</body>
</html>
