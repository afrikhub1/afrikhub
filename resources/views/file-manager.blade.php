Gestionnaire de Fichiers Ultra-Simple (Code Source)

Vous pouvez copier ce contenu et le coller dans un nouveau fichier index.html si l'artefact principal n'apparaît pas.

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire de Fichiers Ultra-Simple</title>
    <!-- Styles CSS basiques intégrés pour garantir l'affichage -->
    <style>
        body { font-family: sans-serif; background: #f0f0f0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
        .controls { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .btn { padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; transition: background-color 0.3s; }
        .btn-primary { background: #3498db; color: white; }
        .btn-danger { background: #e74c3c; color: white; margin-left: 10px; }
        .btn-primary:hover { background: #2980b9; }
        .btn-danger:hover { background: #c0392b; }
        .file-table { width: 100%; border-collapse: collapse; }
        .file-table th, .file-table td { padding: 10px; text-align: left; border-bottom: 1px solid #f0f0f0; }
        .file-table th { background: #f4f4f4; }
        .file-table tr:hover { background: #f9f9f9; }
        .folder-row:hover { background: #e8f3ff; cursor: pointer; }
        .selected-row { background-color: #ffebeb !important; } /* Surlignage de la ligne sélectionnée */
        .message { padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .msg-success { background: #e6ffe6; color: #0a6b0a; border: 1px solid #c8ffc8; }
        .msg-error { background: #ffeeee; color: #a00a0a; border: 1px solid #ffc8c8; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📁 Gestionnaire de Fichiers</h1>

        <!-- Affichage des messages -->
        <div id="message-container"></div>

        <!-- Contrôles de Navigation et d'Action -->
        <div class="controls">
            <div style="display: flex; align-items: center;">
                <button id="back-button" class="btn btn-primary" disabled>← Retour</button>
                <span id="current-path" style="margin-left: 15px; font-weight: 500;">Chemin: /</span>
            </div>
            <div>
                <button id="select-all-button" class="btn btn-primary">Tout Sélectionner</button>
                <button id="delete-selected-button" class="btn btn-danger" disabled>Supprimer la Sélection (<span id="selected-count">0</span>)</button>
            </div>
        </div>

        <!-- Formulaires d'Action -->
        <div style="display: flex; gap: 10px; margin-bottom: 20px; border: 1px solid #ccc; padding: 15px; border-radius: 4px;">
            <form id="new-folder-form" style="display: flex; gap: 5px;">
                <input type="text" id="folder-name" placeholder="Nom du dossier" required style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                <button type="submit" class="btn btn-primary">Créer Dossier</button>
            </form>
            <form id="upload-file-form" style="display: flex; gap: 5px;">
                <input type="text" id="file-name" placeholder="Nom du fichier (ex: doc.txt)" required style="padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                <button type="submit" class="btn btn-primary" style="background: #27ae60;">Simuler Fichier</button>
            </form>
        </div>

        <!-- Tableau des Fichiers -->
        <table class="file-table">
            <thead>
                <tr>
                    <th style="width: 50px;">Sel.</th>
                    <th>Nom</th>
                    <th>Taille</th>
                    <th>Modification</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="file-list-body">
                <tr><td colspan="5" style="text-align: center; color: #999;">Chargement...</td></tr>
            </tbody>
        </table>
    </div>

    <script>
        const STORAGE_KEY = 'fileManagerDataSimple';
        let currentPath = [];
        let selectedItems = new Set();

        // --- Références UI ---
        const fileListBody = document.getElementById('file-list-body');
        const currentPathDisplay = document.getElementById('current-path');
        const backButton = document.getElementById('back-button');
        const messageContainer = document.getElementById('message-container');
        const selectAllButton = document.getElementById('select-all-button');
        const deleteSelectedButton = document.getElementById('delete-selected-button');
        const selectedCountSpan = document.getElementById('selected-count');

        // --- Fonctions Utilitaires et Stockage ---

        function displayMessage(text, isError = false) {
            const className = isError ? 'msg-error' : 'msg-success';
            messageContainer.innerHTML = `<div class="message ${className}">${text}</div>`;
            setTimeout(() => { messageContainer.innerHTML = ''; }, 5000);
        }

        function formatBytes(bytes) {
            if (bytes === 0 || bytes === null) return '-';
            const k = 1024;
            const sizes = [' Octets', ' Ko', ' Mo', ' Go'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + sizes[i];
        }

        function formatTimestamp(timestamp) {
            if (!timestamp) return '-';
            return new Date(timestamp).toLocaleString('fr-FR', {
                year: 'numeric', month: 'short', day: 'numeric',
                hour: '2-digit', minute: '2-digit'
            });
        }

        function getCurrentPathString() {
            return currentPath.join('/');
        }

        function getFilesData() {
            try {
                const data = localStorage.getItem(STORAGE_KEY);
                return data ? JSON.parse(data) : [
                    { id: 'a1', name: 'Rapports', type: 'dir', parentPath: '', size: 0, lastModified: Date.now() - 86400000 },
                    { id: 'b1', name: 'Images.jpg', type: 'file', parentPath: 'Rapports', size: 1250000, lastModified: Date.now() - 3600000 },
                    { id: 'c1', name: 'Archives', type: 'dir', parentPath: '', size: 0, lastModified: Date.now() - 172800000 },
                    { id: 'd1', name: 'Document_Important.pdf', type: 'file', parentPath: '', size: 550000, lastModified: Date.now() },
                ];
            } catch (e) {
                console.error("Erreur de lecture localStorage:", e);
                return [];
            }
        }

        function saveFilesData(data) {
            try {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(data));
            } catch (e) {
                console.error("Erreur d'écriture localStorage:", e);
                displayMessage("Erreur d'enregistrement des données.", true);
            }
        }

        // --- Logique du Gestionnaire de Fichiers ---

        function listFiles() {
            const allFiles = getFilesData();
            const currentPathString = getCurrentPathString();

            let files = allFiles.filter(item => item.parentPath === currentPathString);

            // Tri : Dossiers d'abord
            files.sort((a, b) => {
                if (a.type === 'dir' && b.type !== 'dir') return -1;
                if (a.type !== 'dir' && b.type === 'dir') return 1;
                return a.name.localeCompare(b.name);
            });

            renderFiles(files);
            updateUIPath();
            updateSelectionUI();
        }

        function renderFiles(files) {
            fileListBody.innerHTML = '';

            if (files.length === 0) {
                fileListBody.innerHTML = `<tr><td colspan="5" style="text-align: center; color: #999; padding: 20px;">Ce dossier est vide.</td></tr>`;
            }

            files.forEach(file => {
                const isFolder = file.type === 'dir';
                const row = document.createElement('tr');
                row.dataset.id = file.id;

                if (selectedItems.has(file.id)) {
                    row.classList.add('selected-row');
                }
                if (isFolder) {
                    row.classList.add('folder-row');
                }

                const icon = isFolder ? '📁' : '📄';
                const nameCellContent = isFolder
                    ? `<span onclick="navigateToFolder('${file.name}')" style="color: #3498db; text-decoration: underline; cursor: pointer;">${file.name}</span>`
                    : file.name;

                row.innerHTML = `
                    <td>
                        <input type="checkbox" data-id="${file.id}"
                               class="file-checkbox"
                               ${selectedItems.has(file.id) ? 'checked' : ''}
                               onclick="event.stopPropagation(); toggleSelection('${file.id}')">
                    </td>
                    <td onclick="${isFolder ? `MapsToFolder('${file.name}')` : ''}" style="cursor: ${isFolder ? 'pointer' : 'default'};">
                        ${icon} ${nameCellContent}
                    </td>
                    <td>${formatBytes(file.size)}</td>
                    <td>${formatTimestamp(file.lastModified)}</td>
                    <td>
                        <button onclick="window.deleteSingleItem('${file.id}', '${file.name}', '${file.type}')"
                            class="btn" style="background: #e74c3c; color: white; padding: 5px 10px;">Supprimer</button>
                    </td>
                `;

                fileListBody.appendChild(row);
            });
        }

        // --- Navigation ---

        function updateUIPath() {
            const pathDisplay = currentPath.length > 0 ? currentPath.join(' / ') : '/';
            currentPathDisplay.textContent = `Chemin: /${pathDisplay}`;
            backButton.disabled = currentPath.length === 0;
        }

        function navigateToFolder(folderName) {
            currentPath.push(folderName);
            selectedItems.clear();
            listFiles();
        }

        // --- Logique de Sélection ---

        window.toggleSelection = function(id) {
            const row = document.querySelector(`tr[data-id='${id}']`);
            if (selectedItems.has(id)) {
                selectedItems.delete(id);
                row.classList.remove('selected-row');
            } else {
                selectedItems.add(id);
                row.classList.add('selected-row');
            }
            updateSelectionUI();
        }

        function toggleSelectAll() {
            const allCheckboxes = Array.from(fileListBody.querySelectorAll('.file-checkbox'));
            const isAllSelected = selectedItems.size === allCheckboxes.length && allCheckboxes.length > 0;

            const newState = !isAllSelected;

            allCheckboxes.forEach(checkbox => {
                const id = checkbox.dataset.id;
                checkbox.checked = newState;
                const row = document.querySelector(`tr[data-id='${id}']`);

                if (newState) {
                    selectedItems.add(id);
                    row.classList.add('selected-row');
                } else {
                    selectedItems.delete(id);
                    row.classList.remove('selected-row');
                }
            });
            updateSelectionUI();
        }

        function updateSelectionUI() {
            const count = selectedItems.size;
            selectedCountSpan.textContent = count;
            deleteSelectedButton.disabled = count === 0;
            selectAllButton.textContent = (count > 0 && count === fileListBody.querySelectorAll('.file-checkbox').length) ? 'Tout Désélectionner' : 'Tout Sélectionner';
        }

        // --- Logique de Suppression (récursive) ---

        function findChildrenRecursive(itemId, allFiles) {
            const itemToDelete = allFiles.find(i => i.id === itemId);
            if (!itemToDelete || itemToDelete.type !== 'dir') return [];

            const currentDir = getCurrentPathString();
            const pathPrefix = currentDir + (currentDir ? '/' : '') + itemToDelete.name;
            const childrenIds = [];

            allFiles.forEach(item => {
                if (item.parentPath.startsWith(pathPrefix + '/') || item.parentPath === pathPrefix) {
                    childrenIds.push(item.id);
                }
            });
            return childrenIds;
        }

        function deleteItems(ids) {
            if (ids.length === 0) return;

            if (!window.confirm(`Voulez-vous vraiment supprimer les ${ids.length} élément(s) sélectionné(s) ?\nATTENTION : La suppression d'un dossier est RECURSIVE (supprime tout son contenu) et IRREVERSIBLE.`)) {
                return;
            }

            let allFiles = getFilesData();
            let itemsToDelete = new Set(ids);

            // 1. Identification récursive des éléments à supprimer
            ids.forEach(id => {
                const children = findChildrenRecursive(id, allFiles);
                children.forEach(childId => itemsToDelete.add(childId));
            });

            // 2. Suppression dans le tableau de données
            const initialCount = allFiles.length;
            allFiles = allFiles.filter(item => !itemsToDelete.has(item.id));
            const deletedCount = initialCount - allFiles.length;

            saveFilesData(allFiles);
            selectedItems.clear();
            listFiles();
            displayMessage(`${deletedCount} élément(s) supprimé(s) avec succès.`, false);
        }

        window.deleteSingleItem = function(id, name, type) {
            if (type === 'dir' && !window.confirm(`ATTENTION : Le dossier "${name}" sera supprimé RECURSIVEMENT avec tout son contenu. Continuer ?`)) {
                 return;
            }
            deleteItems([id]);
        }

        // --- Création d'élément ---
        function generateUniqueId() {
            return Date.now().toString(36) + Math.random().toString(36).substring(2, 5);
        }

        function isDuplicate(name) {
            const allFiles = getFilesData();
            const currentPathString = getCurrentPathString();
            return allFiles.some(item =>
                item.parentPath === currentPathString && item.name === name
            );
        }

        function createItem(type, name, size = 0) {
            if (!name || name.includes('/')) {
                displayMessage("Nom invalide (évitez /).", true);
                return;
            }

            if (isDuplicate(name)) {
                displayMessage(`"${name}" existe déjà.`, true);
                return;
            }

            const allFiles = getFilesData();
            allFiles.push({
                id: generateUniqueId(),
                name: name,
                type: type,
                parentPath: getCurrentPathString(),
                size: size,
                lastModified: Date.now()
            });

            saveFilesData(allFiles);
            listFiles();
            document.getElementById(type === 'dir' ? 'folder-name' : 'file-name').value = '';
            displayMessage(`${type === 'dir' ? 'Dossier' : 'Fichier'} créé : ${name}`, false);
        }

        // --- Démarrage et Écouteurs ---
        function setupEventListeners() {
            backButton.addEventListener('click', () => {
                if (currentPath.length > 0) {
                    currentPath.pop();
                    selectedItems.clear();
                    listFiles();
                }
            });

            selectAllButton.addEventListener('click', toggleSelectAll);
            deleteSelectedButton.addEventListener('click', () => { deleteItems(Array.from(selectedItems)); });

            document.getElementById('new-folder-form').addEventListener('submit', (e) => {
                e.preventDefault();
                const name = document.getElementById('folder-name').value.trim();
                if (name) createItem('dir', name);
            });

            document.getElementById('upload-file-form').addEventListener('submit', (e) => {
                e.preventDefault();
                const name = document.getElementById('file-name').value.trim();
                const randomSize = Math.floor(Math.random() * (5 * 1024 * 1024 - 1024)) + 1024;
                if (name) createItem('file', name, randomSize);
            });
        }

        setupEventListeners();
        listFiles();
    </script>
</body>
</html>
