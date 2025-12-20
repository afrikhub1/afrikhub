<?php

// app/Http/Controllers/PubliciteController.php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Carousels;
use App\Models\Publicite;
use Illuminate\Http\Request;
use App\Models\Residence;

class PubliciteController extends Controller
{
    public function accueil()
    {
        // Récupération des résidences disponibles
        $residences = Residence::where('status', 'vérifiée')
            ->where('disponible', 1)
            ->get();

        // Ajout de la prochaine date disponible
        foreach ($residences as $residence) {
            $residence->date_disponible = $residence->dateDisponibleAvecNettoyage();
        }

        // Publicités actives
        $publicites = Publicite::where('actif', true)
            ->orderBy('ordre')
            ->get();

        $showPub = $publicites->count() > 0;

        // Carousels actifs
        $carousels = Carousels::where('actif', true)
            ->orderBy('ordre')
            ->get();

        // 🔹 Ajouter l'URL S3 pour chaque image de carousel
        $carousels->transform(function ($item) {
            $item->image_url = Storage::disk('s3')->url($item->image);
            return $item;
        });

        // Passage des données à la vue
        return view('accueil', compact('residences', 'publicites', 'showPub', 'carousels'));
    }


    public function index()
    {
        $publicites = Publicite::orderBy('ordre')->get();
        return view('admin.publicite', compact('publicites'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
        ]);

        Publicite::create($request->all());

        return redirect()->back()->with('success', 'Publicité ajoutée');
    }

    public function edit(Publicite $publicite)
    {
        return view('admin.publicites_edit', compact('publicite'));
    }

    public function update(Request $request, Publicite $publicite)
    {
        $publicite->update($request->all());
        return redirect()->route('publicites.index')->with('success', 'Publicité modifiée');
    }


    public function destroy(Publicite $publicite)
    {
        $publicite->delete();

        return redirect()->back()->with('success', 'Publicité supprimée');
    }

    public function toggle(Publicite $publicite)
    {
        $publicite->update([
            'actif' => !$publicite->actif
        ]);

        return redirect()->back();
    }
}
