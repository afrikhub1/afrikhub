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
                <input type="text" id="searchInput" placeholder="Rechercher par nom de résidence..."
                       class="w-full py-2 pl-10 pr-4 bg-gray-800 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150"
                       onkeyup="filterElements()">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <select id="searchOption" class="py-2 px-3 bg-gray-800 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150">
                <option value="name">Nom de la Résidence</option>
                <option value="all">Tout le Contenu</option>
            </select>
        </div>
        <div class="flex flex-wrap justify-between text-center border-t border-gray-800 py-2 -mx-4">
            <a href="{{ route('admin_dashboard') }}" class="flex-1 min-w-[15%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                <i class="fas fa-user mr-1"></i> Dashboard
            </a>
            <a href="{{ route('admin.residences') }}" class="flex-1 min-w-[15%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                <i class="fas fa-home mr-1"></i> Residences
            </a>
            <a href="{{ route('admin.reservations.all') }}" class="flex-1 min-w-[15%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                <i class="fas fa-clock mr-1"></i> Reservation
            </a>
            <a href="{{ route('admin.utilisateurs.all') }}" class="flex-1 min-w-[15%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
                <i class="fas fa-users mr-1"></i> Utilisateurs
            </a>
        </div>
    </div>
</header>
