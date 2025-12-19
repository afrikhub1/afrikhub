@extends('admin.header_footer')

@section('title', 'Modifier Publicité')

@section('main')
<div class="container py-4">
    <h2 class="mb-4 text-primary">✏️ Modifier la Publicité</h2>

   <form method="POST" action="{{ route('publicites.update', $publicite) }}">
        @csrf
        @method('PUT')

        {{-- Sélection icône --}}
        <div class="mb-3">
            <label>Icône</label>
            <select name="icone" class="form-select" required>
                <option value="" disabled>Choisir une icône</option>

                {{-- Alertes / Notifications --}}
                <option value="fas fa-bell" {{ $publicite->icone == 'fas fa-bell' ? 'selected' : '' }}>🔔 Bell</option>
                <option value="fas fa-exclamation-triangle" {{ $publicite->icone == 'fas fa-exclamation-triangle' ? 'selected' : '' }}>⚠️ Warning</option>
                <option value="fas fa-bullhorn" {{ $publicite->icone == 'fas fa-bullhorn' ? 'selected' : '' }}>📢 Bullhorn</option>

                {{-- Actions / Général --}}
                <option value="fas fa-home" {{ $publicite->icone == 'fas fa-home' ? 'selected' : '' }}>🏠 Home</option>
                <option value="fas fa-info-circle" {{ $publicite->icone == 'fas fa-info-circle' ? 'selected' : '' }}>ℹ️ Info</option>
                <option value="fas fa-lightbulb" {{ $publicite->icone == 'fas fa-lightbulb' ? 'selected' : '' }}>💡 Light</option>

                {{-- Social / Favoris --}}
                <option value="fas fa-heart" {{ $publicite->icone == 'fas fa-heart' ? 'selected' : '' }}>❤️ Heart</option>
                <option value="fas fa-star" {{ $publicite->icone == 'fas fa-star' ? 'selected' : '' }}>⭐ Star</option>
                <option value="fas fa-thumbs-up" {{ $publicite->icone == 'fas fa-thumbs-up' ? 'selected' : '' }}>👍 Like</option>

                {{-- Argent / Cadeaux --}}
                <option value="fas fa-money-bill-wave" {{ $publicite->icone == 'fas fa-money-bill-wave' ? 'selected' : '' }}>💰 Money</option>
                <option value="fas fa-gift" {{ $publicite->icone == 'fas fa-gift' ? 'selected' : '' }}>🎁 Gift</option>

                {{-- Autres fun --}}
                <option value="fas fa-fire" {{ $publicite->icone == 'fas fa-fire' ? 'selected' : '' }}>🔥 Fire</option>
                <option value="fas fa-smile" {{ $publicite->icone == 'fas fa-smile' ? 'selected' : '' }}>😄 Smile</option>
                <option value="fas fa-paper-plane" {{ $publicite->icone == 'fas fa-paper-plane' ? 'selected' : '' }}>✈️ Paper Plane</option>
            </select>
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
