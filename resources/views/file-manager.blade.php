@extends('admin.header_footer')

@section('titre', 'Gestionnaire de Fichiers S3')

@section('style')
    <style>
        /* Fixer la hauteur pour le scroll interne */
        .file-manager-container {
            max-height: 65vh;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #4f46e5 #f3f4f6;
        }

        /* Effet sur les miniatures */
        .img-thumb {
            width: 45px; height: 45px;
            object-fit: cover; border-radius: 8px;
            transition: all 0.3s ease;
        }
        .img-thumb:hover { transform: scale(3); z-index: 100; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.2); }

        /* Animation des lignes */
        .file-row { transition: all 0.2s; border-left: 3px solid transparent; }
        .file-row:hover { border-left: 3px solid #4f46e5; background-color: #f8fafc; }

        /* Style pour le footer fixe en bas de page */
        body { display: flex; flex-direction: column; min-height: 100vh; }
        main { flex: 1; }
    </style>
@endsection

@section('main')
<div class="container-fluid p-4">

    {{-- En-tête Dynamique --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-black text-indigo-800 flex items-center">
                <span class="bg-indigo-100 p-2 rounded-lg mr-3">
                    <i class="fas fa-folder-open text-indigo-600"></i>
                </span>
                Explorateur S3
            </h1>
            <p class="text-gray-500 text-sm mt-1">Gérez vos médias stockés sur Amazon S3</p>
        </div>

        {{-- Fil d'Ariane --}}
        <nav class="bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100 flex text-sm">
            <a href="{{ route('files.index') }}" class="text-indigo-600 hover:font-bold transition-all">Root</a>
            @if($folder)
                @php $path = ''; @endphp
                @foreach(explode('/', trim($folder, '/')) as $segment)
                    @php $path .= ($path ? '/' : '') . $segment; @endphp
                    <span class="mx-2 text-gray-400">/</span>
                    <a href="{{ route('files.index', ['folder' => $path]) }}" class="text-gray-600 hover:text-indigo-600">{{ $segment }}</a>
                @endforeach
            @endif
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- Sidebar Gauche : Upload --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 sticky top-4">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-cloud-upload-alt mr-2 text-indigo-500"></i> Nouveau Fichier
                </h3>

                <form method="POST" action="{{ route('files.upload') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="folder" value="{{ $folder }}">

                    <div class="group relative border-2 border-dashed border-gray-300 rounded-xl p-4 transition hover:border-indigo-400 bg-gray-50">
                        <input type="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required>
                        <div class="text-center">
                            <i class="fas fa-file-image text-3xl text-gray-400 group-hover:text-indigo-500 mb-2"></i>
                            <p class="text-xs text-gray-500">Cliquez ou glissez un fichier ici</p>
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-4 bg-indigo-600 text-white py-3 rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 active:scale-95">
                        Lancer l'envoi
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Infos Dossier</p>
                    <div class="bg-indigo-50 p-3 rounded-lg text-indigo-700 text-xs break-all">
                        <i class="fas fa-link mr-1"></i> path: /{{ $folder ?: 'root' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Zone Droite : Tableau avec Scroll --}}
        <div class="lg:col-span-9">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">

                {{-- Barre de titre du tableau --}}
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <span class="text-sm font-bold text-gray-600">{{ count($files) }} Élément(s)</span>
                    <span class="text-xs bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full font-bold">Amazon S3 Storage</span>
                </div>

                {{-- Conteneur de scroll --}}
                <div class="file-manager-container">
                    <table class="w-full text-left border-collapse">
                        <thead class="sticky top-0 bg-white shadow-sm z-10">
                            <tr class="text-gray-400 text-[11px] uppercase tracking-wider">
                                <th class="px-6 py-3 font-bold">Nom de l'élément</th>
                                <th class="px-6 py-3 font-bold text-center">Taille</th>
                                <th class="px-6 py-3 font-bold text-center">Aperçu</th>
                                <th class="px-6 py-3 font-bold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">

                            {{-- BOUTON RETOUR DANS LE TABLEAU --}}
                            @if($folder)
                                <tr class="bg-gray-50/50 hover:bg-gray-100 transition cursor-pointer"
                                    onclick="window.location='{{ route('files.index', ['folder' => (str_contains($folder, '/') ? dirname($folder) : '')]) }}'">
                                    <td colspan="4" class="px-6 py-3">
                                        <div class="flex items-center text-indigo-600 font-bold text-sm">
                                            <i class="fas fa-level-up-alt fa-rotate-270 mr-3"></i>
                                            ... / Dossier parent
                                        </div>
                                    </td>
                                </tr>
                            @endif

                            @forelse($files as $file)
                                <tr class="file-row">
                                    <td class="px-6 py-4">
                                        @if($file['type'] === 'dir')
                                            <a href="{{ route('files.index', ['folder' => trim($file['path'], '/')]) }}" class="flex items-center group">
                                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3 group-hover:bg-yellow-200 transition">
                                                    <i class="fas fa-folder text-yellow-600"></i>
                                                </div>
                                                <span class="text-gray-800 font-semibold group-hover:text-indigo-600 transition">{{ $file['name'] }}</span>
                                            </a>
                                        @else
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center mr-3">
                                                    <i class="fas fa-file text-blue-400"></i>
                                                </div>
                                                <span class="text-gray-600 text-sm">{{ $file['name'] }}</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-xs font-mono text-gray-400">
                                            {{ $file['type'] === 'file' ? number_format($file['size'] / 1024, 2) . ' Ko' : '--' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($file['type'] === 'file' && preg_match('/\.(jpg|jpeg|png|webp|gif)$/i', $file['name']))
                                            <img src="{{ $file['url'] }}" class="img-thumb mx-auto shadow-sm ring-2 ring-white" alt="Aperçu">
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end gap-2">
                                            @if($file['type'] === 'file')
                                                <a href="{{ $file['url'] }}" target="_blank" class="w-8 h-8 flex items-center justify-center bg-green-50 text-green-600 rounded-full hover:bg-green-600 hover:text-white transition shadow-sm">
                                                    <i class="fas fa-external-link-alt text-xs"></i>
                                                </a>
                                            @endif

                                            <form action="{{ route('files.delete') }}" method="POST" onsubmit="return confirm('Confirmer la suppression ?')">
                                                @csrf @method('DELETE')
                                                <input type="hidden" name="path" value="{{ trim($file['path'], '/') }}">
                                                <button type="submit" class="w-8 h-8 flex items-center justify-center bg-red-50 text-red-500 rounded-full hover:bg-red-500 hover:text-white transition shadow-sm">
                                                    <i class="fas fa-trash-alt text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-20 text-center">
                                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076444.png" class="w-20 mx-auto opacity-20 mb-4" alt="Vide">
                                        <p class="text-gray-400 font-medium italic">Aucun fichier trouvé dans ce répertoire</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
