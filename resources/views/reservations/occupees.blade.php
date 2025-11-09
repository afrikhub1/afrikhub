@extends('layouts.app') {{-- adapte selon ton layout --}}

@section('content')
<div class="container py-5">

    <h2 class="mb-4 text-center fw-bold">Résidences Occupées</h2>

    @if($residences->isEmpty())
        <div class="alert alert-info text-center">
            Vous n'avez actuellement aucune résidence occupée.
        </div>
    @else

        <div class="row g-4">
            @foreach ($residences as $residence)
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-3">

                        {{-- Image (si tu as une relation images) --}}
                        @if(isset($residence->images) && $residence->images->count() > 0)
                            <img src="{{ asset('storage/' . $residence->images->first()->chemin) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/400x200?text=Pas+d'image" class="card-img-top">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $residence->nom }}</h5>

                            <p class="text-muted mb-1">
                                <i class="bi bi-geo-alt"></i> {{ $residence->ville }}, {{ $residence->pays }}
                            </p>

                            <p class="fw-semibold mb-1">
                                <i class="bi bi-currency-dollar"></i> {{ number_format($residence->prix_journalier, 0, ',', ' ') }} Fcfa / nuit
                            </p>

                            <span class="badge bg-danger">Occupée</span>

                            <hr>

                            {{-- Bouton Libérer --}}
                            <form action="{{ route('residences.liberer', $residence->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    Libérer la résidence
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @endif

</div>
@endsection
