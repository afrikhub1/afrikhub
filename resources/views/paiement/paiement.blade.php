<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Codes Paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        .payment-btn {
            min-width: 120px;
            font-weight: bold;
        }
        #qrDisplay img {
            max-height: 400px;
        }
        #qrDisplay {
            text-align: center;
            margin-top: 30px;
        }
        .qr-card img {
            cursor: pointer;
            transition: transform 0.2s;
        }
        .qr-card img:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="h-100">

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

<!-- Contenu principal -->
<div class="container mt-5">
    <h2 class="mb-4 text-center">Choisissez votre méthode de paiement</h2>

    <!-- Boutons des paiements -->
    <div class="d-flex justify-content-center gap-3 flex-wrap">
        @php
            $paiements = ['Moov', 'MTN', 'Orange', 'Wave'];
        @endphp

        @foreach($paiements as $pay)
            <button class="btn btn-warning payment-btn" data-pay="{{ strtolower($pay) }}">{{ $pay }}</button>
        @endforeach
    </div>

    <!-- Affichage du QR code -->
    <div id="qrDisplay">
        <p class="text-muted mt-3">Cliquez sur un bouton pour afficher le QR code</p>
    </div>
</div>

<div class="row p-0 m-0 justify-content-center bottom-0">

</div>
<footer class="bottom-0">
    @include('includes.footer')
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const qrDisplay = document.getElementById('qrDisplay');

    document.querySelectorAll('.payment-btn').forEach(button => {
        button.addEventListener('click', () => {
            const service = button.getAttribute('data-pay');
            const imgPath = `/assets/paiement/code_qr/${service}.jpg`; // fichiers moov.jpg, mtn.jpg, orange.jpg, wave.jpg

            qrDisplay.innerHTML = `
            <div class='col-12 row m-o justify-content-center'>
                <h4>${service.toUpperCase()}</h4>
                    <img src="${imgPath}" alt="QR Code ${service}" class="img-fluid rounded shadow" style="max-width:400px;">
                <p class="mt-2">Scannez ce QR code avec votre application ${service} pour effectuer le paiement.</p>
            </div>

            `;
        });
    });
    </script>

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
