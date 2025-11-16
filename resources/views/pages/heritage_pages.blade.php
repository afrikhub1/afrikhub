<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>{{ config('app.name') }} - @yield('title')</title>

  <!-- Tailwind CDN (rapide pour dev; pour prod compile via Tailwind CLI) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Petite configuration Tailwind (couleurs custom) -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'dg-primary': '#d4a017', /* dark gold */
            'dg-accent': '#111827',  /* deep dark */
            'dg-muted': '#6b7280'
          },
          borderRadius: {
            'xl2': '14px'
          },
          boxShadow: {
            'soft-lg': '0 10px 30px rgba(15,23,36,0.06)'
          }
        }
      }
    }
  </script>

  <style>
    /* Small extras not in Tailwind utilities */
    .glass-header {
      background: rgba(17,24,39,0.5); /* semi-dark glass */
      backdrop-filter: blur(8px);
      border-bottom: 1px solid rgba(255,255,255,0.04);
      transition: background .25s ease;
    }
    .nav-underline:hover::after {
      width: 100%;
    }
    /* underline animation */
    .nav-underline {
      position: relative;
    }
    .nav-underline::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: -6px;
      width: 0%;
      height: 2px;
      background: #d4a017;
      transition: width .25s ease;
    }
    /* two-line truncation */
    .line-clamp-2 {
      overflow: hidden;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
    }
  </style>
