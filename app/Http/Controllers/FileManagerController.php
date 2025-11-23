<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use League\Flysystem\DirectoryAttributes;
use League\Flysystem\FileAttributes;

class FileManagerController extends Controller
{
    public function delete(Request $request)
    {
        $path = $request->input('path');
        if (!$path) {
            return back()->with('error', 'Aucun fichier ou dossier sélectionné.');
        }

        $disk = Storage::disk('s3');

        if ($disk->exists($path)) {
            // Vérifie si c'est un fichier ou un dossier
            $metadata = $disk->getMetadata($path);
            if (($metadata['type'] ?? 'file') === 'file') {
                // Supprime le fichier
                $disk->delete($path);
                return back()->with('success', "Fichier supprimé : {$path}");
            } else {
                // Supprime récursivement le dossier
                $this->deleteS3Folder($disk, $path);
                return back()->with('success', "Dossier et son contenu supprimés : {$path}");
            }
        }

        return back()->with('error', "Le fichier ou dossier n'existe pas : {$path}");
    }

    /**
     * Supprime un dossier S3 récursivement.
     */
    protected function deleteS3Folder($disk, $folder)
    {
        // Supprimer tous les fichiers
        $files = $disk->allFiles($folder);
        if (!empty($files)) {
            $disk->delete($files);
        }

        // Supprimer tous les sous-dossiers
        $dirs = $disk->allDirectories($folder);
        foreach ($dirs as $dir) {
            $this->deleteS3Folder($disk, $dir); // récursion
        }

        // Supprime enfin le dossier lui-même
        $disk->deleteDirectory($folder);
    }
}
