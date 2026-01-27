@extends('pages.heritage_pages')

@section('title', 'Résidences Occupées')

@section('main')
    <style>
        .text-brand { color: #006d77; }
        .bg-brand { background-color: #006d77; }
        .card-occupied {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 2rem;
        }
        .card-occupied:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        }
        .status-pulse {
            animation: pulse-red 2s infinite;
        }
        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(244, 63, 94, 0); }
            100% { box-shadow: 0 0 0 0 rgba(244, 63, 94, 0); }
        }
    </style>

    <div class="container-fluid px-3 py-4 mt-2">
        <main class="bg-white p-6 md:p-10 rounded-[2.5rem] shadow-xl border border-slate-100">
            
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1 bg-rose-50 text-rose-600 text-[0.65rem] font-black uppercase tracking-[0.2em] rounded-full mb-3">
                    Gestion de l'inventaire
                </span>
                <h1 class="text-3xl font-black text-slate-800 mb-2">
                    <i class="fas fa-door-closed mr-3 text-rose-500"></i> Résidences Occupées
                </h1>
                <div class="w-20 h-1.5 bg-rose-500 mx-auto rounded-full"></div>
            </div>

            <section id="occupees">
                @if($residences_occupees->isEmpty())
                    <div class="bg-slate-50 border-2 border-dashed border-slate-200 text-slate-500 p-12 rounded-[2rem] text-center max-w-lg mx-auto">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                            <i class="fas fa-check-circle text-3xl text-emerald-400"></i>
                        </div>
                        <p class="font-bold text-xl text-slate-700">Toutes vos résidences sont libres</p>
                        <p class="text-sm mt-2">Aucune occupation n'est enregistrée pour le moment.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                        @foreach($residences_occupees as $res_occupees)
                            @if($res_occupees)
                                <div class="card-occupied bg-white border border-slate-100 p-6 flex flex-col justify-between relative overflow-hidden">
                                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-rose-50 rounded-full opacity-50"></div>
                                    
                                    <div class="relative">
                                        <div class="flex justify-between items-start mb-6">
                                            <div class="w-12 h-12 bg-rose-100 rounded-2xl flex items-center justify-center text-rose-600">
                                                <i class="fas fa-building text-xl"></i>
                                            </div>
                                            <span class="status-pulse flex h-3 w-3 rounded-full bg-rose-500"></span>
                                        </div>

                                        <h5 class="text-xl font-black text-slate-800 mb-4 leading-tight">
                                            {{ $res_occupees->nom ?? 'Résidence sans nom' }}
                                        </h5>

                                        <div class="space-y-3 mb-8">
                                            <div class="flex items-center text-sm font-medium text-slate-500">
                                                <i class="fas fa-map-marker-alt w-6 text-brand"></i>
                                                {{ $res_occupees->ville ?? 'N/A' }}, {{ $res_occupees->pays ?? 'N/A' }}
                                            </div>
                                            <div class="flex items-center text-sm font-medium text-slate-700">
                                                <i class="fas fa-tag w-6 text-brand"></i>
                                                {{ number_format($res_occupees->prix_journalier ?? 0, 0, ',', ' ') }} 
                                                <span class="ml-1 text-[10px] text-slate-400 font-bold uppercase">FCFA / Nuit</span>
                                            </div>
                                        </div>

                                        <div class="py-2 px-4 bg-rose-50 rounded-xl border border-rose-100 inline-flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                                            <span class="text-[10px] font-black text-rose-600 uppercase tracking-widest">Actuellement Occupée</span>
                                        </div>
                                    </div>

                                    <div class="mt-8">
                                        <a href="{{ route('sejour.interrompre', $res_occupees->reservations->first()->id) }}" 
                                           class="group flex items-center justify-center gap-3 w-full bg-slate-900 text-white p-4 rounded-2xl font-bold text-sm hover:bg-rose-600 transition-all duration-300 shadow-lg shadow-slate-200 hover:shadow-rose-200">
                                            <i class="fas fa-key transition-transform group-hover:-rotate-45"></i>
                                            Libérer la Résidence
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </section>
        </main>
    </div>
@endsection