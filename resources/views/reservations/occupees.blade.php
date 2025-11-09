<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résidences Actuellement Occupées</title>

    <!-- GLightbox CSS -->
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">

    <!-- Assets Bootstrap et FontAwesome -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; min-height: 100vh; }
        #sidebar { transition: transform 0.3s ease-in-out; transform: translateX(100%); position: fixed; top: 0; right: 0; width: 350px; z-index: 50; height: 100%; background-color: #1f2937; padding: 1.5rem; box-shadow: -4px 0 12px rgba(0,0,0,0.3); }
        #sidebar.active { transform: translateX(0); }
        .image-scroll-wrapper { overflow-x: auto; white-space: nowrap; scrollbar-width: thin; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- HEADER -->
    <header class="bg-gray-900 shadow-lg fixed top-0 left-0 right-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-3">
                <div class="flex items-center space-x-4">
                    <div class="h-10 w-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">A'H</div>
                    <h1 class="text-xl font-semibold text-white">gestionnaire@afrikhub.com</h1>
                </div>
                <button id="toggleSidebar" class="p-2 rounded-lg text-white hover:bg-indigo-700 focus:outline-none transition duration-150">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>

            <div class="flex flex-wrap justify-between text-center border-t border-gray-800 py-2 -mx-4">
                <a href="{{ route('dashboard') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                    <i class="fas fa-user mr-1"></i> Profil
                    <span class="ml-1 px-2 py-0.5 bg-red-600 text-white text-xs font-bold rounded-full">3</span>
                </a>
                <a href="{{ route('residences') }}" class="flex-1 min-w-[25%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                    <i class="fas fa-home mr-1"></i> Residences
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

    <!-- SIDEBAR -->
    <div id="sidebar" class="text-white flex flex-col items-center">
        <button id="closeSidebar" class="absolute top-4 right-4 text-gray-400 hover:text-white transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
        <div class="mt-12 w-full flex flex-col space-y-4">
            <a href="{{ route('accueil') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition"><i class="fas fa-home mr-1"></i> Accueil</a>
            <a href="{{ route('recherche') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Recherche</a>
            <a href="{{ route('historique') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Réservation</a>
            <a href="#" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition"><i class="fas fa-user mr-1"></i> Mon Compte</a>
            <a href="{{ route('residences') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Mes Residences</a>
            <a href="{{ route('mise_en_ligne') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Mise en ligne</a>
            <a href="{{ route('occupees') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Résidences occupées</a>
            <a href="{{ route('mes_demandes') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Demandes de réservations</a>
            <div class="py-2 w-full mx-auto row m-0">
                <a href="{{ route('logout') }}" class="w-full text-center py-2 px-4 bg-red-600 hover:bg-red-700 rounded-lg font-semibold transition shadow-lg">Déconnexion</a>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="container mx-auto px-4 py-8 pt-44 lg:pt-40">
        <main class="bg-white p-6 md:p-8 rounded-xl shadow-2xl border border-gray-200">
            <h1 class="text-4xl font-extrabold text-red-600 mb-8 text-center border-b-4 border-red-500 pb-3">
                <i class="fas fa-lock-open text-3xl mr-3"></i> Résidences Actuellement Occupées
            </h1>

            <section id="occupees">
                @if($residences->isEmpty())
                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 p-6 rounded-lg text-center shadow-lg">
                        <i class="fas fa-info-circle text-2xl mb-2 block"></i>
                        <p class="font-semibold text-lg">Aucune résidence n'est actuellement occupée.</p>
                        <p class="text-sm mt-1">Les résidences disponibles ne figurent pas dans cette liste.</p>
                    </div>
                @else
                    <div class="flex flex-wrap gap-6 justify-center">
                        @foreach($residences as $residence)
                            <div class="w-full sm:w-[320px] bg-red-50 border-2 border-red-400 rounded-xl shadow-2xl p-6 flex flex-col justify-between">
                                <div>
                                    <h5 class="text-2xl font-bold text-red-800 mb-3 flex items-center">
                                        <i class="fas fa-building mr-3 text-red-600"></i> {{ $residence->nom }}
                                    </h5>
                                    <p class="text-sm mb-2"><strong>Ville :</strong> {{ $residence->ville }}</p>
                                    <p class="text-sm mb-2"><strong>Pays :</strong> {{ $residence->pays }}</p>
                                    <p class="text-sm mb-2"><strong>Prix journalier :</strong> {{ number_format($residence->prix_journalier, 0, ',', ' ') }} FCFA</p>
                                    <p class="text-sm mb-2"><strong>Type :</strong> {{ $residence->type_residence }}</p>
                                    <p class="text-sm mb-2"><strong>Chambres :</strong> {{ $residence->nombre_chambres }}</p>
                                    <p class="text-sm mb-2"><strong>Salons :</strong> {{ $residence->nombre_salons }}</p>
                                </div>
                                <button class="w-full bg-red-600 text-white p-3 rounded-lg font-semibold mt-6 hover:bg-red-700 transition duration-150 transform hover:scale-[1.02] shadow-md hover:shadow-lg">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Libérer la Résidence
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggleSidebar');
            const closeButton = document.getElementById('closeSidebar');
            const sidebar = document.getElementById('sidebar');
            if(toggleButton && sidebar){ toggleButton.addEventListener('click', () => sidebar.classList.add('active')); }
            if(closeButton && sidebar){ closeButton.addEventListener('click', () => sidebar.classList.remove('active')); }
        });
    </script>
</body>
</html>
