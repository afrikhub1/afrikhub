<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résidences Actuellement Occupées</title>

    <!-- GLightbox CSS -->
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">

    <!-- Assets Bootstrap et FontAwesome -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; min-height: 100vh; }
        #sidebar { transition: transform 0.3s ease-in-out; transform: translateX(100%); position: fixed; top: 0; right: 0; width: 350px; z-index: 50; height: 100%; background-color: #1f2937; padding: 1.5rem; box-shadow: -4px 0 12px rgba(0,0,0,0.3); }
        #sidebar.active { transform: translateX(0); }
        .image-scroll-wrapper { overflow-x: auto; white-space: nowrap; scrollbar-width: thin; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- Header et Sidebar (idem ton code précédent) -->

    <div class="container mx-auto px-4 py-8 pt-44 lg:pt-40">
        <main class="bg-white p-6 md:p-8 rounded-xl shadow-2xl border border-gray-200">
            <h1 class="text-4xl font-extrabold text-red-600 mb-8 text-center border-b-4 border-red-500 pb-3">
                <i class="fas fa-lock-open text-3xl mr-3"></i> Résidences Actuellement Occupées
            </h1>

            <section id="occupees">
                @if($residences->isEmpty())
                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 p-6 rounded-lg text-center shadow-lg">
                        <i class="fas fa-info-circle text-2xl mb-2 block"></i>
                        <p class="font-semibold text-lg">Aucune résidence n'est actuellement occupée.</p>
                        <p class="text-sm mt-1">Les résidences disponibles ne figurent pas dans cette liste.</p>
                    </div>
                @else
                    <div class="flex flex-wrap gap-6 justify-center">
                        @foreach($residences as $residence)
                            <div class="w-full sm:w-[320px] bg-red-50 border-2 border-red-400 rounded-xl shadow-2xl p-6 flex flex-col justify-between">
                                <div>
                                    <h5 class="text-2xl font-bold text-red-800 mb-3 flex items-center">
                                        <i class="fas fa-building mr-3 text-red-600"></i> {{ $residence->nom }}
                                    </h5>
                                    <p class="text-sm mb-2">
                                        <strong>Ville :</strong> {{ $residence->ville }}
                                    </p>
                                    <p class="text-sm mb-2">
                                        <strong>Pays :</strong> {{ $residence->pays }}
                                    </p>
                                    <p class="text-sm mb-2">
                                        <strong>Prix journalier :</strong> {{ number_format($residence->prix_journalier, 0, ',', ' ') }} FCFA
                                    </p>
                                    <p class="text-sm mb-2">
                                        <strong>Type :</strong> {{ $residence->type_residence }}
                                    </p>
                                    <p class="text-sm mb-2">
                                        <strong>Chambres :</strong> {{ $residence->nombre_chambres }}
                                    </p>
                                    <p class="text-sm mb-2">
                                        <strong>Salons :</strong> {{ $residence->nombre_salons }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggleSidebar');
            const closeButton = document.getElementById('closeSidebar');
            const sidebar = document.getElementById('sidebar');

            if(toggleButton && sidebar){
                toggleButton.addEventListener('click', () => sidebar.classList.add('active'));
            }
            if(closeButton && sidebar){
                closeButton.addEventListener('click', () => sidebar.classList.remove('active'));
            }
        });
    </script>
</body>
</html>
