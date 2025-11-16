@extends('pages.heritage_pages')

@section('dashboard', '- Demande de reservations')

@section('main')
    <!-- Main Content Area (Ajusté pour le Header) -->
    <div class="container mx-auto p-2 mt-4">

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
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 lg:grid-cols-4 gap-2 px-4">
                @foreach($demandes as $res)
                    @php
                        // Assurez-vous que le modèle Reservation a la relation 'residence' chargée
                        $residence = $res->residence;
                        $images = ($residence->img);
                        if (is_string($images)) {
                            $images = json_decode($images, true) ?? [];
                        };
                        $firstImage = $images[0] ?? 'https://placehold.co/400x250/E0E7FF/4F46E5?text=EN+ATTENTE';
                    @endphp

                    <div class="bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col border-2
                        @if($res->status == 'en attente') border-indigo-500/50 hover:shadow-indigo-300/50
                        @elseif($res->status == 'confirmée') border-green-500
                        @elseif($res->status == 'annulée') border-red-500
                        @else border-yellow-500 @endif
                        transition duration-300 transform hover:scale-[1.01]">

                        <img src="{{ $firstImage}}" class="w-full h-48 object-cover"
                            onerror="this.onerror=null;this.src='https://placehold.co/400x250/E0E7FF/4F46E5?text=DEMANDE';" alt="Image de la résidence">

                        <div class="p-6 flex flex-col flex-grow text-center">
                            <h5 class="text-2xl font-extrabold text-gray-800 mb-1 truncate">{{ $residence->nom }}</h5>
                            <p class="text-sm text-gray-500 mb-4">📍 {{ $residence->ville }}</p>

                            <ul class="space-y-2 text-base text-gray-700 font-medium border-t pt-4 border-gray-100">
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-500"><i class="fas fa-plane-arrival mr-2 text-indigo-400"></i> Arrivée :</span>
                                    <span class="text-gray-900 font-bold">{{ $res->date_arrivee->format('d/m/Y') }}</span>
                                </li>
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-500"><i class="fas fa-plane-departure mr-2 text-indigo-400"></i> Départ :</span>
                                    <span class="text-gray-900 font-bold">{{ $res->date_depart->format('d/m/Y') }}</span>
                                </li>
                            </ul>

                            <!-- AFFICHAGE DU STATUT -->
                            <div class="mt-4 mb-5">
                                @if($res->status == 'en attente')
                                    <span class="inline-block px-4 py-1.5 text-sm font-bold bg-indigo-600 text-white rounded-full shadow-md">En attente de votre validation</span>

                                @elseif($res->status == 'confirmée')
                                    <span class="inline-block px-4 py-1.5 text-sm font-bold bg-green-600 text-white rounded-full">Confirmée</span>

                                @elseif($res->status == 'annulée')
                                    <span class="inline-block px-4 py-1.5 text-sm font-bold bg-yellow-500 text-gray-900 rounded-full">Annulée (Client)</span>

                                @elseif($res->status == 'interrompue')
                                    <span class="inline-block px-4 py-1.5 text-sm font-bold bg-gray-500 text-light-900 rounded-full">interrompue (Admin)</span>

                                @elseif($res->status == 'payé')
                                    <span class="inline-block px-4 py-1.5 text-sm font-bold bg-yellow-500 text-gray-900 rounded-full">payé</span>

                                @else
                                    <span class="inline-block px-4 py-1.5 text-sm font-bold bg-red-600 text-white rounded-full">Refusée (Vous)</span>
                                @endif
                            </div>

                            <!-- LOGIQUE D'ACTION : ACCEPT/REFUS -->
                            @if($res->status == 'en attente')
                                <div class="flex gap-3 justify-center mt-auto px-4">
                                    <form action="{{ route('reservation.accepter', $res->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-5 py-2.5 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition duration-150 shadow-md">
                                            <i class="fas fa-check"></i> Accepter
                                        </button>
                                    </form>

                                    <form action="{{ route('reservation.refuser', $res->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-5 py-2.5 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-150 shadow-md">
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
