@extends('admin.header_footer')
@section('title', 'Modifier image carrousel')

@section('main')
<div class="container py-4">
    <h2>Modifier une image du carrousel</h2>

    <form method="POST" action="{{ route('carousels.update', $carousel) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Image actuelle</label>
            <img src="{{ asset('storage/'.$carousel->image) }}" class="img-fluid mb-2">
        </div>

        <div class="mb-3">
            <label>Changer l'image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label>Titre</label>
            <input type="text" name="titre" class="form-control" value="{{ $carousel->titre }}">
        </div>

        <div class="mb-3">
            <label>Lien</label>
            <input type="url" name="lien" class="form-control" value="{{ $carousel->lien }}">
        </div>

        <div class="mb-3">
            <label>Ordre</label>
            <input type="number" name="ordre" class="form-control" value="{{ $carousel->ordre }}">
        </div>

        <button class="btn btn-success">💾 Enregistrer</button>
        <a href="{{ route('carousels.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
