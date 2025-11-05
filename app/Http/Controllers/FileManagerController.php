<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use League\Flysystem\DirectoryAttributes;
use League\Flysystem\FileAttributes;

class FileManagerController extends Controller
{
    public function index(Request $request)
    {
        $folder = $request->input('folder', ''); // dossier courant

        $all = Storage::disk('s3')->listContents($folder, false); // false = non récursif

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

    public function delete(Request $request)
    {
        $path = $request->input('path');
        if (!$path) {
            return back()->with('error', 'Aucun fichier ou dossier sélectionné.');
        }

        $disk = Storage::disk('s3');

        // Si c'est un fichier simple
        if ($disk->exists($path)) {
            $disk->delete($path);
            return back()->with('success', "Fichier supprimé : {$path}");
        }

        // Sinon, supposons que c'est un "dossier" (préfixe)
        $allFiles = $disk->allFiles($path); // récupère tous les fichiers sous ce dossier
        if (!empty($allFiles)) {
            $disk->delete($allFiles); // supprime tous les fichiers
        }

        // Supprimer les dossiers “virtuels” (clé vide) s’il en reste
        $allDirs = $disk->allDirectories($path);
        foreach ($allDirs as $dir) {
            $filesInDir = $disk->allFiles($dir);
            if (!empty($filesInDir)) {
                $disk->delete($filesInDir);
            }
        }

        return back()->with('success', "Dossier supprimé : {$path}");
    }
}
