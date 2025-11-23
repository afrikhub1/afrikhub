<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire de Fichiers</title>
    <!-- Chargement de Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Styles "MacOS Finder" personnalisés et responsifs */
        :root {
            --primary-blue: #007aff;
            --danger-red: #ff3b30;
            --background: #f2f2f5;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--background);
        }

        .container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: box-shadow 0.3s ease;
        }

        /* Style pour les boutons d'action */
        .btn-action {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        /* Style du bouton de suppression (Rouge) */
        .btn-delete {
            background-color: var(--danger-red);
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.875rem; /* 14px */
        }
        .btn-delete:hover {
            background-color: #d32f2f;
        }

        /* Style de la table */
        th {
            text-align: left;
            color: #555;
            font-weight: 600;
            font-size: 0.9rem;
            border-bottom: 2px solid #e5e7eb;
        }
        td {
            color: #333;
            font-size: 0.95rem;
            border-top: 1px solid #f2f2f5;
        }
        tr.file-item:hover {
            background-color: #f7f7fa;
        }

        /* Liens des dossiers */
        .folder-link {
            color: var(--primary-blue);
            font-weight: 500;
            transition: color 0.2s ease;
        }
        .folder-link:hover {
            text-decoration: underline;
            color: #005bb5;
        }

        /* Fil d'Ariane (Breadcrumb) */
        .breadcrumb {
            font-size: 1rem;
            color: #888;
            font-weight: 500;
        }
        .breadcrumb span {
            margin: 0 6px;
            color: #aaa;
        }

        /* Icônes */
        .icon-small {
            width: 20px;
            height: 20px;
            margin-right: 8px;
            fill: currentColor;
        }
        .icon-folder { color: #ffb800; }
        .icon-file { color: #888; }
        .icon-image { color: #10b981; }
        .icon-back { color: #333; }

        /* Modal Backdrop */
        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.4);
        }

        /* Mobile adjustments */
        @media (max-width: 640px) {
            .container {
                padding: 1rem;
                margin: 0.5rem;
            }
            .btn-action {
                font-size: 0.8rem;
                padding: 6px 10px;
            }
            th, td {
                padding: 0.5rem;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body class="p-4 sm:p-6 lg:p-10 min-h-screen">

<div class="container max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
    <header class="flex justify-between items-center mb-6 border-b pb-4">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center">
            <!-- SVG Icone Dossier Principal -->
            <svg class="w-8 h-8 mr-3 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M22 13h-4v2h4v-2zM18 11V7c0-1.11-.9-2-2-2H4c-1.1 0-2 .89-2 2v10c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2v-4h2v-2h2zM4 7h12v10H4V7z"/></svg>
            Gestionnaire de Fichiers
        </h1>
    </header>

    <!-- Messages -->
    @if(session('success'))
        <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-700 border border-green-200 shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <!-- Remplacement du @if par un modal ou un affichage plus clair si possible, mais je garde la structure backend ici -->
        <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-700 border border-red-200 shadow-sm">{{ session('error') }}</div>
    @endif

    <!-- Outils (Création/Upload) et Navigation -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6">
        <!-- Breadcrumb / Navigation -->
        <div class="breadcrumb flex items-center mb-3 sm:mb-0 overflow-x-auto whitespace-nowrap pb-2 sm:pb-0">
            @if($folder)
                <button onclick="navigateUp()" class="btn-action bg-gray-100 text-gray-700 hover:bg-gray-200 mr-2 flex-shrink-0">
                    <svg class="icon-small icon-back" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/></svg>
                    Retour
                </button>
            @endif
            <a href="{{ route('file.manager') }}" class="folder-link text-gray-800 hover:text-gray-600 font-bold flex-shrink-0">Accueil</a>
            @if($folder)
                @php $parts = explode('/', $folder); $pathAcc = ''; @endphp
                @foreach($parts as $part)
                    @php $pathAcc = $pathAcc ? $pathAcc.'/'.$part : $part; @endphp
                    <span>/</span>
                    <a href="{{ route('file.manager', ['folder' => $pathAcc]) }}" class="folder-link flex-shrink-0">{{ $part }}</a>
                @endforeach
            @endif
        </div>

        <!-- Boutons d'Action -->
        <div class="flex space-x-3 flex-shrink-0">
            <button onclick="openModal('createFolderModal')" class="btn-action bg-green-500 text-white hover:bg-green-600">
                <svg class="icon-small text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M11 9H9V2H7v7H5V2H3v7c0 1.1.9 2 2 2h2c1.1 0 2-.9 2-2V4h2v5zM15 2h-2v7h-2V2H9v7c0 1.1.9 2 2 2h2c1.1 0 2-.9 2-2V2zM15 13H5v2h10v-2zM15 17H5v2h10v-2z"/></svg>
                Nouveau Dossier
            </button>
            <button onclick="openModal('uploadFileModal')" class="btn-action bg-blue-500 text-white hover:bg-blue-600">
                <svg class="icon-small text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M19 12h-4v4h-2v-4H9V8h4V4h2v4h4v4zM4 20h16v-2H4v2z"/></svg>
                Uploader Fichier
            </button>
        </div>
    </div>

    <!-- Tableau des fichiers/dossiers -->
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-lg">
        <table class="w-full border-collapse divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-3 whitespace-nowrap">Nom</th>
                    <th class="p-3 whitespace-nowrap w-24">Taille</th>
                    <th class="p-3 whitespace-nowrap w-40">Dernière modification</th>
                    <th class="p-3 whitespace-nowrap w-20 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($files as $file)
                <tr class="file-item transition-colors">
                    <td class="p-3 flex items-center">
                        @if($file['type'] === 'dir')
                            <!-- SVG Dossier -->
                            <svg class="icon-small icon-folder" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M10 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2h-8l-2-2z"/></svg>
                            <a href="{{ route('file.manager', ['folder' => $file['path']]) }}" class="folder-link">{{ $file['name'] }}</a>
                        @else
                            <!-- SVG Fichier (générique ou image) -->
                            {!! fileIcon($file['name']) !!}
                            {{ $file['name'] }}
                        @endif
                    </td>
                    <td class="p-3 whitespace-nowrap text-gray-500">{{ $file['size'] ? round($file['size']/1024, 2).' Ko' : '-' }}</td>
                    <td class="p-3 whitespace-nowrap text-gray-500">{{ $file['lastModified'] }}</td>
                    <td class="p-3 text-center">
                        <button onclick="openDeleteModal('{{ $file['name'] }}', '{{ $file['path'] }}')" class="btn-delete">Supprimer</button>
                    </td>
                </tr>
                @endforeach
                @if(count($files) === 0)
                <tr>
                    <td colspan="4" class="p-6 text-center text-gray-500 italic">Ce dossier est vide.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- --------------------------------- -->
<!-- MODALS PERSONNALISÉS (Pas de confirm()/alert()) -->
<!-- --------------------------------- -->

<!-- 1. Modal de Confirmation de Suppression -->
<div id="deleteModal" class="fixed inset-0 hidden items-center justify-center z-50 modal-backdrop">
    <div class="bg-white p-6 rounded-xl shadow-2xl w-full max-w-sm transform transition-all scale-100 opacity-100" onclick="event.stopPropagation()">
        <h3 class="text-xl font-bold mb-4 text-gray-800">Confirmer la Suppression</h3>
        <p class="mb-6 text-gray-600">Êtes-vous sûr de vouloir supprimer <strong id="deleteFileName" class="text-red-500"></strong> ? Cette action est irréversible.</p>
        <div class="flex justify-end space-x-3">
            <button onclick="closeModal('deleteModal')" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Annuler</button>
            <form method="POST" action="{{ route('file.manager.delete') }}" id="deleteForm" class="inline">
                @csrf
                <!-- L'input hidden est rempli par JS -->
                <input type="hidden" name="path" id="deletePathInput">
                <button type="submit" class="px-4 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600 transition-colors font-semibold">Supprimer Définitivement</button>
            </form>
        </div>
    </div>
</div>

<!-- 2. Modal de Création de Dossier -->
<div id="createFolderModal" class="fixed inset-0 hidden items-center justify-center z-50 modal-backdrop">
    <div class="bg-white p-6 rounded-xl shadow-2xl w-full max-w-md" onclick="event.stopPropagation()">
        <h3 class="text-xl font-bold mb-4 text-gray-800">Créer un Nouveau Dossier</h3>
        <form method="POST" action="{{ route('file.manager.createFolder') }}">
            @csrf
            <input type="hidden" name="current_folder" value="{{ $folder ?? '' }}">
            <div class="mb-4">
                <label for="folderName" class="block text-sm font-medium text-gray-700 mb-1">Nom du dossier</label>
                <input type="text" id="folderName" name="name" required placeholder="Ex: Documents personnels" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal('createFolderModal')" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Annuler</button>
                <button type="submit" class="px-4 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600 transition-colors font-semibold">Créer</button>
            </div>
        </form>
    </div>
</div>

<!-- 3. Modal d'Upload de Fichier -->
<div id="uploadFileModal" class="fixed inset-0 hidden items-center justify-center z-50 modal-backdrop">
    <div class="bg-white p-6 rounded-xl shadow-2xl w-full max-w-md" onclick="event.stopPropagation()">
        <h3 class="text-xl font-bold mb-4 text-gray-800">Uploader un Fichier</h3>
        <form method="POST" action="{{ route('file.manager.upload') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="current_folder" value="{{ $folder ?? '' }}">
            <div class="mb-4">
                <label for="fileUpload" class="block text-sm font-medium text-gray-700 mb-1">Sélectionner un fichier</label>
                <input type="file" id="fileUpload" name="file" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeModal('uploadFileModal')" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">Annuler</button>
                <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition-colors font-semibold">Uploader</button>
            </div>
        </form>
    </div>
</div>


<!-- --------------------------------- -->
<!-- JAVASCRIPT POUR MODALS ET NAVIGATION -->
<!-- --------------------------------- -->
<script>
    // --- Fonctions d'Utilitaires ---

    /**
     * Retourne l'icône SVG appropriée en fonction de l'extension du fichier.
     * Cette fonction simule l'aide du backend Laravel (le `fileIcon` dans la boucle)
     * car nous sommes dans un environnement purement HTML/JS pour la simulation.
     */
    function fileIcon(fileName) {
        const extension = fileName.split('.').pop().toLowerCase();
        let iconSvg = '';
        let iconClass = 'icon-file';

        switch (extension) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
            case 'svg':
                iconSvg = '<path d="M5 21h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>';
                iconClass = 'icon-image text-green-500';
                break;
            case 'pdf':
                iconSvg = '<path d="M19 12h-2V7h-6v2H9V5h4V3h2v4h2v5zM5 19v-5h14v5H5z"/>';
                iconClass = 'icon-file text-red-500';
                break;
            case 'zip':
            case 'rar':
                iconSvg = '<path d="M20 6h-2V2H6v4H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zM8 4h8v2H8V4zm12 16H4V8h16v12z"/>';
                iconClass = 'icon-file text-yellow-600';
                break;
            default:
                iconSvg = '<path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zM6 20V4h7v5h5v11H6z"/>';
                iconClass = 'icon-file text-gray-500';
                break;
        }

        return `<svg class="icon-small ${iconClass} mr-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">${iconSvg}</svg>`;
    }

    // Pour simuler la fonction fileIcon dans la boucle Laravel (c'est une petite triche pour l'exemple HTML)
    document.querySelectorAll('tr.file-item > td:first-child').forEach(td => {
        const isDir = td.querySelector('.folder-link');
        if (!isDir) {
            // C'est un fichier, on récupère son nom qui est le texte contenu
            const fileName = td.textContent.trim();
            // On le remplace par l'icône + nom
            td.innerHTML = fileIcon(fileName) + fileName;
        }
    });

    /**
     * Ouvre un modal spécifique.
     * @param {string} modalId L'ID du modal à ouvrir.
     */
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal(modalId);
            }
        });
    }

    /**
     * Ferme un modal spécifique.
     * @param {string} modalId L'ID du modal à fermer.
     */
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    /**
     * Prépare et ouvre le modal de suppression.
     * @param {string} name Le nom du fichier/dossier.
     * @param {string} path Le chemin du fichier/dossier.
     */
    function openDeleteModal(name, path) {
        document.getElementById('deleteFileName').textContent = name;
        document.getElementById('deletePathInput').value = path;
        openModal('deleteModal');
    }

    /**
     * Navigue au dossier parent.
     */
    function navigateUp() {
        const currentFolder = "{{ $folder ?? '' }}";
        if (currentFolder) {
            const parts = currentFolder.split('/');
            parts.pop(); // Retire le dernier élément (dossier actuel)
            const parentFolder = parts.join('/');

            // Si parentFolder est vide, on va à la racine, sinon on passe le chemin
            const newUrl = parentFolder
                ? "{{ route('file.manager', ['folder' => '']) }}?folder=" + encodeURIComponent(parentFolder)
                : "{{ route('file.manager') }}";

            window.location.href = newUrl;
        }
    }

</script>
</body>
</html>
