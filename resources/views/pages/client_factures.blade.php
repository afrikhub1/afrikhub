<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique de Facturation — {{ config('app.name') }}</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .card-shadow { box-shadow: 0 6px 20px rgba(12,17,36,0.06); }
        .truncate-2 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
    </style>
</head>
<body class="bg-gray-50">

<!-- HEADER FIXE + SIDEBAR MOBILE -->
<header class="bg-white shadow-md fixed w-full z-50 top-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
        <div class="flex items-center space-x-4">
            <button id="sidebarToggle" class="md:hidden text-gray-700 hover:text-gray-900">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <img class="h-10 w-auto" src="{{ asset('assets/images/logo.png') }}" alt="Logo">
            <span class="hidden md:block font-semibold text-gray-800">{{ Auth::user()->name ?? 'Utilisateur' }}</span>
        </div>

        <nav class="hidden md:flex items-center space-x-6 text-sm font-medium">
            <a href="{{ route('accueil') }}" class="text-slate-600 hover:text-slate-900"><i class="fas fa-home mr-1"></i> Accueil</a>
            <a href="{{ route('recherche') }}" class="text-slate-600 hover:text-slate-900"><i class="fas fa-search mr-1"></i> Recherche</a>
            <a href="{{ route('clients_historique') }}" class="text-slate-600 hover:text-slate-900"><i class="fas fa-history mr-1"></i> Mes réservations</a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="py-2 px-4 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 transition">
                    <i class="fas fa-sign-out-alt mr-1"></i> Déconnexion
                </button>
            </form>
        </nav>
    </div>
</header>

<!-- Sidebar Mobile -->
<aside id="mobileSidebar" class="fixed top-0 left-0 h-full w-64 bg-white shadow-lg transform -translate-x-full transition-transform z-60 md:hidden">
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
            <button type="submit" class="w-full py-2 px-3 bg-red-600 text-white rounded hover:bg-red-700 flex items-center justify-center gap-2">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </button>
        </form>
    </nav>
</aside>

<main class="max-w-7xl mx-auto p-4 pt-24">
    <header class="text-center mb-8">
        <h1 class="text-3xl lg:text-4xl font-extrabold text-indigo-700 inline-flex items-center justify-center gap-2">
            <i class="fas fa-file-invoice-dollar text-3xl"></i> Historique de Facturation
        </h1>
        <p class="text-gray-500 mt-2">Accédez et téléchargez vos factures pour les séjours terminés ou payés.</p>
    </header>

    <div class="flex justify-center mb-8">
        <a href="{{ route('clients_historique') }}" class="py-2 px-4 bg-amber-50 border border-amber-200 rounded-lg text-amber-700 font-medium hover:bg-amber-100 transition">
            <i class="fas fa-history mr-1"></i> Voir toutes mes Réservations
        </a>
    </div>

    @if($reservations->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($reservations as $res)
                @php
                    $status = $res->status;
                    $dateArrivee = \Carbon\Carbon::parse($res->date_arrivee);
                    $dateDepart = \Carbon\Carbon::parse($res->date_depart);
                    $jours = $dateDepart->diffInDays($dateArrivee);
                @endphp

                <div class="bg-white rounded-xl card-shadow overflow-hidden flex flex-col border transition transform hover:-translate-y-1">
                    <div class="p-5 flex flex-col flex-grow text-center">
                        <div class="mb-3">
                            <span class="inline-block px-3 py-1 text-xs font-bold rounded-full
                                @if($status == 'payée') bg-green-500 text-white
                                @elseif($status == 'confirmée') bg-orange-500 text-white
                                @else bg-gray-300 text-gray-800 @endif">
                                {{ $status }}
                            </span>
                        </div>

                        <h5 class="text-xl font-extrabold text-gray-800 mb-2 truncate">Facture #{{ $res->reservation_code }}</h5>
                        <p class="text-sm text-gray-500 mb-4">
                            <i class="fas fa-home text-indigo-500 mr-1"></i> {{ $res->residence->nom ?? 'Résidence inconnue' }}
                        </p>

                        <ul class="space-y-2 text-sm text-gray-700 font-medium border-t pt-4 border-gray-100 mb-4 flex-grow">
                            <li class="flex justify-between">
                                <span class="text-gray-500"><i class="fas fa-calendar-alt mr-2 text-indigo-400"></i> Période :</span>
                                <span class="font-semibold text-gray-900">{{ $dateArrivee->format('d/m/y') }} ➡ {{ $dateDepart->format('d/m/y') }}</span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-gray-500"><i class="fas fa-moon mr-2 text-indigo-400"></i> Nuits :</span>
                                <span class="font-semibold text-gray-900">{{ $jours }}</span>
                            </li>
                        </ul>

                        <div class="mt-auto border-t pt-3">
                            <p class="text-xl font-extrabold text-indigo-700">
                                Total : {{ number_format($res->total, 0, ',', ' ') }} FCFA
                            </p>
                        </div>

                        <div class="mt-4 flex flex-col gap-2">
                            <a href="{{ route('facture.telecharger', $res->id) }}" target="_blank"
                                class="w-full py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 shadow-md transition text-sm flex items-center justify-center gap-2">
                                <i class="fas fa-download"></i> Télécharger PDF
                            </a>

                            @if($status == 'confirmée')
                                <a href="{{ route('payer', $res->id) }}"
                                    class="w-full py-2 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 shadow-md transition text-sm flex items-center justify-center gap-2">
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
    // Sidebar mobile toggle
    const sidebar = document.getElementById('mobileSidebar');
    document.getElementById('sidebarToggle').addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
    });
    document.getElementById('closeSidebar').addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
    });
</script>

</body>
</html>
