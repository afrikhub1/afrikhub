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
        $folder = urldecode($request->input('folder', '')); // Décodage URL pour compatibilité

        try {
            $all = Storage::disk('s3')->listContents($folder, false); // false = non récursif
        } catch (\Exception $e) {
            return back()->with('error', 'Impossible de charger le dossier : ' . $e->getMessage());
        }

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

        try {
            if ($disk->exists($path)) {
                $disk->delete($path);
                return back()->with('success', "Fichier supprimé : {$path}");
            }

            // Supprimer récursivement tous les fichiers et sous-dossiers
            $files = $disk->allFiles($path);
            if (!empty($files)) $disk->delete($files);

            $dirs = $disk->allDirectories($path);
            foreach ($dirs as $dir) {
                $subFiles = $disk->allFiles($dir);
                if (!empty($subFiles)) $disk->delete($subFiles);
            }

            return back()->with('success', "Dossier supprimé : {$path}");
        } catch (\Exception $e) {
            return back()->with('error', "Erreur lors de la suppression : " . $e->getMessage());
        }
    }
}
