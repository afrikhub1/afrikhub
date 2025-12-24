<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact / Newsletter</title>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Contactez-nous / Newsletter</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  <!-- Header -->
<header class="bg-white border-b fixed w-full z-50 top-0">
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
    <!-- Formulaire -->
    <form action="{{ route('newsletters.store') }}" method="POST" class="shadow p-4 rounded bg-light">
        @csrf
        <div class="row g-3">

            <div class="col-md-6">
                <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom" required>
            </div>

            <div class="col-md-6">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="exemple@domain.com" required>
            </div>

            <div class="col-md-6">
                <label for="telephone" class="form-label">Numéro de téléphone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Ex: 0123456789">
            </div>

            <div class="col-md-6">
                <label for="sujet" class="form-label">Sujet <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="sujet" name="sujet" placeholder="Sujet du message" required>
            </div>

            <div class="col-12">
                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Votre message" required></textarea>
            </div>

        </div>

        <div class="mt-4 text-center">
            <button type="submit" class="btn btn-primary px-5">
                <i class="fas fa-paper-plane"></i> Envoyer
            </button>
        </div>
    </form>
</div>


   @include('includes.footer')

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

<!-- Bootstrap 5 JS (Popper + Bundle) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
