<header class="bg-gray-900 shadow-lg top-0 left-0 right-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between py-3">
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <img class="w-20 md:w-28 lg:w-32 h-auto" src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo"/>
                </div>
                <h1 class="text-xl font-semibold text-white">gestionnaire@afrikhub.com</h1>
            </div>
            <button id="toggleSidebar" class="p-2 rounded-lg text-white hover:bg-indigo-700 focus:outline-none transition duration-150">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>

        <div class="flex items-center space-x-2 py-3 border-t border-gray-800">
            <div class="relative flex-grow">
                <input type="text" id="searchInput" placeholder="Rechercher (Dashboard, Réservations...)"
                       class="w-full py-2 pl-10 pr-4 bg-gray-800 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150"
                       onkeyup="filterElements()">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <select id="searchOption" class="py-2 px-3 bg-gray-800 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150">
                <option value="title">Nom du Lien</option>
                <option value="all">Tout le Texte</option>
            </select>
        </div>
        <div class="flex flex-wrap justify-between text-center border-t border-gray-800 py-2 -mx-4" id="navLinksContainer">
            <a href="{{ route('admin_dashboard') }}" class="nav-item flex-1 min-w-[15%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg" data-title="Dashboard">
                <i class="fas fa-user mr-1"></i> Dashboard
            </a>
            <a href="{{ route('admin.residences') }}" class="nav-item flex-1 min-w-[15%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg" data-title="Residences">
                <i class="fas fa-home mr-1"></i> Residences
            </a>
            <a href="{{ route('admin.reservations.all') }}" class="nav-item flex-1 min-w-[15%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg" data-title="Reservation">
                <i class="fas fa-clock mr-1"></i> Reservation
            </a>
            <a href="{{ route('admin.utilisateurs.all') }}" class="nav-item flex-1 min-w-[15%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg" data-title="Utilisateurs">
                <i class="fas fa-users mr-1"></i> Utilisateurs
            </a>
        </div>
    </div>
</header>

<div id="sidebar" class="text-white flex flex-col items-center">
    <button id="closeSidebar" class="absolute top-4 right-4 text-gray-400 hover:text-white transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <div class="mt-12 w-full flex flex-col space-y-4">
        <a href="{{ route('accueil') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition"><i class="fas fa-home mr-1"></i> Accueil</a>
        <a href="{{ route('recherche') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Recherche</a>
        <a href="{{ route('historique') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Réservation</a>
        <a href="{{ route('mise_en_ligne') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Mise en ligne</a>
        <div class="py-2 w-full mx-auto row m-0">
            <a href="{{ route('logout') }}" class="w-full text-center py-2 px-4 bg-red-600 hover:bg-red-700 rounded-lg font-semibold transition shadow-lg">Déconnexion</a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Logique existante de la sidebar
    const toggleButton = document.getElementById('toggleSidebar');
    const closeButton = document.getElementById('closeSidebar');
    const sidebar = document.getElementById('sidebar');

    if (toggleButton && sidebar) {
        toggleButton.addEventListener('click', function() {
            sidebar.classList.add('active');
        });
    }

    if (closeButton && sidebar) {
        closeButton.addEventListener('click', function() {
            sidebar.classList.remove('active');
        });
    }

    // Logique AJOUTÉE pour le filtre de recherche
    const searchOption = document.getElementById('searchOption');
    if (searchOption) {
        searchOption.addEventListener('change', filterElements);
    }
});

/**
 * Filtre les liens de navigation dans le header basés sur le texte de recherche et l'option sélectionnée.
 */
function filterElements() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toUpperCase();
    const option = document.getElementById('searchOption').value;
    // Cible tous les liens avec la classe 'nav-item'
    const navItems = document.querySelectorAll('.nav-item');

    navItems.forEach(item => {
        let textValue;

        if (option === 'title') {
            // Utilise l'attribut data-title
            textValue = item.getAttribute('data-title');
        } else { // 'all'
            // Utilise tout le contenu textuel du lien
            textValue = item.textContent;
        }

        // Vérifie si la valeur de recherche est présente dans le texte de comparaison
        if (textValue && textValue.toUpperCase().indexOf(filter) > -1) {
            item.style.display = ""; // Afficher l'élément
        } else {
            item.style.display = "none"; // Masquer l'élément
        }
    });
}
</script>
