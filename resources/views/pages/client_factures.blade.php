<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique de Facturation — {{ config('app.name') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-gradient-brand { background: linear-gradient(135deg, #006d77, #00afb9); }
        .text-brand { color: #006d77; }
        .border-brand { border-color: #006d77; }
        .card-shadow { transition: all 0.3s ease; box-shadow: 0 10px 30px -12px rgba(0, 109, 119, 0.15); }
        .card-shadow:hover { transform: translateY(-5px); box-shadow: 0 20px 40px -12px rgba(0, 109, 119, 0.25); }
        .badge-sm { font-size: 0.70rem; padding: 0.25rem 0.6rem; border-radius: 9999px; font-weight: 700; text-transform: uppercase; }
        .glass-header { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="bg-slate-50">

<header class="glass-header border-b border-slate-100 fixed top-0 left-0 right-0 z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-20">
        <div class="flex items-center space-x-4">
            <button id="sidebarToggle" class="text-slate-600 hover:text-brand md:hidden p-2 rounded-lg bg-slate-50">
                <i class="fas fa-bars-staggered text-xl"></i>
            </button>
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="h-12 w-auto">
        </div>
        <nav class="hidden md:flex items-center space-x-6 text-sm font-bold">
            <a href="{{ route('accueil') }}" class="text-slate-500 hover:text-brand transition flex items-center gap-2"><i class="fas fa-house"></i> Accueil</a>
            <a href="{{ route('recherche') }}" class="text-slate-500 hover:text-brand transition flex items-center gap-2"><i class="fas fa-magnifying-glass"></i> Recherche</a>
            <a href="{{ route('clients_historique') }}" class="text-slate-500 hover:text-brand transition flex items-center gap-2"><i class="fas fa-calendar-check"></i> Réservations</a>
            <form action="{{ route('logout') }}" method="POST" class="ml-4">
                @csrf
                <button type="submit" class="py-2.5 px-5 bg-slate-900 text-white rounded-xl hover:bg-red-600 transition duration-300 flex items-center gap-2 shadow-lg shadow-slate-200">
                    <i class="fas fa-power-off"></i> Déconnexion
                </button>
            </form>
        </nav>
    </div>
</header>

<div id="overlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-30 hidden md:hidden"></div>

<aside id="mobileSidebar" class="fixed top-0 left-0 h-full w-72 bg-white shadow-2xl transform -translate-x-full transition-transform duration-300 z-40 md:hidden">
    <div class="flex justify-between items-center p-6 border-b border-slate-50">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="h-10 w-auto">
        <button id="closeSidebar" class="w-10 h-10 flex items-center justify-center rounded-full bg-slate-50 text-slate-400"><i class="fas fa-times"></i></button>
    </div>
    <nav class="flex flex-col mt-6 space-y-2 px-6">
        <a href="{{ route('accueil') }}" class="py-3 px-4 rounded-xl font-semibold text-slate-600 hover:bg-emerald-50 hover:text-brand flex items-center gap-3"><i class="fas fa-home w-5"></i> Accueil</a>
        <a href="{{ route('recherche') }}" class="py-3 px-4 rounded-xl font-semibold text-slate-600 hover:bg-emerald-50 hover:text-brand flex items-center gap-3"><i class="fas fa-search w-5"></i> Recherche</a>
        <a href="{{ route('clients_historique') }}" class="py-3 px-4 rounded-xl font-semibold text-slate-600 hover:bg-emerald-50 hover:text-brand flex items-center gap-3"><i class="fas fa-history w-5"></i> Mes réservations</a>
        <form action="{{ route('logout') }}" method="POST" class="mt-6 pt-6 border-t border-slate-50">
            @csrf
            <button type="submit" class="w-full py-4 px-3 bg-red-50 text-red-600 font-bold rounded-xl flex items-center justify-center gap-2 hover:bg-red-600 hover:text-white transition-all">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </button>
        </form>
    </nav>
</aside>

<main class="max-w-7xl mx-auto p-4 pt-10 pb-10">

    <div class="text-center mb-12">
        <h1 class="text-3xl lg:text-5xl font-extrabold text-slate-900 mb-4 tracking-tight">
            Historique de Facturation
        </h1>
        <p class="text-slate-500 text-lg max-w-2xl mx-auto">Consultez et téléchargez vos justificatifs de paiement en un clic.</p>
    </div>

    <div class="flex justify-center mb-12">
        <a href="{{ route('clients_historique') }}" class="group py-3 px-6 bg-white text-slate-700 rounded-2xl hover:bg-emerald-50 hover:text-brand transition duration-300 font-bold border border-slate-200 flex items-center gap-3 shadow-sm hover:border-brand/30">
            <div class="p-2 bg-emerald-100 rounded-lg group-hover:bg-brand group-hover:text-white transition-colors">
                <i class="fas fa-arrow-left text-sm"></i>
            </div>
            Retour aux Réservations
        </a>
    </div>

    @if($reservations->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($reservations as $res)
                @php
                    $facturestatus = $res->status;
                    $reference = $res->reference;
                    $prixJour = $res->residence->prix_journalier;
                    $datePaiement = $res->date_paiement;
                    $dateArrivee = \Carbon\Carbon::parse($res->date_arrivee);
                    $dateDepart = \Carbon\Carbon::parse($res->date_depart);
                    $jours = $dateDepart->diffInDays($dateArrivee);
                @endphp

                <div class="bg-white rounded-[2rem] overflow-hidden flex flex-col border border-slate-100 card-shadow">
                    
                    <div class="h-2 bg-gradient-brand"></div>

                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex justify-between items-start mb-4">
                            <span class="badge-sm 
                                @if($facturestatus == 'payée') bg-emerald-100 text-brand @else bg-orange-100 text-orange-600 @endif">
                                {{ $facturestatus }}
                            </span>
                            <i class="fas fa-file-invoice text-slate-200 text-2xl"></i>
                        </div>

                        <h5 class="text-lg font-extrabold text-slate-900 mb-1">Facture #{{ $res->reservation_code }}</h5>
                        <p class="text-xs font-semibold text-slate-400 mb-6 flex items-center gap-1">
                             {{ $res->residence->nom ?? 'Résidence inconnue' }}
                        </p>

                        <div class="bg-slate-50 rounded-2xl p-4 space-y-3 mb-6 border border-slate-100/50">
                            <div class="flex justify-between items-center text-[13px]">
                                <span class="text-slate-400 italic">Durée</span>
                                <span class="font-bold text-slate-700">{{ str_replace('-', '', number_format($jours, 0, ',', ' ')) }} nuit(s)</span>
                            </div>
                            <div class="flex justify-between items-center text-[13px]">
                                <span class="text-slate-400 italic">Réf.</span>
                                <span class="font-bold text-brand truncate max-w-[100px]">{{ $reference ?? '---' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-[13px]">
                                <span class="text-slate-400 italic">Payé le</span>
                                <span class="font-bold text-slate-700">{{ $datePaiement ? \Carbon\Carbon::parse($datePaiement)->format('d/m/Y') : 'En attente' }}</span>
                            </div>
                        </div>

                        <div class="mt-auto pt-4 border-t border-dashed border-slate-200">
                             <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1 text-center">Montant Total</p>
                             <p class="text-2xl font-black text-brand text-center">
                                {{ number_format($res->total, 0, ',', ' ') }} <small class="text-xs">FCFA</small>
                            </p>
                        </div>

                        <div class="mt-6 flex flex-col gap-3">
                            <a href="{{ route('facture.telecharger', $res->id) }}" target="_blank" class="w-full py-3 bg-slate-900 text-white font-bold rounded-xl hover:bg-brand transition duration-300 shadow-lg shadow-slate-200 text-sm flex justify-center items-center gap-2">
                                <i class="fas fa-file-pdf"></i> PDF Facture
                            </a>

                            @if($facturestatus == 'confirmée')
                                <a href="{{ route('paiement.qr', $res->id) }}" class="w-full py-3 bg-gradient-brand text-white font-bold rounded-xl hover:opacity-90 transition duration-300 shadow-lg shadow-cyan-900/20 text-sm flex justify-center items-center gap-2 uppercase tracking-tight">
                                    <i class="fas fa-wallet"></i> Payer maintenant
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white p-16 rounded-[3rem] shadow-sm border border-slate-100 text-center mx-auto max-w-2xl">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-receipt text-3xl text-slate-200"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Aucune facture disponible</h3>
            <p class="text-slate-500 mb-8">Vos factures apparaîtront ici dès que vos réservations seront confirmées ou réglées.</p>
            <a href="{{ route('recherche') }}" class="inline-flex py-3 px-8 bg-gradient-brand text-white font-bold rounded-2xl shadow-xl shadow-cyan-900/20">Explorer les résidences</a>
        </div>
    @endif
</main>

@include('includes.footer')

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