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
        $folder = $request->input('folder', '');

        $all = Storage::disk('s3')->listContents($folder, false);

        $files = [];
        foreach ($all as $item) {
            if ($item instanceof FileAttributes) {
                $files[] = [
                    'type' => 'file',
                    'name' => basename($item->path()),
                    'path' => $item->path(),
                    'size' => $item->fileSize(),
                    'lastModified' => Carbon::createFromTimestamp($item->lastModified())->format('Y-m-d H:i'),
                ];
            } elseif ($item instanceof DirectoryAttributes) {
                $files[] = [
                    'type' => 'dir',
                    'name' => basename($item->path()),
                    'path' => $item->path(),
                    'size' => null,
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

        $newPath = trim($currentPath . '/' . $folderName, '/');

        $disk = Storage::disk('s3');

        if ($disk->exists($newPath) || $disk->directoryExists($newPath)) {
            return back()->with('error', "Le dossier '{$folderName}' existe déjà à cet emplacement.");
        }

        $disk->makeDirectory($newPath);

        return back()->with('success', "Dossier '{$folderName}' créé avec succès.");
    }

    /**
     * Supprime un ou plusieurs fichiers/dossiers (récursif pour dossiers non vides).
     */
    public function delete(Request $request)
    {
        $paths = $request->input('paths', []);

        if (empty($paths) || !is_array($paths)) {
            return back()->with('error', 'Aucun élément valide sélectionné pour la suppression.');
        }

        $disk = Storage::disk('s3');
        $deletedCount = 0;

        foreach ($paths as $path) {
            if (empty($path)) continue;

            // Supprime le contenu du dossier s'il s'agit d'un répertoire
            if ($disk->directoryExists($path)) {
                $allFiles = $disk->allFiles($path);
                $allDirs  = $disk->allDirectories($path);

                if (!empty($allFiles)) {
                    $disk->delete($allFiles);
                }

                if (!empty($allDirs)) {
                    foreach ($allDirs as $dir) {
                        $disk->deleteDirectory($dir);
                    }
                }

                // Supprime le dossier lui-même
                $disk->deleteDirectory($path);
                $deletedCount++;
            }
            // Sinon, supprime le fichier simple
            else if ($disk->exists($path)) {
                $disk->delete($path);
                $deletedCount++;
            }
        }

        return back()->with('success', "{$deletedCount} élément(s) supprimé(s) avec succès.");
    }
}
