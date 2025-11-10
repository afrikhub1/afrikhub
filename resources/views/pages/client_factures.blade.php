@extends('pages.heritage_pages')

@section('dashboard', '-Mes Factures')

@section('main')
    <div class="container mx-auto p-2">

        <div class="page-header text-center mb-8">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-indigo-700 mb-2 border-b-4 border-indigo-500 pb-3 inline-block">
                <i class="fas fa-file-invoice-dollar mr-3 text-3xl"></i> Historique de Facturation
            </h1>
            <p class="text-gray-500">Accédez et téléchargez vos factures pour les séjours terminés ou payés.</p>
        </div>

        {{-- Liens Rapides pour le client --}}
        <div class="flex justify-center space-x-4 mb-8 border-b pb-4">
            <a href="{{ route('accueil') }}" class="py-2 px-4 text-gray-700 rounded-lg hover:bg-gray-100 transition duration-150 font-medium">
                <i class="fas fa-home mr-1"></i> Accueil
            </a>
            <a href="{{ route('historique') }}" class="py-2 px-4 text-amber-700 rounded-lg hover:bg-amber-50 transition duration-150 font-medium border border-amber-100">
                <i class="fas fa-history mr-1"></i> Mes Réservations
            </a>
            <a href="{{ route('recherche') }}" class="py-2 px-4 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition duration-150 font-medium">
                <i class="fas fa-search mr-1"></i> Nouvelle Recherche
            </a>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="py-2 px-4 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-150 font-medium">
                    <i class="fas fa-sign-out-alt mr-1"></i> Déconnexion
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($reservations as $res)
                @php
                    // Adaptation des statuts de réservation pour l'affichage de "Facture"
                    $factureStatut = ($res->status == 'terminée' || $res->status == 'payée') ? 'payée' : 'en_attente';

                    $statusClass = [
                        'en_attente' => 'bg-orange-600 text-white',
                        'payée' => 'bg-green-600 text-white',
                    ][$factureStatut] ?? 'bg-gray-400 text-gray-800';

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
                            <span class="inline-block px-3 py-1 text-xs font-bold {{ $statusClass }} rounded-full shadow-md">
                                {{ ucfirst(str_replace('_', ' ', $factureStatut)) }}
                            </span>
                        </div>

                        <h5 class="text-xl font-extrabold text-gray-800 mb-2 truncate">Facture Réf. #{{ $res->id }}</h5>
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

                            @if($factureStatut == 'en_attente')
                                <a href="{{ route('payer', $res->id) }}" class="w-full py-2 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition duration-150 shadow-md text-sm">
                                    <i class="fas fa-credit-card mr-1"></i> Procéder au Paiement
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-8 rounded-xl shadow-lg text-center mx-auto max-w-xl">
                    <p class="text-lg text-gray-500"><i class="fas fa-box-open mr-2"></i> Aucune facture (réservation payée/terminée) trouvée.</p>
                    <a href="{{ route('historique') }}" class="mt-4 inline-block text-amber-500 hover:text-amber-700 font-medium">
                        Voir toutes mes réservations
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
