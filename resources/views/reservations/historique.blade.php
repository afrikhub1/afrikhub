@extends('pages.heritage_pages')

@section('title', 'Réservations reçues')

@section('main')
    <style>
        /* TA COULEUR DE BASE ET STYLES PERSONNALISÉS */
        .bg-gradient-brand { background: linear-gradient(135deg, #006d77, #00afb9); }
        .text-brand { color: #006d77; }
        .border-brand { border-color: #006d77; }
        .card-res-received { 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            box-shadow: 0 10px 25px -5px rgba(0, 109, 119, 0.05);
        }
        .card-res-received:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 20px 30px -10px rgba(0, 109, 119, 0.15);
        }
    </style>

    <div class="container-fluid px-4 py-6 mt-4">
        <main class="bg-white p-6 md:p-10 rounded-[2rem] shadow-xl border border-slate-100">
            
            <div class="page-header text-center mb-12">
                <span class="inline-block px-4 py-1.5 bg-emerald-50 text-brand text-[0.65rem] font-bold uppercase tracking-[0.2em] rounded-full mb-3">
                    Gestion des demandes
                </span>
                <h1 class="text-3xl md:text-4xl font-black text-slate-900 mb-2">
                    Réservations reçues
                </h1>
                <div class="w-24 h-1.5 bg-gradient-brand mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($reservationsRecu as $res)
                    <div class="card-res-received bg-white rounded-[2rem] overflow-hidden flex flex-col border border-slate-100
                        @if($res->status == 'confirmée') border-t-emerald-500 border-t-4
                        @elseif($res->status == 'en_attente') border-t-cyan-500 border-t-4
                        @elseif($res->status == 'terminée') border-t-slate-400 border-t-4
                        @else border-t-rose-500 border-t-4 @endif">

                        <div class="p-6 flex flex-col flex-grow">

                            <div class="mb-4 flex justify-between items-start">
                                @php
                                    $statusClass = [
                                        'en_attente' => 'bg-cyan-50 text-cyan-600 border border-cyan-100',
                                        'confirmée' => 'bg-emerald-50 text-emerald-600 border border-emerald-100',
                                        'terminée' => 'bg-slate-50 text-slate-600 border border-slate-100',
                                        'annulée' => 'bg-rose-50 text-rose-600 border border-rose-100',
                                    ][$res->status] ?? 'bg-gray-50 text-gray-600';
                                @endphp
                                <span class="px-3 py-1 text-[0.65rem] font-black uppercase tracking-wider {{ $statusClass }} rounded-lg">
                                    {{ mb_strtoupper(str_replace('_', ' ', $res->status), 'UTF-8') }}
                                </span>
                                <i class="fas fa-receipt text-slate-200 text-xl"></i>
                            </div>

                            <h5 class="text-xl font-bold text-slate-800 mb-1 truncate">{{ $res->residence->nom }}</h5>
                            <p class="text-xs font-semibold text-slate-400 mb-6 flex items-center">
                                <i class="fas fa-location-dot text-brand mr-1.5"></i> {{ $res->residence->ville }}
                            </p>

                            <ul class="space-y-3 text-sm border-t border-slate-50 pt-5 mb-6">
                                <li class="flex flex-col gap-1">
                                    <span class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest">Suivi :</span>
                                    <span class="text-slate-700 font-bold italic text-xs">
                                        <i class="fas fa-clock mr-1.5 text-brand/50"></i>
                                        {{ $res->status != 'payée'
                                        ? mb_strtoupper($res->status, 'UTF-8') . ' LE ' . (optional($res->date_validation)->format('d/m/Y') ?? '-')
                                        : 'PAYÉE LE ' . (optional($res->date_paiement)->format('d/m/Y') ?? '-') }}
                                    </span>
                                </li>
                                <li class="flex flex-col gap-1">
                                    <span class="text-[0.65rem] font-bold text-slate-400 uppercase tracking-widest">Période :</span>
                                    <span class="text-slate-700 font-bold text-xs">
                                        <i class="fas fa-calendar-alt mr-1.5 text-brand/50"></i>
                                        {{ $res->date_arrivee ? \Carbon\Carbon::parse($res->date_arrivee)->format('d/m/Y') : '-' }} 
                                        <i class="fas fa-arrow-right mx-1 text-[10px] text-slate-300"></i>
                                        {{ $res->date_depart ? \Carbon\Carbon::parse($res->date_depart)->format('d/m/Y') : '-' }}
                                    </span>
                                </li>
                            </ul>

                            <div class="mt-auto bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase">Montant perçu</span>
                                    <p class="text-lg font-black text-brand">
                                        {{ number_format($res->total, 0, ',', ' ') }} <small class="text-[10px]">FCFA</small>
                                    </p>
                                </div>
                                <p class="text-[9px] text-slate-400 mt-2 text-right italic font-medium">
                                    Reçu le {{ $res->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-inbox text-3xl text-slate-200"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Aucune réservation pour le moment</h3>
                        <p class="text-slate-500 max-w-sm mx-auto">Dès qu'un client réservera l'un de vos biens, il apparaîtra ici.</p>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
@endsection