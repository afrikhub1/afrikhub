@extends('heritage')
@section('titre', 'Accueil')

@section('contenu')

<!-- Sidebar toggle button (mobile) -->
<button id="sidebarToggle" class="block md:hidden fixed top-4 left-4 z-50 bg-white p-2 rounded-lg shadow-md">
    <i class="fas fa-bars text-2xl text-gray-800"></i>
</button>

<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-gradient-to-b from-teal-700 to-teal-500 text-white transform -translate-x-full md:hidden transition-transform z-40 shadow-lg">
    <div class="p-4 flex items-center justify-between">
        <img src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo" class="h-12 w-auto">
        <button id="sidebarClose" class="text-white text-2xl">&times;</button>
    </div>
    <ul class="mt-8 space-y-4 text-lg font-semibold">
        <li><a href="{{ route('login') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-white/20"><i class="fas fa-sign-in-alt"></i> Connexion</a></li>
        <li><a href="{{ route('register') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-white/20"><i class="fas fa-user-plus"></i> Inscription</a></li>
        <li><a href="{{ route('admin.login') }}" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-white/20"><i class="fas fa-user-shield"></i> Admin</a></li>
        <li><a href="#hebergement" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-white/20"><i class="fas fa-home"></i> Hébergements</a></li>
        <li><a href="#location" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-white/20"><i class="fas fa-car"></i> Véhicules</a></li>
        <li><a href="#contact" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-white/20"><i class="fas fa-phone"></i> Contact</a></li>
    </ul>
</aside>

<!-- Header (grande écran) -->
<header class="hidden md:flex items-center justify-between bg-gradient-to-r from-teal-700 to-teal-500 text-white p-4 shadow-md fixed top-0 left-0 right-0 z-30">
    <img src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo" class="h-12">
    <nav>
        <ul class="flex items-center gap-4 font-semibold text-white">
            <li><a href="{{ route('login') }}" class="hover:underline flex items-center gap-1"><i class="fas fa-sign-in-alt"></i> Connexion</a></li>
            <li><a href="{{ route('register') }}" class="hover:underline flex items-center gap-1"><i class="fas fa-user-plus"></i> Inscription</a></li>
            <li><a href="{{ route('admin.login') }}" class="hover:underline flex items-center gap-1"><i class="fas fa-user-shield"></i> Admin</a></li>
            <li><a href="#hebergement" class="hover:underline flex items-center gap-1"><i class="fas fa-home"></i> Hébergements</a></li>
            <li><a href="#location" class="hover:underline flex items-center gap-1"><i class="fas fa-car"></i> Véhicules</a></li>
            <li><a href="#contact" class="hover:underline flex items-center gap-1"><i class="fas fa-phone"></i> Contact</a></li>
        </ul>
    </nav>
</header>

<main class="pt-20 md:pt-24">
    <!-- Section Accueil -->
    <section id="accueil" class="text-center py-10 flex flex-col items-center justify-center min-h-[600px] relative px-4 bg-[url('../images/bg.jpg')] bg-center bg-cover">
        <h2 class="text-5xl font-bold text-white mb-4 drop-shadow-lg">Bienvenue</h2>
        <span class="text-xl text-white drop-shadow-md">Explorez l'Afrique autrement avec Afrik’Hub</span>
        <div class="flex flex-wrap justify-center gap-4 mt-6">
            <a href="{{ route('recherche') }}" class="btn-reserver">Réserver</a>
            <a href="{{ route('mise_en_ligne') }}" class="btn-reserver bg-green-500 hover:bg-green-600">Ajouter un bien</a>
        </div>
    </section>

    <!-- Section Hébergement -->
    <section id="hebergement" class="max-w-6xl mx-auto my-10 p-6 bg-teal-100 rounded-xl shadow-lg">
        <h2 class="text-3xl font-bold text-center text-teal-800 uppercase mb-6">Hébergements</h2>
        <div class="flex flex-col md:flex-row items-center justify-center gap-6">
            <img src="{{ asset('assets/images/hebergement.jpg') }}" class="w-full md:w-1/2 rounded-xl shadow-lg" alt="Hébergement"/>
            <div class="md:w-1/2">
                <div class="accordion" id="accordionHebergement">
                    <div class="accordion-item mb-4 rounded-xl">
                        <h2 class="accordion-header" id="headingTypes">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTypes" aria-expanded="true">
                                Types d'hébergements
                            </button>
                        </h2>
                        <div id="collapseTypes" class="accordion-collapse collapse show" data-bs-parent="#accordionHebergement">
                            <div class="accordion-body">
                                <ul class="list-disc pl-5">
                                    <li>Studio - Wifi gratuit, Ventilateur, Caméra</li>
                                    <li>Chambre unique - Wifi, Climatisation, Petit déjeuner inclus</li>
                                    <li>Villa avec piscine - Wifi, Piscine privée, Climatisation, Parking gratuit</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item rounded-xl">
                        <h2 class="accordion-header" id="headingConditions">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseConditions" aria-expanded="false">
                                Conditions de réservation
                            </button>
                        </h2>
                        <div id="collapseConditions" class="accordion-collapse collapse" data-bs-parent="#accordionHebergement">
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
