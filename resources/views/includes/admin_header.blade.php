<!-- TOGGLE CHECKBOX (invisible) -->
<input type="checkbox" id="sidebarToggle" class="hidden peer">

<header class="bg-gray-900 shadow-lg sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- TOP BAR -->
        <div class="flex items-center justify-between py-3 flex-wrap gap-3">

            <!-- LOGO + EMAIL -->
            <div class="flex items-center space-x-3 w-full sm:w-auto justify-between sm:justify-start">
                <img class="w-16 sm:w-20 md:w-28 h-auto"
                     src="{{ asset('assets/images/logo_01.png') }}" alt="Logo">

                <h1 class="text-white font-semibold text-base sm:text-lg md:text-xl truncate max-w-[160px] sm:max-w-none">
                    gestionnaire@afrikhub.com
                </h1>

                <!-- BUTTON OPEN SIDEBAR -->
                <label for="sidebarToggle" class="sm:hidden p-2 rounded-lg text-white hover:bg-indigo-700 transition cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </label>
            </div>

            <!-- RECHERCHE -->
            <div class="relative w-full sm:flex-grow sm:w-auto">
                <input id="searchInput" type="text"
                       placeholder="Rechercher par nom ou statut..."
                       class="w-full py-2 pl-10 pr-4 bg-gray-800 text-white rounded-lg focus:ring-2 focus:ring-indigo-500">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <!-- OPTION -->
            <select id="searchOption" class="w-full sm:w-auto py-2 px-3 bg-gray-800 text-white rounded-lg">
                <option value="name">Nom</option>
                <option value="status">status</option>
            </select>

            <!-- DESKTOP SIDEBAR OPEN -->
            <label for="sidebarToggle" class="hidden sm:block p-2 rounded-lg text-white hover:bg-indigo-700 transition cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </label>
        </div>

        <!-- NAV BAR -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 border-t border-gray-800 py-2">
            <a class="p-2 text-sm md:text-base text-gray-300 text-center hover:bg-gray-800 rounded-lg transition"
                href="{{ route('admin.dashboard') }}"><i class="fas fa-user mr-1"></i> Dashboard</a>
            <a class="p-2 text-sm md:text-base text-gray-300 text-center hover:bg-gray-800 rounded-lg transition"
                href="{{ route('admin.residences') }}"><i class="fas fa-home mr-1"></i> Residences</a>
            <a class="p-2 text-sm md:text-base text-gray-300 text-center hover:bg-gray-800 rounded-lg transition"
                href="{{ route('admin.reservations') }}"><i class="fas fa-clock mr-1"></i> Reservation</a>
            <a class="p-2 text-sm md:text-base text-gray-300 text-center hover:bg-gray-800 rounded-lg transition"
                href="{{ route('admin.utilisateurs.all') }}"><i class="fas fa-users mr-1"></i> Utilisateurs</a>
        </div>

    </div>
</header>

<!-- OVERLAY -->
<div class="fixed inset-0 bg-black/50 opacity-0 pointer-events-none transition peer-checked:opacity-100 peer-checked:pointer-events-auto z-40"></div>

<!-- SIDEBAR PANEL -->
<aside class="fixed top-0 left-0 w-64 h-full bg-gray-900 shadow-xl transform -translate-x-full
            transition-all duration-300 peer-checked:translate-x-0 z-50 p-6">

    <!-- BUTTON CLOSE -->
    <label for="sidebarToggle" class="absolute top-5 right-5 text-gray-400 hover:text-white cursor-pointer">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </label>

    <div class="mt-12 flex flex-col space-y-4">
        <a href="{{ route('accueil') }}" class="py-2 px-4 rounded-lg hover:bg-gray-700 text-white">Accueil</a>
        <a href="{{ route('recherche') }}" class="py-2 px-4 rounded-lg hover:bg-gray-700 text-white">Recherche</a>
        <a href="{{ route('admin.reservations') }}" class="py-2 px-4 rounded-lg hover:bg-gray-700 text-white">Réservation</a>
        <a href="{{ route('mise_en_ligne') }}" class="py-2 px-4 rounded-lg hover:bg-gray-700 text-white">Mise en ligne</a>
        <a href="{{ route('admin.demande.interruptions') }}" class="py-2 px-4 rounded-lg hover:bg-gray-700 text-white">Interuption</a>

        <a href="{{ route('logout') }}" class="py-2 px-4 bg-red-600 hover:bg-red-700 rounded-lg shadow-lg text-center text-white">
            Déconnexion
        </a>
    </div>
</aside>


<script>
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("searchInput");
        const searchOption = document.getElementById("searchOption");

        // Sélectionne toutes les cartes de résidence
        const rows = document.querySelectorAll(".search-row");

        // Fonction pour normaliser texte (minuscules + accents)
        function normalizeText(text) {
            return text
                .toLowerCase()
                .normalize("NFD")   // Décompose les caractères accentués
                .replace(/[\u0300-\u036f]/g, ""); // Supprime les accents
        }

        searchInput.addEventListener("keyup", () => {
            const query = normalizeText(searchInput.value.trim());
            const option = searchOption.value;

            rows.forEach(row => {
                let value = "";

                // Selon l'option choisie
                switch(option) {
                    case "name":
                        value = normalizeText(row.dataset.name || "");
                        break;
                    case "status":
                        value = normalizeText(row.dataset.status || "");
                        break;
                    case "city":
                        value = normalizeText(row.dataset.city || "");
                        break;
                    case "owner":
                        value = normalizeText(row.dataset.owner || "");
                        break;
                    default:
                        value = "";
                }

                // Affiche ou cache la ligne
                if(value.includes(query)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    });
</script>


