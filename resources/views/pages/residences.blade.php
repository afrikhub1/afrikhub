@extends('pages.heritage_pages')

@section('title', 'Mes Résidences')

@section('main')
    <style>
        /* Définition des couleurs basées sur ton dégradé */
        :root {
            --primary-gradient: linear-gradient(135deg, #006d77, #00afb9);
            --primary-dark: #006d77;
            --primary-light: #00afb9;
        }

        .bg-custom-gradient { background: var(--primary-gradient); }
        .text-custom-primary { color: var(--primary-dark); }
        .border-custom-primary { border-color: var(--primary-dark); }
        
        .residence-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #f1f5f9;
        }
        
        .residence-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 109, 119, 0.1), 0 10px 10px -5px rgba(0, 109, 119, 0.04);
        }

        .text-gradient-title {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>

    <div class="container-fluid px-4 py-4">

        <div class="text-center mb-10">
            <h1 class="text-3xl lg:text-4xl font-extrabold uppercase tracking-tight mb-3">
                <i class="fas fa-house-user mr-3 text-custom-primary"></i>
                <span class="text-gradient-title">Mes Résidences</span>
            </h1>
            <div class="h-1.5 w-32 bg-custom-gradient mx-auto rounded-full"></div>
        </div>

        @if($residences->isEmpty())
            <div class="bg-white border-t-4 border-custom-primary shadow-xl p-10 rounded-2xl text-center mx-auto max-w-lg">
                <div class="w-20 h-20 bg-cyan-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-folder-open text-custom-primary text-3xl"></i>
                </div>
                <p class="font-bold text-xl text-gray-800">Aucune résidence enregistrée</p>
                <p class="text-gray-500 mt-2 mb-6">Votre catalogue est actuellement vide.</p>
                <a href="{{ route('mise_en_ligne') }}" class="bg-custom-gradient text-white px-8 py-3 rounded-full font-bold shadow-lg hover:opacity-90 transition inline-block">
                    Mettre un bien en ligne
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($residences as $residence)
                    <div class="residence-card bg-white rounded-2xl overflow-hidden flex flex-col shadow-sm">
                        @php
                           $images = $residence->img;
                            if (is_string($images)) {
                                $images = json_decode($images, true) ?? [];
                            };
                            $firstImage = $images[0] ?? null;
                            $imagePath = $firstImage ? $firstImage 
                            : 'https://placehold.co/400x250/f0fdfa/006d77?text=Pas+d\'image';
                        @endphp

                        <div class="relative group">
                            <a href="{{ $imagePath }}" class="glightbox block" data-gallery="residence-{{ $residence->id }}" data-title="{{ $residence->nom }}">
                                <img src="{{ $imagePath }}" class="w-full h-56 object-cover transition duration-500 group-hover:scale-105"
                                    onerror="this.onerror=null;this.src='https://placehold.co/400x250/f0fdfa/006d77?text=Image+Indisponible';"
                                    alt="Image de la résidence">
                                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors"></div>
                            </a>
                            <div class="absolute bottom-4 left-4">
                                <span class="bg-white/95 backdrop-blur-sm text-custom-primary font-black px-4 py-2 rounded-xl shadow-lg">
                                    {{ number_format($residence->prix_journalier, 0, ',', ' ') }} <small class="text-[10px] uppercase">FCFA / Jour</small>
                                </span>
                            </div>
                        </div>

                        {{-- Galerie invisible pour les autres images --}}
                        @if (is_array($images))
                            @foreach($images as $key => $image)
                                @if($key > 0)
                                    <a href="{{ $image }}" class="glightbox" data-gallery="residence-{{ $residence->id }}" data-title="{{ $residence->nom }}" hidden></a>
                                @endif
                            @endforeach
                        @endif

                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <h5 class="text-xl font-bold text-gray-800 truncate pr-2">{{ $residence->nom }}</h5>
                                @if($residence->disponible)
                                    <span class="flex h-3 w-3">
                                        <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-green-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                                    </span>
                                @endif
                            </div>

                            <p class="text-gray-500 mb-4 text-sm line-clamp-2 italic">
                                {{ Str::limit($residence->description, 85) }}
                            </p>
                            
                            <div class="space-y-3 mt-auto pt-4 border-t border-gray-50">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400"><i class="fas fa-bed w-6 text-custom-primary"></i> Chambres</span>
                                    <span class="font-bold text-gray-700">{{ $residence->nombre_chambres }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400"><i class="fas fa-couch w-6 text-custom-primary"></i> Salons</span>
                                    <span class="font-bold text-gray-700">{{ $residence->nombre_salons }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-400"><i class="fas fa-map-marked-alt w-6 text-custom-primary"></i> Ville</span>
                                    <span class="font-semibold text-gray-700">{{ $residence->ville }}</span>
                                </div>

                                <div class="pt-2">
                                    @if($residence->disponible)
                                        <div class="w-full py-1.5 text-center rounded-lg bg-green-50 text-green-700 text-xs font-black uppercase tracking-wider border border-green-100">
                                            Disponible Immédiatement
                                        </div>
                                    @else
                                        <div class="w-full py-1.5 text-center rounded-lg bg-red-50 text-red-700 text-xs font-black uppercase tracking-wider border border-red-100">
                                            Indisponible / Occupé
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <a href="{{ route('details', $residence->id) }}" class="mt-4 w-full py-2.5 rounded-xl border-2 border-custom-primary text-custom-primary font-bold text-center hover:bg-custom-gradient hover:text-white hover:border-transparent transition duration-300">
                                Gérer l'annonce
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection