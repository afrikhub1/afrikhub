@extends('admin.header_footer')

@section('titre', 'Demandes interruption')

@section('main')

<div class="container mx-auto p-4">

    <h1 class="text-4xl md:text-5xl font-extrabold text-center text-gray-900 mb-8 drop-shadow-lg">
        <i class="fas fa-stop-circle text-red-500 mr-3"></i>Demandes d'interruption
    </h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4 text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white p-3 rounded mb-4 text-center">{{ session('error') }}</div>
    @endif

    @if($demandes->isEmpty())
        <p class="text-gray-700 text-center">Aucune demande.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($demandes as $demande)
                @php
                    // Couleur selon le status
                    $badgeColor = match($demande->status) {
                        'en_attente' => 'bg-yellow-500',
                        'validee'    => 'bg-green-500',
                        'rejete'     => 'bg-red-500',
                        default      => 'bg-gray-400',
                    };
                @endphp

               <div class="search-row bg-white rounded-2xl shadow-md p-5 flex flex-col justify-between hover:shadow-lg transition-shadow residence-item"
                    data-name="{{ $demande->residence->nom }} {{ $demande->user->name }}"
                    data-status="{{ $demande->status }}">


                    {{-- Informations --}}
                    <div class="space-y-2">
                        <p><strong>Client :</strong> {{ $demande->user->name }}</p>
                        <p><strong>Résidence :</strong> {{ $demande->residence->nom }}</p>
                        <p>
                            <strong>status :</strong>
                            <span class="px-3 py-1 rounded text-white font-semibold {{ $badgeColor }}">
                                {{ ucfirst(str_replace('_', ' ', $demande->status)) }}
                            </span>
                        </p>
                        <p class=" text-gray-500">Demandée le : {{ $demande->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    {{-- Actions --}}
                    @if($demande->status == 'en_attente')
                        <div class="mt-4 flex gap-2">
                            <form action="{{ route('admin.demande.valider', $demande->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">
                                    Valider
                                </button>
                            </form>
                            <form action="{{ route('admin.demande.rejeter', $demande->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">
                                    Rejeter
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full text-center p-10 bg-white rounded-2xl shadow-md">
                    <p class="text-gray-500 ">Aucune demande pour le moment.</p>
                </div>
            @endforelse
        </div>
    @endif

</div>

@endsection
