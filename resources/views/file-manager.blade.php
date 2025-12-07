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
    const link = card.querySelector('a'); // vérifie si c'est un dossier

    if (link) return; // ne fait rien pour les dossiers

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


                <!-- Résidences -->
                <div class="mt-8">
                    @if ($residences->isEmpty())
                        <div class="text-center bg-yellow-100 text-yellow-800 font-bold rounded-xl p-6 shadow">
                            <i class="fa-solid fa-triangle-exclamation mr-2"></i>Aucune résidence trouvée pour cette recherche.
                        </div>
                    @else
                        <div class="row m-0 p-0 justify-content-start">
                            <!-- RECHERCHE -->
                            <div class="col-8 col-md-6 col-lg-4">
                                <input id="searchInput" type="text"
                                    placeholder="Rechercher par nom ou status..."
                                    class="w-full py-2 pl-10 pr-4 bg-gray-800 text-white rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <!-- OPTION -->
                             <div class="col-4 col-md-3 col-lg-2">
                                <select id="searchOption" class="py-2 px-3 bg-gray-800 text-white rounded-lg">
                                    <option value="name">Nom</option>
                                    <option value="ville">Ville</option>
                                    <option value="prix_journalier">prix</option>
                                    <option value="salon">salon</option>
                                    <option value="chambre">chambre</option>
                                </select>
                             </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mt-4">
                            @foreach($residences as $residence)
                                @php
                                    $images = $residence->img;
                                    if (is_string($images)) $images = json_decode($images, true) ?? [];
                                    $firstImage = $images[0] ?? null;
                                    $imagePath = $firstImage ?: 'https://placehold.co/400x250/E0E7FF/4F46E5?text=Pas+d\'image';
                                @endphp

                                <div class="search-row bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-indigo-300/50 transition transform hover:scale-[1.01]"
                                    data-name="{{ $residence->nom }}" data-prix_journalier="{{ $residence->prix_journalier }}"
                                    data-ville="{{ $residence->ville }}" data-nombre_chambres="{{ $residence->nombre_chambres }}"
                                    data-nombre_salons="{{ $residence->nombre_salons }}">

                                    <a href="{{ $imagePath }}"
                                        class="glightbox block relative"
                                        data-gallery="residence-{{ $residence->id }}"
                                        data-title="{{ $residence->nom }}">

                                            <!-- Conteneur qui fixe la hauteur -->
                                            <div class="w-full h-[200px] overflow-hidden rounded-xl">
                                                <img src="{{ $imagePath }}"
                                                    class="w-full h-[200px] object-cover transition duration-300 hover:opacity-90"
                                                    alt="Image de la résidence">
                                            </div>
                                        </a>

                                    @if(is_array($images))
                                        @foreach($images as $key => $image)
                                            @if($key > 0)
                                                <a href="{{ $image }}" class="glightbox" data-gallery="residence-{{ $residence->id }}" data-title="{{ $residence->nom }}" style="display:none; height:200px;"></a>
                                            @endif
                                        @endforeach
                                    @endif

                                    <div class="p-6 flex flex-col flex-grow border-t border-gray-200">
                                        <h5 class="font-extrabold text-indigo-800 mb-2 border-b border-gray-100 pb-2 truncate">{{ $residence->nom }} - {{ $residence->id }}</h5>
                                        <ul class="space-y-2 text-gray-700 flex-grow">
                                            <li class="flex justify-between items-center">
                                                <span class="text-gray-500"><i class="fas fa-tag mr-2 text-green-500"></i>Prix / Jour :</span>
                                                <span class="text-green-600 font-extrabold">{{ number_format($residence->prix_journalier, 0, ',', ' ') }} FCFA</span>
                                            </li>
                                            <li class="flex justify-between items-center">
                                                <span class="text-gray-500"><i class="fas fa-map-marker-alt mr-2 text-indigo-400"></i>Ville :</span>
                                                <span class="text-gray-900">{{ $residence->ville }} ({{ $residence->pays }})</span>
                                            </li>
                                            <li class="flex justify-between items-center">
                                                <span class="text-gray-500"><i class="fas fa-user-tie mr-2 text-indigo-400"></i>Nombre de chambres :</span>
                                                <span class="text-gray-900 font-bold">{{ $residence->nombre_chambres ?? 'N/A' }}</span>
                                            </li>
                                            <li class="flex justify-between items-center">
                                                <span class="text-gray-500"><i class="fas fa-user-tie mr-2 text-indigo-400"></i>Nombre de salons :</span>
                                                <span class="text-gray-900 font-bold">{{ $residence->nombre_salons ?? 'N/A' }}</span>
                                            </li>
                                            <li class="flex justify-between items-center">
                                                <span class="text-gray-500"><i class="fas fa-city mr-2 text-indigo-400"></i></span>
                                                @if($residence->disponible == 0)
                                                    <span class="text-gray-900">Indisponible</span>
                                                @else
                                                    <span class="text-green-600 font-semibold">Disponible le {{ $residence->date_disponible }}</span>
                                                @endif
                                            </li>
                                        </ul>

                                        <div class="mt-4 border-t pt-4">
                                            <a href="{{ route('details', $residence->id) }}" class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
                                                <i class="fas fa-edit mr-1"></i> Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
