@extends('pages.heritage_pages')

@section('title', 'Mes Résidences')

@section('main')
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #006d77, #00afb9);
            --primary-dark: #006d77;
            --primary-light: #00afb9;
        }

        /* Animation d'apparition fluide */
        @keyframes revealCard {
            from { opacity: 0; transform: translateY(20px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .animate-reveal {
            animation: revealCard 0.5s ease-out forwards;
        }

        .text-gradient {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .residence-card-premium {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 24px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .residence-card-premium:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgba(0, 109, 119, 0.2);
            border-color: var(--primary-light);
        }

        /* Badge de prix au design moderne */
        .glass-price {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 14px;
            color: var(--primary-dark);
            font-weight: 900;
        }

        /* Personnalisation de la barre de scroll si nécessaire */
        .custom-shadow-indigo {
            box-shadow: 0 10px 15px -3px rgba(0, 109, 119, 0.1);
        }
    </style>

    <div class="container-fluid px-4 py-6" style="background: linear-gradient(to bottom, #f8fafc, #ffffff);">

        <div class="relative mb-12 text-center">
            <h1 class="text-4xl lg:text-5xl font-black mb-4 tracking-tight">
                <i class="fas fa-house-user mr-3 text-custom-primary text-gradient"></i>
                <span class="text-gray-900">Mes</span> <span class="text-gradient">Résidences</span>
            </h1>
            <div class="h-1.5 w-24 bg-gradient-to-r from-[#006d77] to-[#00afb9] mx-auto rounded-full shadow-sm"></div>
            <p class="text-gray-500 mt-4 font-medium uppercase text-xs tracking-[0.2em]">Gestionnaire de patrimoine immobilier</p>
        </div>

        @if($residences->isEmpty())
            <div class="bg-white border-2 border-dashed border-cyan-100 p-12 rounded-[2rem] text-center shadow-sm mx-auto max-w-lg animate-reveal">
                <div class="mb-6 inline-flex items-center justify-center w-20 h-20 bg-cyan-50 rounded-full">
                    <i class="fas fa-plus text-3xl text-gradient"></i>
                </div>
                <h3 class="font-bold text-2xl text-gray-800">Aucune résidence ?</h3>
                <p class="text-gray-500 mt-2 mb-8">Commencez à générer des revenus en publiant votre premier bien.</p>
                <a href="{{ route('mise_en_ligne') }}" class="inline-block px-8 py-3 bg-gradient-to-r from-[#006d77] to-[#00afb9] text-white font-bold rounded-xl shadow-lg hover:scale-105 transition-transform">
                    Publier une annonce
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($recherches as $index => $residence)
                    <div class="residence-card-premium flex flex-col overflow-hidden animate-reveal" style="animation-delay: {{ $index * 0.1 }}s">
                        
                        @php
                           $images = $residence->img;
                            if (is_string($images)) {
                                $images = json_decode($images, true) ?? [];
                            };
                            $firstImage = $images[0] ?? null;
                            $imagePath = $firstImage ? $firstImage 
                            : 'https://placehold.co/600x400/f1f5f9/006d77?text=Afrik+Hub';
                        @endphp

                        <div class="relative group h-60 overflow-hidden">
                            <a href="{{ $imagePath }}" class="glightbox block h-full" data-gallery="residence-{{ $residence->id }}" data-title="{{ $residence->nom }}">
                                <img src="{{ $imagePath }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110"
                                    onerror="this.onerror=null;this.src='https://placehold.co/600x400/f1f5f9/006d77?text=Image+Indisponible';"
                                    alt="{{ $residence->nom }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                    <span class="text-white text-xs font-bold"><i class="fas fa-search-plus mr-2"></i> Voir les photos</span>
                                </div>
                            </a>
                            
                            <div class="absolute top-4 right-4 glass-price px-4 py-2 shadow-xl">
                                {{ number_format($residence->prix_journalier, 0, ',', ' ') }} <small class="text-[10px]">FCFA</small>
                            </div>

                            <div class="absolute top-4 left-4">
                                @if($residence->disponible)
                                    <span class="flex items-center bg-white/90 backdrop-blur-sm text-green-600 px-3 py-1 rounded-full text-[10px] font-black tracking-wider shadow-sm">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span> ACTIF
                                    </span>
                                @else
                                    <span class="flex items-center bg-white/90 backdrop-blur-sm text-red-500 px-3 py-1 rounded-full text-[10px] font-black tracking-wider shadow-sm">
                                        <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span> OCCUPÉ
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Galerie invisible conservée --}}
                        @if (is_array($images))
                            @foreach($images as $key => $image)
                                @if($key > 0)
                                    <a href="{{ $image }}" class="glightbox" data-gallery="residence-{{ $residence->id }}" data-title="{{ $residence->nom }}" hidden></a>
                                @endif
                            @endforeach
                        @endif

                        <div class="p-6 flex flex-col flex-grow bg-white">
                            <h5 class="text-xl font-black text-gray-800 mb-1 truncate">{{ $residence->nom }}</h5>
                            <p class="text-cyan-700 text-xs font-bold mb-4 flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i> {{ $residence->ville }}
                            </p>
                            
                            <p class="text-gray-500 mb-6 text-sm line-clamp-2 leading-relaxed italic">
                                {{ Str::limit($residence->description, 90) }}
                            </p>

                            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-50 mt-auto">
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-gray-400 uppercase font-black">Chambres</span>
                                    <span class="text-gray-800 font-bold"><i class="fas fa-bed mr-2 text-custom-primary"></i>{{ $residence->nombre_chambres }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-gray-400 uppercase font-black">Salons</span>
                                    <span class="text-gray-800 font-bold"><i class="fas fa-couch mr-2 text-custom-primary"></i>{{ $residence->nombre_salons }}</span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('details', $residence->id) }}" class="flex items-center justify-center w-full py-3 bg-gray-50 text-custom-primary font-black rounded-xl border border-transparent hover:border-cyan-200 hover:bg-white transition-all group">
                                    GÉRER LE BIEN 
                                    <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection