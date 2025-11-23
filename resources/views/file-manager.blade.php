<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestionnaire de Fichiers</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    body { font-family: 'Inter', sans-serif; background: #f5f5f7; }
    .file-card {
        background: #fff;
        border-radius: 10px;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
        border: 2px solid transparent;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .file-card:hover { box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .file-card.selected { border-color: #007aff; background: #e6f0ff; }
    .file-name { margin-top: 0.5rem; font-weight: 500; word-break: break-word; }
    .overlay-selected { position: absolute; inset:0; background: rgba(0,122,255,0.15); border-radius: 10px; pointer-events:none; display:none; }
    .file-card.selected .overlay-selected { display:block; }
    .search-bar { padding:0.5rem 1rem; border-radius: 10px; border:1px solid #ccc; outline:none; width:100%; max-width:400px; }
    .search-bar:focus { border-color:#007aff; box-shadow:0 0 5px rgba(0,122,255,0.4); }
</style>
</head>
<body>
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">📂 Gestionnaire de Fichiers</h1>

    @if(session('success'))
        <p class="text-green-600 mb-2">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p class="text-red-600 mb-2">{{ session('error') }}</p>
    @endif

    <div class="flex items-center justify-between mb-4">
        @if($folder)
        <a href="{{ route('file.manager', ['folder'=>dirname($folder)]) }}"
           class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 flex items-center text-gray-700">
           ⬅️ Retour
        </a>
        @endif
        <input type="text" id="search-input" class="search-bar" placeholder="Rechercher un fichier...">
    </div>

    <form id="delete-form" method="POST" action="{{ route('file.manager.delete') }}">
        @csrf
        <div id="file-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach($files as $file)
            <div class="file-card relative" data-name="{{ strtolower($file['name']) }}" data-type="{{ $file['type'] }}">
                @if($file['type']==='file')
                    <input type="checkbox" name="paths[]" value="{{ $file['path'] }}" class="file-checkbox absolute top-2 left-2 w-5 h-5">
                @endif
                <div class="file-icon">
                    @if($file['type']==='dir')
                    <a href="{{ route('file.manager', ['folder'=>$file['path']]) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="#FFD93B" viewBox="0 0 24 24" class="w-12 h-12 mx-auto">
                            <path d="M3 4a1 1 0 011-1h6l2 2h9a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/>
                        </svg>
                    </a>
                    @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#4B9CD3" viewBox="0 0 24 24" class="w-12 h-12 mx-auto">
                        <path d="M4 2h12l4 4v16a1 1 0 01-1 1H4a1 1 0 01-1-1V3a1 1 0 011-1z"/>
                    </svg>
                    @endif
                </div>
                <div class="file-name">{{ $file['name'] }}</div>
                <div class="overlay-selected"></div>
            </div>
            @endforeach
        </div>

        <button type="submit" id="delete-selected"
            class="mt-6 px-6 py-2 bg-red-500 text-white rounded font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
            disabled>
            Supprimer la sélection
        </button>
    </form>
</div>

<script>
const fileCards = document.querySelectorAll('.file-card');
const deleteBtn = document.getElementById('delete-selected');
const searchInput = document.getElementById('search-input');

// Ajouter un texte dynamique pour l'état de sélection
const selectedText = document.createElement('p');
selectedText.className = 'mt-2 text-gray-700';
deleteBtn.parentNode.insertBefore(selectedText, deleteBtn);

fileCards.forEach(card => {
    const checkbox = card.querySelector('.file-checkbox');
    const type = card.dataset.type;

    card.addEventListener('click', e => {
        // Si c'est un dossier et qu'on clique sur le lien, ouvrir le dossier
        if(type === 'dir' && e.target.tagName === 'A') return;

        // Toggle sélection
        const selected = !checkbox.checked;
        checkbox.checked = selected;
        card.classList.toggle('selected', selected);

        updateDeleteButton();
    });

    // Double-clic sur un dossier pour “ouvrir”
    card.addEventListener('dblclick', e => {
        if(type === 'dir') {
            const folderPath = card.dataset.path;
            window.location.href = `?folder=${encodeURIComponent(folderPath)}`;
        }
    });
});

function updateDeleteButton() {
    const selected = document.querySelectorAll('.file-checkbox:checked');
    const count = selected.length;
    deleteBtn.disabled = count === 0;
    selectedText.textContent = count === 0
        ? "Aucun fichier ou dossier sélectionné."
        : `${count} élément(s) sélectionné(s)`;
}

// Recherche
searchInput.addEventListener('input', () => {
    const query = searchInput.value.toLowerCase();
    fileCards.forEach(card => {
        const name = card.dataset.name;
        card.style.display = name.includes(query) ? 'block' : 'none';
    });
});
</script>

</body>
</html>
