<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique de Facturation — {{ config('app.name') }}</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">

    <style>
        /* Ombres et badges */
        .card-shadow { box-shadow: 0 6px 20px rgba(12, 17, 36, 0.06); }
        .badge-sm { font-size: 0.70rem; padding: 0.25rem 0.5rem; border-radius: 9999px; }
    </style>
</head>
<body class="bg-gray-50">

<!-- HEADER -->
<header class="bg-white shadow-md fixed top-0 left-0 right-0 z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
        <div class="flex items-center space-x-4">
            <button id="sidebarToggle" class="text-gray-600 hover:text-gray-900 md:hidden">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="h-10 w-auto">
        </div>
        <nav class="hidden md:flex items-center space-x-4 text-sm font-medium">
            <a href="{{ route('accueil') }}" class="text-slate-600 hover:text-slate-900 flex items-center gap-1"><i class="fas fa-home"></i> Accueil</a>
            <a href="{{ route('recherche') }}" class="text-slate-600 hover:text-slate-900 flex items-center gap-1"><i class="fas fa-search"></i> Recherche</a>
            <a href="{{ route('clients_historique') }}" class="text-slate-600 hover:text-slate-900 flex items-center gap-1"><i class="fas fa-history"></i> Réservations</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="py-2 px-3 bg-red-600 text-white rounded hover:bg-red-700 flex items-center gap-2">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>
        </nav>
    </div>
</header>

<!-- OVERLAY -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-40 z-30 hidden md:hidden"></div>

<!-- SIDEBAR MOBILE -->
<aside id="mobileSidebar" class="fixed top-0 left-0 h-full w-64 bg-white shadow-lg transform -translate-x-full transition-transform z-40 md:hidden">
    <div class="flex justify-between items-center p-4 border-b">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="h-10 w-auto">
        <button id="closeSidebar" class="text-gray-600 hover:text-gray-900"><i class="fas fa-times text-xl"></i></button>
    </div>
    <nav class="flex flex-col mt-4 space-y-2 px-4">
        <a href="{{ route('accueil') }}" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2"><i class="fas fa-home"></i> Accueil</a>
        <a href="{{ route('recherche') }}" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2"><i class="fas fa-search"></i> Recherche</a>
        <a href="{{ route('clients_historique') }}" class="py-2 px-3 rounded hover:bg-gray-100 flex items-center gap-2"><i class="fas fa-history"></i> Mes réservations</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full py-2 px-3 bg-red-600 text-white rounded hover:bg-red-700 flex items-center justify-center gap-2 mt-2">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </button>
        </form>
    </nav>
</aside>

<!-- MAIN -->
<main class="container mx-auto p-2 pt-28">

    <div class="text-center mb-8">
        <h1 class="text-3xl lg:text-4xl font-extrabold text-indigo-700 mb-2 border-b-4 border-indigo-500 pb-3 inline-block">
            <i class="fas fa-file-invoice-dollar mr-3"></i> Historique de Facturation
        </h1>
        <p class="text-gray-500">Accédez et téléchargez vos factures pour les séjours terminés ou payés.</p>
    </div>

    <div class="flex justify-center space-x-4 mb-8 border-b pb-4">
        <a href="{{ route('clients_historique') }}" class="py-2 px-4 text-amber-700 rounded-lg hover:bg-amber-50 transition duration-150 font-medium border border-amber-100 flex items-center gap-2">
            <i class="fas fa-history"></i> Voir toutes mes Réservations
        </a>
    </div>

    @if($reservations->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($reservations as $res)
                @php
                    $facturestatus = $res->status;
                    $dateArrivee = \Carbon\Carbon::parse($res->date_arrivee);
                    $dateDepart = \Carbon\Carbon::parse($res->date_depart);
                    $jours = $dateDepart->diffInDays($dateArrivee);
                @endphp

                <div class="bg-white rounded-xl shadow-xl overflow-hidden flex flex-col border-4
                    @if($facturestatus == 'payée') border-green-500/50 hover:shadow-green-300/50
                    @else border-orange-500/50 hover:shadow-orange-300/50 @endif
                    transition duration-300 transform hover:scale-[1.01] card-shadow">

                    <div class="p-5 flex flex-col flex-grow text-center">
                        <div class="mb-3">
                            <span class="inline-block px-3 py-1 text-xs font-bold bg-green-200 rounded-full shadow-md">
                               {{ $facturestatus }}
                            </span>
                        </div>

                        <h5 class="text-xl font-extrabold text-gray-800 mb-2 truncate">Facture Réf. #{{ $res->reservation_code }}</h5>
                        <p class="text-sm text-gray-500 mb-4 flex items-center justify-center gap-1">
                            <i class="fas fa-home text-indigo-500"></i> {{ $res->residence->nom ?? 'Résidence inconnue' }}
                        </p>

                        <ul class="space-y-2 text-sm text-gray-700 font-medium border-t pt-4 border-gray-100 mb-4">
                            <li class="flex justify-between items-center">
                                <span class="text-gray-500"><i class="fas fa-calendar-alt mr-2 text-indigo-400"></i> Période :</span>
                                <span class="text-gray-900 font-semibold">{{ $dateArrivee->format('d/m/y') }} ➡ {{ $dateDepart->format('d/m/y') }}</span>
                            </li>
                            <li class="flex justify-between items-center">
                                <span class="text-gray-500"><i class="fas fa-calendar-alt mr-2 text-indigo-400"></i> Nuits :</span>
                                <span class="text-gray-900 font-semibold">{{ $jours }}</span>
                            </li>
                        </ul>

                        <div class="mt-auto border-t pt-3">
                             <p class="text-xl font-extrabold text-indigo-700">
                                Total : {{ number_format($res->total, 0, ',', ' ') }} FCFA
                            </p>
                        </div>

                        <div class="mt-4 flex flex-col gap-2">
                            <a href="{{ route('facture.telecharger', $res->id) }}" target="_blank" class="w-full py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-150 shadow-md text-sm flex justify-center items-center gap-2">
                                <i class="fas fa-download"></i> Télécharger PDF
                            </a>

                            @if($facturestatus == 'confirmée')
                                <a href="{{ route('payer', $res->id) }}" class="w-full py-2 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition duration-150 shadow-md text-sm flex justify-center items-center gap-2">
                                    <i class="fas fa-credit-card"></i> Procéder au Paiement
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="col-span-full bg-white p-8 rounded-xl shadow-lg text-center mx-auto max-w-xl">
            <p class="text-lg text-gray-500"><i class="fas fa-box-open mr-2"></i> Aucune facture trouvée.</p>
        </div>
    @endif
</main>

<script>
    const sidebar = document.getElementById('mobileSidebar');
    const overlay = document.getElementById('overlay');

    document.getElementById('sidebarToggle').addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    });

    document.getElementById('closeSidebar').addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });
</script>

</body>
</html>
