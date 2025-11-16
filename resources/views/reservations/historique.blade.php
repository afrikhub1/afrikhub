@extends('pages.heritage_pages')

@section('dashboard', '-historique de reservation')

@section('main')
    <!-- Main Content Area (Ajusté pour le Header) -->
    <div class="container mx-auto p-2 mt-4">

        <!-- Titre Principal de la Page -->
        <div class="page-header text-center mb-8">
            <h1 class="text-3xl lg:text-4xl font-extrabold text-amber-600 mb-2 border-b-4 border-amber-500 pb-3 inline-block">
                <i class="fas fa-history mr-3 text-3xl"></i> Historique de vos réservations reçu
            </h1>
            <p class="text-gray-500">Retrouvez toutes vos réservations reçu</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">
            @forelse($reservationsRecu as $res)
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
                                Total : {{ number_format($res->total, 0, ',', ' ') }} FCFA
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                Réservé le {{ $res->created_at->format('d/m/Y') }}
                            </p>
                        </div>

                        <!-- Préfacture/Détails (Optionnel en Historique) -->
                        @php
                            $dateArrivee = $res->date_arrivee ? \Carbon\Carbon::parse($res->date_arrivee) : null;
                            $dateDepart = $res->date_depart ? \Carbon\Carbon::parse($res->date_depart) : null;
                            $jours = ($dateArrivee && $dateDepart) ? $dateDepart->diffInDays($dateArrivee) : 0;
                            $prixJournalier = $res->residence->prix_journalier ?? 0;
                            $totalEstime = $jours * $prixJournalier;
                        @endphp

                        @if($res->status == 'confirmée' && $dateArrivee && $dateDepart)
                            <div class="mt-3 p-3 rounded-lg bg-amber-50 border border-amber-300 text-xs shadow-inner">
                                <h6 class="fw-bold mb-1 text-amber-700 text-sm">🧾 Détails : {{ $jours }} nuit(s)</h6>
                                <p class="mb-0 text-gray-600">Prix/jour : {{ number_format($prixJournalier,0,',',' ') }} FCFA</p>
                            </div>
                        @endif

                        @if($res->status == 'en attente')
                            <div class="mt-auto border-t pt-3">
                                <p class="text-sm mt-2 text-red-600 w-full">
                                    <i class="fas fa-calendar-check me-2"></i>Disponibilité :
                                    @if($res->residence)
                                        {{ \Carbon\Carbon::parse($res->residence->date_disponible)->translatedFormat('d F Y') }}
                                    @else
                                        Résidence indisponible
                                    @endif
                                </p>
                            </div>
                        @endif
                        <!-- Boutons en bas -->
                        <div class="mt-4 flex gap-2 justify-center">
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

