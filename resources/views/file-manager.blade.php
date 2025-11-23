<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestionnaire de Fichiers MacOS</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.3/dist/tailwind.min.css" rel="stylesheet">
<style>
    body {
        font-family: 'San Francisco', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: #f2f2f5;
    }
    .container {
        max-width: 1200px;
        margin: auto;
        padding: 2rem;
    }
    .file-card {
        background: #fff;
        border-radius: 14px;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
        position: relative;
        border: 2px solid transparent;
    }
    .file-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        border-color: #cce4ff;
    }
    .file-card.selected {
        border-color: #007aff;
        background: #e6f0ff;
    }
    .file-icon {
        width: 50px;
        height: 50px;
        margin: auto;
    }
    .file-name {
        margin-top: 0.5rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: #333;
        word-break: break-word;
    }
    .search-bar {
        padding: 0.5rem 1rem;
        border-radius: 12px;
        border: 1px solid #ccc;
        width: 100%;
        max-width: 400px;
        outline: none;
        transition: all 0.2s;
    }
    .search-bar:focus {
        border-color: #007aff;
        box-shadow: 0 0 5px rgba(0,122,255,0.4);
    }
    /* Overlay sélection */
    .overlay-selected {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 122, 255, 0.15);
        border-radius: 14px;
        pointer-events: none;
    }
</style>
</head>
<body>
<div class="container">
    <h1 class="text-3xl font-semibold mb-6">📁 Gestionnaire de Fichiers MacOS</h1>

    <!-- Barre de recherche -->
    <input type="text" id="search-input" class="search-bar mb-6" placeholder="Rechercher un fichier ou dossier...">

    <!-- Grille des fichiers/dossiers -->
    <div id="file-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @foreach($files as $file)
        <div class="file-card relative" data-name="{{ strtolower($file['name']) }}">
            <input type="checkbox" class="file-checkbox hidden" data-path="{{ $file['path'] }}">
            <div class="file-icon">
                @if($file['type'] === 'dir')
                    <!-- SVG Dossier -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#FFD93B" viewBox="0 0 24 24">
                        <path d="M3 4a1 1 0 011-1h6l2 2h9a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/>
                    </svg>
                @else
                    <!-- SVG Fichier -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#4B9CD3" viewBox="0 0 24 24">
                        <path d="M4 2h12l4 4v16a1 1 0 01-1 1H4a1 1 0 01-1-1V3a1 1 0 011-1z"/>
                    </svg>
                @endif
            </div>
            <div class="file-name">{{ $file['name'] }}</div>
            <div class="overlay-selected hidden"></div>
        </div>
        @endforeach
    </div>

    <!-- Bouton supprimer sélection -->
    <button id="delete-selected" class="mt-6 px-6 py-2 bg-red-500 text-white rounded-lg font-semibold disabled:opacity-50" disabled>Supprimer la sélection</button>
</div>

<script>
    const fileCards = document.querySelectorAll('.file-card');
    const deleteBtn = document.getElementById('delete-selected');
    const searchInput = document.getElementById('search-input');

    fileCards.forEach(card => {
        const checkbox = card.querySelector('.file-checkbox');
        const overlay = card.querySelector('.overlay-selected');

        card.addEventListener('click', () => {
            const selected = !checkbox.checked;
            checkbox.checked = selected;
            card.classList.toggle('selected', selected);
            overlay.classList.toggle('hidden', !selected);
            updateDeleteButton();
        });
    });

    function updateDeleteButton() {
        const anySelected = document.querySelectorAll('.file-checkbox:checked').length > 0;
        deleteBtn.disabled = !anySelected;
    }

    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();
        fileCards.forEach(card => {
            const name = card.dataset.name;
            card.style.display = name.includes(query) ? 'block' : 'none';
        });
    });

    deleteBtn.addEventListener('click', () => {
        if(!confirm('Voulez-vous supprimer tous les éléments sélectionnés ?')) return;
        const selected = document.querySelectorAll('.file-checkbox:checked');
        selected.forEach(cb => {
            cb.closest('.file-card').remove();
        });
        updateDeleteButton();
    });
</script>
</body>
</html>
