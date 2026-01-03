<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique de Facturation — {{ config('app.name') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .card-shadow { box-shadow: 0 6px 20px rgba(12, 17, 36, 0.06); }
    </style>
</head>
<body class="bg-gray-50 text-slate-900">

<header class="bg-white/80 backdrop-blur-md shadow-sm fixed top-0 left-0 right-0 z-20 border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-20">
        <div class="flex items-center space-x-4">
            <button id="sidebarToggle" class="text-gray-600 hover:text-indigo-600 md:hidden transition">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <a href="{{ route('accueil') }}" class="flex items-center gap-3">
                <img src="{{ asset('assets/logo.png') }}" alt="Afrique Hub Logo" class="h-12 w-auto object-contain">
                <span class="text-xl font-black tracking-tighter text-indigo-900 uppercase hidden sm:block">Afrique Hub</span>
            </a>
        </div>

        <nav class="hidden md:flex items-center space-x-6 text-sm font-bold">
            <a href="{{ route('accueil') }}" class="text-slate-600 hover:text-indigo-600 transition flex items-center gap-2">
                <i class="fas fa-home text-indigo-400"></i> Accueil
            </a>
            <a href="{{ route('recherche') }}" class="text-slate-600 hover:text-indigo-600 transition flex items-center gap-2">
                <i class="fas fa-search text-indigo-400"></i> Recherche
            </a>
            <a href="{{ route('clients_historique') }}" class="text-indigo-600 flex items-center gap-2">
                <i class="fas fa-history"></i> Réservations
            </a>
            <form action="{{ route('logout') }}" method="POST" class="ml-4">
                @csrf
                <button type="submit" class="py-2.5 px-5 bg-rose-50 text-rose-600 rounded-full hover:bg-rose-100 transition flex items-center gap-2 border border-rose-100">
                    <i class="fas fa-sign-out-alt"></i> Quitter
                </button>
            </form>
        </nav>
    </div>
</header>

<div id="overlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-30 hidden"></div>
<aside id="mobileSidebar" class="fixed top-0 left-0 h-full w-72 bg-white shadow-2xl transform -translate-x-full transition-transform duration-300 z-40 md:hidden">
    <div class="flex justify-between items-center p-6 border-b">
        <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-10 w-auto">
        <button id="closeSidebar" class="text-slate-400 hover:text-rose-500"><i class="fas fa-times text-xl"></i></button>
    </div>
    <nav class="flex flex-col p-6 space-y-4">
        <a href="{{ route('accueil') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-indigo-50 text-slate-600 font-semibold transition"><i class="fas fa-home text-indigo-500"></i> Accueil</a>
        <a href="{{ route('recherche') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-indigo-50 text-slate-600 font-semibold transition"><i class="fas fa-search text-indigo-500"></i> Recherche</a>
        <a href="{{ route('clients_historique') }}" class="flex items-center gap-3 p-3 rounded-xl bg-indigo-50 text-indigo-700 font-bold"><i class="fas fa-history"></i> Mes réservations</a>
        <hr>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-3 p-4 bg-rose-600 text-white rounded-xl font-bold shadow-lg shadow-rose-200">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </button>
        </form>
    </nav>
</aside>

<main class="container mx-auto px-4 pt-32 pb-12">

    <div class="text-center mb-12">
        <h1 class="text-3xl lg:text-5xl font-extrabold text-slate-900 mb-4 tracking-tight">
            Historique de <span class="text-indigo-600">Facturation</span>
        </h1>
        <p class="text-slate-500 max-w-xl mx-auto">Consultez et téléchargez vos justificatifs de paiement pour vos séjours Afrique Hub.</p>
    </div>

    @if($reservations->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($reservations as $res)
                @php
                    $facturestatus = $res->status;
                    $dateArrivee = \Carbon\Carbon::parse($res->date_arrivee);
                    $dateDepart = \Carbon\Carbon::parse($res->date_depart);
                    $jours = $dateDepart->diffInDays($dateArrivee);
                @endphp

                <div class="bg-white rounded-[2rem] border border-slate-100 card-shadow overflow-hidden group hover:border-indigo-200 transition-all duration-300">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-6">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $facturestatus == 'payée' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $facturestatus }}
                            </span>
                            <i class="fas fa-file-invoice text-slate-200 group-hover:text-indigo-500 transition-colors text-2xl"></i>
                        </div>

                        <h5 class="text-lg font-bold text-slate-900 mb-1">#{{ $res->reservation_code }}</h5>
                        <p class="text-xs text-slate-400 font-semibold mb-6 truncate">{{ $res->residence->nom ?? 'Résidence' }}</p>

                        <div class="space-y-3 mb-8">
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-400 font-medium">Séjour</span>
                                <span class="text-slate-900 font-bold">{{ $jours }} nuits</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-400 font-medium">Arrivée</span>
                                <span class="text-slate-900 font-bold">{{ $dateArrivee->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-400 font-medium">Départ</span>
                                <span class="text-slate-900 font-bold">{{ $dateDepart->format('d M Y') }}</span>
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-2xl p-4 mb-6">
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Montant Total</p>
                            <p class="text-xl font-black text-indigo-700">
                                {{ str_replace('-', '', number_format($res->total, 0, '.', ' ')) }} <span class="text-xs">FCFA</span>
                            </p>
                        </div>

                        <div class="grid gap-2">
                            <a href="{{ route('facture.telecharger', $res->id) }}" target="_blank" class="flex items-center justify-center gap-2 py-3 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-indigo-600 transition shadow-lg shadow-slate-200">
                                <i class="fas fa-cloud-download-alt"></i> Télécharger PDF
                            </a>

                            @if($facturestatus == 'confirmée')
                                <a href="{{ route('paiement.qr') }}" class="flex items-center justify-center gap-2 py-3 bg-amber-500 text-white rounded-xl text-xs font-bold hover:bg-amber-600 transition shadow-lg shadow-amber-100">
                                    <i class="fas fa-credit-card"></i> Payer maintenant
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="max-w-md mx-auto bg-white p-12 rounded-[3rem] shadow-xl text-center border border-slate-50">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-200">
                <i class="fas fa-folder-open text-4xl"></i>
            </div>
            <p class="text-slate-500 font-medium">Aucun historique de facturation disponible pour le moment.</p>
        </div>
    @endif
</main>

<script>
    const sidebar = document.getElementById('mobileSidebar');
    const overlay = document.getElementById('overlay');

    document.getElementById('sidebarToggle').addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    });

    document.getElementById('closeSidebar').addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });
</script>

</body>
</html>
