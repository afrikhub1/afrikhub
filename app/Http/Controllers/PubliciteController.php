<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Carousels;
use App\Models\Publicite;
use App\Models\Residence;
use Illuminate\Http\Request;

class PubliciteController extends Controller
{
    // Page d'accueil
    public function accueil()
    {
        // 1️⃣ Résidences disponibles
        $residences = Residence::where('status', 'vérifiée')
            ->where('disponible', 1)
            ->get();

        foreach ($residences as $residence) {
            $residence->date_disponible = $residence->dateDisponibleAvecNettoyage();
        }

        // 2️⃣ Publicités actives
        $publicites = Publicite::where('actif', true)
            ->orderBy('ordre')
            ->get();
        $showPub = $publicites->count() > 0;

        // 3️⃣ Carousels actifs
        $carousels = Carousels::where('actif', true)
            ->orderBy('ordre')
            ->get();

        // 🔹 Ajouter l'URL S3 pour chaque carousel
        $carousels->transform(function ($item) {
            $item->image_url = Storage::disk('s3')->url($item->image);
            return $item;
        });

        // 4️⃣ Retour de la vue
        return view('accueil', compact('residences', 'publicites', 'showPub', 'carousels'));
    }

    // Liste des publicités pour l'administration
    public function index()
    {
        $publicites = Publicite::orderBy('ordre')->get();
        return view('admin.publicite', compact('publicites'));
    }

    // Ajouter une publicité
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
        ]);

        Publicite::create($request->all());

        return redirect()->back()->with('success', 'Publicité ajoutée');
    }

    // Modifier une publicité
    public function edit(Publicite $publicite)
    {
        return view('admin.publicites_edit', compact('publicite'));
    }

    public function update(Request $request, Publicite $publicite)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
        ]);

        $publicite->update($request->all());
        return redirect()->route('publicites.index')->with('success', 'Publicité modifiée');
    }

    // Supprimer une publicité
    public function destroy(Publicite $publicite)
    {
        $publicite->delete();
        return redirect()->back()->with('success', 'Publicité supprimée');
    }

    // Activer / désactiver une publicité
    public function toggle(Publicite $publicite)
    {
        $publicite->update([
            'actif' => !$publicite->actif
        ]);

        return redirect()->back();
    }
}
