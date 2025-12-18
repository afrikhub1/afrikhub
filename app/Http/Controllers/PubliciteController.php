<?php

// app/Http/Controllers/PubliciteController.php

namespace App\Http\Controllers;

use App\Models\Publicite;
use Illuminate\Http\Request;
use App\Models\Residence;

class PubliciteController extends Controller
{
    public function accueil()
    {
        // Récupération des résidences disponibles pour l'affichage

        $residences = Residence::where('status', 'vérifiée')
            ->where('disponible', 1) // 1 -> résidences disponibles
            ->get();

        // 1️⃣ pubs actives
        $publicites = Publicite::where('actif', true)
            ->orderBy('ordre')
            ->get();

        // 3️⃣ afficher ou non la section pub
        $showPub = $publicites->count() > 0;

        // Ajoute la prochaine date disponible à chaque résidence (si nécessaire)
        foreach ($residences as $residence) {
            $residence->date_disponible = $residence->dateDisponibleAvecNettoyage();
        }


        // Passage des données à la vue accueil
        return view('accueil', compact('residences', 'publicites','showPub'));
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

    public function update(Request $request, Publicite $publicite)
    {
        $publicite->update($request->all());

        return redirect()->back()->with('success', 'Publicité modifiée');
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
