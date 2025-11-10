<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Réservations</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome (pour les icônes) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Inter Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* Configuration Tailwind pour utiliser la police Inter et styles globaux */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        :root {
            --primary-color: #f59e0b; /* Amber 500 - Simule le #ff7a00 */
            --header-bg: #1f2937; /* Dark Gray 800 */
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* Gray 100 */
            min-height: 100vh;
        }

        /* Style spécifique pour la Sidebar (réutilisé pour cohérence) */
        #sidebar {
            transition: transform 0.3s ease-in-out;
            transform: translateX(100%);
            position: fixed;
            top: 0;
            right: 0;
            width: 350px;
            z-index: 50;
            height: 100%;
            background-color: var(--header-bg);
            padding: 1.5rem;
            box-shadow: -4px 0 12px rgba(0, 0, 0, 0.3);
        }
        #sidebar.active {
            transform: translateX(0);
        }

        /* Ajustement de la couleur principale des liens/boutons pour l'orange/ambre */
        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            transition: background-color 0.15s;
        }
        .btn-primary-custom:hover {
            background-color: #d97706; /* Amber 700 */
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- Header & Navigation Bar (FIXE) - Adoptant la structure de l'autre page -->
    <header class="bg-gray-900 shadow-lg fixed top-0 left-0 right-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Top Row: Logo, Title, Toggle Button -->
            <div class="flex items-center justify-between py-3">
                <div class="flex items-center space-x-4">
                    <!-- Placeholder Logo -->
                    <div class="h-10 w-10 bg-amber-500 rounded-lg flex items-center justify-center text-gray-900 font-bold text-lg">H</div>
                    <h1 class="text-xl font-semibold text-white">Historique Réservations</h1>
                </div>

                <!-- Toggle Button (pour ouvrir la Sidebar) -->
                <button id="toggleSidebar" class="p-2 rounded-lg text-white hover:bg-gray-700 focus:outline-none transition duration-150">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>

            <!-- Bottom Row: Nav Links/Stats - Simplifié pour cette page -->
            <div class="flex flex-wrap justify-between text-center border-t border-gray-800 py-2 -mx-4">


                <a href="{{ route('dashboard') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-white bg-gray-800 transition duration-150 rounded-lg">
                    <i class="fas fa-user mr-1"></i> Profil
                </a>

                <a href="{{ route('residences') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                    <i class="fas fa-home mr-1"></i> Residences
                    <span class="ml-1 px-2 py-0.5 bg-green-600 text-white text-xs font-bold rounded-full">4</span>
                </a>

                <a href="{{ route('occupees') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                    <i class="fas fa-lock mr-1"></i> Occupées
                    <span class="ml-1 px-2 py-0.5 bg-yellow-500 text-gray-900 text-xs font-bold rounded-full">1</span>
                </a>

                <a href="{{ route('mes_demandes') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                    <i class="fas fa-spinner mr-1"></i> Demandes
                    <span class="ml-1 px-2 py-0.5 bg-gray-600 text-white text-xs font-bold rounded-full">2</span>
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
        <div class="page-header text-center mb-8">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-amber-600 mb-2 border-b-4 border-amber-500 pb-3 inline-block">
                <i class="fas fa-history mr-3 text-3xl"></i> Historique de vos réservations
            </h1>
            <p class="text-gray-500">Retrouvez toutes vos réservations passées et à venir</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 text-center p-4 rounded-lg mb-8 shadow-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($reservations as $res)
                <div class="bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col border-4
                    @if($res->status == 'confirmée') border-green-500/50 hover:shadow-green-300/50
                    @elseif($res->status == 'en_attente') border-blue-500/50 hover:shadow-blue-300/50
                    @elseif($res->status == 'terminée') border-gray-400/50 hover:shadow-gray-300/50
                    @else border-red-500/50 hover:shadow-red-300/50 @endif
                    transition duration-300 transform hover:scale-[1.01]">

                    <div class="p-5 flex flex-col flex-grow text-center">

                        <!-- STATUT -->
                        <div class="mb-3">
                            @php
                                $statusClass = [
                                    'en_attente' => 'bg-blue-600 text-white',
                                    'confirmée' => 'bg-green-600 text-white',
                                    'terminée' => 'bg-gray-500 text-white',
                                    'annulée' => 'bg-red-600 text-white',
                                ][$res->status] ?? 'bg-gray-400 text-gray-800';
                            @endphp
                            <span class="inline-block px-3 py-1 text-xs font-bold {{ $statusClass }} rounded-full shadow-md">
                                {{ ucfirst(str_replace('_', ' ', $res->status)) }}
                            </span>
                        </div>

                        <!-- INFOS PRINCIPALES -->
                        <h5 class="text-xl font-extrabold text-gray-800 mb-2 truncate">{{ $res->residence->nom }}</h5>
                        <p class="text-sm text-gray-500 mb-4">
                            <i class="fas fa-map-marker-alt text-amber-500 mr-1"></i> {{ $res->residence->ville }}
                        </p>

                        <ul class="space-y-2 text-sm text-gray-700 font-medium border-t pt-4 border-gray-100 mb-4">
                            <li class="flex justify-between items-center">
                                <span class="text-gray-500"><i class="fas fa-calendar-check mr-2 text-amber-400"></i> Dates :</span>
                                <span class="text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($res->date_arrivee)->format('d/m/y') }} ➡ {{ \Carbon\Carbon::parse($res->date_depart)->format('d/m/y') }}</span>
                            </li>
                            <li class="flex justify-between items-center">
                                <span class="text-gray-500"><i class="fas fa-user-friends mr-2 text-amber-400"></i> Personnes :</span>
                                <span class="text-gray-900 font-semibold">{{ $res->personnes }}</span>
                            </li>
                        </ul>

                        <!-- TOTAL -->
                        <div class="mt-auto border-t pt-3">
                             <p class="text-lg font-extrabold text-amber-600">
                                Total payé : {{ number_format($res->total, 0, ',', ' ') }} FCFA
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                Réservé le {{ $res->created_at->format('d/m/Y') }}
                            </p>
                        </div>

                        <!-- Préfacture/Détails (Optionnel en Historique) -->
                        @if($res->status == 'en_attente')
                            <div class="mt-3 p-3 rounded-lg bg-amber-50 border border-amber-300 text-xs shadow-inner">
                                @php
                                    $jours = \Carbon\Carbon::parse($res->date_depart)->diffInDays(\Carbon\Carbon::parse($res->date_arrivee));
                                    $prixJournalier = $res->residence->prix_journalier;
                                    $totalEstime = $jours * $prixJournalier;
                                @endphp
                                <h6 class="fw-bold mb-1 text-amber-700 text-sm">🧾 Détails : {{ $jours }} nuit(s)</h6>
                                <p class="mb-0 text-gray-600">Prix/jour : {{ number_format($prixJournalier,0,',',' ') }} FCFA</p>
                            </div>
                        @endif

                        <!-- Boutons en bas -->
                        <div class="mt-4 flex gap-2 justify-center">
                        @if($res->status != 'payé')
                            <form action="{{ route('payer', $res->id) }}" method="GET" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full py-2 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 transition duration-150 shadow-md text-sm">
                                    <i class="fas fa-credit-card mr-1"></i> Payer la facture
                                </button>
                            </form>
                        @else
                            <button type="button" class="w-full py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition duration-150 shadow-md text-sm">
                                <i class="fas fa-check-circle mr-1"></i> Payé
                            </button>
                        @endif

                            @if($res->status == 'en_attente' || $res->status == 'confirmée')
                                <form action="{{ route('annuler', $res->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-150 shadow-md text-sm">
                                        <i class="fas fa-times-circle mr-1"></i> Annuler
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('rebook', $res->id) }}" method="GET" class="flex-1">
                                <button type="submit" class="w-full py-2 btn-primary-custom font-semibold rounded-lg hover:bg-amber-700 transition duration-150 shadow-md text-sm">
                                    <i class="fas fa-redo-alt mr-1"></i> Rebooker
                                </button>
                            </form>
                        </div>


                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-8 rounded-xl shadow-lg text-center mx-auto max-w-xl">
                    <p class="text-lg text-gray-500"><i class="fas fa-box-open mr-2"></i> Vous n’avez encore aucune réservation.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // LOGIQUE DE LA SIDEBAR (réutilisée)
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
