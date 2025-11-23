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
    .alert-success { color: green; margin-bottom: 10px; }
    .alert-error { color: red; margin-bottom: 10px; }
</style>
</head>
<body>
<div class="container">
    <h2>📂 Gestionnaire de Fichiers</h2>

    @if(session('success'))
        <p class="alert-success">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p class="alert-error">{{ session('error') }}</p>
    @endif

    <table class="file-list">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Taille</th>
            <th>Dernière modification</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @if($folder)
        <tr>
            <td colspan="4">
                <a class="btn-folder" href="{{ route('file.manager', ['folder' => dirname($folder)]) }}">⬅️ Retour</a>
            </td>
        </tr>
        @endif

        @foreach($files as $file)
        <tr>
            <td>
                @if($file['type'] === 'dir')
                    📁 <a class="btn-folder" href="{{ route('file.manager', ['folder' => $file['path']]) }}">{{ $file['name'] }}</a>
                @else
                    🖼️ {{ $file['name'] }}
                @endif
            </td>
            <td>{{ $file['size'] ? round($file['size']/1024, 2).' Ko' : '-' }}</td>
            <td>{{ $file['lastModified'] }}</td>
            <td>
                @if($file['type'] !== 'dir')
                <form method="POST" action="{{ route('file.manager.delete') }}" onsubmit="return confirm('Supprimer {{ $file['name'] }} ?');">
                    @csrf
                    <input type="hidden" name="path" value="{{ $file['path'] }}">
                    <button type="submit" class="btn-delete">Supprimer</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
