@extends('pages.heritage_pages')

@section('title', 'Tableau de bord')

@section('main')
    {{-- On force le overflow-x-hidden sur le parent pour stopper tout glissement horizontal --}}
    <div class="container-fluid px-2 py-2 mt-2 overflow-x-hidden">

        <main class="bg-white p-2 md:p-6 rounded-xl shadow-2xl border border-gray-200">

            <section id="occupees" class="mb-8">
                <h2 class="font-extrabold text-gray-900 mb-6 text-center border-b-2 border-indigo-500 pb-2 text-sm md:text-xl uppercase tracking-wider">
                    <i class="fas fa-key text-indigo-500 mr-2"></i> Résidences occupées
                </h2>

                @if($residences_occupees->isEmpty())
                    <div class="bg-red-50 text-red-700 p-3 rounded-lg text-center text-xs md:text-sm border border-red-100">
                        <i class="fas fa-info-circle mr-2"></i> Aucune résidence occupée.
                    </div>
                @else
                    {{-- Grid auto-adaptatif --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($residences_occupees as $res_occ)
                        <div class="bg-red-50 border border-red-300 rounded-lg p-3 shadow-sm">
                            <h5 class="font-bold text-red-800 text-xs md:text-sm truncate mb-2">
                                <i class="fas fa-building mr-2"></i> {{ $res_occ->nom }}
                            </h5>
                            <div class="text-[10px] md:text-xs space-y-1">
                                <p><strong>Prix :</strong> {{ number_format($res_occ->prix_journalier, 0, ',', ' ') }} F</p>
                                <p class="text-red-600"><strong>Libre le :</strong> {{ $res_occ->date_disponible_apres }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <section id="historique" class="mb-8">
                <h2 class="font-extrabold text-gray-900 mb-6 text-center border-b-2 border-indigo-500 pb-2 text-sm md:text-xl uppercase tracking-wider">
                    <i class="fas fa-history text-indigo-500 mr-2"></i> Demandes reçues
                </h2>

                @if($reservation_reçu->isEmpty())
                    <div class="bg-gray-50 text-gray-500 p-3 rounded-lg text-center text-xs">
                        Aucun historique.
                    </div>
                @else
                    {{-- Utilisation de overflow-hidden pour que la liste ne dépasse jamais --}}
                    <div class="border border-gray-200 rounded-xl overflow-hidden shadow-md">
                        <ul class="divide-y divide-gray-100">
                            @foreach($reservation_reçu as $res_recu)
                            <li class="p-3 bg-white hover:bg-gray-50">
                                <div class="flex flex-col sm:flex-row justify-between items-start gap-2">
                                    <div class="max-w-full overflow-hidden">
                                        <p class="text-[11px] md:text-sm text-gray-800 leading-tight">
                                            <strong class="text-indigo-700 truncate block">{{ $res_recu->residence->nom }}</strong>
                                            <span class="text-gray-500">Par: {{ $res_recu->client }}</span>
                                        </p>
                                    </div>
                                    <span class="text-[9px] md:text-[10px] px-2 py-0.5 bg-indigo-100 text-indigo-700 font-bold rounded uppercase">
                                        {{ $res_recu->status }}
                                    </span>
                                </div>
                                <p class="text-[10px] text-gray-400 mt-2 italic">
                                    Du {{ \Carbon\Carbon::parse($res_recu->date_arrivee)->format('d/m/y') }} au {{ \Carbon\Carbon::parse($res_recu->date_depart)->format('d/m/y') }}
                                </p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </section>

            <section id="reservation" class="pt-4 border-t border-gray-100">
                <h2 class="font-extrabold text-gray-900 mb-6 text-center border-b-2 border-indigo-500 pb-2 text-sm md:text-xl uppercase tracking-wider">
                    <i class="fas fa-home text-indigo-500 mr-2"></i> Mes Résidences
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($residences as $res)
                        @php
                            $images = is_string($res->img) ? json_decode($res->img, true) ?? [] : $res->img;
                            $imagePath = $images[0] ?? "https://placehold.co/400x250/E0E7FF/4F46E5?text=Img";
                        @endphp

                        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow hover:shadow-lg transition-all flex flex-col">
                            {{-- Image fixe --}}
                            <div class="relative h-32 md:h-40 w-full bg-gray-100">
                                <a href="{{ $imagePath }}" class="glightbox">
                                    <img src="{{ $imagePath }}" class="w-full h-full object-cover" alt="Résidence">
                                </a>
                            </div>

                            <div class="p-3 flex flex-col flex-grow">
                                <div class="font-bold text-gray-800 text-[11px] md:text-xs mb-2 truncate uppercase border-b border-gray-50 pb-1">
                                    {{ $res->nom }}
                                </div>

                                <ul class="text-[10px] md:text-[11px] text-gray-600 space-y-1 mb-3">
                                    <li class="flex justify-between"><span>Chambres:</span> <strong>{{ $res->nombre_chambres }}</strong></li>
                                    <li class="flex justify-between"><span>Prix/j:</span> <strong class="text-green-600">{{ number_format($res->prix_journalier, 0, ',', ' ') }} F</strong></li>
                                </ul>

                                <div class="mt-auto">
                                    <span class="{{ $res->disponible == 1 ? 'bg-green-500' : 'bg-red-500' }} block w-full py-1 text-white text-[9px] md:text-[10px] font-bold rounded text-center">
                                        {{ $res->disponible == 1 ? 'DISPONIBLE' : 'OCCUPÉE' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </main>
    </div>
@endsection

@section('script')
<script>
    const lightbox = GLightbox({ selector: '.glightbox' });
</script>
@endsection