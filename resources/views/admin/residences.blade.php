@extends('admin.header_footer')

@section('titre', 'Mes Résidences')

@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/admin_residences.css') }}">
@endsection

@section('main')
    <div class="container mx-auto p-2 ">
        {{-- Alerts success / danger --}}
        @if (session('success'))
            <div id="alert-success" class="flex justify-between items-center p-4 mb-4 rounded-lg bg-green-50 border-l-4 border-green-600 shadow text-center">
                <div class="w-full">
                    <p class="font-bold text-green-700">Succès !</p>
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
                <button onclick="closeAlert('alert-success')" class="text-green-700 hover:text-green-900 ml-3">✕</button>
            </div>
        @endif

        @if (session('danger'))
            <div id="alert-danger" class="flex justify-between items-center p-4 mb-4 rounded-lg bg-red-50 border-l-4 border-red-600 shadow text-center">
                <div class="w-full">
                    <p class="font-bold text-red-700">Alerte !</p>
                    <p class="text-red-800">{{ session('danger') }}</p>
                </div>
                <button onclick="closeAlert('alert-danger')" class="text-red-700 hover:text-red-900 ml-3">✕</button>
            </div>
        @endif

        <h1 class="text-3xl lg:text-4xl font-extrabold text-indigo-700 mb-8 text-center border-b-4 border-indigo-500 pb-3">
            <i class="fas fa-home mr-3 text-3xl"></i> Résidences en ligne
        </h1>

        @if($residences->isEmpty())
            <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-6 rounded-lg text-center shadow-lg mx-auto max-w-lg">
                <i class="fas fa-info-circle text-2xl mb-2 block"></i>
                <p class="font-semibold text-lg">Vous n'avez aucune résidence enregistrée.</p>
                <p class="text-sm mt-1">Utilisez le menu latéral pour la mise en ligne.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($residences as $residence)
                    @php
                        // Décodage JSON si nécessaire
                        $images = $residence->img;
                        if (is_string($images)) {
                            $images = json_decode($images, true) ?? [];
                        }

                        $firstImage = $images[0] ?? null;
                        $imagePath = $firstImage ?: 'https://placehold.co/400x250/E0E7FF/4F46E5?text=Pas+d\'image';
                    @endphp

                    <div class="residence-item  data-name='{{ $residence->nom }}'
                        data-status='{{ $reservationEnCours?->status ?? 'aucune' }}'
                        bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col hover:shadow-indigo-300/50
                        transition duration-300 transform hover:scale-[1.01] border border-gray-100">

                        {{-- Image principale --}}
                        <a href="{{ $imagePath }}" class="glightbox block relative" data-gallery="residence-{{ $residence->id }}" data-title="{{ $residence->nom }}">
                            <img src="{{ $imagePath }}" class="w-full h-48 object-cover transition duration-300 hover:opacity-90"
                                onerror="this.onerror=null;this.src='https://placehold.co/400x250/E0E7FF/4F46E5?text=Pas+d\'image';"
                                alt="Image de la résidence">

                            {{-- Statut --}}
                            <span class="absolute top-2 left-2 px-3 py-1 text-xs font-semibold rounded-full
                                @switch($residence->statut)
                                    @case('vérifiée') bg-green-500 text-white @break
                                    @case('en attente') bg-yellow-500 text-gray-900 @break
                                    @default bg-gray-500 text-white @endswitch">
                                <i class="fas fa-check-circle mr-1"></i> {{ ucfirst($residence->statut) }}
                            </span>
                        </a>

                        {{-- Galerie invisible pour les autres images --}}
                        @if(is_array($images))
                            @foreach($images as $key => $image)
                                @if($key > 0)
                                    <a href="{{ $image }}" class="glightbox" data-gallery="residence-{{ $residence->id }}" data-title="{{ $residence->nom }}" style="display:none;"></a>
                                @endif
                            @endforeach
                        @endif

                        <div class="p-6 flex flex-col flex-grow">
                            <h5 class="text-xl font-extrabold text-indigo-800 mb-2 border-b border-gray-100 pb-2 truncate">{{ $residence->nom }} - {{ $residence->id }}</h5>
                            <ul class="space-y-2 text-sm text-gray-700 mb-4 flex-grow">
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-500"><i class="fas fa-tag mr-2 text-green-500"></i> Prix / Jour :</span>
                                    <span class="text-green-600 font-extrabold text-lg">{{ number_format($residence->prix_journalier, 0, ',', ' ') }} FCFA</span>
                                </li>
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-500"><i class="fas fa-map-marker-alt mr-2 text-indigo-400"></i> Ville :</span>
                                    <span class="text-gray-900">{{ $residence->ville }} ({{ $residence->pays }})</span>
                                </li>
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-500"><i class="fas fa-user-tie mr-2 text-indigo-400"></i> ID Propriétaire :</span>
                                    <span class="text-gray-900 font-bold">{{ $residence->proprietaire_id ?? 'N/A' }}</span>
                                </li>
                                <li class="flex justify-between items-center">
                                    <span class="text-gray-500"><i class="fas fa-ban mr-2 text-red-500"></i> Suspension :</span>
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ (!empty($residence->is_suspended) && $residence->is_suspended) ? 'bg-red-500 text-white' : 'bg-green-100 text-green-800' }}">
                                        {{ (!empty($residence->is_suspended) && $residence->is_suspended) ? 'Suspendue' : 'Active' }}
                                    </span>
                                </li>
                                @php
                                    // On récupère la réservation en cours / confirmée pour cette résidence
                                    $reservationEnCours = $residence->reservations
                                        ->whereIn('status', ['confirmée', 'payé', 'suspendu'])
                                        ->first();
                                @endphp

                                <li class="fw-bold mt-2 text-secondary fw-light">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    Statut : {{ $reservationEnCours?->status ?? 'Aucune réservation en cours' }}
                                </li>

                                <li class="fw-bold mt-2 text-danger fw-600">
                                    <i class="fas fa-calendar-check me-2"></i>
                                    Prochaine disponibilité : {{ \Carbon\Carbon::parse($residence->date_disponible)->translatedFormat('d F Y') }}
                                </li>

                                <form action="{{ route('admin.libererResidence', $residence->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                        Libérer la résidence
                                    </button>
                                </form>

                            </ul>

                            {{-- Actions d'administration --}}
                            <div class="mt-4 border-t pt-4">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Actions d'Administration :</p>
                                <div class="flex flex-wrap justify-start gap-2">

                                    @if ($residence->statut != 'vérifiée')
                                        <form action="{{ route('admin.residences.activation', $residence->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="text-sm px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                                                <i class="fas fa-thumb-up mr-1"></i> Valider
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.residences.desactivation', $residence->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="text-sm px-3 py-1.5 bg-yellow-500 text-gray-900 rounded-lg hover:bg-yellow-600 transition font-medium" onclick="return confirm('Confirmer la remise en attente ?')">
                                                <i class="fas fa-times-circle mr-1"></i> Désactiver
                                            </button>
                                        </form>
                                    @endif

                                    <a href="{{ route('admin.residences.edit', $residence->id) }}" class="text-sm px-3 py-1.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
                                        <i class="fas fa-edit mr-1"></i> Modifier
                                    </a>

                                    <form action="{{ route('admin.residences.sup', $residence->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette résidence ?')">
                                            <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8 flex justify-center">
                {{ $residences->links() }}
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialisation GLightbox
            GLightbox({ selector: '.glightbox', touchNavigation: true, loop: true });
        });

        // Fonction pour fermer les alertes
        function closeAlert(id) {
            const el = document.getElementById(id);
            if(el) {
                el.style.transition = "opacity 0.4s";
                el.style.opacity = 0;
                setTimeout(() => el.remove(), 400);
            }
        }
    </script>
@endsection
