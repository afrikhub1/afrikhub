<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
    
    /* ===== Base & Typographie Fluide ===== */
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f3f4f6;
        color: #1f2937;
        /* Utilisation de clamp pour une taille de police qui s'adapte sans paliers brutaux */
        font-size: clamp(14px, 1.2vw, 16px); 
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
    }
    
    /* ===== Titres Adaptatifs ===== */
    h1 { 
        font-size: clamp(1.25rem, 4vw, 1.875rem); 
        font-weight: 700; 
        color: #111827; 
        letter-spacing: -0.02em;
    }
    
    h2 { 
        font-size: clamp(1.1rem, 3vw, 1.5rem); 
        font-weight: 600; 
    }
    
    /* Spécificité pour le nom d'utilisateur dans le header */
    header h1 { 
        font-size: 1rem !important; 
        font-weight: 600; 
        white-space: nowrap;
    }
    
    /* ===== Gestion des liens et textes secondaires ===== */
    .stats-link {
        flex: 1 1 auto;
        padding: 0.5rem 0.25rem;
        font-size: 0.75rem; /* Forcer petit sur mobile */
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }
    
    @media (min-width: 768px) {
        .stats-link { font-size: 0.875rem; text-transform: none; }
    }
    
    /* ===== Footer Typo ===== */
    footer h3 { font-size: 1.25rem; font-weight: 800; }
    footer h4 { font-size: 0.9rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
    footer ul li a { font-size: 0.875rem; transition: all 0.2s ease; }
    
    /* ===== Ajustements sous 720px ===== */
    @media (max-width: 720px) {
        /* Évite que les longs mots ne cassent le layout */
        h1, h2, h3, p {
            overflow-wrap: break-word;
            hyphens: auto;
        }
        
        /* Réduction des marges pour laisser plus de place au texte */
        main { padding-top: 9rem; } 
        
        .headerfixe_link span {
            display: none; /* Cache le texte "Ajouter" ou "Profil" si trop étroit, garde l'icône */
        }
    }
    </style>
    
    <header class="bg-gray-900 shadow-lg fixed top-0 left-0 right-0 z-40">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between py-3">
                <div class="flex items-center space-x-3 min-w-0"> <a href="{{ route('accueil') }}" class="flex-shrink-0">
                        <img src="{{ asset('assets/images/logo_01.png') }}" alt="Logo" class="h-8 w-auto" />
                    </a>
                    <h1 class="text-white truncate">{{ Auth::user()->name ?? 'Utilisateur' }}</h1>
                </div>
                </div>
            
            <div class="flex justify-between border-t border-gray-800 py-2">
                <a href="#" class="stats-link flex flex-col md:flex-row items-center justify-center">
                    <i class="fas fa-home mb-1 md:mb-0 md:mr-2"></i>
                    <span class="hidden xs:inline">Résidences</span>
                    <span class="ml-1 px-2 bg-red-600 rounded-full text-[10px]">{{ $totalResidences }}</span>
                </a>
                </div>
        </div>
    </header>