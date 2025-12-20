@extends('admin.header_footer')
@section('title', 'Modifier image carrousel')

@section('main')
<div class="container py-4">
    <h2>Modifier une image du carrousel</h2>

    <form method="POST" action="{{ route('carousels.update', $carousel) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Image actuelle depuis S3 --}}
        <div class="mb-3">
            <label>Image actuelle</label>
            <img src="{{ Storage::disk('s3')->url($carousel->image) }}" class="img-fluid mb-2" style="max-height: 300px; object-fit: cover;">
        </div>

        {{-- Changer l'image --}}
        <div class="mb-3">
            <label>Changer l'image</label>
            <input type="file" name="image" class="form-control">
            <small class="text-muted">Laisser vide si vous ne souhaitez pas changer l'image.</small>
        </div>

        {{-- Titre --}}
        <div class="mb-3">
            <label>Titre</label>
            <input type="text" name="titre" class="form-control" value="{{ old('titre', $carousel->titre) }}">
        </div>

        {{-- Lien --}}
        <div class="mb-3">
            <label>Lien</label>
            <input type="url" name="lien" class="form-control" value="{{ old('lien', $carousel->lien) }}">
        </div>

        {{-- Ordre --}}
        <div class="mb-3">
            <label>Ordre</label>
            <input type="number" name="ordre" class="form-control" value="{{ old('ordre', $carousel->ordre) }}">
        </div>

        {{-- Boutons --}}
        <button type="submit" class="btn btn-success">💾 Enregistrer</button>
        <a href="{{ route('carousels.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