</head>
<body class="antialiased bg-slate-50 text-slate-800">

  {{-- HEADER --}}
  <header class="glass-header fixed inset-x-0 top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">

        {{-- Left: logo + user --}}
        <div class="flex items-center gap-4">
          <a href="{{ route('accueil') }}" class="flex items-center gap-3">
            <!-- Logo SVG or image -->
            <img src="{{ asset('assets/images/logo_01.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto transform transition hover:-rotate-3 hover:scale-105">
            <span class="text-white font-semibold text-lg hidden sm:inline-block">{{ config('app.name') }}</span>
          </a>

          {{-- username small --}}
          @auth
            <div class="hidden md:flex flex-col text-sm">
              <span class="text-white font-medium">{{ Auth::user()->name }}</span>
              <span class="text-dg-muted text-xs">Bienvenue</span>
            </div>
          @endauth
        </div>

        {{-- Center: optional nav links (desktop) --}}
        <nav class="hidden lg:flex items-center gap-6">
          <a href="{{ route('residences') }}" class="text-slate-100 nav-underline nav-link hover:text-dg-primary nav-underline">Résidences</a>
          <a href="{{ route('occupees') }}" class="text-slate-100 nav-underline nav-link hover:text-dg-primary">Occupées</a>
          <a href="{{ route('mes_demandes') }}" class="text-slate-100 nav-underline nav-link hover:text-dg-primary">Demandes</a>
          <a href="{{ route('historique') }}" class="text-slate-100 nav-underline nav-link hover:text-dg-primary">Historique</a>
        </nav>

        {{-- Right: search + actions --}}
        <div class="flex items-center gap-3">
          {{-- Search link --}}
          <a href="{{ route('recherche') }}" class="p-2 rounded-md hover:bg-white/5 text-white" aria-label="Recherche">
            {{-- Search SVG --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" /></svg>
          </a>

          {{-- Logout (POST) --}}
          <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-dg-primary px-3 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-dg-primary/30">
              <!-- logout svg -->
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 8v8"/></svg>
              Quitter
            </button>
          </form>

          {{-- Mobile: menu toggle --}}
          <button id="mobileMenuBtn" aria-label="Ouvrir le menu" class="lg:hidden p-2 rounded-md text-white hover:bg-white/5">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
          </button>
        </div>

      </div>

      {{-- bottom thin nav (mobile visible) --}}
      <div class="lg:hidden py-2 flex items-center gap-2 justify-between">
        <a href="{{ route('residences') }}" class="text-sm text-white/90 px-3 py-2 rounded-md hover:bg-white/5 inline-flex items-center gap-2">
          <!-- home svg --> <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9.5 12 4l9 5.5V20a1 1 0 0 1-1 1h-5V14H9v7H4a1 1 0 0 1-1-1V9.5z"/></svg>
          <span class="text-xs">Résidences</span>
        </a>
        <a href="{{ route('occupees') }}" class="text-sm text-white/90 px-3 py-2 rounded-md hover:bg-white/5 inline-flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.657 0 3-1.567 3-3.5S13.657 4 12 4s-3 1.567-3 3.5S10.343 11 12 11z"/><path stroke-linecap="round" stroke-linejoin="round" d="M5 20a4 4 0 018 0M3 7h18"/></svg>
          <span class="text-xs">Occupées</span>
        </a>
        <a href="{{ route('mes_demandes') }}" class="text-sm text-white/90 px-3 py-2 rounded-md hover:bg-white/5 inline-flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3"/></svg>
          <span class="text-xs">Demandes</span>
        </a>
        <a href="{{ route('historique') }}" class="text-sm text-white/90 px-3 py-2 rounded-md hover:bg-white/5 inline-flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-9-9"/></svg>
          <span class="text-xs">Historique</span>
        </a>
      </div>
    </div>
  </header>

  {{-- MOBILE SIDEBAR (off-canvas) --}}
  <aside id="mobileMenu" class="fixed inset-y-0 right-0 w-3/4 max-w-xs bg-dg-accent text-white transform translate-x-full transition-transform z-50 shadow-lg">
    <div class="p-4">
      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
          <img src="{{ asset('assets/images/logo_01.png') }}" alt="logo" class="h-8">
          <span class="font-semibold">{{ config('app.name') }}</span>
        </div>
        <button id="mobileMenuClose" aria-label="Fermer le menu" class="p-2 rounded-md hover:bg-white/5">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <nav class="flex flex-col gap-2">
        <a href="{{ route('accueil') }}" class="px-3 py-2 rounded-md hover:bg-white/5">Accueil</a>
        <a href="{{ route('recherche') }}" class="px-3 py-2 rounded-md hover:bg-white/5">Recherche</a>
        <a href="{{ route('residences') }}" class="px-3 py-2 rounded-md hover:bg-white/5">Mes Résidences</a>
        <a href="{{ route('mes_demandes') }}" class="px-3 py-2 rounded-md hover:bg-white/5">Demandes</a>
        <a href="{{ route('historique') }}" class="px-3 py-2 rounded-md hover:bg-white/5">Historique</a>
        <a href="{{ route('mise_en_ligne') }}" class="px-3 py-2 rounded-md hover:bg-white/5">Mise en ligne</a>
      </nav>

      <div class="mt-6">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 8v8"/></svg>
            Déconnexion
          </button>
        </form>
      </div>
    </div>
  </aside>

  {{-- OVERLAY when mobile menu open --}}
  <div id="mobileOverlay" class="fixed inset-0 bg-black/40 opacity-0 pointer-events-none transition-opacity z-40"></div>

  {{-- MAIN CONTENT --}}
  <main class="pt-28 mb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      {{-- flash messages --}}
      @include('includes.messages')

      {{-- Yield the main content of each page --}}
      @yield('main')
    </div>
  </main>

  {{-- FOOTER (optional) --}}
  <footer class="mt-12 text-center text-sm text-dg-muted mb-8">
    © {{ date('Y') }} {{ config('app.name') }} — Tous droits réservés
  </footer>

  {{-- SCRIPTS: mobile menu + GLightbox init (if used) --}}
  <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
  <script>
    (function(){
      const mobileBtn = document.getElementById('mobileMenuBtn') || document.getElementById('mobileMenuBtn'); // just in case
      const openBtn = document.getElementById('mobileMenuBtn') || document.getElementById('mobileMenuBtn');
      const mobileOpen = document.getElementById('mobileMenu');
      const mobileClose = document.getElementById('mobileMenuClose');
      const mobileOverlay = document.getElementById('mobileOverlay');

      // open handler
      document.getElementById('mobileMenuBtn')?.addEventListener('click', () => {
        mobileOpen.classList.remove('translate-x-full');
        mobileOpen.classList.add('translate-x-0');
        mobileOverlay.classList.remove('opacity-0','pointer-events-none');
        mobileOverlay.classList.add('opacity-100');
      });

      // close handlers
      document.getElementById('mobileMenuClose')?.addEventListener('click', closeMobile);
      mobileOverlay?.addEventListener('click', closeMobile);

      function closeMobile(){
        mobileOpen.classList.add('translate-x-full');
        mobileOpen.classList.remove('translate-x-0');
        mobileOverlay.classList.add('opacity-0','pointer-events-none');
        mobileOverlay.classList.remove('opacity-100');
      }

      // GLightbox init only if .glightbox present
      if(document.querySelectorAll('.glightbox').length){
        GLightbox({ selector: '.glightbox', loop:true, touchNavigation:true, openEffect:'zoom' });
      }

      // accessibility: close menu with Esc
      document.addEventListener('keydown', (e) => {
        if(e.key === 'Escape') closeMobile();
      });
    })();
  </script>

  @stack('scripts')
  @yield('script')
</body>
</html>
