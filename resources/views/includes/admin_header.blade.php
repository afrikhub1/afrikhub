<header class="bg-gray-900 shadow-lg top-0 left-0 right-0 z-40 sticky">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between py-3">
      <div class="flex items-center space-x-4">
        <div class="flex items-center">
          <img class="w-20 md:w-28 lg:w-32 h-auto" src="{{ asset('assets/images/logo_01.png') }}" alt="Afrik'Hub Logo"/>
        </div>
        <h1 class="text-xl font-semibold text-white">gestionnaire@afrikhub.com</h1>
      </div>

      <div class="relative flex-grow max-w-md mx-4">
        <input type="text" id="searchInput" placeholder="Rechercher par nom ou statut de résidence..."
               class="w-full py-2 pl-10 pr-4 bg-gray-800 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150"
               onkeyup="filterElements()">
        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
      </div>

      <select id="searchOption" class="py-2 px-3 bg-gray-800 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150">
        <option value="name">Nom de la Résidence</option>
        <option value="all">Tout le Contenu</option>
      </select>

      <button type="button" id="toggleSidebar" class="p-2 rounded-lg text-white hover:bg-indigo-700 focus:outline-none transition duration-150">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
      </button>
    </div>

    <div class="flex flex-wrap justify-between text-center border-t border-gray-800 py-2 -mx-4">
      <a href="{{ route('admin.dashboard') }}" class="flex-1 min-w-[15%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
        <i class="fas fa-user mr-1"></i> Dashboard
      </a>
      <a href="{{ route('admin.residences') }}" class="flex-1 min-w-[15%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
        <i class="fas fa-home mr-1"></i> Residences
      </a>
      <a href="{{ route('admin.reservations') }}" class="flex-1 min-w-[15%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
        <i class="fas fa-clock mr-1"></i> Reservation
      </a>
      <a href="{{ route('admin.utilisateurs.all') }}" class="flex-1 min-w-[15%] p-2 text-sm md:text-base font-medium text-gray-300 hover:bg-gray-800 transition duration-150 rounded-lg">
        <i class="fas fa-users mr-1"></i> Utilisateurs
      </a>
    </div>
  </div>
</header>

<!-- Sidebar -->
<div id="sidebar" class="fixed inset-0 bg-gray-900 bg-opacity-95 z-50 transform -translate-x-full transition-transform duration-300 text-white flex flex-col items-center p-4">
  <button type="button" id="closeSidebar" class="absolute top-4 right-4 text-gray-400 hover:text-white transition">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
    </svg>
  </button>

  <div class="mt-12 w-full flex flex-col space-y-4">
    <a href="{{ route('accueil') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition"><i class="fas fa-home mr-1"></i> Accueil</a>
    <a href="{{ route('recherche') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Recherche</a>
    <a href="{{ route('admin.reservations') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Réservation</a>
    <a href="{{ route('mise_en_ligne') }}" class="w-full text-center py-2 px-4 rounded-lg hover:bg-gray-700 transition">Mise en ligne</a>
    <a href="{{ route('logout') }}" class="w-full text-center py-2 px-4 bg-red-600 hover:bg-red-700 rounded-lg font-semibold transition shadow-lg">Déconnexion</a>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const toggleButton = document.getElementById('toggleSidebar');
  const closeButton = document.getElementById('closeSidebar');
  const sidebar = document.getElementById('sidebar');

  toggleButton?.addEventListener('click', () => sidebar.classList.toggle('-translate-x-full'));
  closeButton?.addEventListener('click', () => sidebar.classList.add('-translate-x-full'));
});

function filterElements() {
  const filter = document.getElementById('searchInput').value.toUpperCase();
  const option = document.getElementById('searchOption').value;
  const items = document.querySelectorAll('.residence-item');

  items.forEach(item => {
    let textValue = option === 'name' ? item.dataset.name || '' : item.textContent || '';
    item.style.display = textValue.toUpperCase().includes(filter) ? '' : 'none';
  });
}
</script>
