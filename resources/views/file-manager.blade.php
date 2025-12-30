@extends('admin.header_footer')

@section('titre', 'Gestionnaire de Fichiers S3')

@section('style')
    <style>
        .img-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            transition: transform 0.2s;
        }
        .img-thumb:hover { transform: scale(2.5); z-index: 50; position: relative; }
        .file-row:hover { background-color: rgba(79, 70, 229, 0.05); }
    </style>
@endsection

@section('main')
<div class="container-fluid p-4">

    {{-- Fil d'Ariane & Titre --}}
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-indigo-700 mb-2">
            <i class="fas fa-cloud-upload-alt mr-3"></i> File Manager S3
        </h1>
        <nav class="flex text-gray-600 text-sm">
            <a href="{{ route('files.index') }}" class="hover:text-indigo-600">Root</a>
            @if($folder)
                @php $path = ''; @endphp
                @foreach(explode('/', trim($folder, '/')) as $segment)
                    @php $path .= ($path ? '/' : '') . $segment; @endphp
                    <span class="mx-2">/</span>
                    <a href="{{ route('files.index', ['folder' => $path]) }}" class="hover:text-indigo-600">{{ $segment }}</a>
                @endforeach
            @endif
        </nav>
    </div>

    {{-- Alertes --}}
    @if(session('success'))
        <div id="alert-success" class="flex justify-between items-center p-4 mb-4 rounded-lg bg-green-50 border-l-4 border-green-600 shadow-sm">
            <span class="text-green-800"><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-700 ml-3">✕</button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        {{-- Section Upload --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Uploader</h3>
                <form method="POST" action="{{ route('files.upload') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="folder" value="{{ $folder }}">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Choisir un fichier</label>
                        <input type="file" name="file" class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100 cursor-pointer" required>
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                        <i class="fas fa-upload mr-2"></i> Envoyer
                    </button>
                </form>

                @if($folder)
                    <div class="mt-6">
                        <a href="{{ route('files.index', ['folder' => (str_contains($folder, '/') ? dirname($folder) : '')]) }}"
                           class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Dossier Parent
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Liste des fichiers --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-indigo-700 text-white">
                            <tr>
                                <th class="px-4 py-3 font-semibold text-sm uppercase">Nom</th>
                                <th class="px-4 py-3 font-semibold text-sm uppercase text-center">Taille</th>
                                <th class="px-4 py-3 font-semibold text-sm uppercase text-center">Aperçu</th>
                                <th class="px-4 py-3 font-semibold text-sm uppercase text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($files as $file)
                                <tr class="file-row transition">
                                    <td class="px-4 py-4">
                                        @if($file['type'] === 'dir')
                                            <a href="{{ route('files.index', ['folder' => trim($file['path'], '/')]) }}" class="flex items-center text-indigo-600 font-bold hover:underline">
                                                <i class="fas fa-folder text-yellow-500 mr-3 text-xl"></i>
                                                {{ $file['name'] }}
                                            </a>
                                        @php $currentFolder = trim($folder ?? '', '/');
                                             $parentFolder = str_contains($currentFolder, '/') ? dirname($currentFolder) : '';
                                        @endphp
                                        @else
                                            <div class="flex items-center text-gray-700">
                                                <i class="fas fa-file-alt text-gray-400 mr-3 text-xl"></i>
                                                {{ $file['name'] }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-center text-sm text-gray-500">
                                        {{ $file['type'] === 'file' ? number_format($file['size'] / 1024, 2) . ' Mo' : '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if($file['type'] === 'file' && preg_match('/\.(jpg|jpeg|png|webp|gif)$/i', $file['name']))
                                            <img src="{{ $file['url'] }}" class="img-thumb mx-auto shadow-sm" alt="Aperçu">
                                        @elseif($file['type'] === 'file')
                                            <span class="text-gray-300 text-xs italic">Pas d'aperçu</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            @if($file['type'] === 'file')
                                                <a href="{{ $file['url'] }}" target="_blank" class="p-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition" title="Voir">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif

                                            <form action="{{ route('files.delete') }}" method="POST" onsubmit="return confirm('Supprimer définitivement ce fichier ?')">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="path" value="{{ trim($file['path'], '/') }}">
                                                <button type="submit" class="p-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-12 text-center text-gray-400 italic">
                                        <i class="fas fa-folder-open text-4xl mb-3 block"></i>
                                        Ce dossier est vide
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
