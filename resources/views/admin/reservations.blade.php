@extends('admin.header_footer')

@section('titre', 'Reservations | Admin')

@section('main')
<div class="container-fluid mx-0 p-2 border">

    {{-- Section: Nombre total de reservations --}}
        <h1 class=" font-semibold text-gray-700">
            <i class="fas fa-list-ul mr-2 text-indigo-500"></i> Total des reservations :
            <span class="text-indigo-600 font-bold">{{ $reservations->count() }}</span>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Locataire</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">status</th>
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
                                @else
                                    @php
                                        $color = match ($reservation->status) {
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

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
