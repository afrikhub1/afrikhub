@extends('admin.header_footer')

@section('titre', 'Demandes interruption')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/admin_residences.css') }}">
@endsection

@section('main')

<div class="container mx-auto p-4">

    <h1 class="text-4xl md:text-5xl font-extrabold text-center text-gray-900 mb-8 drop-shadow-lg">
        <i class="fas fa-stop-circle text-red-500 mr-3"></i>Demandes d'interruption
    </h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4 text-center">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white p-3 rounded mb-4 text-center">{{ session('error') }}</div>
    @endif

    @if($demandes->isEmpty())
        <p class="text-gray-700 text-center">Aucune demande.</p>
    @else

    @endif

</div>

@endsection
