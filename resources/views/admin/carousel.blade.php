@extends('admin.header_footer')
@section('title', 'Ajouter une image carrousel')

@section('main')
<div class="container py-4">
    <h2>Ajouter une image au carrousel</h2>

    {{-- 🔹 Liste des carousels actifs --}}
    <h4 class="mt-4">Carousels actifs</h4>
    @if($carousels->count() > 0)
        <div class="row">
            @foreach($carousels as $carousel)
                <div class="col-md-3 mb-3">
                    <div class="card">
                        <img src="{{ Storage::disk('s3')->url($carousel->image) }}"
                             class="card-img-top"
                             alt="{{ $carousel->titre ?? 'Carousel' }}"
                             style="height:150px; object-fit:cover;">
                        <div class="card-body p-2">
                            <p class="mb-1"><strong>Titre:</strong> {{ $carousel->titre ?? '-' }}</p>
                            <p class="mb-1"><strong>Ordre:</strong> {{ $carousel->ordre }}</p>
                            @if($carousel->lien)
                                <a href="{{ $carousel->lien }}" target="_blank" class="btn btn-sm btn-primary w-100">Voir lien</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Aucun carousel actif pour le moment.</p>
    @endif

    {{-- 🔹 Formulaire d'ajout --}}
    <form method="POST" action="{{ route('carousels.store') }}" enctype="multipart/form-data" class="mt-4">
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
