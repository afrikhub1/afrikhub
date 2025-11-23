<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestionnaire de Fichiers Windows</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f3f3f3;
        min-height: 100vh;
    }
    .container {
        max-width: 1200px;
        margin: auto;
        padding: 2rem;
    }
    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .search-bar {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border: 1px solid #ccc;
        width: 250px;
        transition: all 0.2s;
    }
    .search-bar:focus {
        outline: none;
        border-color: #0078d4;
        box-shadow: 0 0 5px rgba(0,120,212,0.4);
    }
    .file-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 1rem;
    }
    .file-card {
        background: #fff;
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: transform 0.15s, box-shadow 0.15s;
        border: 2px solid transparent;
        user-select: none;
        position: relative;
    }
    .file-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    }
    .file-card.selected {
        border-color: #0078d4;
        background-color: #e6f0ff;
    }
    .file-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    .file-name {
        font-size: 0.9rem;
        word-break: break-word;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .overlay-selected {
        position: absolute;
        inset: 0;
        background: rgba(0,120,212,0.1);
        border-radius: 8px;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.2s;
    }
    .file-card.selected .overlay-selected { opacity: 1; }
    .btn-action {
        background-color: #e81123;
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: 5px;
        font-size: 0.8rem;
        border: none;
        cursor: pointer;
    }
    .btn-action:hover { background-color: #b50e1c; }
    .btn-back {
        background-color: #0078d4;
        color: white;
        padding: 0.5rem 0.8rem;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
    }
    .btn-back:hover { background-color: #005a9e; }
</style>
</head>
<body>
<div class="container">
    <div class="toolbar">
        @if($folder)
        <a href="{{ route('file.manager', ['folder' => dirname($folder)]) }}" class="btn-back">⬅️ Dossier parent</a>
        @endif
        <input type="text" id="search-input" class="search-bar" placeholder="Rechercher...">
    </div>

    <div class="file-grid" id="file-grid">
        @foreach($files as $file)
        <div class="file-card" data-name="{{ strtolower($file['name']) }}" data-path="{{ $file['path'] }}" data-type="{{ $file['type'] }}">
            <div class="file-icon">
                @if($file['type'] === 'dir') 📁 @else 📄 @endif
            </div>
            <div class="file-name">{{ $file['name'] }}</div>
            <div class="overlay-selected"></div>
            <form method="POST" action="{{ route('file.manager.delete') }}" onsubmit="return confirm('Supprimer {{ $file['name'] }} ?');" class="absolute bottom-2 left-1/2 transform -translate-x-1/2">
                @csrf
                <input type="hidden" name="paths[]" value="{{ $file['path'] }}">
                <button type="submit" class="btn-action">Supprimer</button>
            </form>
        </div>
        @endforeach
    </div>
</div>

<script>
    const fileCards = document.querySelectorAll('.file-card');
    const searchInput = document.getElementById('search-input');

    fileCards.forEach(card => {
        const overlay = card.querySelector('.overlay-selected');
        card.addEventListener('click', (e) => {
            if(e.detail === 2 && card.dataset.type === 'dir') {
                window.location.href = "{{ route('file.manager') }}/" + encodeURIComponent(card.dataset.path);
                return;
            }
            card.classList.toggle('selected');
            overlay.style.opacity = card.classList.contains('selected') ? '1' : '0';
        });
    });

    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();
        fileCards.forEach(card => {
            card.style.display = card.dataset.name.includes(query) ? 'block' : 'none';
        });
    });
</script>
</body>
</html>
