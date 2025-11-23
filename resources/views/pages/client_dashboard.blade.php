<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Historique des Réservations — {{ config('app.name') }}</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
    body { font-family: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-slate-50 p-0 m-0">

  <!-- Header -->
  <header class="bg-white border-b fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <!-- Logo + titre -->
        <div class="flex items-center space-x-4">
          <a href="{{ route('accueil') }}" class="block">
            <img src="{{ asset('assets/images/logo.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto">
          </a>
          <h1 class="text-lg font-semibold text-slate-900 hidden sm:block">{{ Auth::user()->name ?? 'Utilisateur' }}</h1>
        </div>

        <!-- Nav principal (desktop) -->
        <nav class="hidden md:flex items-center space-x-3">
          <a href="{{ route('recherche') }}" class="px-3 py-1 text-sm font-medium text-slate-700 hover:text-slate-900 transition">Résidences</a>
          <a href="{{ route('factures') }}" class="px-3 py-1 text-sm font-medium text-slate-700 hover:text-slate-900 transition">Factures</a>

          @if(Auth::user()->type_compte == 'client')
            <a href="{{ route('devenir_pro') }}" class="px-4 py-2 bg-orange-500 text-white font-semibold rounded-lg shadow hover:bg-orange-600 transition">
              Pro
            </a>
          @else
            <a href="{{ route('pro.dashboard') }}" class="px-4 py-2 bg-orange-500 text-white font-semibold rounded-lg shadow hover:bg-orange-600 transition">
              Profil
            </a>
          @endif

          <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit"
              class="ml-3 px-4 py-2 bg-red-600 text-white font-semibold rounded-lg shadow hover:bg-red-700 transition flex items-center gap-2">
              <i class="fas fa-sign-out-alt"></i> Déconnexion
            </button>
          </form>
        </nav>

        <!-- Toggle sidebar (mobile) -->
        <button id="sidebarToggle" class="md:hidden p-2 rounded-md text-slate-700 hover:text-slate-900 focus:outline-none">
          <i class="fas fa-bars text-xl"></i>
        </button>
      </div>
    </div>
  </header>

  <!-- Sidebar mobile -->
  <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform -translate-x-full transition-transform z-50 overflow-y-auto">
    <div class="flex items-center justify-between p-4 border-b">
      <div class="flex items-center space-x-2">
        <img src="{{ asset('assets/images/logo.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto">
        <span class="font-semibold text-lg">{{ Auth::user()->name ?? 'Utilisateur' }}</span>
      </div>
      <button id="sidebarClose" class="p-2 text-slate-700 hover:text-slate-900 focus:outline-none">
        <i class="fas fa-times text-xl"></i>
      </button>
    </div>

    <nav class="flex flex-col mt-4 space-y-2 px-4">
      <a href="{{ route('recherche') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100 flex items-center gap-2"><i class="fas fa-search"></i> Résidences</a>
      <a href="{{ route('factures') }}" class="px-3 py-2 rounded-lg hover:bg-slate-100 flex items-center gap-2"><i class="fas fa-file-invoice-dollar"></i> Factures</a>
      @if(Auth::user()->type_compte == 'client')
        <a href="{{ route('devenir_pro') }}" class="px-3 py-2 rounded-lg bg-orange-500 text-white flex items-center gap-2 hover:bg-orange-600">Pro</a>
      @else
        <a href="{{ route('pro.dashboard') }}" class="px-3 py-2 rounded-lg bg-orange-500 text-white flex items-center gap-2 hover:bg-orange-600">Profil</a>
      @endif
      <form action="{{ route('logout') }}" method="POST" class="mt-2">
        @csrf
        <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white rounded-lg flex items-center gap-2 hover:bg-red-700">Déconnexion</button>
      </form>
    </nav>
  </aside>

  <!-- Main -->
  <main class="max-w-7xl mx-auto px-4 py-10 mt-16">
    @include('includes.messages')
    <header class="mb-8 text-center">
      <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 inline-flex items-center gap-3">
        <i class="fas fa-history text-amber-600 text-xl"></i> Historique de vos réservations
      </h2>
      <p class="text-sm text-slate-500 mt-2">Retrouvez ici vos réservations passées, en cours et à venir.</p>
    </header>

    <div class="flex justify-center mb-8">
      <a href="{{ route('factures') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white border shadow-sm hover:shadow transition text-sm font-medium">
        <i class="fas fa-file-invoice-dollar text-slate-600"></i> Voir mes factures
      </a>
    </div>

    <section>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($reservations as $res)
        <!-- Carte réservation -->
        <article class="bg-white rounded-2xl border shadow-sm overflow-hidden transition transform hover:-translate-y-1">
          <div class="p-5 flex flex-col h-full">
            <!-- Badge -->
            <div class="mb-3 flex justify-center">
              <span class="text-xs font-semibold px-2 py-1 rounded-full
              {{ $res->status=='en attente' ? 'bg-indigo-500/50' : ($res->status=='confirmée' ? 'bg-green-500' : ($res->status=='annulée' ? 'bg-red-500' : 'bg-yellow-700 text-white')) }}">
                {{ $res->status }}
              </span>
            </div>
            <h3 class="text-lg font-semibold text-slate-900 mb-1 line-clamp-2">{{ $res->residence->nom ?? 'Résidence' }}</h3>
            <p class="text-sm text-slate-500 mb-4 flex items-center gap-2">
              <i class="fas fa-map-marker-alt text-amber-500"></i>
              <span>{{ $res->residence->ville ?? '-' }}, {{ $res->residence->pays ?? '-' }}</span>
            </p>
            <ul class="text-sm text-slate-700 mb-4 space-y-2 flex-1">
              <li class="flex justify-between">
                <span class="text-slate-500">Dates</span>
                <span class="font-semibold">{{ \Carbon\Carbon::parse($res->date_arrivee)->format('d/m/Y') }} → {{ \Carbon\Carbon::parse($res->date_depart)->format('d/m/Y') }}</span>
              </li>
              <li class="flex justify-between">
                <span class="text-slate-500">Personnes</span>
                <span class="font-semibold">{{ $res->personnes }}</span>
              </li>
            </ul>

            <div class="mt-auto space-y-2">
              @if($res->status=='en attente')
              <form action="{{ route('reservation.annuler', $res->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?')">
                @csrf
                <button type="submit" class="w-full px-3 py-2 bg-red-600 text-white rounded-lg font-semibold flex items-center justify-center gap-2 hover:bg-red-700">Annuler</button>
              </form>
              @elseif($res->status=='confirmée')
                <button disabled class="w-full px-3 py-2 bg-green-100 text-slate-400 rounded-lg">
                    <a href="{{ route('payer', $res->id) }}" class="d-flex">payer</a>
                </button>
              @elseif($res->status=='payé')
                <div class="flex gap-2">
                  <button disabled class="flex-1 px-3 py-2 bg-green-100 text-slate-400 rounded-lg cursor-not-allowed">Payé</button>
                  <a href="{{ route('sejour.interrompre', $res->id) }}" class="flex-1 px-3 py-2 bg-amber-600 text-white rounded-lg text-center hover:bg-amber-700">Interrompre</a>
                </div>
              @endif
              <a href="{{ route('reservation.rebook', $res->id) }}" class="block text-center text-sm font-semibold text-slate-500 hover:text-slate-900 mt-2">Renouveler</a>
            </div>
          </div>
        </article>
        @empty
        <div class="col-span-full">
          <div class="bg-white rounded-2xl p-8 text-center shadow-sm">
            <p class="text-2xl text-slate-500"><i class="fas fa-box-open mb-2"></i></p>
            <p class="text-lg font-medium text-slate-700">Vous n’avez encore aucune réservation.</p>
            <div class="mt-4">
              <a href="{{ route('recherche') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700">Parcourir les résidences</a>
            </div>
          </div>
        </div>
        @endforelse
      </div>
    </section>
  </main>

  <!-- Scripts sidebar -->
  <script>
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');

    sidebarToggle.addEventListener('click', () => {
      sidebar.classList.remove('-translate-x-full');
    });
    sidebarClose.addEventListener('click', () => {
      sidebar.classList.add('-translate-x-full');
    });
  </script>
</body>
</html>
