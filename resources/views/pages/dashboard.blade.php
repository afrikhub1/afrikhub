@extends('pages.heritage_pages')

@section('dashboard', '- Tableau de bord')

@section('main')
    <div class="container-fluid px-2 py-2 mt-2">
        <main class="bg-white p-3 md:p-6 rounded-xl shadow-2xl border border-gray-200">

            <section id="occupees" class="mb-10">
                <h2 class="font-extrabold text-gray-900 mb-8 text-center border-b-4 border-indigo-500 pb-3 text-lg md:text-2xl">
                    <i class="fas fa-key text-indigo-500 mr-3"></i> Résidences occupées
                </h2>

                <div class="w-full">
                    @if($residences_occupees->isEmpty())
                        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg text-center shadow-inner">
                            <i class="fas fa-info-circle mr-2"></i> Aucune résidence actuellement occupée.
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($residences_occupees as $res_occ)
                            <div class="bg-red-50 border-2 border-red-400 rounded-xl shadow-lg p-5 flex flex-col justify-between">
                                <div>
                                    <h5 class="font-bold text-red-800 mb-3 flex items-center text-base truncate">
                                        <i class="fas fa-building mr-3 text-red-600"></i> {{ $res_occ->nom }}
                                    </h5>
                                    <p class="text-sm mb-2"><strong>Prix journalier :</strong> {{ number_format($res_occ->prix_journalier, 0, ',', ' ') }} FCFA</p>
                                    <p class="text-sm mb-2"><strong>Fin :</strong> {{ $res_occ->date_disponible_apres }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <section id="historique" class="mb-10">
                <h2 class="font-extrabold text-gray-900 mb-8 text-center border-b-4 border-indigo-500 pb-3 text-lg md:text-2xl">
                    <i class="fas fa-history text-indigo-500 mr-3"></i> Demandes reçues
                </h2>

                @if($reservation_reçu->isEmpty())
                    <div class="bg-blue-100 border border-blue-200 text-blue-700 p-4 rounded-lg text-center">
                        <i class="fas fa-info-circle mr-2"></i> Aucun historique de réservation trouvé.
                    </div>
                @else
                    <ul class="divide-y divide-gray-200 border border-gray-200 rounded-xl overflow-hidden shadow-lg">
                        @foreach($reservation_reçu as $res_recu)
                        <li class="p-4 bg-white hover:bg-gray-50 transition">
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-3">
                                <div class="w-full">
                                    <p class="text-gray-800 font-medium leading-tight">
                                        <strong class="uppercase text-indigo-700 block sm:inline">{{ $res_recu->residence->nom }}</strong>
                                        <span class="text-sm text-gray-500 block sm:inline"> réservée par Mr/Mme <strong>{{ $res_recu->client }}</strong>.</span>
                                    </p>
                                </div>
                                {{-- Status Badges --}}
                                <div class="shrink-0">
                                    @php
                                        $statusClasses = [
                                            'confirmée' => 'bg-green-500',
                                            'payéé' => 'bg-green-500',
                                            'en attente' => 'bg-yellow-500',
                                            'refusée' => 'bg-red-500',
                                            'annulée' => 'bg-red-500'
                                        ];
                                        $bgColor = $statusClasses[$res_recu->status] ?? 'bg-gray-500';
                                    @endphp
                                    <span class="text-xs px-3 py-1 {{ $bgColor }} text-white font-bold rounded-full shadow-sm">
                                        {{ $res_recu->status }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-3 grid grid-cols-1 gap-1 text-xs text-gray-500">
                                <p><i class="fas fa-calendar-alt mr-1"></i> Du {{ \Carbon\Carbon::parse($res_recu->date_arrivee)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($res_recu->date_depart)->format('d/m/Y') }}</p>
                                <p class="text-gray-400">Créé le {{ \Carbon\Carbon::parse($res_recu->create_at)->format('d/m/Y') }}</p>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @endif
            </section>

            <section id="reservation" class="mb-10 border-t pt-8 border-gray-200">
                <h2 class="font-extrabold text-gray-900 mb-8 text-center border-b-4 border-indigo-500 pb-3 text-lg md:text-2xl">
                    <i class="fas fa-home text-indigo-500 mr-3"></i> Mes Résidences
                </h2>

                @if($residences->isEmpty())
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg shadow-md text-center">
                        <i class="fas fa-info-circle mr-2"></i> Aucune résidence enregistrée.
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($residences as $res)
                            @php
                                $images = is_string($res->img) ? json_decode($res->img, true) ?? [] : $res->img;
                                $imagePath = $images[0] ?? "https://placehold.co/400x250/E0E7FF/4F46E5?text=Pas+d'image";
                            @endphp

                            <div class="bg-white border border-gray-200 rounded-2xl shadow-md hover:shadow-xl transition-all flex flex-col overflow-hidden">
                                <div class="relative h-48 w-full">
                                    <a href="{{ $imagePath }}" class="glightbox" data-gallery="res-{{ $res->id }}">
                                        <img src="{{ $imagePath }}" class="w-full h-full object-cover" alt="Résidence">
                                    </a>
                                </div>

                                <div class="p-4 flex flex-col flex-grow">
                                    <div class="uppercase font-bold text-gray-800 mb-3 border-b border-indigo-100 pb-2 truncate text-center">
                                        {{ $res->nom }}
                                    </div>

                                    <ul class="text-xs text-gray-700 space-y-2 mb-4">
                                        <li class="flex justify-between"><strong>Chambres:</strong> <span>{{ $res->nombre_chambres }} <i class="fas fa-door-closed text-indigo-400"></i></span></li>
                                        <li class="flex justify-between"><strong>Prix/Jour:</strong> <span class="text-green-600 font-bold">{{ number_format($res->prix_journalier, 0, ',', ' ') }} F</span></li>
                                        <li class="flex justify-between"><strong>Ville:</strong> <span>{{ $res->ville }}</span></li>
                                    </ul>

                                    <div class="mt-auto">
                                        <span class="{{ $res->disponible == 1 ? 'bg-green-500' : 'bg-red-500' }} block w-full py-2 text-white text-xs font-bold rounded-lg text-center shadow">
                                            <i class="{{ $res->disponible == 1 ? 'fas fa-check-circle' : 'fas fa-bed' }} mr-1"></i>
                                            {{ $res->disponible == 1 ? 'Disponible' : 'Occupée' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </main>
    </div>
@endsection