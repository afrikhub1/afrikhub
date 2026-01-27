<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Historique des Réservations — {{ config('app.name') }}</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .glass-header { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); }
    /* TA COULEUR DE BASE */
    .bg-gradient-brand { background: linear-gradient(135deg, #006d77, #00afb9); }
    .text-brand { color: #006d77; }
    .border-brand { border-color: #006d77; }
    
    .res-card { transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
    .res-card:hover { transform: translateY(-8px); box-shadow: 0 20px 25px -5px rgba(0, 109, 119, 0.1); }
  </style>
</head>
<body class="bg-slate-50 p-0 m-0 text-slate-900">

  <header class="glass-header border-b border-slate-100 fixed w-full z-50 top-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-20">
        <div class="flex items-center space-x-4">
          <a href="{{ route('accueil') }}" class="transition hover:opacity-80">
            <img src="{{ asset('assets/images/logo.png') }}" alt="{{ config('app.name') }}" class="h-12 w-auto">
          </a>
          <div class="hidden sm:block border-l border-slate-200 pl-4">
            <h1 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Espace Client</h1>
            <p class="text-base font-extrabold text-brand leading-tight">{{ Auth::user()->name ?? 'Utilisateur' }}</p>
          </div>
        </div>

        <nav class="hidden md:flex items-center space-x-2">
          <a href="{{ route('recherche') }}" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-brand transition">Résidences</a>
          <a href="{{ route('factures') }}" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:text-brand transition">Factures</a>

          <div class="h-6 w-[1px] bg-slate-200 mx-2"></div>

          @if(Auth::user()->type_compte == 'client')
            <a href="{{ route('devenir_pro') }}" class="px-5 py-2.5 bg-gradient-brand text-white font-bold rounded-xl shadow-lg shadow-cyan-900/20 hover:scale-105 transition active:scale-95">
              Passer Pro
            </a>
          @else
            <a href="{{ route('pro.dashboard') }}" class="px-5 py-2.5 bg-slate-900 text-white font-bold rounded-xl shadow-lg hover:bg-slate-800 transition">
              Dashboard
            </a>
          @endif

          <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="ml-2 p-2.5 text-slate-400 hover:text-red-500 transition" title="Déconnexion">
              <i class="fas fa-power-off text-lg"></i>
            </button>
          </form>
        </nav>

        <button id="sidebarToggle" class="md:hidden p-3 rounded-xl bg-slate-50 text-slate-700 hover:bg-slate-100 transition">
          <i class="fas fa-bars-staggered text-xl text-brand"></i>
        </button>
      </div>
    </div>
  </header>

  <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white shadow-2xl transform -translate-x-full transition-transform duration-300 z-[100] overflow-y-auto">
    <div class="flex items-center justify-between p-6 border-b border-slate-50">
      <div class="flex items-center space-x-3">
        <img src="{{ asset('assets/images/logo.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto">
        <span class="font-bold text-slate-900 truncate">{{ Auth::user()->name ?? 'Menu' }}</span>
      </div>
      <button id="sidebarClose" class="p-2 text-slate-400 hover:text-brand transition">
        <i class="fas fa-times text-xl"></i>
      </button>
    </div>

    <nav class="flex flex-col p-6 gap-2">
      <a href="{{ route('recherche') }}" class="px-4 py-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand flex items-center gap-3 transition">
        <i class="fas fa-search w-5"></i> Résidences
      </a>
      <a href="{{ route('factures') }}" class="px-4 py-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-50 hover:text-brand flex items-center gap-3 transition">
        <i class="fas fa-file-invoice-dollar w-5"></i> Factures
      </a>
      <div class="my-4 border-t border-slate-50"></div>
      @if(Auth::user()->type_compte == 'client')
        <a href="{{ route('devenir_pro') }}" class="px-4 py-4 rounded-xl bg-gradient-brand text-white font-bold flex items-center justify-center gap-2 shadow-lg shadow-cyan-900/20">
          Devenir Pro
        </a>
      @else
        <a href="{{ route('pro.dashboard') }}" class="px-4 py-4 rounded-xl bg-slate-900 text-white font-bold flex items-center justify-center gap-2 shadow-lg">
          Accéder au Profil
        </a>
      @endif
      <form action="{{ route('logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="w-full px-4 py-3 bg-red-50 text-red-600 font-bold rounded-xl flex items-center justify-center gap-2 hover:bg-red-100 transition">
          <i class="fas fa-sign-out-alt"></i> Déconnexion
        </button>
      </form>
    </nav>
  </aside>

  <main class="max-w-7xl mx-auto px-4 py-12 mt-20">
    @include('includes.messages')
    
    <header class="mb-12 text-center">
      <span class="inline-block px-4 py-1.5 bg-emerald-50 text-brand text-xs font-bold uppercase tracking-widest rounded-full mb-4">Suivi de compte</span>
      <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
        Historique de vos réservations
      </h2>
      <p class="text-slate-500 mt-3 text-lg">Gérez vos séjours passés et à venir en toute simplicité.</p>
    </header>

    <div class="flex justify-center mb-12">
      <a href="{{ route('factures') }}" class="group inline-flex items-center gap-3 px-6 py-3 rounded-2xl bg-white border border-slate-200 shadow-sm hover:border-brand/30 hover:bg-emerald-50 transition-all duration-300">
        <div class="p-2 bg-emerald-100 rounded-lg group-hover:bg-brand group-hover:text-white transition-all">
          <i class="fas fa-file-invoice-dollar"></i>
        </div>
        <span class="font-bold text-slate-700">Consulter mes factures</span>
      </a>
    </div>

    <section>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($reservations as $res)
        <article class="res-card bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col h-full">
          <div class="p-6 flex flex-col h-full">
            <div class="mb-5">
              <span class="font-black px-3 py-1.5 rounded-lg inline-block text-[0.65rem] uppercase tracking-wider
              {{ $res->status=='en attente' ? 'bg-amber-100 text-amber-700' : ($res->status=='confirmée' ? 'bg-emerald-100 text-brand' : ($res->status=='annulée' ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-600')) }}">
                <i class="fas fa-circle text-[0.5rem] mr-1.5 align-middle"></i>
                {{ $res->status }}
              </span>
            </div>

            <h3 class="text-xl font-bold text-slate-900 mb-2 leading-snug">
              {{ $res->residence->nom ?? 'Résidence' }}
            </h3>
            
            <p class="text-sm font-medium text-slate-400 mb-6 flex items-center gap-2">
              <i class="fas fa-location-dot text-brand"></i>
              {{ $res->residence->ville ?? '-' }}, {{ $res->residence->pays ?? '-' }}
            </p>

            <div class="bg-slate-50 rounded-2xl p-4 mb-6 space-y-3 border border-slate-100">
              <div class="flex justify-between items-center text-sm">
                <span class="text-slate-400 font-medium italic">Séjour</span>
                <span class="font-bold text-slate-700">
                   {{ \Carbon\Carbon::parse($res->date_arrivee)->format('d/m/Y') }}
                </span>
              </div>
              <div class="flex justify-between items-center text-sm">
                <span class="text-slate-400 font-medium italic">Voyageurs</span>
                <span class="font-bold text-slate-700">{{ $res->personnes }} pers.</span>
              </div>
            </div>

            <div class="mt-auto pt-4 border-t border-slate-50 space-y-3">
              @if($res->status=='en attente')
                <form action="{{ route('reservation.annuler', $res->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?')">
                  @csrf
                  <button type="submit" class="w-full py-3 bg-rose-50 text-rose-600 rounded-xl font-extrabold text-sm hover:bg-rose-600 hover:text-white transition-all">
                    Annuler la demande
                  </button>
                </form>
              @elseif($res->status=='confirmée')
                <a href="{{ route('paiement.qr', $res->id) }}" class="block w-full py-3 bg-gradient-brand text-center text-sm font-black text-white rounded-xl shadow-lg shadow-cyan-900/20 hover:opacity-90 transition">
                  PAYER MAINTENANT
                </a>
                <a href="{{ route('sejour.interrompre', $res->id) }}" class="block w-full py-2.5 bg-amber-50 text-amber-600 text-center text-xs font-bold rounded-xl hover:bg-amber-100 transition">
                  Interrompre le séjour
                </a>
              @elseif($res->status=='payée')
                <div class="w-full py-3 bg-slate-100 text-brand text-center text-sm font-bold rounded-xl flex items-center justify-center gap-2">
                  <i class="fas fa-check-circle"></i> Paiement validé
                </div>
                <a href="{{ route('sejour.interrompre', $res->id) }}" class="block w-full py-2.5 bg-amber-50 text-amber-600 text-center text-xs font-bold rounded-xl hover:bg-amber-100 transition">
                  Interrompre
                </a>
              @endif
              
              <a href="{{ route('reservation.rebook', $res->id) }}" class="block w-full py-2.5 border-2 border-slate-100 text-slate-400 text-center text-xs font-bold rounded-xl hover:border-brand hover:text-brand transition">
                <i class="fas fa-rotate-right mr-1"></i> Réserver à nouveau
              </a>
            </div>
          </div>
        </article>
        @empty
        <div class="col-span-full">
          <div class="bg-white rounded-[3rem] p-16 text-center shadow-sm border border-slate-100">
            <div class="w-20 h-20 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6">
              <i class="fas fa-calendar-xmark text-3xl text-brand/30"></i>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 mb-2">Aucune réservation</h3>
            <p class="text-slate-500 mb-8 max-w-xs mx-auto">Vous n'avez pas encore de réservations enregistrées sur votre compte.</p>
            <a href="{{ route('recherche') }}" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-brand text-white font-bold rounded-2xl shadow-xl shadow-cyan-900/20 hover:scale-105 transition">
              Explorer les offres <i class="fas fa-arrow-right"></i>
            </a>
          </div>
        </div>
        @endforelse
      </div>
    </section>
  </main>

  @include('includes.footer')

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
    window.addEventListener('click', (e) => {
      if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target) && !sidebar.classList.contains('-translate-x-full')) {
        sidebar.classList.add('-translate-x-full');
      }
    });
  </script>
</body>
</html>