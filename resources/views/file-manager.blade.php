<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Barre d'outils / Retour -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 space-y-4 sm:space-y-0">
        @if($folder)
        <a href="{{ route('file.manager', ['folder' => dirname($folder)]) }}"
           class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 flex items-center text-gray-700 font-medium transition duration-150 ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Dossier parent
        </a>
        @endif

        <input type="text" id="search-input" class="search-bar w-full sm:w-80 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400"
               placeholder="Rechercher un fichier ou dossier...">
    </div>

    <!-- Grille des fichiers/dossiers -->
    <div id="file-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-7 gap-4 sm:gap-6">
        @foreach($files as $file)
        <div class="file-card relative border border-transparent rounded-xl shadow-md hover:shadow-lg cursor-pointer"
             data-name="{{ strtolower($file['name']) }}"
             data-path="{{ $file['path'] }}"
             data-type="{{ $file['type'] }}">
            <input type="checkbox" class="file-checkbox hidden" data-path="{{ $file['path'] }}">
            <div class="file-icon w-full flex justify-center items-center bg-gray-100 p-4 rounded-t-xl">
                @if($file['type'] === 'dir')
                <svg xmlns="http://www.w3.org/2000/svg" fill="#FFD93B" viewBox="0 0 24 24" class="w-12 h-12">
                    <path d="M3 4a1 1 0 011-1h6l2 2h9a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/>
                </svg>
                @else
                <svg xmlns="http://www.w3.org/2000/svg" fill="#4B9CD3" viewBox="0 0 24 24" class="w-12 h-12">
                    <path d="M4 2h12l4 4v16a1 1 0 01-1 1H4a1 1 0 01-1-1V3a1 1 0 011-1z"/>
                </svg>
                @endif
            </div>
            <div class="file-name p-2 text-center font-medium truncate">{{ $file['name'] }}</div>
            <div class="overlay-selected absolute inset-0 rounded-xl pointer-events-none"></div>
        </div>
        @endforeach
    </div>

    <!-- Bouton supprimer sélection -->
    <div class="mt-8 flex justify-end">
        <button id="delete-selected"
                class="px-6 py-3 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed shadow-md"
                disabled>
            Supprimer la sélection (<span id="selected-count">0</span>)
        </button>
    </div>
</div>
