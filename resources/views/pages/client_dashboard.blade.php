<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Historique des Réservations — {{ config('app.name') }}</title>

  <!-- Tailwind (cdn, production-ready) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome (icônes) -->
  <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-6.4.0-web/css/all.css') }}">

  <style>
    /* Petites personnalisations pour un rendu plus "pro" */
    .card-shadow { box-shadow: 0 6px 20px rgba(12, 17, 36, 0.06); }
    .badge-sm { font-size: 0.70rem; padding: 0.25rem 0.5rem; border-radius: 9999px; }
    /* Forcer truncation propre sur titres */
    .truncate-2 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; }
  </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

  <!-- Header simple et pro -->
  <header class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center space-x-4">
          <a href="{{ route('accueil') }}" class="block">
            <img src="{{ asset('assets/images/logo.png') }}" alt="{{ config('app.name') }}" class="h-10 w-auto" />
          </a>
          <div>
            <h1 class="text-lg font-semibold">{{ Auth::user()->name ?? 'Utilisateur' }}</h1>
            <p class="text-xs text-slate-400">Historique de vos réservations</p>
          </div>
        </div>

        <nav class="flex items-center space-x-3">
          <a href="{{ route('recherche') }}" class="text-sm text-slate-600 hover:text-slate-900">Résidences</a>
          <a href="{{ route('factures') }}" class="text-sm text-slate-600 hover:text-slate-900">Factures</a>

          {{-- Logout as POST for security --}}
          <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="ml-3 inline-flex items-center gap-2 rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
              <i class="fas fa-sign-out-alt"></i> Déconnexion
            </button>
          </form>
        </nav>
      </div>
    </div>
  </header>

  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{-- Titre --}}
    <header class="mb-8 text-center">
      <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 inline-flex items-center gap-3">
        <i class="fas fa-history text-amber-600 text-xl"></i>
        Historique de vos réservations
      </h2>
      <p class="text-sm text-slate-500 mt-2">Retrouvez ici vos réservations passées, en cours et à venir.</p>
    </header>

    {{-- Actions / liens internes --}}
    <div class="flex justify-center mb-8">
      <a href="{{ route('factures') }}" class="inline-flex items-center gap-2 rounded-md border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:shadow card-shadow">
        <i class="fas fa-file-invoice-dollar text-slate-600"></i> Voir mes factures
      </a>
    </div>

    {{-- Grid de cartes --}}
    <section>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($reservations as $res)
            @php
                // Normalisation du statut (utilise lowercase + remplace underscore par espace)
                $status = $res->status;

            @endphp

        <article class="bg-white rounded-2xl card-shadow overflow-hidden border transition transform hover:-translate-y-1">
            <div class="p-5 flex flex-col h-full">
              {{-- Badge statut --}}
              <div class="mb-3 flex justify-center">
                <span class="badge-sm badge font-semibold">{{ $status }}</span>
              </div>

              {{-- Titre résidence --}}
              <h3 class="text-lg font-semibold text-slate-900 mb-1 truncate-2">{{ $res->residence->nom ?? 'Résidence' }}</h3>

              {{-- Localisation --}}
              <p class="text-sm text-slate-500 mb-4 flex items-center gap-2">
                <i class="fas fa-map-marker-alt text-amber-500"></i>
                <span>{{ $res->residence->ville ?? '-' }}, {{ $res->residence->pays ?? '-' }}</span>
              </p>

              {{-- Détails (dates, personnes) --}}
              <ul class="text-sm text-slate-700 mb-4 space-y-2 flex-1">
                <li class="flex justify-between">
                  <span class="text-slate-500">Dates</span>
                  <span class="font-semibold">
                    {{ \Carbon\Carbon::parse($res->date_arrivee)->format('d/m/Y') }} → {{ \Carbon\Carbon::parse($res->date_depart)->format('d/m/Y') }}
                  </span>
                </li>
                <li class="flex justify-between">
                  <span class="text-slate-500">Personnes</span>
                  <span class="font-semibold">{{ $res->personnes }}</span>
                </li>
                <li class="flex justify-between">
                  <span class="text-slate-500">Réservé le</span>
                  <span class="text-xs text-slate-400">{{ optional($res->created_at)->format('d/m/Y') }}</span>
                </li>
              </ul>

              {{-- Total --}}
              <div class="mt-auto border-t pt-3">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-sm text-slate-500">Total estimé</p>
                    <p class="text-xl font-extrabold text-slate-900">{{ number_format($res->total ?? 0, 0, ',', ' ') }} FCFA</p>
                  </div>
                </div>

                {{-- Actions (une seule occurrence par action) --}}
                <div class="mt-4 grid grid-cols-2 gap-3">
                    {{-- Payer: visible si payable (status confirmée --}}
                    @if($status=='confirmée')
                        <a href="{{ route('payer', $res->id) }}" class="inline-flex items-center justify-center gap-2 rounded-md bg-amber-600 px-3 py-2 text-sm font-semibold text-white hover:bg-amber-700">
                        <i class="fas fa-credit-card"></i> Payer
                        </a>
                    @elseif ($status=='payé')
                        <button disabled class="inline-flex items-center justify-center gap-2 rounded-md bg-slate-100 px-3 py-2 text-sm font-semibold text-slate-400 cursor-not-allowed">
                        <i class="fas fa-credit-card"></i> Payé
                        </button>
                    @endif

                    @if($status=='confirmée')
                        <form action="{{ route('reservation.annuler', $res->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                        @csrf
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700">
                            <i class="fas fa-ban"></i> Annuler
                        </button>
                        </form>
                    @endif

                    @if ($status=='annulée')
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700">
                            <i class="fas fa-ban"></i> Annulée
                        </button>
                    @endif
                </div>

                {{-- Rebook / Renouveler toujours disponible (GET) --}}
                <div class="mt-3">
                  <a href="{{ route('reservation.rebook', $res->id) }}" class="block text-center text-sm font-semibold text-slate-700 hover:text-slate-900">
                    <i class="fas fa-redo mr-2"></i> Renouveler
                  </a>
                </div>
              </div>
            </div>
        </article>

        @empty
          <div class="col-span-full">
            <div class="bg-white rounded-2xl p-8 text-center card-shadow">
              <p class="text-lg text-slate-500">
                <i class="fas fa-box-open text-2xl mb-2"></i>
              </p>
              <p class="text-lg font-medium text-slate-700">Vous n’avez encore aucune réservation.</p>
              <p class="text-sm text-slate-500 mt-2">Commencez par rechercher une résidence et effectuer une réservation.</p>
              <div class="mt-4">
                <a href="{{ route('recherche') }}" class="inline-flex items-center gap-2 rounded-md bg-amber-600 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-700">
                  Parcourir les résidences
                </a>
              </div>
            </div>
          </div>
        @endforelse
      </div>
    </section>
  </main>

  {{-- Scripts (aucun framework JS externe requis ici) --}}
  <script>
    // nothing complex here — keep page JS minimal for the professional layout
    // If you use GLightbox or other components elsewhere, initialize only on pages that need them
  </script>

</body>
</html>
