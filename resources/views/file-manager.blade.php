<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>File Manager S3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .img-thumb { width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; }
    </style>
</head>
<body class="bg-light">

@php
$currentFolder = trim($folder ?? '', '/');
$parentFolder = str_contains($currentFolder, '/') ? dirname($currentFolder) : '';
@endphp

<div class="container py-5">

    <h2 class="mb-3 text-center">☁️ File Manager S3</h2>

    {{-- Bouton retour --}}
    @if($currentFolder)
        <a href="{{ route('files.index', ['folder' => $parentFolder]) }}" class="btn btn-outline-secondary mb-3">
            ⬅️ Retour
        </a>
    @endif

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Upload --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('files.upload') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="folder" value="{{ $currentFolder }}">

                <div class="mb-3">
                    <label class="form-label">Uploader un fichier</label>
                    <input type="file" name="file" class="form-control" required>
                </div>

                <button class="btn btn-primary w-100">⬆️ Envoyer</button>
            </form>
        </div>
    </div>

    {{-- Liste fichiers et dossiers --}}
    <div class="card">
        <div class="card-header bg-dark text-white">Fichiers & Dossiers</div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Nom</th>
                        <th>Taille (Ko)</th>
                        <th>Modifié</th>
                        <th>Aperçu</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($files as $file)
                    <tr>
                        <td>{{ $file['type'] === 'file' ? '📄' : '📁' }}</td>

                        <td>
                            @if($file['type'] === 'dir')
                                <a href="{{ route('files.index', ['folder' => trim($file['path'], '/')]) }}" class="fw-bold text-decoration-none">
                                    {{ $file['name'] }}
                                </a>
                            @else
                                {{ $file['name'] }}
                            @endif
                        </td>

                        <td>{{ $file['size'] ?? '-' }}</td>
                        <td>{{ $file['lastModified'] }}</td>

                        <td>
                            @if($file['type'] === 'file' && preg_match('/\.(jpg|jpeg|png|webp)$/i', $file['name']))
                                <img src="{{ $file['url'] }}" class="img-thumb" alt="{{ $file['name'] }}">
                            @endif
                        </td>

                        <td>
                            @if($file['type'] === 'file' && $file['url'])
                                <a href="{{ $file['url'] }}" target="_blank" class="btn btn-sm btn-success">Voir</a>
                            @endif

                            <form action="{{ route('files.delete') }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="path" value="{{ trim($file['path'], '/') }}">
                                <button class="btn btn-sm btn-danger">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Aucun fichier ou dossier</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>
