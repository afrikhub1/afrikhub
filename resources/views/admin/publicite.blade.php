@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Gestion des Publicités</h2>

    <form method="POST" action="{{ route('publicites.store') }}" class="mb-4">
        @csrf
        <input name="icone" placeholder="🔥" class="form-control mb-2">
        <input name="titre" placeholder="Texte de la pub" class="form-control mb-2" required>
        <input name="lien" placeholder="Lien (optionnel)" class="form-control mb-2">
        <input name="ordre" type="number" placeholder="Ordre" class="form-control mb-2">
        <button class="btn btn-success">Ajouter</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Ordre</th>
                <th>Pub</th>
                <th>Statut</th>
                <th>Actions</th>
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
                <td class="d-flex gap-1">
                    <form method="POST" action="{{ route('publicites.toggle', $pub) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-warning btn-sm">On / Off</button>
                    </form>

                    <form method="POST" action="{{ route('publicites.destroy', $pub) }}">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
