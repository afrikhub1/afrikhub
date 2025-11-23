@extends('heritage')
@section('titre', 'Accueil')

@section('contenu')

<!-- Sidebar toggle button (mobile) -->
<button id="sidebarToggle" class="block md:hidden fixed top-4 left-4 z-50 bg-white p-2 rounded-lg shadow-md">
    <i class="fas fa-bars text-2xl text-gray-800"></i>
</button>

<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-gradient-to-b from-teal-700 to-teal-500 text-white transform -translate-x-full md:translate-x-0 transition-transform z-40 shadow-lg">
    <div class="p-4 flex items-center justify-between md:justify-center">
        <img src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo" class="h-12 w-auto">
        <button id="sidebarClose" class="md:hidden text-white text-2xl">&times;</button>
    </div>
    <ul class="mt-8 space-y-4 text-lg font-semibold">
        <li><a href="{{ route('login') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-white/20"> <i class="fas fa-sign-in-alt"></i> Connexion </a></li>
        <li><a href="{{ route('register') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-white/20"> <i class="fas fa-user-plus"></i> Inscription </a></li>
        <li><a href="{{ route('admin.login') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-white/20"> <i class="fas fa-user-shield"></i> Admin </a></li>
        <li><a href="#hebergement" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-white/20"> <i class="fas fa-home"></i> Hébergements </a></li>
        <li><a href="#location" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-white/20"> <i class="fas fa-car"></i> Véhicules </a></li>
        <li><a href="#contact" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-white/20"> <i class="fas fa-phone"></i> Contact </a></li>
    </ul>
</aside>

<main class="ml-0 md:ml-64 transition-all duration-300">
    <!-- Section accueil -->
    <section id="accueil" class="text-center py-5 flex flex-col items-center justify-center min-h-[700px] relative px-4">
        @include('includes.messages')
        <h2>Bienvenue</h2>
        <span class="fs-6">Explorez l'Afrique autrement avec Afrik’Hub</span><br><br>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('recherche') }}" class="btn-reserver">Réserver</a>
            <a href="{{ route('mise_en_ligne') }}" class="btn-reserver bg-green-500 hover:bg-green-600">Ajouter un bien</a>
        </div>
    </section>

    <!-- Section hébergement -->
    <section id="hebergement" class="my-2 mx-auto max-w-6xl p-6 rounded-xl shadow-lg">
        <h2>Hébergements</h2>
        <div class="flex flex-col md:flex-row items-center justify-center gap-6 mt-6">
            <img class="w-full md:w-1/2 rounded-xl shadow-lg" src="{{ asset('assets/images/hebergement.jpg') }}" alt="Hébergement"/>
            <div class="md:w-1/2">
                <div class="accordion" id="accordionHebergement">
                    <div class="accordion-item bg-teal-100 rounded-xl mb-4">
                        <h2 class="accordion-header" id="headingTypes">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTypes" aria-expanded="true">
                                Types d'hébergements
                            </button>
                        </h2>
                        <div id="collapseTypes" class="accordion-collapse collapse show" aria-labelledby="headingTypes" data-bs-parent="#accordionHebergement">
                            <div class="accordion-body">
                                <ul class="list-disc pl-5">
                                    <li>Studio - Wifi gratuit, Ventilateur, Caméra de surveillance</li>
                                    <li>Chambre unique - Wifi, Climatisation, Petit déjeuner inclus</li>
                                    <li>Villa avec piscine - Wifi, Piscine privée, Climatisation, Parking gratuit</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item bg-teal-100 rounded-xl">
                        <h2 class="accordion-header" id="headingConditions">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseConditions" aria-expanded="false">
                                Conditions de réservation
                            </button>
                        </h2>
                        <div id="collapseConditions" class="accordion-collapse collapse" aria-labelledby="headingConditions" data-bs-parent="#accordionHebergement">
                            <div class="accordion-body">
                                <ul class="list-disc pl-5">
                                    <li>Réservation préalable requise</li>
                                    <li>Acompte de 20% pour confirmation</li>
                                    <li>Annulation gratuite jusqu'à 48h avant l'arrivée</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('recherche') }}" class="btn-reserver">Réserver</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Section résidences dynamiques -->
    <div class="container mx-auto py-6">
        @if ($residences->isEmpty())
            <div class="alert alert-warning text-center fw-bold rounded-3 p-4">
                <i class="fas fa-exclamation-triangle me-2"></i> Désolé, aucune résidence trouvée pour cette recherche.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($residences as $residence)
                    @php
                        $images = is_string($residence->img) ? json_decode($residence->img, true) : ($residence->img ?? []);
                        $firstImage = $images[0] ?? asset('assets/images/placeholder.jpg');
                    @endphp
                    <div class="card shadow-lg rounded-xl overflow-hidden flex flex-col">
                        <a href="javascript:void(0)" class="glightbox-trigger-{{ $residence->id }}">
                            <img src="{{ $firstImage }}" alt="{{ $residence->nom }}" class="w-full h-48 object-cover"/>
                        </a>
                        @foreach($images as $key => $image)
                            <a href="{{ $image }}" class="glightbox" data-gallery="gallery-{{ $residence->id }}" style="display:none" data-trigger=".glightbox-trigger-{{ $residence->id }}"></a>
                        @endforeach
                        <div class="p-4 flex flex-col flex-grow">
                            <h5 class="font-bold text-lg mb-1">{{ $residence->nom }}</h5>
                            <p class="text-gray-600 text-sm mb-2">{{ Str::limit($residence->description, 100) }}</p>
                            <ul class="text-sm text-gray-700 flex-grow">
                                <li>Chambres: {{ $residence->nombre_chambres ?? '-' }}</li>
                                <li>Salon: {{ $residence->nombre_salons ?? '-' }}</li>
                                <li>Situation: {{ $residence->pays ?? '-' }}/{{ $residence->ville ?? '-' }}</li>
                                <li>Prix/jour: {{ number_format($residence->prix_journalier ?? 0, 0, ',', ' ') }} FCFA</li>
                            </ul>
                            <a href="{{ route('details', $residence->id) }}" class="btn-reserver mt-2">Voir les détails</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</main>

@endsection

@section('footer')
<footer class="mt-8 p-4 text-center bg-gradient-to-r from-teal-700 to-teal-500 text-white">
    &copy; 2025 Afrik’Hub. Tous droits réservés.
</footer>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const sidebar = document.getElementById('sidebar');
const toggleBtn = document.getElementById('sidebarToggle');
const closeBtn = document.getElementById('sidebarClose');

toggleBtn.addEventListener('click', () => sidebar.classList.toggle('-translate-x-full'));
closeBtn.addEventListener('click', () => sidebar.classList.add('-translate-x-full'));
document.addEventListener('click', e => {
    if(!sidebar.contains(e.target) && !toggleBtn.contains(e.target)){
        sidebar.classList.add('-translate-x-full');
    }
});
</script>
@endsection
