<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire de Fichiers MacOS</title>
    <!-- Chargement de Tailwind CSS pour le style -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Utilisation de la police Inter pour une esthétique moderne */
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f2f2f5;
            min-height: 100vh;
        }
        /* Style des cartes de fichiers pour l'effet macOS */
        .file-card {
            background: #fff;
            border-radius: 14px;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
            position: relative;
            border: 2px solid transparent;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .file-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }
        /* Style de sélection */
        .file-card.selected {
            border-color: #007aff;
            background: #e6f0ff;
            box-shadow: 0 4px 8px rgba(0, 122, 255, 0.2);
        }
        .file-name {
            margin-top: 0.5rem;
            font-size: 0.95rem;
            font-weight: 500;
            color: #333;
            word-break: break-word;
            line-height: 1.2;
            max-height: 2.4em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .search-bar {
            padding: 0.6rem 1rem;
            border-radius: 12px;
            border: 1px solid #ccc;
            outline: none;
            transition: all 0.2s;
        }
        .search-bar:focus {
            border-color: #007aff;
            box-shadow: 0 0 5px rgba(0,122,255,0.4);
        }
        /* Overlay de sélection */
        .overlay-selected {
            position: absolute;
            inset: 0; /* Équivalent de top: 0; left: 0; width: 100%; height: 100%; */
            border-radius: 14px;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .file-card.selected .overlay-selected {
            opacity: 1;
        }
    </style>
</head>
<body>

    <!-- Conteneur principal -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Barre d'outils et de recherche -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 space-y-4 sm:space-y-0">
            <button id="back-button" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 flex items-center text-gray-700 font-medium transition duration-150 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Dossier parent
            </button>
            <input type="text" id="search-input" class="search-bar w-full sm:w-80" placeholder="Rechercher un fichier ou dossier...">
        </div>

        <!-- Grille des fichiers/dossiers -->
        <div id="file-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-7 gap-4 sm:gap-6">
            <!-- Les cartes de fichiers seront insérées ici par JavaScript -->
        </div>

        <!-- Bouton supprimer sélection -->
        <div class="mt-8 flex justify-end">
            <button id="delete-selected" class="px-6 py-3 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed shadow-md" disabled>
                Supprimer la sélection (<span id="selected-count">0</span>)
            </button>
        </div>
    </div>

    <!-- Modale de Confirmation (Remplace window.confirm/alert) -->
    <div id="confirmation-modal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 w-11/12 max-w-sm shadow-2xl transform scale-100 transition-all duration-300">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Confirmer l'action</h3>
            <p id="modal-message" class="text-gray-600 mb-6">Message de l'opération.</p>
            <div class="flex justify-end space-x-3">
                <button id="modal-cancel" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Annuler</button>
                <button id="modal-confirm" class="px-4 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600 font-medium transition">Confirmer</button>
            </div>
        </div>
    </div>

<script type="module">
    // --- Configuration et initialisation Firebase ---
    // Ces imports sont nécessaires pour l'environnement (même sans utilisation active des données)
    import { initializeApp } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-app.js";
    import { getAuth, signInAnonymously, signInWithCustomToken, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-auth.js";
    import { getFirestore, setLogLevel } from "https://www.gstatic.com/firebasejs/11.6.1/firebase-firestore.js";

    setLogLevel('Debug');
    const appId = typeof __app_id !== 'undefined' ? __app_id : 'default-app-id';
    const firebaseConfig = typeof __firebase_config !== 'undefined' ? JSON.parse(__firebase_config) : null;
    const initialAuthToken = typeof __initial_auth_token !== 'undefined' ? __initial_auth_token : null;
    let db, auth;
    let userId = null;

    if (firebaseConfig) {
        const app = initializeApp(firebaseConfig);
        db = getFirestore(app);
        auth = getAuth(app);

        onAuthStateChanged(auth, async (user) => {
            if (!user) {
                try {
                    if (initialAuthToken) {
                        await signInWithCustomToken(auth, initialAuthToken);
                    } else {
                        await signInAnonymously(auth);
                    }
                    userId = auth.currentUser.uid;
                } catch (error) {
                    console.error("Firebase Auth failed:", error);
                    userId = crypto.randomUUID(); // ID de secours
                }
            } else {
                userId = user.uid;
            }
            console.log(`Firebase Initialisé. User ID: ${userId}`);
        });
    }

    // --- Données de maquette (Mock Data) pour simuler les fichiers S3 ---
    const initialFiles = [
        { name: "Projets-Client-2025", type: "dir", path: "/Projets-Client-2025" },
        { name: "Photos-Vacances-2024", type: "dir", path: "/Photos-Vacances-2024" },
        { name: "Rapport_Annuel_V2.docx", type: "file", path: "/Rapport_Annuel_V2.docx" },
        { name: "Liste_Ingredients_Cuisine.txt", type: "file", path: "/Liste_Ingredients_Cuisine.txt" },
        { name: "Presentation_Marketing.pptx", type: "file", path: "/Presentation_Marketing.pptx" },
        { name: "Budget_Q3_Final.xlsx", type: "file", path: "/Budget_Q3_Final.xlsx" },
        { name: "Installation_Drivers.pkg", type: "file", path: "/Installation_Drivers.pkg" },
        { name: "Configuration_Serveur.conf", type: "file", path: "/Configuration_Serveur.conf" },
        { name: "Sauvegarde-iPhone-2023", type: "dir", path: "/Sauvegarde-iPhone-2023" },
        { name: "Documentation-API.pdf", type: "file", path: "/Documentation-API.pdf" },
    ];

    const fileGrid = document.getElementById('file-grid');
    const deleteBtn = document.getElementById('delete-selected');
    const searchInput = document.getElementById('search-input');
    const backButton = document.getElementById('back-button');
    const selectedCountSpan = document.getElementById('selected-count');

    let currentFiles = [...initialFiles];

    // --- Fonctions utilitaires de l'interface utilisateur (Remplacement de alert/confirm) ---

    /**
     * Affiche une boîte de dialogue de confirmation personnalisée.
     * @param {string} message Le message à afficher.
     * @param {boolean} isConfirm Si true, affiche les boutons Confirmer/Annuler.
     * @returns {Promise<boolean>} Résout à true si confirmé, false sinon.
     */
    function showDialog(message, isConfirm = true) {
        return new Promise(resolve => {
            const modal = document.getElementById('confirmation-modal');
            const confirmBtn = document.getElementById('modal-confirm');
            const cancelBtn = document.getElementById('modal-cancel');
            const messageEl = document.getElementById('modal-message');
            const titleEl = modal.querySelector('h3');

            messageEl.textContent = message;

            // Configuration de la modale en mode Confirmation ou Alerte
            if (isConfirm) {
                titleEl.textContent = "Confirmer l'action";
                confirmBtn.textContent = "Confirmer";
                confirmBtn.classList.remove('hidden');
                cancelBtn.classList.remove('hidden');
            } else {
                titleEl.textContent = "Information";
                confirmBtn.textContent = "OK";
                confirmBtn.classList.remove('hidden');
                cancelBtn.classList.add('hidden');
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            const handleConfirm = () => {
                cleanup();
                resolve(true);
            };

            const handleCancel = () => {
                cleanup();
                resolve(false);
            };

            const cleanup = () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                confirmBtn.removeEventListener('click', handleConfirm);
                cancelBtn.removeEventListener('click', handleCancel);
            };

            // Événements
            confirmBtn.addEventListener('click', handleConfirm);
            if (isConfirm) {
                cancelBtn.addEventListener('click', handleCancel);
            }

            // Fermeture en cliquant sur l'arrière-plan
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    handleCancel();
                }
            });
        });
    }

    function alertUser(message) {
        // Utilise la modale en mode alerte simple
        showDialog(message, false);
    }

    function getFileIcon(type) {
        // SVG pour Dossier (Jaune)
        if (type === 'dir') {
            return `
                <svg xmlns="http://www.w3.org/2000/svg" fill="#FFD93B" viewBox="0 0 24 24" class="w-12 h-12">
                    <path d="M3 4a1 1 0 011-1h6l2 2h9a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V4z"/>
                </svg>`;
        }
        // SVG pour Fichier (Bleu)
        return `
            <svg xmlns="http://www.w3.org/2000/svg" fill="#4B9CD3" viewBox="0 0 24 24" class="w-12 h-12">
                <path d="M4 2h12l4 4v16a1 1 0 01-1 1H4a1 1 0 01-1-1V3a1 1 0 011-1z"/>
            </svg>`;
    }

    function updateDeleteButton() {
        const selected = document.querySelectorAll('.file-card.selected').length;
        deleteBtn.disabled = selected === 0;
        selectedCountSpan.textContent = selected;
    }

    function renderFiles(files) {
        fileGrid.innerHTML = '';
        files.forEach(file => {
            const card = document.createElement('div');
            card.className = 'file-card relative border border-transparent rounded-xl shadow-md hover:shadow-lg cursor-pointer';
            card.dataset.name = file.name.toLowerCase();
            card.dataset.path = file.path; // La "route" que vous vouliez conserver

            const iconHtml = getFileIcon(file.type);

            card.innerHTML = `
                <input type="checkbox" class="file-checkbox hidden" data-path="${file.path}">
                <div class="file-icon w-full flex justify-center items-center bg-gray-100 p-4 rounded-t-xl">
                    ${iconHtml}
                </div>
                <div class="file-name p-2 text-center font-medium">${file.name}</div>
                <div class="overlay-selected absolute inset-0 rounded-xl pointer-events-none"></div>
            `;

            // Ajout du listener de sélection
            card.addEventListener('click', (e) => {
                // Double-clic pour ouvrir un dossier (simulation)
                if (e.detail === 2 && file.type === 'dir') {
                    console.log(`Action: Ouvrir le dossier ${file.path}`);
                    alertUser(`Ouverture du dossier : ${file.name}. (Simulation)`);
                    return;
                }

                // Logique de sélection
                const selected = !card.classList.contains('selected');
                card.classList.toggle('selected', selected);
                updateDeleteButton();
            });

            fileGrid.appendChild(card);
        });
    }

    // --- Logique des événements ---

    // 1. Recherche
    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();
        const cards = document.querySelectorAll('.file-card');
        cards.forEach(card => {
            const name = card.dataset.name;
            // Affiche ou masque la carte en fonction de la recherche
            card.style.display = name.includes(query) ? 'block' : 'none';
        });
    });

    // 2. Suppression de la sélection
    deleteBtn.addEventListener('click', async () => {
        const selectedCards = document.querySelectorAll('.file-card.selected');
        const count = selectedCards.length;

        if (count === 0) return;

        // Utilisation de la modale de confirmation
        const confirmed = await showDialog(`Voulez-vous supprimer les ${count} élément(s) sélectionné(s) ? Cette action est irréversible.`, true);

        if (confirmed) {
            const pathsToDelete = Array.from(selectedCards).map(card => card.dataset.path);

            // Suppression des éléments du DOM
            selectedCards.forEach(card => card.remove());

            // Mise à jour de la liste des données de maquette
            currentFiles = currentFiles.filter(file => !pathsToDelete.includes(file.path));

            updateDeleteButton();
            console.log("Fichiers supprimés (simulation) :", pathsToDelete);
            alertUser(`${count} élément(s) ont été supprimés (simulation).`);

            // REMPLACER CECI par votre appel API pour supprimer les routes (pathsToDelete) sur S3
        }
    });

    // 3. Bouton Retour
    backButton.addEventListener('click', () => {
        console.log('Action: Naviguer vers le dossier parent');
        alertUser('Simuler la navigation vers le dossier parent. Intégration de la ROUTE S3 nécessaire ici.');
    });

    // Rendu initial au chargement
    renderFiles(currentFiles);

</script>
</body>
</html>
