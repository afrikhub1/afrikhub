@extends('admin.header_footer')
@section('title', 'Gestion Carousels')

@section('main')
<div class="container py-4">
    @if (session('success'))
        <div id="alert-success" class="flex justify-between items-center p-4 mb-4 rounded-lg bg-green-50 border-l-4 border-green-600 shadow text-center">
            <div class="w-full">
                <p class="font-bold text-green-700">Succès !</p>
                <p class="text-green-800">{{ session('success') }}</p>
            </div>
            <button onclick="closeAlert('alert-success')" class="text-green-700 hover:text-green-900 ml-3">✕</button>
        </div>
    @endif

    @if (session('danger'))
        <div id="alert-danger" class="flex justify-between items-center p-4 mb-4 rounded-lg bg-red-50 border-l-4 border-red-600 shadow text-center">
            <div class="w-full">
                <p class="font-bold text-red-700">Alerte !</p>
                <p class="text-red-800">{{ session('danger') }}</p>
            </div>
            <button onclick="closeAlert('alert-danger')" class="text-red-700 hover:text-red-900 ml-3">✕</button>
        </div>
    @endif
    <h2>Ajouter une image au carrousel</h2>

    {{-- 🔹 Liste des carousels actifs --}}
    <h4 class="mt-4">Carousels existants</h4>
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
                                <a href="{{ $carousel->lien }}" target="_blank" class="btn btn-sm btn-primary w-100 mb-1">Voir lien</a>
                            @endif
                            <div class="d-flex justify-content-between">
                                {{-- Modifier --}}
                                <a href="{{ route('carousels.edit', $carousel->id) }}" class="btn btn-sm btn-warning">Modifier</a>

                                {{-- Supprimer --}}
                                <form method="POST" action="{{ route('carousels.destroy', $carousel->id) }}"
                                      onsubmit="return confirm('Voulez-vous vraiment supprimer ce carousel ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Supprimer</button>
                                </form>
                            </div>

                            {{-- Activer / Désactiver --}}
                            <form method="POST" action="{{ route('carousels.toggle', $carousel->id) }}" class="mt-1">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm {{ $carousel->actif ? 'btn-success' : 'btn-secondary' }} w-100">
                                    {{ $carousel->actif ? 'Actif' : 'Inactif' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Aucun carousel trouvé.</p>
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
