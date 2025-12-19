@extends('admin.header_footer')

@section('title', 'Modifier Publicité')

@section('main')
<div class="container py-4">
    <h2 class="mb-4 text-primary">✏️ Modifier la Publicité</h2>

    <form method="POST" action="{{ route('publicites.update', $publicite) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Icône</label>
            <input name="icone" class="form-control" value="{{ $publicite->icone }}">
        </div>
        <div class="mb-3">
            <label>Titre</label>
            <input name="titre" class="form-control" value="{{ $publicite->titre }}" required>
        </div>
        <div class="mb-3">
            <label>Lien</label>
            <input name="lien" class="form-control" value="{{ $publicite->lien }}">
        </div>
        <div class="mb-3">
            <label>Ordre</label>
            <input name="ordre" type="number" class="form-control" value="{{ $publicite->ordre }}">
        </div>
        <button class="btn btn-success">💾 Enregistrer</button>
        <a href="{{ route('publicites.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
