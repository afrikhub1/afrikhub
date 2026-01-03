@extends('admin.header_footer')

@section('titre', 'Journal des activités')

@section('main')

<div class="container mx-auto p-4">

    {{-- Titre de la page --}}
    <h1 class="lg:text-4xl md:text-2xl text-xl font-extrabold text-indigo-700 mb-8 text-center border-b-4 border-indigo-500 pb-3">
        <i class="fas fa-fingerprint text-indigo-500 mr-3"></i>Journal des Activités
    </h1>

    {{-- Alertes de session --}}
    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded-xl mb-6 text-center shadow-lg animate-bounce">
            {{ session('success') }}
        </div>
    @endif

    {{-- Barre de statistiques rapides --}}
    <div class="mb-8 flex justify-center">
        <div class="bg-white px-6 py-2 rounded-full shadow-sm border border-indigo-100 flex items-center space-x-4">
            <span class="flex items-center text-sm font-medium text-gray-600">
                <i class="fas fa-list-ul mr-2 text-indigo-500"></i> {{ $logs->total() }} événements enregistrés
            </span>
        </div>
    </div>

    @if($logs->isEmpty())
        <div class="col-span-full text-center p-20 bg-white rounded-3xl shadow-md border-2 border-dashed border-gray-200">
            <i class="fas fa-history text-5xl text-gray-200 mb-4"></i>
            <p class="text-gray-500 text-lg italic">Aucune activité détectée sur la plateforme.</p>
        </div>
    @else
        {{-- Grille des Logs --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($logs as $log)
                @php
                    // Logique de couleur selon le type d'action
                    $actionType = strtolower($log->action);
                    $badgeColor = match(true) {
                        str_contains($actionType, 'creation') || str_contains($actionType, 'inscription') => 'bg-emerald-500',
                        str_contains($actionType, 'reservation') => 'bg-blue-500',
                        str_contains($actionType, 'mdp') || str_contains($actionType, 'securite') => 'bg-orange-500',
                        str_contains($actionType, 'suppression') || str_contains($actionType, 'interruption') => 'bg-rose-500',
                        str_contains($actionType, 'connexion') => 'bg-indigo-600',
                        default => 'bg-slate-500',
                    };
                @endphp

                <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col overflow-hidden group">

                    {{-- Barre de couleur supérieure --}}
                    <div class="h-1.5 w-full {{ $badgeColor }}"></div>

                    <div class="p-5 flex-1 flex flex-col">
                        {{-- Header Log : Action & Date --}}
                        <div class="flex justify-between items-start mb-4">
                            <span class="px-3 py-1 rounded-lg text-white text-[10px] font-black uppercase tracking-wider {{ $badgeColor }}">
                                {{ $log->action }}
                            </span>
                            <span class="text-[10px] text-gray-400 font-medium">
                                <i class="far fa-clock mr-1"></i>{{ $log->created_at->diffForHumans() }}
                            </span>
                        </div>

                        {{-- Profil Utilisateur --}}
                        <div class="flex items-center mb-4 bg-indigo-50/50 p-2 rounded-xl border border-indigo-50">
                            <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold shadow-md">
                                {{ substr($log->user->name ?? '?', 0, 1) }}
                            </div>
                            <div class="ml-3 overflow-hidden">
                                <p class="text-sm font-extrabold text-gray-900 truncate">{{ $log->user->name ?? 'Utilisateur Inconnu' }}</p>
                                <p class="text-[10px] text-indigo-500 font-medium truncate">{{ $log->user->email ?? 'Session Invité' }}</p>
                            </div>
                        </div>

                        {{-- Description de l'action --}}
                        <div class="mb-5 flex-1">
                            <p class="text-sm text-gray-700 leading-snug">
                                <i class="fas fa-quote-left text-gray-200 mr-1"></i>
                                {{ $log->description }}
                            </p>
                        </div>

                        {{-- Section Technique & Géo --}}
                        <div class="space-y-2.5 pt-4 border-t border-gray-50">

                            {{-- IP --}}
                            <div class="flex items-center text-xs text-gray-600">
                                <div class="w-6"><i class="fas fa-network-wired text-gray-400"></i></div>
                                <span class="font-mono bg-gray-100 px-2 py-0.5 rounded text-indigo-600 font-bold">
                                    {{ $log->ip_address }}
                                </span>
                            </div>

                            {{-- Géo-localisation cliquable --}}
                            @if($log->latitude && $log->longitude)
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $log->latitude }},{{ $log->longitude }}"
                                   target="_blank"
                                   class="flex items-center text-xs text-gray-600 hover:text-indigo-600 transition-colors group/geo">
                                    <div class="w-6">
                                        @if($log->code_pays)
                                            <img src="https://flagcdn.com/w20/{{ strtolower($log->code_pays) }}.png" class="w-4 rounded-sm">
                                        @else
                                            <i class="fas fa-map-marker-alt text-rose-500"></i>
                                        @endif
                                    </div>
                                    <span class="underline decoration-indigo-200 decoration-dotted group-hover/geo:decoration-solid">
                                        {{ $log->ville }}, {{ $log->pays }}
                                    </span>
                                    <i class="fas fa-external-link-alt ml-2 text-[9px] opacity-0 group-hover/geo:opacity-100"></i>
                                </a>
                            @else
                                <div class="flex items-center text-xs text-gray-400 italic">
                                    <div class="w-6"><i class="fas fa-map-marker-slash"></i></div>
                                    Localisation inconnue
                                </div>
                            @endif

                            {{-- User Agent / Device --}}
                            <div class="flex items-start text-[10px] text-gray-500 leading-tight">
                                <div class="w-6 mt-0.5">
                                    <i class="{{ str_contains($log->user_agent, 'Mobile') ? 'fas fa-mobile-alt text-indigo-400' : 'fas fa-desktop text-slate-400' }}"></i>
                                </div>
                                <span class="flex-1 italic" title="{{ $log->user_agent }}">
                                    {{ Str::limit($log->user_agent, 65) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Footer précis --}}
                    <div class="bg-gray-50 px-5 py-2 flex justify-between items-center border-t border-gray-100">
                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter">ID Enregistrement: #{{ $log->id }}</span>
                        <span class="text-[10px] text-gray-500 font-mono">{{ $log->created_at->format('d/m/Y H:i:s') }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-12 flex justify-center">
            <div class="bg-white p-2 rounded-xl shadow-sm border border-gray-100">
                {{ $logs->links() }}
            </div>
        </div>
    @endif

</div>

@endsection
