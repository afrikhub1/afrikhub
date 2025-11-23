<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire de Fichiers</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Style "MacOS Finder" */
        body {
            font-family: 'San Francisco', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f2f2f5;
        }
        .container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 16px 40px rgba(0,0,0,0.1);
        }
        th {
            text-align: left;
            color: #555;
            font-weight: 500;
        }
        td {
            color: #333;
        }
        tr:hover {
            background-color: #f0f0f5;
        }
        .folder-link {
            color: #007aff;
            font-weight: 500;
        }
        .folder-link:hover {
            text-decoration: underline;
        }
        .btn-delete {
            background-color: #ff3b30;
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.9rem;
        }
        .btn-delete:hover {
            background-color: #d32f2f;
        }
        .breadcrumb {
            font-size: 0.95rem;
            color: #555;
        }
        .breadcrumb span {
            margin: 0 4px;
        }
    </style>
</head>
<body class="p-6">

<div class="container max-w-6xl mx-auto p-6">
    <h1 class="text-3xl font-semibold mb-6">📁 Gestionnaire de Fichiers</h1>

    <!-- Messages -->
    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800">{{ session('error') }}</div>
    @endif

    <!-- Breadcrumb / Navigation -->
    <div class="breadcrumb mb-4">
        <a href="{{ route('file.manager') }}" class="folder-link">Accueil</a>
        @if($folder)
            @php $parts = explode('/', $folder); $pathAcc = ''; @endphp
            @foreach($parts as $part)
                @php $pathAcc = $pathAcc ? $pathAcc.'/'.$part : $part; @endphp
                <span>›</span>
                <a href="{{ route('file.manager', ['folder' => $pathAcc]) }}" class="folder-link">{{ $part }}</a>
            @endforeach
        @endif
    </div>

    <!-- Tableau des fichiers/dossiers -->
    <div class="overflow-x-auto rounded-xl border border-gray-200">
        <table class="w-full border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3">Nom</th>
                    <th class="p-3">Taille</th>
                    <th class="p-3">Dernière modification</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($files as $file)
                <tr class="hover:bg-gray-100 transition-colors">
                    <td class="p-3">
                        @if($file['type'] === 'dir')
                            📁 <a href="{{ route('file.manager', ['folder' => $file['path']]) }}" class="folder-link">{{ $file['name'] }}</a>
                        @else
                            🖼️ {{ $file['name'] }}
                        @endif
                    </td>
                    <td class="p-3">{{ $file['size'] ? round($file['size']/1024, 2).' Ko' : '-' }}</td>
                    <td class="p-3">{{ $file['lastModified'] }}</td>
                    <td class="p-3">
                        <form method="POST" action="{{ route('file.manager.delete') }}" onsubmit="return confirm('Supprimer {{ $file['name'] }} ?');" class="inline">
                            @csrf
                            <input type="hidden" name="path" value="{{ $file['path'] }}">
                            <button type="submit" class="btn-delete">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
