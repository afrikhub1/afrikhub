<?php

// app/Http/Controllers/PubliciteController.php

namespace App\Http\Controllers;

use App\Models\Publicite;
use Illuminate\Http\Request;

class PubliciteController extends Controller
{
    public function index()
    {
        $publicites = Publicite::orderBy('ordre')->get();
        return view('admin.publicites.index', compact('publicites'));
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
