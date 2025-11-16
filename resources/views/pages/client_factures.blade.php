<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique de Facturation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    {{-- Garder ou supprimer cette ligne selon votre configuration Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <header class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <div class="flex items-center">
                {{-- Utilisez 'asset' si vous avez un layout parent, sinon assurez-vous que le chemin est correct --}}
                <img class="w-20 md:w-28 lg:w-32 h-auto" src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo"/>
            </div>
            <nav class="flex items-center space-x-6 text-sm font-medium">
                <a href="{{ route('accueil') }}" class="text-sm text-slate-600 hover:text-slate-900"><i class="fas fa-home mr-1"></i> Accueil</a>
                <a href="{{ route('recherche') }}" class="text-sm text-slate-600 hover:text-slate-900"><i class="fas fa-search mr-1"></i> Recherche</a>
                <a href="{{ route('factures') }}" class="text-sm text-slate-600 hover:text-slate-900"><i class="fas fa-file-invoice-dollar mr-1"></i> Factures</a>
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
        <h1 class="text-3xl lg:text-4xl font-extrabold text-indigo-700 mb-2 border-b-4 border-indigo-500 pb-3 inline-block">
            <i class="fas fa-file-invoice-dollar mr-3 text-3xl"></i> Historique de Facturation
        </h1>
        <p class="text-gray-500">Accédez et téléchargez vos factures pour les séjours terminés ou payés.</p>
    </div>

    <div class="flex justify-center space-x-4 mb-8 border-b pb-4">
        <a href="{{ route('clients_historique') }}" class="py-2 px-4 text-amber-700 rounded-lg hover:bg-amber-50 transition duration-150 font-medium border border-amber-100">
            <i class="fas fa-history mr-1"></i> Voir toutes mes Réservations
        </a>
    </div>

    @if($reservations->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($reservations as $res)
                @php
                    $factureStatut = $res->status;
                    $dateArrivee = \Carbon\Carbon::parse($res->date_arrivee);
                    $dateDepart = \Carbon\Carbon::parse($res->date_depart);
                    $jours = $dateDepart->diffInDays($dateArrivee);
                @endphp

                <div class="bg-white rounded-xl shadow-xl overflow-hidden flex flex-col border-4
                    @if($factureStatut == 'payée') border-green-500/50 hover:shadow-green-300/50
                    @else border-orange-500/50 hover:shadow-orange-300/50 @endif
                    transition duration-300 transform hover:scale-[1.01]">

                    <div class="p-5 flex flex-col flex-grow text-center">
                        <div class="mb-3">
                            <span class="inline-block px-3 py-1 text-xs font-bold bg_success  rounded-full shadow-md">
                               {{ $factureStatut }}
                            </span>
                        </div>

                        <h5 class="text-xl font-extrabold text-gray-800 mb-2 truncate">Facture Réf. #{{ $res->reservation_code }}</h5>
                        <p class="text-sm text-gray-500 mb-4">
                            <i class="fas fa-home text-indigo-500 mr-1"></i> {{ $res->residence->nom ?? 'Résidence inconnue' }}
                        </p>

                        <ul class="space-y-2 text-sm text-gray-700 font-medium border-t pt-4 border-gray-100 mb-4 flex-grow">
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
                            <a href="{{ route('facture.telecharger', $res->id) }}" target="_blank" class="w-full py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition duration-150 shadow-md text-sm">
                                <i class="fas fa-download mr-1"></i> Télécharger PDF
                            </a>

                            @if($factureStatut == 'confirmée')
                                <a href="{{ route('payer', $res->id) }}" class="w-full py-2 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition duration-150 shadow-md text-sm">
                                    <i class="fas fa-credit-card mr-1"></i> Procéder au Paiement
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="col-span-full bg-white p-8 rounded-xl shadow-lg text-center mx-auto max-w-xl">
            <p class="text-lg text-gray-500"><i class="fas fa-box-open mr-2"></i> Aucune facture (réservation payée/terminée) trouvée.</p>
        </div>
    @endif
</main>

</body>
</html>
