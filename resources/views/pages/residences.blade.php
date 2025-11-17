@extends('pages.heritage_pages')

@section('dashboard', '- Tableau de bord')

@section('main')
    <!-- Main Content Area (Ajusté pour le Header) -->
    <div class="container-fluid mx-4 px-4 py-2 mt-2">

        <!-- Titre Principal de la Page -->
        <h1 class="text-3xl lg:text-4xl font-extrabold text-indigo-700 mb-8 text-center border-b-4 border-indigo-500 pb-3">
            <i class="fas fa-home mr-3 text-3xl"></i> Mes Résidences
        </h1>

        @if($residences->isEmpty())
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-6 rounded-lg text-center shadow-lg mx-auto max-w-lg">
                <i class="fas fa-info-circle text-2xl mb-2 block"></i>
                <p class="font-semibold text-lg">Vous n'avez aucune résidence enregistrée.</p>
                <p class="text-sm mt-1">Utilisez le menu latéral pour la mise en ligne.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-col-2 md:grid-cols-2 xl:grid-cols-4 lg:grid-cols-3 gap-4">
                @foreach($residences as $residence)
                    <div class="bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col hover:shadow-indigo-300/50 transition duration-300 transform hover:scale-[1.01] border border-gray-100">
                        @php
                           $images = $residence->img;
                            if (is_string($images)) {
                                $images = json_decode($images, true) ?? [];
                            };
                            $firstImage = $images[0] ?? null;
                            $imagePath = $firstImage? $firstImage // URL S3 déjà complète
                            : 'https://placehold.co/400x250/E0E7FF/4F46E5?text=Pas+d\'image';
                        @endphp

                        <a href="{{ $imagePath }}" class="glightbox block" data-gallery="residence-{{ $residence->id }}" data-title="{{ $residence->nom }}">
                            <img src="{{ $imagePath }}" class="w-full h-48 object-cover transition duration-300 hover:opacity-90"
                                onerror="this.onerror=null;this.src='https://placehold.co/400x250/E0E7FF/4F46E5?text=Pas+d\'image';"
                                alt="Image de la résidence">
                        </a>


                        {{-- Galerie invisible pour les autres images --}}
                        {{-- Galerie invisible pour les autres images --}}
                        @if (is_array($images))
                            @foreach($images as $key => $image)
                                @if($key > 0)
                                    {{-- Utiliser l'URL directe (pas asset() si l'URL est déjà complète) --}}
                                    <a href="{{ $image }}"
                                    class="glightbox"
                                    data-gallery="residence-{{ $residence->id }}"
                                    data-title="{{ $residence->nom }}"
                                    hidden></a>
                                @endif
                            @endforeach
                        @endif


                        <div class="p-6 flex flex-col flex-grow">
                            <h5 class="text-xl font-extrabold text-indigo-800 mb-2 border-b border-gray-100 pb-2 truncate">{{ $residence->nom }}</h5>
                            <p class="text-gray-600 mb-4 text-sm flex-grow">
                                {{ Str::limit($residence->description, 100) }}
                            </p>
                            <ul class="space-y-2 text-sm text-gray-700 mt-auto pt-4 border-t border-gray-100 font-medium">
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-500"><i class="fas fa-bed mr-2 text-indigo-400"></i> Chambres :</span>
                                    <span class="text-gray-900 font-bold">{{ $residence->nombre_chambres }}</span>
                                </li>
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-500"><i class="fas fa-couch mr-2 text-indigo-400"></i> Salons :</span>
                                    <span class="text-gray-900 font-bold">{{ $residence->nombre_salons }}</span>
                                </li>
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-500"><i class="fas fa-city mr-2 text-indigo-400"></i> Ville :</span>
                                    <span class="text-gray-900">{{ $residence->ville }}</span>
                                </li>

                                @if($residence->disponible == 0 )
                                    <li class="flex justify-between items-center">
                                        <span class="text-gray-500"><i class="fas fa-city mr-2 text-indigo-400"></i> Disponibilité :</span>
                                        <span class="text-gray-900">Indisponible</span>
                                    </li>

                                @else
                                    <li class="flex justify-between items-center">
                                        <span class="text-gray-500"><i class="fas fa-city mr-2 text-indigo-400"></i> Disponibilité :</span>
                                        <span class="text-gray-900">Disponible</span>
                                    </li>
                                @endif


                                <li class="flex justify-between items-center text-lg pt-2">
                                    <span class="text-gray-500"><i class="fas fa-money-bill-wave mr-2 text-green-500"></i> Prix / Jour :</span>
                                    <span class="text-green-600 font-extrabold">{{ number_format($residence->prix_journalier, 0, ',', ' ') }} €</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

