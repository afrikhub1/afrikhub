<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestionnaire de Fichiers</title>
<style>
    body { font-family: Arial, sans-serif; background: #f5f5f7; padding: 20px; }
    .container { max-width: 900px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);}
    h2 { margin-top: 0; color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px; }
    .file-list { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .file-list th, .file-list td { padding: 10px; text-align: left; border-bottom: 1px solid #eee; }
    .file-list th { background: #f0f0f0; }
    .file-list tr:hover { background: #f9f9ff; }
    .btn-delete { background: #e74c3c; color: white; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; }
    .btn-delete:hover { background: #c0392b; }
    .btn-folder { background: #3498db; color: white; padding: 3px 7px; border-radius: 5px; text-decoration: none; }
    .file-checkbox { margin-right: 5px; }
    .selected { background-color: #e6f0ff; }
    .search-bar { padding: 6px 10px; border-radius: 8px; border: 1px solid #ccc; margin-bottom: 10px; width: 100%; max-width: 400px; }
</style>
</head>
<body>
<div class="container">
    <h2>📂 Gestionnaire de Fichiers</h2>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <input type="text" id="search-input" class="search-bar" placeholder="Rechercher un fichier ou dossier...">

    <table class="file-list">
        <tr>
            <th>Nom</th>
            <th>Taille</th>
            <th>Dernière modification</th>
            <th>Actions</th>
        </tr>

        @if($folder)
        <tr>
            <td colspan="4">
                <a class="btn-folder" href="{{ route('file.manager', ['folder' => dirname($folder)]) }}">⬅️ Retour</a>
            </td>
        </tr>
        @endif

        @foreach($files as $file)
        <tr class="file-card" data-name="{{ strtolower($file['name']) }}" data-type="{{ $file['type'] }}" data-path="{{ $file['path'] }}">
            <td>
                <input type="checkbox" class="file-checkbox">
                @if($file['type'] === 'dir')
                    📁 <a href="{{ route('file.manager', ['folder' => $file['path']]) }}">{{ $file['name'] }}</a>
                @else
                    🖼️ {{ $file['name'] }}
                @endif
            </td>
            <td>{{ $file['size'] ? round($file['size']/1024, 2).' Ko' : '-' }}</td>
            <td>{{ $file['lastModified'] }}</td>
            <td></td>
        </tr>
        @endforeach
    </table>

    <p id="selected-text" class="mt-2 text-gray-700">Aucun fichier ou dossier sélectionné.</p>
    <button id="delete-selected" class="btn-delete" disabled>Supprimer la sélection</button>
</div>

<!-- Formulaire global pour suppression multiple -->
<form id="delete-form" method="POST" action="{{ route('file.manager.delete') }}" style="display:none;">
    @csrf
</form>

<script>
const fileCards = document.querySelectorAll('.file-card');
const deleteBtn = document.getElementById('delete-selected');
const searchInput = document.getElementById('search-input');
const selectedText = document.getElementById('selected-text');
const deleteForm = document.getElementById('delete-form');

fileCards.forEach(card => {
    const checkbox = card.querySelector('.file-checkbox');
    const type = card.dataset.type;

    // Clic simple = sélection
    card.addEventListener('click', e => {
        if(type==='dir' && e.target.tagName==='A') return;
        const selected = !checkbox.checked;
        checkbox.checked = selected;
        card.classList.toggle('selected', selected);
        updateSelectedText();
    });

    // Double-clic = ouvrir dossier
    card.addEventListener('dblclick', e => {
        if(type==='dir') {
            window.location.href = `?folder=${encodeURIComponent(card.dataset.path)}`;
        }
    });
});

function updateSelectedText() {
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
        card.style.display = name.includes(query) ? 'table-row' : 'none';
    });
});

// Suppression multiple
deleteBtn.addEventListener('click', () => {
    const selected = document.querySelectorAll('.file-checkbox:checked');
    if(selected.length === 0) return;

    if(!confirm(`Voulez-vous supprimer ${selected.length} élément(s) ?`)) return;

    // Vider le formulaire
    deleteForm.innerHTML = '@csrf';

    // Ajouter tous les fichiers sélectionnés
    selected.forEach(cb => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'paths[]';
        input.value = cb.closest('.file-card').dataset.path;
        deleteForm.appendChild(input);
    });

    deleteForm.submit();
});
</script>
</body>
</html>
