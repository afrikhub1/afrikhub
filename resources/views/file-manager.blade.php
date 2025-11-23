<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire de Fichiers S3</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Style pour masquer le bouton de soumission par défaut de la suppression */
        .delete-form { display: inline; }
    </style>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">
            Gestionnaire de Fichiers S3
        </h1>

        <!-- Messages Flash -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <!-- Upload Form -->
        <div class="mb-8 border-b pb-4">
            <h2 class="text-xl font-semibold mb-3 text-gray-700">Télécharger un Fichier</h2>
            <form action="{{ route('file-manager.upload') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-4">
                @csrf
                <input type="hidden" name="current_folder" value="{{ $folder }}">
                <input type="file" name="upload_file" required class="flex-grow p-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-150 shadow-md">
                    Télécharger
                </button>
            </form>
            @error('upload_file')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Navigation & Listing -->
        <h2 class="text-xl font-semibold mb-3 text-gray-700">Dossier Courant: /{{ $folder }}</h2>

        <div class="overflow-x-auto shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Taille</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modifié</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Navigation vers le dossier parent -->
                    @if ($folder)
                        @php
                            $parentFolder = dirname($folder);
                            // S'assure que le dossier parent est vide si on est à la racine
                            $parentFolder = $parentFolder === '.' || $parentFolder === '/' ? '' : $parentFolder;
                        @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600 hover:text-blue-800">
                                <a href="{{ route('file-manager.index', ['folder' => $parentFolder]) }}">.. (Dossier parent)</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Dir</td>
                            <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                        </tr>
                    @endif

                    <!-- Liste des fichiers et dossiers -->
                    @forelse ($files as $file)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if ($file['type'] === 'dir')
                                    <a href="{{ route('file-manager.index', ['folder' => $file['path']]) }}" class="text-blue-600 hover:text-blue-800">
                                        📁 {{ $file['name'] }}
                                    </a>
                                @else
                                    <span class="text-gray-900">📄 {{ $file['name'] }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $file['type'] === 'dir' ? 'Dossier' : 'Fichier' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($file['size'] !== null)
                                    {{ round($file['size'] / 1024, 2) }} KB
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $file['lastModified'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('file-manager.delete') }}" method="POST" class="delete-form" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer {{ $file['name'] }} ? Cette action est irréversible.');">
                                    @csrf
                                    <input type="hidden" name="path" value="{{ $file['path'] }}">
                                    <button type="submit" class="text-red-600 hover:text-red-900 ml-2 p-1 rounded-md border border-red-300 hover:bg-red-50 transition duration-150">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Ce dossier est vide.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>
