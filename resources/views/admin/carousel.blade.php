@extends('admin.header_footer')
@section('title', 'Ajouter une image carrousel')

@section('main')
<div class="container py-4">
    <h2>Ajouter une image au carrousel</h2>

    <form method="POST" action="" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Titre</label>
            <input type="text" name="titre" class="form-control">
        </div>
        <div class="mb-3">
            <label>Lien</label>
            <input type="url" name="lien" class="form-control">
        </div>
        <div class="mb-3">
            <label>Ordre</label>
            <input type="number" name="ordre" class="form-control">
        </div>
        <button class="btn btn-success">💾 Ajouter</button>
        <a href="{{ route('carousels.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
