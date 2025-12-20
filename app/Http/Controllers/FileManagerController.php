<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use League\Flysystem\DirectoryAttributes;
use League\Flysystem\FileAttributes;

class FileManagerController extends Controller
{
    private string $baseFolder = 'galerie';

    // Dossiers virtuels que l'on veut toujours afficher
    private array $virtualDirs = [
        'galerie/carousels',
        'galerie/blog',
        'galerie/pub',
    ];

    public function index(Request $request)
    {
        $folder = urldecode($request->input('folder', ''));

        // Sécurité + construction du chemin correct
        $currentFolder = $this->baseFolder;
        if (!empty($folder)) {
            $currentFolder .= '/' . trim(str_replace($this->baseFolder, '', $folder), '/');
        }

        // Récupération du contenu réel S3
        try {
            $all = Storage::disk('s3')->listContents($currentFolder, false);
        } catch (\Exception $e) {
            return back()->with('error', 'Impossible de charger le dossier : ' . $e->getMessage());
        }

        $files = [];

        foreach ($all as $item) {
            // Ignorer les fichiers cachés
            if ($item instanceof FileAttributes && basename($item->path()) === '.keep') {
                continue;
            }

            if ($item instanceof FileAttributes) {
                $files[] = [
                    'type' => 'file',
                    'name' => basename($item->path()),
                    'path' => $item->path(),
                    'size' => $item->fileSize(),
                    'lastModified' => Carbon::createFromTimestamp($item->lastModified())->format('Y-m-d H:i'),
                ];
            }

            if ($item instanceof DirectoryAttributes) {
                $files[] = [
                    'type' => 'dir',
                    'name' => basename($item->path()),
                    'path' => $item->path(),
                    'size' => null,
                    'lastModified' => '-',
                ];
            }
        }

        // Ajouter les dossiers virtuels si ils sont dans ce dossier parent
        foreach ($this->virtualDirs as $vDir) {
            if (dirname($vDir) === $currentFolder) {
                // Vérifier qu'il n'est pas déjà dans $files
                $exists = collect($files)->firstWhere('path', $vDir);
                if (!$exists) {
                    $files[] = [
                        'type' => 'dir',
                        'name' => basename($vDir),
                        'path' => $vDir,
                        'size' => null,
                        'lastModified' => '-',
                    ];
                }
            }
        }

        return view('file-manager', [
            'files' => $files,
            'folder' => str_replace($this->baseFolder . '/', '', $currentFolder),
        ]);
    }

    public function delete(Request $request)
    {
        $path = $request->input('path');

        if (!$path || !str_starts_with($path, $this->baseFolder)) {
            return back()->with('error', 'Chemin non autorisé.');
        }

        $disk = Storage::disk('s3');

        try {
            if ($disk->fileExists($path)) {
                $disk->delete($path);
                return back()->with('success', 'Fichier supprimé.');
            }

            if ($disk->directoryExists($path)) {
                $disk->deleteDirectory($path);
                return back()->with('success', 'Dossier supprimé.');
            }

            return back()->with('error', 'Élément introuvable.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur : ' . $e->getMessage());
        }
    }
}
