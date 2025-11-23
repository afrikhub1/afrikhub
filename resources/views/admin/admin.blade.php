<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Hébergement Admin</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        'primary': '#ff7a00',
                        'primary-dark': '#e66b00',
                        'success': '#10b981',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans transition-colors duration-300">

<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex-shrink-0 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 md:block transition-transform duration-300 transform -translate-x-full md:translate-x-0 no-scrollbar overflow-y-auto">
        <div class="h-16 flex items-center justify-center border-b border-gray-200 dark:border-gray-700">
            <span class="text-2xl font-bold text-primary dark:text-primary-dark tracking-wide">
                Afrik'<span class="text-gray-900 dark:text-white">Hub Admin</span>
            </span>
        </div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="#" class="flex items-center p-3 text-sm font-medium text-white bg-primary dark:bg-primary-dark rounded-lg shadow-md hover:bg-primary-dark dark:hover:bg-primary transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Aperçu Général
            </a>
            <a href="{{ route('admin.residences') }}" class="flex items-center p-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1.03M9 11h1.03M9 15h1.03M13 7h1.03M13 11h1.03M13 15h1.03M17 7h1.03M17 11h1.03M17 15h1.03"></path></svg>
                Gestion Résidences
            </a>
            <a href="{{ route('admin.reservations') }}" class="flex items-center p-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M16 11h.01M21 21H3a2 2 0 01-2-2V8a2 2 0 012-2h18a2 2 0 012 2v11a2 2 0 01-2 2z"></path></svg>
                Réservations
            </a>
            <a href="{{ route('admin.utilisateurs.all') }}" class="flex items-center p-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2a3 3 0 00-5.356-1.857M17 20H7m0 0a3 3 0 01-5.356-1.857M7 20v-2a3 3 0 01-5.356-1.857m0 0H2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Utilisateurs
            </a>
            <a href="{{ route('admin.demande.interruptions') }}" class="flex items-center p-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2a3 3 0 00-5.356-1.857M17 20H7m0 0a3 3 0 01-5.356-1.857M7 20v-2a3 3 0 01-5.356-1.857m0 0H2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Demandes d'interruption
            </a>
            <a href="{{ route('file.manager') }}" class="flex items-center p-3 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
               <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20v-2a3 3 0 00-5.356-1.857M17 20H7m0 0a3 3 0 01-5.356-1.857M7 20v-2a3 3 0 01-5.356-1.857m0 0H2"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                Galerie photo
            </a>
        </nav>
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 absolute bottom-0 w-full">
            <div class="flex items-center justify-between text-gray-700 dark:text-gray-300 p-2 rounded-lg bg-gray-50 dark:bg-gray-900">
                <span class="text-sm font-medium">Thème</span>
                <button id="theme-toggle" class="p-1 rounded-full text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 hover:ring-2 hover:ring-primary-dark transition-all duration-300">
                    <svg id="sun-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <svg id="moon-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                </button>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div id="main-content" class="flex-1 overflow-x-hidden overflow-y-auto md:ml-64 transition-all duration-300">
        <header class="flex items-center justify-between h-16 px-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-30">
            <button id="sidebar-toggle" class="md:hidden p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white hidden sm:block">Tableau de Bord des Hébergements</h1>
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 hidden sm:inline">Bienvenue, Administrateur</span>
                <img class="w-8 h-8 rounded-full object-cover border-2 border-primary dark:border-primary-dark"
                     src="https://placehold.co/32x32/ff7a00/ffffff?text=A"
                     alt="Avatar Admin">
            </div>
        </header>

        <main class="p-4 sm:p-6 lg:p-8">
            <!-- KPIs -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">

                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700/50 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-success/10 text-success dark:bg-success/20 dark:text-success">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2m-3-12h6m-6 16h6"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Revenus du Mois</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($totalGain,0,',','.') }} FCFA</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700/50 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-primary/10 text-primary dark:bg-primary-dark/20 dark:text-primary-dark">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20a1 1 0 01-1 1H6a1 1 0 01-1-1V5a1 1 0 011-1h12a1 1 0 011 1v15z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-6 4h6m-6-8h6"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Taux Occupation</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $tauxOccupation }}%</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700/50 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-500/10 text-blue-500 dark:bg-blue-500/20 dark:text-blue-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h.01M16 11h.01M21 21H3a2 2 0 01-2-2V8a2 2 0 012-2h18a2 2 0 012 2v11a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Réservations</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalReservation }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700/50 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-500/10 text-yellow-500 dark:bg-yellow-500/20 dark:text-yellow-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 01-2-2V9a2 2 0 012-2h6zm-2 1h-2a1 1 0 00-1 1v4a1 1 0 001 1h2a1 1 0 001-1V9a1 1 0 00-1-1z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20v2M16 20v2M8 4V2M16 4V2"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Résidences Actives</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $residencesactives }}</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-8 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700/50 overflow-x-auto">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Résidences à Vérifier En attente/Désactivées</h2>

                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tl-lg">Résidence</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Localisation</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider hidden sm:table-cell">Statut</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tr-lg" style="width: 250px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($pendingResidences as $residence)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $residence->nom }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $residence->ville }}, {{ $residence->pays }}</td>
                            <td class="px-4 py-4 whitespace-nowrap hidden sm:table-cell">
                                @php
                                    $statut_class = [
                                        'vérifiée' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
                                        'en_attente' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100',
                                        'desactive' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
                                    ][$residence->statut] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statut_class }}">
                                    {{ ucfirst(str_replace('_', ' ', $residence->statut)) }}
                                </span>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2 items-center">

                                    {{-- Bouton d'action (Valider / Désactiver) --}}
                                    @if ($residence->statut === 'vérifiée')
                                        {{-- Si la résidence est vérifiée, on propose de la DÉSACTIVER --}}
                                        <form action="{{ route('admin.residences.desactivation', $residence->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-sm px-3 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium"
                                                    onclick="return confirm('Confirmer la désactivation de {{ $residence->nom }} ?')">
                                                <i class="fas fa-times-circle mr-1"></i> Désactiver
                                            </button>
                                        </form>
                                    @else
                                        {{-- Si la résidence est en attente ou désactivée, on propose de la VALIDER/ACTIVER --}}
                                        <form action="{{ route('admin.residences.activation', $residence->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-sm px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition font-medium">
                                                <i class="fas fa-check-circle mr-1"></i> Valider
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Bouton Examiner/Modifier --}}
                                    <a href="{{ route('admin.residences.edit', $residence->id) }}" class="text-sm px-3 py-1.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
                                        <i class="fas fa-edit mr-1"></i> Modifier
                                    </a>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>

<!-- Script Dark Mode minimal -->
<script>
    const themeToggle = document.getElementById('theme-toggle');
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');
    const htmlElement = document.documentElement;

    function updateThemeIcons(isDark) {
        if (isDark) { sunIcon.classList.add('hidden'); moonIcon.classList.remove('hidden'); }
        else { sunIcon.classList.remove('hidden'); moonIcon.classList.add('hidden'); }
    }

    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        htmlElement.classList.add('dark'); updateThemeIcons(true);
    } else { htmlElement.classList.remove('dark'); updateThemeIcons(false); }

    themeToggle.addEventListener('click', () => {
        const isDark = htmlElement.classList.toggle('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        updateThemeIcons(isDark);
    });
</script>

</body>
</html>
