@extends('admin.header_footer')

@section('title', 'Modifier Publicité')

@section('main')
<div class="max-w-3xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-xl shadow-lg">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Modifier Publicité</h1>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Formulaire de modification --}}
    <form action="{{ route('publicites.update', $publicite->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Titre --}}
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 font-medium mb-1" for="titre">Titre</label>
            <input type="text" name="titre" id="titre" value="{{ old('titre', $publicite->titre) }}"
                   class="w-full px-4 py-2 rounded border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dar
