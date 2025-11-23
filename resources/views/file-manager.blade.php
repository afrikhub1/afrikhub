<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire de Fichiers</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-6">

<div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow-lg">
    <h1 class="text-2xl font-bold mb-4">📁 Gestionnaire de Fichiers</h1>

    <!-- Messages -->
    @if(session('success'))
        <div class="p-3 mb-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-3 mb-3 rounded bg-red-100 text-red-800">{{ session('error') }}</div>
    @endif

    <!-- Navigation -->
    @if($folder)
        <div class="mb-4">
            <a href="{{ route('file.manager', ['folder' => dirname($folder)]) }}"
               class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">⬅️ Retour</a>
            <span class="ml-2 font-medium">Chemin : /{{ $folder }}</span>
        </div>
    @else
        <div class="mb-4 font-medium">Chemin : /</div>
    @endif

    <!-- Tableau des fichiers/dossiers -->
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">Nom</th>
                <th class="p-2 border">Taille</th>
                <th class="p-2 border">Dernière modification</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $file)
            <tr class="hover:bg-gray-50">
                <td class="p-2 border">
                    @if($file['type'] === 'dir')
                        📁 <a href="{{ route('file.manager', ['folder' => $file['path']]) }}"
                               class="text-blue-500 hover:underline">{{ $file['name'] }}</a>
                    @else
                        🖼️ {{ $file['name'] }}
                    @endif
                </td>
                <td class="p-2 border">
                    {{ $file['size'] ? round($file['size']/1024, 2).' Ko' : '-' }}
                </td>
                <td class="p-2 border">{{ $file['lastModified'] }}</td>
                <td class="p-2 border">
                    <form method="POST" action="{{ route('file.manager.delete') }}" onsubmit="return confirm('Supprimer {{ $file['name'] }} ?');" class="inline">
                        @csrf
                        <input type="hidden" name="path" value="{{ $file['path'] }}">
                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                            Supprimer
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
