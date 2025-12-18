@extends('admin.header_footer')

@section('title', 'Gestion des Publicités')

@section('main')
<div class="container py-4">
    <h2 class="mb-4 text-primary">📢 Gestion des Publicités</h2>

    {{-- Formulaire d’ajout de pub --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            Ajouter une nouvelle publicité
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('publicites.store') }}" class="row g-2">
                @csrf
                <div class="col-md-1">
                    <input name="icone" placeholder="🔥" class="form-control">
                </div>
                <div class="col-md-5">
                    <input name="titre" placeholder="Texte de la pub" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <input name="lien" placeholder="Lien (optionnel)" class="form-control">
                </div>
                <div class="col-md-2">
                    <input name="ordre" type="number" placeholder="Ordre" class="form-control">
                </div>
                <div class="col-md-1 d-grid">
                    <button class="btn btn-success"><i class="fas fa-plus"></i> Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Liste des pubs --}}
    <div class="table-responsive shadow-sm">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Ordre</th>
                    <th>Pub</th>
                    <th>Statut</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($publicites as $pub)
                <tr>
                    <td>{{ $pub->ordre }}</td>
                    <td>{{ $pub->icone }} {{ $pub->titre }}</td>
                    <td>
                        @if($pub->actif)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td class="d-flex justify-content-center gap-1">
                        {{-- Bouton activer / désactiver --}}
                        <form method="POST" action="{{ route('publicites.toggle', $pub) }}">
                            @csrf @method('PATCH')
                            <button class="btn btn-warning btn-sm">
                                <i class="fas fa-toggle-on"></i>
                            </button>
                        </form>

                        {{-- Bouton modifier --}}
                        <a href="{{ route('publicites.update', $pub) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>

                        {{-- Bouton supprimer --}}
                        <form method="POST" action="{{ route('publicites.destroy', $pub) }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
