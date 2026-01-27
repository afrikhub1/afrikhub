@extends('pages.heritage_pages')

@section('title', 'Résidences Occupées')

@section('main')
    <div class="container-fluid px-2 py-2 mt-2">

        <main class="bg-white p-6 md:p-8 rounded-xl shadow-2xl border border-gray-200">
            <h1 class="text-2xl font-extrabold text-red-600 mb-8 text-center border-b-4 border-red-500 pb-3">
                <i class="fas fa-lock-open text-2xl mr-3"></i> Résidences Occupées
            </h1>

            <section id="occupees">
                @if($residences_occupees->isEmpty())
                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 p-6 rounded-lg text-center shadow-lg">
                        <i class="fas fa-info-circle text-2xl mb-2 block"></i>
                        <p class="font-semibold text-lg">Aucune résidence n'est actuellement occupée.</p>
                        <p class="text-sm mt-1">Les résidences disponibles ne figurent pas dans cette liste.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 xs:grid-col-2 sm:grid-col-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4  gap-4">
                       @foreach($residences_occupees as $res_occupees)
                            {{-- On vérifie que $res_occupees n'est pas nul avant d'afficher --}}
                            @if($res_occupees)
                                <div class="w-full sm:w-[320px] bg-red-50 border-2 border-red-400 rounded-xl shadow-2xl p-6 flex flex-col justify-between">
                                    <div>
                                        <h5 class="text-xl font-bold text-red-800 mb-3 flex items-center">
                                            <i class="fas fa-building mr-3 text-red-600"></i>
                                            {{-- Le ?? évite l'erreur si le nom est vide en base --}}
                                            {{ $res_occupees->nom ?? 'Résidence sans nom' }}
                                        </h5>

                                        <p class="text-sm mb-2"><strong>Ville :</strong> {{ $res_occupees->ville ?? 'N/A' }}</p>
                                        <p class="text-sm mb-2"><strong>Pays :</strong> {{ $res_occupees->pays ?? 'N/A' }}</p>
                                        <p class="text-sm mb-2"><strong>Prix journalier :</strong> {{ number_format($res_occupees->prix_journalier ?? 0, 0, ',', ' ') }} FCFA</p>

                                        <div class="mt-4 p-2 bg-red-100 rounded text-red-700 text-xs font-bold uppercase text-center">
                                            <i class="fas fa-user-lock mr-1"></i> Statut : Occupée
                                        </div>
                                    </div>

                                    <a href="{{ route('sejour.interrompre', $res_occupees->id) }}" class="text-sm w-full bg-red-600 text-white p-3 rounded-lg font-semibold mt-6 text-center hover:bg-red-700 transition shadow-md">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Libérer la Résidence
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </section>
        </main>
    </div>
@endsection
