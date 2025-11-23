<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use League\Flysystem\DirectoryAttributes;
use League\Flysystem\FileAttributes;

class FileManagerController extends Controller
{
    /**
     * Affiche le contenu du dossier courant.
     */
    public function index(Request $request)
    {
        $folder = $request->input('folder', ''); // dossier courant

        // Liste les fichiers et dossiers au niveau actuel (non récursif)
        $all = Storage::disk('s3')->listContents($folder, false);

        $files = [];
        foreach ($all as $item) {
            if ($item instanceof FileAttributes) {
                // Si c'est un fichier
                $files[] = [
                    'type' => 'file',
                    'name' => basename($item->path()),
                    'path' => $item->path(),
                    'size' => $item->fileSize(),
                    'lastModified' => Carbon::createFromTimestamp($item->lastModified())->format('Y-m-d H:i'),
                ];
            } elseif ($item instanceof DirectoryAttributes) {
                // Si c'est un dossier
                $files[] = [
                    'type' => 'dir',
                    'name' => basename($item->path()),
                    'path' => $item->path(),
                    'size' => null, // La taille des dossiers n'est pas facilement disponible sur S3
                    'lastModified' => '-',
                ];
            }
        }

        return view('file-manager', compact('files', 'folder'));
    }

    /**
     * Crée un nouveau dossier.
     */
    public function store(Request $request)
    {
        $request->validate([
            'folder_name' => 'required|string|max:255',
            'current_path' => 'nullable|string',
        ]);

        $currentPath = $request->input('current_path', '');
        $folderName = trim($request->input('folder_name'), '/');

        // Construction du chemin complet et nettoyage des slashes doubles
        $newPath = trim($currentPath . '/' . $folderName, '/');

        $disk = Storage::disk('s3');

        // Vérification de l'existence du dossier (important pour éviter les doublons)
        if ($disk->exists($newPath) || $disk->directoryExists($newPath)) {
            return back()->with('error', "Le dossier '{$folderName}' existe déjà à cet emplacement.");
        }

        // Création du dossier. Sur S3, cela crée l'objet du "dossier"
        $disk->makeDirectory($newPath);

        return back()->with('success', "Dossier '{$folderName}' créé avec succès.");
    }


    /**
     * Supprime un ou plusieurs fichiers et/ou dossiers.
     * La suppression des dossiers est gérée récursivement via deleteDirectory.
     */
    public function delete(Request $request)
    {
        // On attend un tableau de chemins (paths[]) pour la suppression en masse depuis le frontend
        $paths = $request->input('paths', []);

        if (empty($paths) || !is_array($paths)) {
            return back()->with('error', 'Aucun élément valide sélectionné pour la suppression.');
        }

        $disk = Storage::disk('s3');
        $deletedCount = 0;

        foreach ($paths as $path) {
            if (empty($path)) continue;

            // Tente de supprimer de manière récursive (supprime les dossiers non vides)
            // C'est la méthode recommandée pour S3 qui utilise le préfixe de chemin.
            if ($disk->deleteDirectory($path)) {
                $deletedCount++;
            }
            // Si deleteDirectory retourne false (souvent le cas pour un simple fichier),
            // on essaie de supprimer l'objet simple.
            else if ($disk->delete($path)) {
                $deletedCount++;
            }
        }

        $message = "{$deletedCount} élément(s) supprimé(s) ou ciblés pour la suppression.";
        return back()->with('success', $message);
    }
}
