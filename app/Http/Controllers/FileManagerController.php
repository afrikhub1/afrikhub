<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use League\Flysystem\FileAttributes;
use League\Flysystem\DirectoryAttributes;

class FileManagerController extends Controller
{
    protected string $disk = 's3';

    public function index(Request $request)
    {
        $folder = trim(urldecode($request->input('folder', '')), '/');
        $folder = $folder ? $folder . '/' : '';

        try {
            $all = Storage::disk($this->disk)->listContents($folder, false);
        } catch (\Throwable $e) {
            return back()->with('error', 'Impossible de charger le dossier : ' . $e->getMessage());
        }

        $files = [];

        foreach ($all as $item) {
            if ($item instanceof DirectoryAttributes) {
                $files[] = [
                    'type' => 'dir',
                    'name' => basename($item->path()),
                    'path' => rtrim($item->path(), '/'),
                    'size' => null,
                    'lastModified' => '-',
                    'url' => null,
                ];
            }

            if ($item instanceof FileAttributes) {
                $disk = Storage::disk($this->disk);

                $url = method_exists($disk, 'temporaryUrl')
                    ? $disk->temporaryUrl($item->path(), now()->addMinutes(30))
                    : $disk->url($item->path());

                $files[] = [
                    'type' => 'file',
                    'name' => basename($item->path()),
                    'path' => $item->path(),
                    'size' => round($item->fileSize() / 1024, 2),
                    'lastModified' => Carbon::createFromTimestamp($item->lastModified())->format('Y-m-d H:i'),
                    'url' => $url,
                ];
            }
        }

        // Trier : dossiers en premier, fichiers ensuite
        usort($files, function ($a, $b) {
            return $a['type'] === $b['type'] ? 0 : ($a['type'] === 'dir' ? -1 : 1);
        });

        return view('file-manager', compact('files', 'folder'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            'folder' => 'nullable|string'
        ]);

        $folder = trim($request->input('folder', ''), '/');
        $folder = $folder ? $folder . '/' : '';

        $file = $request->file('file');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();

        try {
            Storage::disk($this->disk)->putFileAs($folder, $file, $filename);
            return back()->with('success', "Fichier uploadé : {$filename}");
        } catch (\Throwable $e) {
            return back()->with('error', "Erreur lors de l'upload : " . $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        $path = trim($request->input('path'), '/');
        if (!$path) return back()->with('error', 'Chemin invalide.');

        $disk = Storage::disk($this->disk);

        try {
            if ($disk->fileExists($path)) {
                $disk->delete($path);
                return back()->with('success', "Fichier supprimé : {$path}");
            }

            // Supprimer le dossier et son contenu
            $disk->deleteDirectory($path);
            return back()->with('success', "Dossier supprimé : {$path}");
        } catch (\Throwable $e) {
            return back()->with('error', 'Erreur : ' . $e->getMessage());
        }
    }
}
