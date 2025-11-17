<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demandes d'interruption</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <h1 class="text-2xl font-bold mb-4">Demandes d'interruption en attente</h1>

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
                        <p><strong>Statut :</strong> {{ ucfirst($demande->status) }}</p>
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

</body>
</html>
