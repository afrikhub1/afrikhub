
@extends('pages.heritage_pages')

@section('dashboard', '- Tableau de bord')

@section('main')
    <!-- Main Content Area (avec votre padding original pour compenser le header) -->
    <div class="container mx-auto p-2 mt-4">

        <!-- Simulation Message d'alerte (Static) -->
        <div id="alert-message" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-8 shadow-lg" role="alert">
            <strong class="font-bold">Succès !</strong>
            <span class="block sm:inline">Résidence marquée comme occupée. (Message statique)</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="document.getElementById('alert-message').classList.add('hidden')">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.697l-2.651 3.152a1.2 1.2 0 1 1-1.697-1.697l3.152-2.651-3.152-2.651a1.2 1.2 0 1 1 1.697-1.697l2.651 3.152 2.651-3.152a1.2 1.2 0 0 1 1.697 1.697l-3.152 2.651 3.152 2.651a1.2 1.2 0 0 1 0 1.697z"/></svg>
            </span>
        </div>

        <main class="bg-white p-6 md:p-8 rounded-xl shadow-2xl border border-gray-200">

            <!-- Résidences Occupées -->
            <section id="occupees" class="mb-10 row m-0">
                <h2 class="text-3xl font-extrabold text-red-600 mb-6 flex items-center border-b pb-2">
                    <i class="fas fa-key text-2xl mr-3"></i> Mes Résidences Occupées
                </h2>
                <div class="p-2 d-flex">
                    {{-- Filtrage des réservations confirmées directement dans la vue (approche Blade) --}}

                    @if($residences_occupees->isEmpty())
                        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg text-center shadow-inner">
                            <i class="fas fa-info-circle mr-2"></i> Vous n'avez aucune résidence actuellement occupée.
                        </div>
                    @else
                        <div class="flex flex-wrap gap-4">
                            @foreach($residences_occupees as $residences_occupees)
                            <div class="w-full sm:w-[320px] bg-red-50 border-2 border-red-400 rounded-xl shadow-2xl p-6 flex flex-col justify-between">
                                <div>
                                    <h5 class="text-2xl font-bold text-red-800 mb-3 flex items-center">
                                        <i class="fas fa-building mr-3 text-red-600"></i> {{ $residences_occupees->nom }}
                                    </h5>
                                    <p class="text-sm mb-2"><strong>Occupant :</strong> {{ $residences_occupees->client }}</p>
                                    <p class="text-sm mb-2"><strong>Reference :</strong> {{ $residences_occupees->reservation_code }}</p>
                                    <p class="text-sm mb-2"><strong>Totalr :</strong> {{ number_format($residences_occupees->total, 0, ',', ' ') }} FCFA</p>
                                    <p class="text-sm mb-2"><strong>Statut :</strong> {{ $residences_occupees->status }}</p>
                                    <p class="text-sm mb-2"><strong>Arrivée :</strong> {{ $residences_occupees->date_arrivee }}</p>
                                    <p class="text-sm mb-2"><strong>Depart :</strong> {{ $residences_occupees->date_depart }}</p>
                                </div>
                                <button class="w-full bg-red-600 text-white p-3 rounded-lg font-semibold mt-6 hover:bg-red-700 transition duration-150 transform hover:scale-[1.02] shadow-md hover:shadow-lg">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Libérer la Résidence
                                </button>
                            </div>
                        @endforeach
                        </div>
                    @endif
                </div>
            </section>

            <!-- Historique des Réservations -->
            <section id="historique" class="mb-10">
                <h2 class="text-3xl font-extrabold text-indigo-600 mb-6 flex items-center border-b pb-2">
                    <i class="fas fa-history text-2xl mr-3"></i> Historique des Demandes de Location
                </h2>

                @if($reservation_reçu->isEmpty())
                    <div class="bg-blue-100 border border-blue-200 text-blue-700 p-4 rounded-lg text-center shadow-inner">
                        <i class="fas fa-info-circle mr-2"></i> Aucun historique de réservation trouvé.
                    </div>
                @else
                    <ul class="divide-y divide-gray-200 border border-gray-200 rounded-xl overflow-hidden shadow-lg">
                        @foreach($reservation_reçu as $reservation_reçu)
                        <li class="p-4 bg-white hover:bg-gray-50 transition duration-150">
                            <div class="flex justify-between items-start flex-wrap gap-2">
                                <p class="text-gray-800 font-medium">
                                    <strong class="uppercase text-indigo-700">{{ $reservation_reçu->residence->nom }}</strong>
                                    <span class="text-sm text-gray-500">réservée par Mr/Mme <strong>{{ $reservation_reçu->client }}</strong>.</span>
                                </p>
                                {{-- Badge de Statut --}}
                                @if($reservation_reçu->status === 'confirmée')
                                    <span class="text-sm px-3 py-1 bg-green-500 text-white font-bold rounded-full capitalize shadow-md">Accepté</span>
                                @elseif($reservation_reçu->status === 'en_attente')
                                    <span class="text-sm px-3 py-1 bg-yellow-500 text-white font-bold rounded-full capitalize shadow-md">En attente</span>
                                @elseif($reservation_reçu->status === 'refusée')
                                    <span class="text-sm px-3 py-1 bg-red-500 text-white font-bold rounded-full capitalize shadow-md">Refusé</span>
                                @elseif($reservation_reçu->status == 'payé')
                                    <span class="text-sm px-3 py-1 bg-green-500 text-white font-bold rounded-full capitalize shadow-md">payé</span>
                                @else
                                    <span class="text-sm px-3 py-1 bg-gray-500 text-white font-bold rounded-full capitalize shadow-md">Inconnu</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-calendar-alt mr-1"></i> Période : du **{{ \Carbon\Carbon::parse($reservation_reçu->date_arrivee)->format('d/m/Y') }}** au **{{ \Carbon\Carbon::parse($reservation_reçu->date_depart)->format('d/m/Y') }}**
                            </p>
                            <div class="text-xs text-gray-400 mt-2">
                                Réservée le {{ \Carbon\Carbon::parse($reservation_reçu->create_at)->format('d/m/Y') }} | Validée le {{ \Carbon\Carbon::parse($reservation_reçu->date_validation)->format('d/m/Y') }}
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @endif
            </section>

            <!-- SECTION PRINCIPALE DES RÉSIDENCES (avec Carrousel GLightbox) -->
            <section id="reservation" class="mb-10 border-t pt-8 border-gray-200">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-8 text-center border-b-4 border-indigo-500 pb-3">
                    <i class="fas fa-home text-indigo-500 mr-3"></i> Toutes Mes Résidences en Gestion
                </h2>

                @if($residences->isEmpty())
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg shadow-md text-center">
                        <i class="fas fa-info-circle mr-2"></i> Vous n'avez aucune résidence enregistrée.
                    </div>
                @else
                    <div class="album-container flex flex-wrap gap-8 justify-center bg-gray-50 p-2  rounded-2xl shadow-inner border border-gray-100">

                        @foreach($residences as $res)
                            @php
                                // Décodage JSON des images si nécessaire
                                $images = is_string($res->img) ? json_decode($res->img, true) ?? [] : $res->img;

                                $firstImage = $images[0] ?? null;
                                $imagePath = $firstImage
                                    ?: "https://placehold.co/400x250/E0E7FF/4F46E5?text=Pas+d'image";
                            @endphp

                            <div class="bg-white border border-gray-200 rounded-2xl shadow-xl
                                transition duration-500 hover:shadow-indigo-400/50
                                flex flex-col items-center
                                w-full sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5
                                p-2 sm:p-3 md:p-4">

                                <!-- Image principale cliquable pour GLightbox -->
                                <div class="w-full">
                                    <a href="{{ $imagePath }}"
                                    class="glightbox block relative"
                                    data-gallery="residence-{{ $res->id }}"
                                    data-title="{{ $res->nom }}">

                                        <img src="{{ $imagePath }}"
                                            class="w-full h-48 object-cover transition duration-300 hover:opacity-90"
                                            onerror="this.onerror=null;this.src='https://placehold.co/400x250/E0E7FF/4F46E5?text=Pas+d\'image';"
                                            alt="Image de la résidence">
                                    </a>
                                </div>

                                <!-- Images supplémentaires invisibles pour la galerie -->
                                @if(is_array($images))
                                    @foreach($images as $key => $image)
                                        @if($key > 0)
                                            <a href="{{ $image }}"
                                            class="glightbox"
                                            data-gallery="residence-{{ $res->id }}"
                                            data-title="{{ $res->nom }}"
                                            style="display:none;">
                                            </a>
                                        @endif
                                    @endforeach
                                @endif

                                <!-- Nom résidence -->
                                <div class="text-lg uppercase font-bold text-gray-800 mb-3
                                            border-b border-indigo-300 w-full text-center pb-2 truncate">
                                    {{ $res->nom }}
                                </div>

                                <!-- Infos -->
                                <ul class="text-sm text-gray-700 w-full space-y-1 mb-4">
                                    <li class="flex justify-between items-center">
                                        <strong class="text-gray-600">Chambres :</strong>
                                        <span>{{ $res->nombre_chambres }} <i class="fas fa-door-closed text-indigo-500"></i></span>
                                    </li>

                                    <li class="flex justify-between items-center">
                                        <strong class="text-gray-600">Salons :</strong>
                                        <span>{{ $res->nombre_salons }} <i class="fas fa-couch text-indigo-500"></i></span>
                                    </li>

                                    <li class="flex justify-between items-center">
                                        <strong class="text-gray-600">Prix/Jour :</strong>
                                        <span class="text-green-600 font-semibold">{{ $res->prix_journalier }} €</span>
                                    </li>

                                    <li class="flex justify-between items-center">
                                        <strong class="text-gray-600">Ville :</strong>
                                        <span>{{ $res->ville }} <i class="fas fa-map-marker-alt text-indigo-500"></i></span>
                                    </li>
                                </ul>

                                <!-- Badge Statut -->
                                @if(isset($res->status) && $res->status === 'occupee')
                                    <span class="bg-red-500 w-full p-3 text-white font-bold rounded-xl text-center
                                                shadow-lg transition duration-150">
                                        <i class="fas fa-bed mr-2"></i> Déjà Occupée
                                    </span>
                                @else
                                    <span class="bg-green-500 w-full p-3 text-white font-bold rounded-xl text-center
                                                shadow-lg transition duration-150">
                                        <i class="fas fa-check-circle mr-2"></i> Disponible
                                    </span>
                                @endif
                            </div>
                        @endforeach

                    </div>
                @endif
            </section>
        </main>
    </div>
@endsection

@section('script')
    <script>
    const lightbox = GLightbox({
        selector: '.glightbox'
    });
</script>

@endsection

