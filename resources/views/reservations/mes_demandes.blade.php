@extends('pages.heritage_pages')

@section('dashboard', '- Demande de reservations')

@section('main')
    <!-- Main Content Area (Ajusté pour le Header) -->
    <div class="container-fluid px-2 py-2 mt-2">

        <!-- Titre Principal de la Page -->
        <h1 class="text-3xl lg:text-4xl font-extrabold text-indigo-700 mb-8 text-center border-b-4 border-indigo-500 pb-3">
            <i class="fas fa-spinner mr-3 text-3xl"></i> Demandes de Réservation
        </h1>

        @if($demandes->isEmpty())
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-6 rounded-lg text-center shadow-lg mx-auto max-w-lg">
                <i class="fas fa-bell-slash text-2xl mb-2 block"></i>
                <p class="font-semibold text-lg">Aucune nouvelle demande de réservation en attente.</p>
                <p class="text-sm mt-1">Revenez plus tard pour de nouvelles demandes.</p>
            </div>
        @else
            <div class="grid grid-cols-1 xs:grid-col-2 sm:grid-col-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4  gap-4">
                @foreach($demandes as $res)
                    @php
                        $residence = $res->residence;
                        $images = is_string($residence->img) ? json_decode($residence->img, true) ?? [] : $residence->img;
                        $firstImage = $images[0] ?? 'https://placehold.co/400x250/E0E7FF/4F46E5?text=EN+ATTENTE';
                    @endphp

                    <div class="bg-white rounded-xl shadow-lg overflow-hidden flex flex-col border-2
                                @if($res->status == 'en attente') border-indigo-500/50 hover:shadow-indigo-300/50
                                @elseif($res->status == 'confirmée') border-green-500
                                @elseif($res->status == 'annulée') border-red-500
                                @else border-yellow-500 @endif
                                transition duration-300 transform hover:scale-105
                                h-full">

                        <!-- Image -->
                        <img src="{{ $firstImage }}" class="w-full h-48 sm:h-56 md:h-48 lg:h-52 xl:h-60 object-cover"
                            onerror="this.onerror=null;this.src='https://placehold.co/400x250/E0E7FF/4F46E5?text=DEMANDE';"
                            alt="Image de la résidence">

                        <!-- Contenu -->
                        <div class="p-4 sm:p-5 flex flex-col flex-grow text-center">
                            <h5 class="text-lg sm:text-xl font-extrabold text-gray-800 mb-1 truncate">{{ $residence->nom }}</h5>
                            <p class="text-sm sm:text-base text-gray-500 mb-3">📍 {{ $residence->ville }}</p>

                            <ul class="space-y-1 sm:space-y-2 text-sm sm:text-base text-gray-700 font-medium border-t pt-3 sm:pt-4 border-gray-100">
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-500"><i class="fas fa-plane-arrival mr-2 text-indigo-400"></i> Arrivée :</span>
                                    <span class="text-gray-900 font-bold">{{ $res->date_arrivee->format('d/m/Y') }}</span>
                                </li>
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-500"><i class="fas fa-plane-departure mr-2 text-indigo-400"></i> Départ :</span>
                                    <span class="text-gray-900 font-bold">{{ $res->date_depart->format('d/m/Y') }}</span>
                                </li>
                            </ul>

                            <!-- Statut -->
                            <div class="mt-3 sm:mt-4 mb-4">
                                @php
                                    $statusColors = [
                                        'en attente' => 'bg-indigo-600 text-white',
                                        'confirmée' => 'bg-green-600 text-white',
                                        'annulée' => 'bg-red-600 text-white',
                                        'interrompue' => 'bg-gray-500 text-white',
                                        'payé' => 'bg-yellow-500 text-gray-900',
                                    ];
                                    $statusText = [
                                        'en attente' => 'En attente de validation',
                                        'confirmée' => 'Confirmée',
                                        'annulée' => 'Annulée (Client)',
                                        'interrompue' => 'Interrompue (Admin)',
                                        'payé' => 'Payé',
                                    ];
                                @endphp
                                <span class="inline-block px-3 text-xs py-1 font-bold rounded-full shadow-md {{ $statusColors[$res->status] ?? 'bg-red-600 text-white' }}">
                                    {{ $statusText[$res->status] ?? 'Refusée (Vous)' }}
                                </span>
                            </div>

                            <!-- Actions alignées en bas -->
                            @if($res->status == 'en attente')
                                <div class="flex flex-col sm:flex-row gap-2 justify-center mt-auto">
                                    <form action="{{ route('reservation.accepter', $res->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="text-sm w-full flex items-center justify-center gap-2 px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition duration-150 shadow-md">
                                            <i class="fas fa-check"></i> Accepter
                                        </button>
                                    </form>

                                    <form action="{{ route('reservation.refuser', $res->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="text-sm w-full flex items-center justify-center gap-2 px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-150 shadow-md">
                                            <i class="fas fa-times"></i> Refuser
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
