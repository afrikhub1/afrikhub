@extends('admin.header_footer')

@section('titre', 'Journal des activités')

@section('main')

<div class="container mx-auto p-4">

    <h1 class="lg:text-4xl md:text-2xl text-xl font-extrabold text-indigo-700 mb-8 text-center border-b-4 border-indigo-500 pb-3">
        <i class="fas fa-history text-indigo-500 mr-3"></i>Journal des activités
    </h1>

    {{-- Statistiques rapides --}}
    <div class="mb-6 flex flex-wrap gap-4 justify-center">
        <span class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-full text-sm font-bold shadow-sm">
            Total : {{ $logs->total() }} événements
        </span>
    </div>

    @if($logs->isEmpty())
        <div class="col-span-full text-center p-10 bg-white rounded-2xl shadow-md">
            <p class="text-gray-500 italic text-lg">Aucune activité enregistrée pour le moment.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6">
            @foreach($logs as $log)
                @php
                    // Logique de couleur selon l'action
                    $actionType = strtolower($log->action);
                    $badgeColor = match(true) {
                        str_contains($actionType, 'creation') || str_contains($actionType, 'inscription') => 'bg-green-500',
                        str_contains($actionType, 'reservation') => 'bg-blue-500',
                        str_contains($actionType, 'interruption') || str_contains($actionType, 'suppression') => 'bg-red-500',
                        str_contains($actionType, 'connexion') => 'bg-indigo-500',
                        default => 'bg-gray-500',
                    };
                @endphp

                <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col justify-between hover:shadow-xl transition-all border-l-8 border-indigo-400">

                    {{-- Header : Action & Date --}}
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 rounded text-white text-xs font-bold uppercase {{ $badgeColor }}">
                            {{ $log->action }}
                        </span>
                        <span class="text-xs text-gray-400 italic">
                            {{ $log->created_at->diffForHumans() }}
                        </span>
                    </div>

                    {{-- Corps des informations --}}
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold border border-indigo-100">
                                {{ substr($log->user->name ?? '?', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">{{ $log->user->name ?? 'Visiteur' }}</p>
                                <p class="text-[10px] text-gray-400 truncate w-40">{{ $log->user->email ?? 'Session publique' }}</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                            <p class="text-sm text-gray-700 leading-relaxed">
                                <i class="fas fa-info-circle text-indigo-400 mr-1"></i> {{ $log->description }}
                            </p>
                        </div>

                        {{-- Détails techniques --}}
                        <div class="text-xs space-y-1.5 pt-2 border-t border-gray-100">
                            <p class="flex items-center text-gray-600">
                                <i class="fas fa-network-wired w-5 text-gray-400"></i>
                                <strong>IP :</strong> <span class="ml-1 font-mono text-indigo-600">{{ $log->ip_address }}</span>
                            </p>

                            <p class="flex items-center text-gray-600">
                                @if($log->code_pays)
                                    <img src="https://flagcdn.com/w20/{{ strtolower($log->code_pays) }}.png" class="w-4 mr-1 rounded-sm">
                                @else
                                    <i class="fas fa-map-marker-alt w-5 text-gray-400"></i>
                                @endif
                                <strong>Lieu :</strong> <span class="ml-1">{{ $log->ville }}, {{ $log->pays }}</span>
                            </p>

                            <p class="flex items-start text-gray-500 leading-tight">
                                <i class="{{ str_contains($log->user_agent, 'Mobile') ? 'fas fa-mobile-alt' : 'fas fa-desktop' }} w-5 mt-0.5 text-gray-400"></i>
                                <span class="text-[10px]">{{ Str::limit($log->user_agent, 60) }}</span>
                            </p>
                        </div>
                    </div>

                    {{-- Footer : Horodatage précis --}}
                    <div class="mt-4 pt-3 border-t border-gray-50 text-right">
                        <p class="text-[10px] text-gray-400 font-semibold">
                            Le {{ $log->created_at->format('d/m/Y') }} à {{ $log->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination stylisée --}}
        <div class="mt-10">
            {{ $logs->links() }}
        </div>
    @endif

</div>

@endsection
