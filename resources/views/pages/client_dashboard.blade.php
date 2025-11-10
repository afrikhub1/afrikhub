@extends('pages.heritage_pages')

@section('dashboard', '-Historique des Réservations')

@section('main')
    <div class="container mx-auto p-2">

        <div class="page-header text-center mb-8">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-amber-600 mb-2 border-b-4 border-amber-500 pb-3 inline-block">
                <i class="fas fa-history mr-3 text-3xl"></i> Historique de vos Réservations
            </h1>
            <p class="text-gray-500">Retrouvez toutes vos réservations passées et à venir.</p>
        </div>

        {{-- Liens Rapides pour le client --}}
        <div class="flex justify-center space-x-4 mb-8 border-b pb-4">
            <a href="{{ route('accueil') }}" class="py-2 px-4 text-gray-700 rounded-lg hover:bg-gray-100 transition duration-150 font-medium">
                <i class="fas fa-home mr-1"></i> Accueil
            </a>
            <a href="{{ route('factures') }}" class="py-2 px-4 text-indigo-700 rounded-lg hover:bg-indigo-50 transition duration-150 font-medium border border-indigo-100">
                <i class="fas fa-file-invoice-dollar mr-1"></i> Mes Factures
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

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
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
                            {{-- Bouton Payer (si la réservation n'est que 'confirmée' mais pas 'payée') --}}
                            @if($res->status == 'confirmée')
                                <form action="{{ route('payer', $res->id) }}" method="GET" class="flex-1">
                                    <button type="submit" class="w-full py-2 bg-amber-500 text-white font-semibold rounded-lg hover:bg-amber-600 transition duration-150 shadow-md text-sm">
                                        <i class="fas fa-credit-card mr-1"></i> Payer
                                    </button>
                                </form>
                            @endif

                            {{-- Bouton Annuler (si la réservation est en attente ou confirmée) --}}
                            @if($res->status == 'en_attente' || $res->status == 'confirmée')
                                <form action="{{ route('annuler', $res->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full p-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-150 shadow-md text-sm" onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                        Annuler
                                    </button>
                                </form>
                            @endif

                            {{-- Bouton Renouveler (s'affiche pour toutes les réservations) --}}
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
    </div>
@endsection
