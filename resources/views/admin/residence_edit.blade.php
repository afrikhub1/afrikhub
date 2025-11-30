@extends('admin.header_footer')

@section('title', 'Modifier la Résidence : ' . $residence->nom)

@section('main')

{{-- Conteneur Principal : Assure le décalage sous le header et la largeur maximale --}}
<div class="max-w-4xl mx-auto pt-10 pb-12 px-4">


    {{-- En-tête de la Page --}}
    <h1 class="text-3xl lg:text-4xl font-extrabold text-indigo-700 mb-8 text-center border-b-4 border-indigo-500 pb-3">
        <i class="fas fa-edit mr-3 text-3xl"></i> Modifier la Résidence : {{ $residence->nom }}
    </h1>

    {{-- Formulaire de Modification (Methode PUT pour la mise à jour) --}}
    {{-- CORRECTION : Changement de la route 'edit' à 'update' pour la soumission --}}
    <form action="{{ route('admin.residences.update', $residence->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-xl shadow-2xl border border-gray-100">
        @csrf
        @method('PUT')

        {{-- ******************************************* --}}
        {{-- SECTION 1 : INFORMATIONS DE BASE --}}
        {{-- ******************************************* --}}
        <fieldset class="border border-gray-300 p-4 rounded-lg mb-6">
            <legend class=" font-semibold text-gray-700 px-2">Informations Générales</legend>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nom de la Résidence --}}
                <div>
                    <label for="nom" class="block  font-medium text-gray-700 mb-1">Nom de la Résidence</label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom', $residence->nom) }}"
                           {{-- AJOUT de la classe d'erreur Tailwind CSS --}}
                           class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none
                                  @error('nom') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 @enderror">
                    @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Prix Journalier --}}
                <div>
                    <label for="prix_journalier" class="block  font-medium text-gray-700 mb-1">Prix Journalier (FCFA)</label>
                    <input type="number" id="prix_journalier" name="prix_journalier" value="{{ old('prix_journalier', $residence->prix_journalier) }}"
                           min="0" step="1000"
                           {{-- AJOUT de la classe d'erreur Tailwind CSS --}}
                           class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none
                                  @error('prix_journalier') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 @enderror">
                    @error('prix_journalier') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-6">
                {{-- Description --}}
                <label for="description" class="block  font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="4"
                          {{-- AJOUT de la classe d'erreur Tailwind CSS --}}
                          class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none
                                 @error('description') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 @enderror">{{ old('description', $residence->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </fieldset>

        {{-- ******************************************* --}}
        {{-- SECTION 2 : LOCALISATION --}}
        {{-- ******************************************* --}}
        <fieldset class="border border-gray-300 p-4 rounded-lg mb-6">
            <legend class=" font-semibold text-gray-700 px-2">Localisation</legend>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Pays --}}
                <div>
                    <label for="pays" class="block  font-medium text-gray-700 mb-1">Pays</label>
                    <input type="text" id="pays" name="pays" value="{{ old('pays', $residence->pays) }}"
                           {{-- AJOUT de la classe d'erreur Tailwind CSS --}}
                           class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none
                                  @error('pays') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 @enderror">
                    @error('pays') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Ville --}}
                <div>
                    <label for="ville" class="block  font-medium text-gray-700 mb-1">Ville</label>
                    <input type="text" id="ville" name="ville" value="{{ old('ville', $residence->ville) }}"
                           {{-- AJOUT de la classe d'erreur Tailwind CSS --}}
                           class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none
                                  @error('ville') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 @enderror">
                    @error('ville') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Quartier --}}
                <div>
                    <label for="quartier" class="block  font-medium text-gray-700 mb-1">Quartier</label>
                    <input type="text" id="quartier" name="quartier" value="{{ old('quartier', $residence->quartier) }}"
                           {{-- AJOUT de la classe d'erreur Tailwind CSS --}}
                           class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 focus:outline-none
                                  @error('quartier') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 @enderror">
                    @error('quartier') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </fieldset>

        {{-- ******************************************* --}}
        {{-- SECTION 3 : ADMINISTRATION ET status --}}
        {{-- ******************************************* --}}
        <fieldset class="border border-gray-300 p-4 rounded-lg mb-6 bg-indigo-50/50">
            <legend class=" font-semibold text-indigo-700 px-2">Paramètres Administratifs</legend>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                {{-- status de Vérification (Select) --}}
                <div>
                    <label for="status" class="block  font-medium text-gray-700 mb-1">status de la Résidence</label>
                    <select id="status" name="status"
                           {{-- AJOUT de la classe d'erreur Tailwind CSS (pour select) --}}
                           class="mt-1 block w-full border rounded-md shadow-sm py-2 px-3 bg-white focus:outline-none
                                  @error('status') border-red-500 focus:ring-red-500 focus:border-red-500 @else border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 @enderror">
                        <option value="vérifiée" {{ old('status', $residence->status) == 'vérifiée' ? 'selected' : '' }}>✅ Vérifiée</option>
                        <option value="en_attente" {{ old('status', $residence->status) == 'en_attente' ? 'selected' : '' }}>⏳ En attente</option>
                        <option value="suspendue" {{ old('status', $residence->status) == 'suspendue' ? 'selected' : '' }}>❌ suspendue</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- ID Propriétaire (Lecture Seule) --}}
                <div>
                    <label for="proprietaire_id" class="block  font-medium text-gray-700 mb-1">ID Propriétaire</label>
                    <input type="text" id="proprietaire_id" value="{{ $residence->proprietaire_id }}" readonly
                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 bg-gray-100 text-gray-500 cursor-not-allowed">
                </div>
            </div>
        </fieldset>

        {{-- ******************************************* --}}
        {{-- SECTION 4 : GESTION DES IMAGES --}}
        {{-- ******************************************* --}}
        <fieldset class="border border-gray-300 p-4 rounded-lg mb-8">
            <legend class=" font-semibold text-gray-700 px-2">Gestion des Images</legend>

            <p class=" text-gray-500 mb-4">
                Pour l'édition, vous pouvez choisir de **remplacer** les images existantes.
            </p>

            <div class="mb-4">
                <label for="img_upload" class="block  font-medium text-gray-700 mb-1">Téléverser de Nouvelles Images (Optionnel)</label>
                <input type="file" id="img_upload" name="img[]" multiple
                       {{-- AJOUT de la classe d'erreur Tailwind CSS (pour input file) --}}
                       class="block w-full  text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file: file:font-semibold
                              @error('img.*') file:bg-red-50 file:text-red-700 hover:file:bg-red-100 @else file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @enderror">
                {{-- Note : Les erreurs d'upload sont souvent sur 'img' ou 'img.*' --}}
                @error('img') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @error('img.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Affichage des images actuelles --}}
            <div class="mt-6">
                <h4 class="text-md font-medium text-gray-700 mb-2">Images Actuelles :</h4>
                <div class="flex flex-wrap gap-3">
                    @php $images = json_decode($residence->img, true) ?? []; @endphp
                    @forelse($images as $image)
                        <div class="relative w-24 h-24 rounded-lg overflow-hidden border border-gray-300 shadow-md">
                            <img src="{{ asset($image) }}" alt="Image actuelle" class="w-full h-full object-cover">
                            {{-- Bouton de suppression d'image individuelle (à connecter en JS/Backend) --}}
                            <button type="button" class="absolute top-0 right-0 p-1 bg-red-500 text-white rounded-bl-lg hover:bg-red-700 text-xs leading-none" title="Supprimer l'image">✕</button>
                        </div>
                    @empty
                        <p class=" text-gray-400">Aucune image enregistrée.</p>
                    @endforelse
                </div>
            </div>
        </fieldset>


        {{-- Boutons d'Action --}}
        <div class="flex justify-end space-x-4 border-t pt-6">
            {{-- Lien de retour (Annuler) --}}
            {{-- CORRECTION : Supposition d'une route plus appropriée pour la liste des résidences --}}
            <a href="{{ route('admin.residences') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition font-medium">
                Annuler
            </a>
            {{-- Bouton de Soumission --}}
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold shadow-lg shadow-indigo-500/50">
                <i class="fas fa-save mr-2"></i> Enregistrer les Modifications
            </button>
        </div>

    </form>
</div>

@endsection

@push('scripts')
    {{-- Les scripts JS spécifiques iront ici --}}
@endpush
