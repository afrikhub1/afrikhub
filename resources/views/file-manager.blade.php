<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestionnaire de Fichiers</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f3f4f6; }
    .file-card { background: #fff; border-radius: 12px; padding: 1rem; text-align: center; cursor: pointer;
        transition: all 0.2s; border: 2px solid transparent; }
    .file-card:hover { border-color: #3b82f6; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .file-card.selected { border-color: #2563eb; background: #e0f2fe; }
    .file-name { margin-top: 0.5rem; font-size: 0.9rem; word-break: break-word; line-height: 1.2; max-height: 2.4em; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
    .search-bar { padding: 0.5rem 1rem; border-radius: 12px; border: 1px solid #ccc; outline: none; transition: all 0.2s; }
    .search-bar:focus { border-color: #3b82f6; box-shadow: 0 0 5px rgba(59,130,246,0.4); }
</style>
</head>
<body>
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">📂 Gestionnaire de Fichiers</h1>

    @if(session('success')) <p class="text-green-600 mb-2">{{ session('success') }}</p> @endif
    @if(session('error')) <p class="text-red-600 mb-2">{{ session('error') }}</p> @endif

    <!-- Barre d'outils -->
    <div class="flex items-center justify-between mb-4 space-x-4">
        @if($folder)
        <a href="{{ route('file.manager', ['folder' => dirname($folder)]) }}" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 flex items-center">
            ⬅️ Retour
        </a>
        @endif
        <input type="text" id="search-input" class="search-bar flex-1" placeholder="Rechercher un fichier ou dossier...">
    </div>

    <!-- Grille des fichiers -->
    <div id="file-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($files as $file)
        <div class="file-card relative" data-name="{{ strtolower($file['name']) }}">
            <input type="checkbox" class="file-checkbox hidden" data-path="{{ $file['path'] }}">
            <div class="file-icon">
                @if($file['type'] === 'dir')
                    <a href="{{ route('file.manager', ['folder' => $file['path']]) }}" class="block text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#FFD43B" viewBox="0 0 24 24" class="w-12 h-12 mx-auto">
                            <path d="M3 4a1 1 0 011-1h6l2 2h9a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/>
                        </svg>
                        <div class="file-name mt-1">{{ $file['name'] }}</div>
                    </a>
                @else
                    <div class="file-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#3b82f6" viewBox="0 0 24 24" class="w-12 h-12 mx-auto">
                            <path d="M4 2h12l4 4v16a1 1 0 01-1 1H4a1 1 0 01-1-1V3a1 1 0 011-1z"/>
                        </svg>
                        <div class="file-name mt-1">{{ $file['name'] }}</div>
                    </div>
                @endif

            </div>
            <div class="file-name">{{ $file['name'] }}</div>
            <div class="absolute inset-0 overlay-selected hidden rounded-xl pointer-events-none"></div>
        </div>
        @endforeach
    </div>

    <!-- Bouton supprimer -->
    <form method="POST" action="{{ route('file.manager.delete') }}" class="mt-4">
        @csrf
        <input type="hidden" name="path" id="delete-path">
        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600" id="delete-button" disabled>Supprimer sélection</button>
    </form>
</div>

<script>
const fileCards = document.querySelectorAll('.file-card');
const deleteBtn = document.getElementById('delete-button');
const deletePath = document.getElementById('delete-path');
const searchInput = document.getElementById('search-input');

fileCards.forEach(card => {
    const checkbox = card.querySelector('.file-checkbox');
    card.addEventListener('click', () => {
        const selected = !checkbox.checked;
        checkbox.checked = selected;
        card.classList.toggle('selected', selected);
        updateDeleteButton();
    });
});

function updateDeleteButton() {
    const selected = document.querySelectorAll('.file-checkbox:checked');
    if (selected.length === 1) {
        deletePath.value = selected[0].dataset.path;
        deleteBtn.disabled = false;
    } else {
        deletePath.value = '';
        deleteBtn.disabled = true;
    }
}

// Recherche simple
searchInput.addEventListener('input', () => {
    const query = searchInput.value.toLowerCase();
    fileCards.forEach(card => {
        card.style.display = card.dataset.name.includes(query) ? 'block' : 'none';
    });
});
</script>
</body>
</html>
