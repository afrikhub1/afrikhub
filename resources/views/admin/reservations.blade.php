@extends('admin.header_footer')

@section('titre', 'Reservations | Admin')

@section('main')
<div class="container-fluid mx-0 p-2 border">
    {{-- Alerts success / danger --}}
        @if (session('success'))
            <div id="alert-success" class="flex justify-between items-center p-4 mb-4 rounded-lg bg-green-50 border-l-4 border-green-600 shadow text-center">
                <div class="w-full">
                    <p class="font-bold text-green-700">Succès !</p>
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
                <button onclick="closeAlert('alert-success')" class="text-green-700 hover:text-green-900 ml-3">✕</button>
            </div>
        @endif

        @if (session('error'))
            <div id="alert-danger" class="flex justify-between items-center p-4 mb-4 rounded-lg bg-red-50 border-l-4 border-red-600 shadow text-center">
                <div class="w-full">
                    <p class="font-bold text-red-700">Alerte !</p>
                    <p class="text-red-800">{{ session('error') }}</p>
                </div>
                <button onclick="closeAlert('alert-danger')" class="text-red-700 hover:text-red-900 ml-3">✕</button>
            </div>
        @endif

    {{-- Section: Nombre total de reservations --}}
        <h1 class=" lg:text-4xl md:text-2xl text-xl font-extrabold text-indigo-700 mb-8 text-center border-b-4 border-indigo-500 pb-3">
            <i class="fas fa-list-ul mr-2 text-indigo-500"></i> Total des reservations :{{ $reservations->count() }}
        </h1>
    @if ($reservations->isEmpty())
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg shadow-md max-w-lg mx-auto">
            <p class="font-semibold text-center"><i class="fas fa-exclamation-triangle mr-2"></i> Aucune reservations de réservation n'a été trouvée.</p>
        </div>
    @else
        {{-- Tableau des reservations (Responsive) --}}
        <div class="overflow-x-auto bg-white rounded-lg shadow-xl">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Id Reservation</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Résidence</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">proprio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ref.paiement</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($reservations as $reservation)
                        <tr class="search-row" data-name="{{ strtolower($reservation->residence->nom ?? '') }} {{ strtolower($reservation->client ?? '') }}"
                            data-status="{{ strtolower($reservation->status) }}">

                            <td class="px-6 py-4 whitespace-nowrap  text-gray-500">#{{ $reservation->id }}</td>

                            <td class="px-6 py-4 whitespace-nowrap  text-gray-500">#{{ $reservation->reservation_code }}</td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class=" font-semibold text-indigo-600 truncate max-w-xs">{{ $reservation->residence->nom ?? 'Résidence inconnue' }}</div>
                                <div class="text-xs text-gray-500">{{ $reservation->residence->ville ?? 'N/A' }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class=" font-medium text-gray-900">{{ $reservation->client ?? 'Client Inconnu' }}</div>
                                <div class="text-xs text-gray-500">{{ $reservation->user->email ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $reservation->user->contact ?? 'N/A' }}</div>
                            </td>

                             <td class="px-6 py-4 whitespace-nowrap">
                                <div class=" font-medium text-gray-900">{{ $reservation->proprietaire_id ?? 'Client Inconnu' }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap  text-gray-700">
                                Du {{ \Carbon\Carbon::parse($reservation->date_arrivee)->format('d/m') }}  au  {{ \Carbon\Carbon::parse($reservation->date_depart)->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap  font-bold text-green-600">
                                {{ number_format($reservation->total, 0, ',', ' ') }} FCFA
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($reservation->status === 'en attente')
                                    <div class="flex space-x-2">
                                        <form action="{{ route('admin.reservation.accepter', $reservation->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 text-xs font-semibold text-white bg-green-600 rounded hover:bg-green-700 transition">
                                                Confirmer
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.reservation.refuser', $reservation->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 text-xs font-semibold text-white bg-red-600 rounded hover:bg-red-700 transition">
                                                Annuler
                                            </button>
                                        </form>
                                    </div>
                                @elseif($reservation->status === 'confirmée')
                                    <div class="flex space-x-2">
                                        <form action="{{ route('admin.reservation.payee', $reservation->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-2 py-2 text-xs font-semibold text-white bg-green-600 rounded hover:bg-orange-500 transition">
                                                payée
                                            </button>
                                        </form>
                                    </div>
                                @else

                                    @php
                                        $color = match ($reservation->status) {
                                            'payée' => 'bg-indigo-100 text-indigo-800',
                                            'confirmée' => 'bg-green-100 text-green-800',
                                            'annulée' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <button class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}" disabled>
                                        {{ ucfirst($reservation->status) }}
                                    </button>
                                @endif
                            </td>
                            <td class="text-xs text-gray-500"> {{ $reservation->reference }} </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
