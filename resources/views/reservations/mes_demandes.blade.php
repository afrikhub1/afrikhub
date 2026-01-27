@extends('pages.heritage_pages')

@section('title', 'Demandes de Réservation')

@section('main')
    <style>
        .text-brand { color: #006d77; }
        .bg-brand { background-color: #006d77; }
        .border-brand { border-color: #006d77; }
        .bg-gradient-brand { background: linear-gradient(135deg, #006d77, #00afb9); }
        .card-demande { 
            transition: all 0.3s ease; 
            border-radius: 1.5rem;
        }
        .card-demande:hover { 
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 109, 119, 0.1), 0 10px 10px -5px rgba(0, 109, 119, 0.04);
        }
    </style>

    <div class="container-fluid px-3 py-4 mt-2">
        <main class="bg-white p-6 md:p-10 rounded-[2.5rem] shadow-xl border border-gray-100">
            
            <div class="text-center mb-10">
                <h1 class="text-3xl font-black text-slate-800 mb-2 inline-block relative">
                    <i class="fas fa-bell mr-3 text-brand animate-pulse"></i> Demandes de Réservation
                    <span class="absolute -bottom-2 left-0 w-full h-1.5 bg-gradient-brand rounded-full"></span>
                </h1>
            </div>

            @if($demandes->isEmpty())
                <div class="bg-slate-50 border-2 border-dashed border-slate-200 text-slate-500 p-12 rounded-[2rem] text-center max-w-lg mx-auto">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                        <i class="fas fa-bell-slash text-2xl text-slate-300"></i>
                    </div>
                    <p class="font-bold text-xl text-slate-700">Aucune demande en attente</p>
                    <p class="text-sm mt-2 font-medium">Vos nouvelles demandes apparaîtront ici dès qu'un client effectuera une réservation.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($demandes as $res)
                        @php
                            $residence = $res->residence;
                            $images = is_string($residence->img) ? json_decode($residence->img, true) ?? [] : $residence->img;
                            $firstImage = $images[0] ?? 'https://placehold.co/400x250/f1f5f9/64748b?text=PAS+D\'IMAGE';
                            
                            $statusColors = [
                                'en attente' => 'bg-cyan-50 text-cyan-600 border-cyan-100',
                                'confirmée'  => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'annulée'    => 'bg-rose-50 text-rose-600 border-rose-100',
                                'interrompue'=> 'bg-slate-100 text-slate-600 border-slate-200',
                                'payée'      => 'bg-amber-50 text-amber-600 border-amber-100',
                            ];
                            
                            $statusText = [
                                'en attente' => 'À VALIDER',
                                'confirmée'  => 'CONFIRMÉE',
                                'annulée'    => 'ANNULÉE (CLIENT)',
                                'interrompue'=> 'INTERROMPUE',
                                'payée'      => 'PAYÉE',
                            ];
                        @endphp

                        <div class="card-demande bg-white border border-slate-100 overflow-hidden flex flex-col h-full
                            @if($res->status == 'en attente') ring-2 ring-cyan-500/10 @endif">

                            <div class="relative group">
                                <img src="{{ $firstImage }}" class="w-full h-48 object-cover"
                                    onerror="this.onerror=null;this.src='https://placehold.co/400x250/f1f5f9/64748b?text=AFRIKHUB';"
                                    alt="Résidence">
                                <div class="absolute top-3 right-3">
                                    <span class="px-3 py-1 text-[10px] font-black border {{ $statusColors[$res->status] ?? 'bg-rose-50 text-rose-600' }} rounded-lg shadow-sm backdrop-blur-md">
                                        {{ $statusText[$res->status] ?? 'REFUSÉE' }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-5 flex flex-col flex-grow">
                                <h5 class="text-lg font-bold text-slate-800 mb-1 truncate">{{ $residence->nom }}</h5>
                                <p class="text-xs font-semibold text-slate-400 mb-4 flex items-center">
                                    <i class="fas fa-map-marker-alt text-brand mr-1.5"></i> {{ $residence->ville }}
                                </p>

                                <div class="bg-slate-50 rounded-xl p-3 space-y-2 mb-5">
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-slate-400 font-bold uppercase tracking-tighter">Arrivée</span>
                                        <span class="text-slate-700 font-black">{{ $res->date_arrivee->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-slate-400 font-bold uppercase tracking-tighter">Départ</span>
                                        <span class="text-slate-700 font-black">{{ $res->date_depart->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="pt-2 border-t border-slate-200 flex justify-between items-center text-xs">
                                        <span class="text-slate-400 font-bold uppercase tracking-tighter">Reçue le</span>
                                        <span class="text-brand font-bold">{{ $res->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>

                                @if($res->status == 'en attente')
                                    <div class="flex gap-2 mt-auto">
                                        <form action="{{ route('reservation.accepter', $res->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full py-2.5 bg-brand text-white text-xs font-bold rounded-xl hover:bg-[#005a63] transition-colors shadow-lg shadow-cyan-900/10 flex items-center justify-center gap-2">
                                                <i class="fas fa-check-circle"></i> Accepter
                                            </button>
                                        </form>

                                        <form action="{{ route('reservation.refuser', $res->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" class="w-full py-2.5 bg-rose-50 text-rose-600 text-xs font-bold rounded-xl hover:bg-rose-100 transition-colors flex items-center justify-center gap-2 border border-rose-100">
                                                <i class="fas fa-times-circle"></i> Refuser
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </main>
    </div>
@endsection