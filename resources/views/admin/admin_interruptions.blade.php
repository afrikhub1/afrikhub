@extends('admin.header_footer')

@section('titre', 'Demandes-interruptions')

@section('main')

    <h1 class="text-4xl md:text-5xl font-extrabold text-center text-gray-900 mb-8 drop-shadow-lg">
        <i class="fas fa-stop-circle text-red-500 mr-3"></i>Demandes d'interruption en attente
    </h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    @if($demandes->isEmpty())
        <p class="text-gray-700">Aucune demande en attente.</p>
    @else
        <div class="space-y-4">
            @foreach($demandes as $demande)
                <div class="bg-white p-4 rounded shadow flex justify-between items-center">
                    <div>
                        <p><strong>Client :</strong> {{ $demande->user->name }}</p>
                        <p><strong>Résidence :</strong> {{ $demande->residence->nom }}</p>
                        <p>
                            <strong>Statut :</strong>
                            <span class="px-2 py-1 rounded text-white
                                @if($demande->status=='en_attente') bg-yellow-500
                                @elseif($demande->status=='validee') bg-green-500
                                @elseif($demande->status=='rejete') bg-red-500
                                @endif">
                                {{ ucfirst($demande->status) }}
                            </span>
                        </p>
                        <p class="text-sm text-gray-500">Demandée le : {{ $demande->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="flex gap-2">
                        <form action="{{ route('admin.demande.valider', $demande->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                Valider
                            </button>
                        </form>
                        <form action="{{ route('admin.demande.rejeter', $demande->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                Rejeter
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection

