<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Codes Paiement | Afrik'Hub</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            padding-top: 80px;
        }

        .payment-btn {
            min-width: 140px;
            padding: 12px 20px;
            border-radius: 15px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Couleurs spécifiques aux opérateurs */
        .btn-moov { background-color: #0056b3; color: white; }
        .btn-mtn { background-color: #ffcc00; color: #000; }
        .btn-orange { background-color: #ff6600; color: white; }
        .btn-wave { background-color: #1cb0f6; color: white; }

        .payment-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            filter: brightness(1.1);
        }

        .payment-btn.active {
            ring: 4px solid #00afb9;
            transform: scale(0.95);
        }

        #qrDisplay img {
            max-height: 350px;
            border-radius: 20px;
            margin: 0 auto;
        }

        .qr-card {
            background: white;
            border-radius: 30px;
            padding: 30px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
            animation: slideUp 0.4s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-slate-50">

    <header class="bg-white/80 backdrop-blur-md border-b fixed w-full z-50 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('accueil') }}" class="block">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto">
                    </a>
                    <h1 class="text-md font-bold text-slate-700 hidden sm:block border-l pl-4 italic">
                        {{ Auth::user()->name ?? 'Utilisateur' }}
                    </h1>
                </div>

                <nav class="hidden md:flex items-center space-x-2">
                    <a href="{{ route('recherche') }}" class="px-4 py-2 text-sm font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition">Résidences</a>
                    <a href="{{ route('factures') }}" class="px-4 py-2 text-sm font-bold text-slate-600 hover:bg-slate-100 rounded-xl transition">Factures</a>

                    @if(Auth::user()->type_compte == 'client')
                        <a href="{{ route('devenir_pro') }}" class="px-5 py-2 bg-[#006d77] text-white font-bold rounded-xl shadow-lg hover:bg-[#005a63] transition">Devenir Pro</a>
                    @else
                        <a href="{{ route('pro.dashboard') }}" class="px-5 py-2 bg-[#006d77] text-white font-bold rounded-xl shadow-lg hover:bg-[#005a63] transition">Tableau de bord</a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="ml-2 p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition">
                            <i class="fas fa-power-off text-lg"></i>
                        </button>
                    </form>
                </nav>

                <button id="sidebarToggle" class="md:hidden p-2 text-slate-700">
                    <i class="fas fa-bars-staggered text-xl"></i>
                </button>
            </div>
        </div>
    </header>

    <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-white shadow-2xl transform -translate-x-full transition-transform z-[60] overflow-y-auto">
        <div class="p-6 border-b flex justify-between items-center">
            <img src="{{ asset('assets/images/logo.png') }}" class="h-8 w-auto">
            <button id="sidebarClose" class="text-slate-400 hover:text-slate-900"><i class="fas fa-times text-xl"></i></button>
        </div>
        <nav class="p-4 space-y-2">
            <a href="{{ route('recherche') }}" class="flex items-center gap-3 p-3 font-bold text-slate-600 hover:bg-slate-50 rounded-xl"><i class="fas fa-search text-[#00afb9]"></i> Résidences</a>
            <a href="{{ route('factures') }}" class="flex items-center gap-3 p-3 font-bold text-slate-600 hover:bg-slate-50 rounded-xl"><i class="fas fa-file-invoice text-[#00afb9]"></i> Factures</a>
            <div class="pt-4 mt-4 border-t">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full p-3 bg-rose-50 text-rose-600 font-bold rounded-xl flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <main class="container py-10">
        <div class="max-w-3xl mx-auto text-center">
            <span class="inline-block px-4 py-1 bg-[#00afb9]/10 text-[#006d77] text-xs font-black uppercase tracking-widest rounded-full mb-4">
                Paiement Sécurisé
            </span>
            <h2 class="text-3xl font-black text-slate-800 mb-8">Comment souhaitez-vous régler ?</h2>

            <div class="flex justify-center gap-3 flex-wrap mb-12">
                @php $paiements = ['Moov', 'MTN', 'Orange', 'Wave']; @endphp
                @foreach($paiements as $pay)
                    <button class="payment-btn btn-{{ strtolower($pay) }}" data-pay="{{ strtolower($pay) }}">
                        {{ $pay }}
                    </button>
                @endforeach
            </div>

            <div id="qrDisplay" class="min-h-[400px] flex items-center justify-center">
                <div class="text-slate-400">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                        <i class="fas fa-qrcode text-3xl"></i>
                    </div>
                    <p class="font-bold">Sélectionnez un opérateur pour voir le QR code</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="mt-20">
        @include('includes.footer')
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const qrDisplay = document.getElementById('qrDisplay');

        document.querySelectorAll('.payment-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Gestion de l'état actif visuel
                document.querySelectorAll('.payment-btn').forEach(b => b.classList.remove('active', 'ring-4'));
                button.classList.add('active', 'ring-4');

                const service = button.getAttribute('data-pay');
                const imgPath = `/assets/paiement/code_qr/${service}.jpg`;

                qrDisplay.innerHTML = `
                <div class="qr-card w-full max-w-md mx-auto border border-slate-100">
                    <div class="flex items-center justify-center gap-3 mb-6">
                        <div class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <h4 class="text-xl font-black text-slate-800 uppercase tracking-tighter">${service} Money</h4>
                    </div>
                    
                    <div class="bg-slate-50 p-4 rounded-[2rem] inline-block mb-6">
                        <img src="${imgPath}" alt="QR Code ${service}" class="img-fluid shadow-2xl" 
                             onerror="this.src='https://placehold.co/400x400/f8fafc/64748b?text=QR+Indisponible'">
                    </div>
                    
                    <div class="space-y-3">
                        <p class="text-sm font-bold text-slate-600">
                            Scannez ce code avec votre application <span class="text-[#006d77]">${service}</span> pour finaliser.
                        </p>
                        <div class="py-3 px-4 bg-emerald-50 rounded-xl flex items-center justify-center gap-2 text-emerald-700 text-xs font-bold">
                            <i class="fas fa-shield-check"></i> Transaction 100% sécurisée
                        </div>
                    </div>
                </div>
                `;
            });
        });

        // Sidebar logic
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');

        sidebarToggle.addEventListener('click', () => sidebar.classList.remove('-translate-x-full'));
        sidebarClose.addEventListener('click', () => sidebar.classList.add('-translate-x-full'));
    </script>
</body>
</html>