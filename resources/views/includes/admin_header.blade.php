<header class="bg-gray-900 shadow-lg top-0 left-0 right-0 z-40 sticky">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- TOP BAR -->
        <div class="flex items-center justify-between py-3 flex-wrap gap-3">

            <!-- Logo + email -->
            <div class="flex items-center space-x-3 w-full sm:w-auto justify-between sm:justify-start">
                <img class="w-16 sm:w-20 md:w-28 h-auto" src="{{ asset('assets/images/logo_01.png') }}" alt="AfrikHub Logo">
                <h1 class="text-white font-semibold text-base sm:text-lg md:text-xl truncate max-w-[160px] sm:max-w-none">
                    gestionnaire@afrikhub.com
                </h1>

                <!-- Mobile toggle -->
                <button id="toggleSidebar" class="sm:hidden p-2 rounded-lg text-white hover:bg-indigo-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>

            <!-- Recherche -->
            <div class="relative w-full sm:flex-grow sm:w-auto">
                <input id="searchInput"
                       type="text"
                       placeholder="Rechercher par nom ou statut..."
                       class="w-full py-2 pl-10 pr-4 bg-gray-800 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <!-- Filtre -->
            <select id="searchOption"
                    class="w-full sm:w-auto py-2 px-3 bg-gray-800 text-white rounded-lg focus:ring-indigo-500 transition">
                <option value="name">Chercher</option>
            </select>

            <!-- Desktop toggle -->
            <button id="toggleSidebar" class="hidden sm:block p-2 rounded-lg text-white hover:bg-indigo-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>

        </div>

        <!-- NAV BAR (ICONS) -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 border-t border-gray-800 py-2">
            <a href="{{ route('admin.dashboard') }}" class="p-2 text-sm md:text-base font-medium text-gray-300 text-center hover:bg-gray-800 rounded-lg transition">
                <i class="fas fa-user mr-1"></i> Dashboard
            </a>
            <a href="{{ route('admin.residences') }}" class="p-2 text-sm md:text-base font-medium text-gray-300 text-center hover:bg-gray-800 rounded-lg transition">
                <i class="fas fa-home mr-1"></i> Residences
            </a>
            <a href="{{ route('admin.reservations') }}" class="p-2 text-sm md:text-base font-medium text-gray-300 text-center hover:bg-gray-800 rounded-lg transition">
                <i class="fas fa-clock mr-1"></i> Reservation
            </a>
            <a href="{{ route('admin.utilisateurs.all') }}" class="p-2 text-sm md:text-base font-medium text-gray-300 text-center hover:bg-gray-800 rounded-lg transition">
                <i class="fas fa-users mr-1"></i> Utilisateurs
            </a>
        </div>

    </div>
</header>

<!-- SIDEBAR -->
<div id="sidebar"
     class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm hidden z-50">
    <div class="bg-gray-900 w-64 h-full p-6 shadow-xl transform translate-x-[-100%] transition-all duration-300" id="sidebarPanel">

        <button id="closeSidebar" class="absolute top-4 right-4 text-gray-400 hover:text-white transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <div class="mt-12 flex flex-col space-y-4">
            <a href="{{ route('accueil') }}" class="py-2 px-4 rounded-lg hover:bg-gray-700">Accueil</a>
            <a href="{{ route('recherche') }}" class="py-2 px-4 rounded-lg hover:bg-gray-700">Recherche</a>
            <a href="{{ route('admin.reservations') }}" class="py-2 px-4 rounded-lg hover:bg-gray-700">Réservation</a>
            <a href="{{ route('mise_en_ligne') }}" class="py-2 px-4 rounded-lg hover:bg-gray-700">Mise en ligne</a>

            <a href="{{ route('logout') }}"
               class="py-2 px-4 bg-red-600 hover:bg-red-700 rounded-lg font-semibold shadow-lg text-center">
                Déconnexion
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggleButtons = document.querySelectorAll('#toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const sidebarPanel = document.getElementById('sidebarPanel');
    const closeButton = document.getElementById('closeSidebar');

    toggleButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            sidebar.classList.remove('hidden');
            setTimeout(() => sidebarPanel.classList.remove('translate-x-[-100%]'), 10);
        });
    });

    closeButton.addEventListener('click', () => {
        sidebarPanel.classList.add('translate-x-[-100%]');
        setTimeout(() => sidebar.classList.add('hidden'), 300);
    });
});
</script>
