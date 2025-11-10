<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Réservations Client</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <header class="bg-dark shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <img class="w-20 md:w-28 lg:w-32 h-auto" src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo"/>
            </div>
            <nav class="flex items-center space-x-6 text-sm font-medium">
                <a href="{{ route('accueil') }}" class="text-gray-600 hover:text-indigo-600"><i class="fas fa-home mr-1"></i> Accueil</a>
                <a href="{{ route('recherche') }}" class="text-gray-600 hover:text-indigo-600"><i class="fas fa-search mr-1"></i> Recherche</a>
                <a href="{{ route('factures') }}" class="text-gray-600 hover:text-indigo-600"><i class="fas fa-file-invoice-dollar mr-1"></i> Factures</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="py-2 px-3 bg-red-600 text-white text-xs rounded-lg hover:bg-red-700 shadow-md">
                        <i class="fas fa-sign-out-alt mr-1"></i> Déconnexion
                    </button>
                </form>
            </nav>
        </div>
    </header>

    <main class="container mx-auto p-2 py-12">

        <div class="page-header text-center mb-8">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-amber-600 mb-2 border-b-4 border-amber-500 pb-3 inline-block">
                <i class="fas fa-history mr-3 text-3xl"></i> Historique de vos Réservations
            </h1>
            <p class="text-gray-500">Retrouvez toutes vos réservations passées et à venir.</p>
        </div>

        {{-- Liens de navigation INTERNE --}}
        <div class="flex justify-center space-x-4 mb-8 border-b pb-4">
            <a href="{{ route('factures') }}" class="py-2 px-4 text-indigo-700 rounded-lg hover:bg-indigo-50 transition duration-150 font-medium border border-indigo-100">
                <i class="fas fa-file-invoice-dollar mr-1"></i> Voir mes Factures
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 xl:grid-cols-4 gap-4">
            @forelse($reservations as $res)
                <div class="bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col border-4
                    @if($res->status == 'confirmée') border-green-500/50 hover:shadow-green-300/50
                    @elseif($res->status == 'en_attente') border-blue-500/50 hover:shadow-blue-300/50
                    @elseif($res->status == 'terminée') border-gray-400/50 hover:shadow-gray-300/50
                    @else border-red-500/50 hover:shadow-red-300/50 @endif
                    transition duration-300 transform hover:scale-[1.01]">

                    <div class="p-5 flex flex-col flex-grow text-center">

                        <div class="mb-3">
                            @php
                                $statusClass = [
                                    'en attente' => 'bg-blue-600 text-white',
                                    'confirmée' => 'bg-green-600 text-white',
                                    'terminée' => 'bg-gray-500 text-white',
                                    'annulée' => 'bg-red-600 text-white',
                                    'interpmpue' => 'bg-orange-600 text-white',
                                    'payé' => 'bg-indigo-600 text-white',
                                ][$res->status] ?? 'bg-gray-400 text-gray-800';
                            @endphp
                            <span class="inline-block px-3 py-1 text-xs font-bold {{ $statusClass }} rounded-full shadow-md">
                                {{ ucfirst(str_replace('_', ' ', $res->status)) }}
                            </span>
                        </div>

                        <h5 class="text-xl font-extrabold text-gray-800 mb-2 truncate">{{ $res->residence->nom }}</h5>
                        <p class="text-sm text-gray-500 mb-4">
                            <i class="fas fa-map-marker-alt text-amber-500 mr-1"></i> {{ $res->residence->ville }}
                        </p>

                        <ul class="space-y-2 text-sm text-gray-700 font-medium border-t pt-4 border-gray-100 mb-4 flex-grow">
                            <li class="flex justify-between items-center">
                                <span class="text-gray-500"><i class="fas fa-calendar-check mr-2 text-amber-400"></i> Dates :</span>
                                <span class="text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($res->date_arrivee)->format('d/m/y') }} ➡ {{ \Carbon\Carbon::parse($res->date_depart)->format('d/m/y') }}</span>
                            </li>
                            <li class="flex justify-between items-center">
                                <span class="text-gray-500"><i class="fas fa-user-friends mr-2 text-amber-400"></i> Personnes :</span>
                                <span class="text-gray-900 font-semibold">{{ $res->personnes }}</span>
                            </li>
                        </ul>

                        <div class="mt-auto border-t pt-3">
                             <p class="text-lg font-extrabold text-amber-600">
                                Total : {{ number_format($res->total, 0, ',', ' ') }} FCFA
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                Réservé le {{ $res->created_at->format('d/m/Y') }}
                            </p>
                        </div>

                        <div class="mt-4 flex gap-2 justify-center">
                            @if($res->status == 'confirmée')
                                {{-- Assurez-vous que la route 'payer' existe --}}
                                <form action="{{ route('payer', $res->id) }}" method="GET" class="flex-1">
                                    <button type="submit" class="w-full py-2 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 transition duration-150 shadow-md text-sm">
                                        <i class="fas fa-credit-card mr-1"></i> Payer
                                    </button>
                                </form>
                            @endif

                            @if($res->status == 'en_attente' || $res->status == 'confirmée')
                                {{-- Assurez-vous que la route 'annuler' existe --}}
                                <form action="{{ route('annuler', $res->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full p-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-150 shadow-md text-sm" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                        Annuler
                                    </button>
                                </form>
                            @endif

                            @if($res->status == 'confirmée')
                                <form action="{{ route('payer', $res->id) }}" method="GET" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full py-2 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 transition duration-150 shadow-md text-sm">
                                        <i class="fas fa-credit-card mr-1"></i> Payer
                                    </button>
                                </form>
                            @endif
                            @if($res->status == 'en attente')
                                <form action="{{ route('annuler', $res->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full p-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-150 shadow-md text-sm">
                                        Annuler
                                    </button>
                                </form>
                            @endif
                            {{-- Assurez-vous que la route 'rebook' existe --}}
                            <form action="{{ route('rebook', $res->id) }}" method="GET" class="flex-1">
                                <button type="submit" class="w-full p-2 btn-primary font-semibold rounded-lg hover:bg-amber-700 transition duration-150 shadow-md text-sm">
                                    Renouveler
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
    </main>
</body>
</html>
