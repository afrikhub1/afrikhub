@extends('pages.heritage_pages')

@section('dashboard', '-historique de reservation')

@section('main')
    <!-- Main Content Area (Ajusté pour le Header) -->
    <div class="container-fluid px-2 py-2 mt-2">
        <main class="bg-white p-6 md:p-8 rounded-xl shadow-2xl border border-gray-200">
            <!-- Titre Principal de la Page -->
            <div class="page-header text-center mb-8">
                <h1 class="text-2xl font-extrabold text-amber-600 mb-2 border-b-4 border-amber-500 pb-3 inline-block">
                    <i class="fas fa-history mr-3 text-2xl"></i> Réservations reçu
                </h1>
            </div>
            <div class="grid grid-cols-1 xs:grid-col-1 sm:grid-col-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4  gap-4">
                @forelse($reservationsRecu as $res)
                    <div class="bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col border-4
                        @if($res->status == 'confirmée') border-green-500/50 hover:shadow-green-300/50
                        @elseif($res->status == 'en_attente') border-blue-500/50 hover:shadow-blue-300/50
                        @elseif($res->status == 'terminée') border-gray-400/50 hover:shadow-gray-300/50
                        @else border-yellow-500/50 hover:shadow-red-300/50 @endif
                        transition duration-300 transform hover:scale-[1.01]">

                        <div class="p-5 flex flex-col flex-grow text-center">

                            <!-- status -->
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
                                    <span class="text-gray-500">
                                        <i class="fas fa-calendar-check mr-2 text-amber-400"></i>
                                        {{ $res->status != 'payée'
                                        ? $res->status . ' le : ' . (optional($res->date_validation)->format('d/m/Y') ?? '-')
                                        : 'payée le : ' . (optional($res->date_paiement)->format('d/m/Y') ?? '-') }}

                                    </span>
                                </li>
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-500"><i class="fas fa-user-friends mr-2 text-amber-400"></i> Période :</span>
                                    <span class="text-gray-900 font-semibold">
                                        {{ $res->date_arrivee ? \Carbon\Carbon::parse($res->date_arrivee)->format('d/m/Y') : '-' }}
                                        ➡
                                        {{ $res->date_depart ? \Carbon\Carbon::parse($res->date_depart)->format('d/m/Y') : '-' }}
                                    </span>
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
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white p-8 rounded-xl shadow-lg text-center mx-auto max-w-xl">
                        <p class="text-lg text-gray-500"><i class="fas fa-box-open mr-2"></i> Vous n’avez encore aucune réservation.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection

