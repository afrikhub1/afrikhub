<?php
// app/Http/Controllers/CarouselController.php

namespace App\Http\Controllers;

use App\Models\Carousel;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    // Liste des images du carrousel
    public function index()
    {
        $carousels = Carousel::orderBy('ordre')->get();
        return view('admin.carousel', compact('carousels'));
    }

    // Formulaire ajout
    public function create()
    {
        return view('admin.carousel');
    }

    // Ajouter une image
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'titre' => 'nullable|string',
            'lien' => 'nullable|url',
            'ordre' => 'nullable|integer',
        ]);

        $path = $request->file('image')->store('carousels', 'public');

        Carousel::create([
            'titre' => $request->titre,
            'lien' => $request->lien,
            'ordre' => $request->ordre ?? 0,
            'image' => $path,
            'actif' => true,
        ]);

        return redirect()->route('carousels.index')->with('success', 'Image ajoutée !');
    }

    // Formulaire modification
    public function edit(Carousel $carousel)
    {
        return view('admin.carousel_edit', compact('carousel'));
    }

    // Modifier
    public function update(Request $request, Carousel $carousel)
    {
        $request->validate([
            'image' => 'nullable|image',
            'titre' => 'nullable|string',
            'lien' => 'nullable|url',
            'ordre' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('carousels', 'public');
            $carousel->image = $path;
        }

        $carousel->titre = $request->titre;
        $carousel->lien = $request->lien;
        $carousel->ordre = $request->ordre ?? 0;
        $carousel->save();

        return redirect()->route('carousels.index')->with('success', 'Image modifiée !');
    }

    // Supprimer
    public function destroy(Carousel $carousel)
    {
        $carousel->delete();
        return redirect()->route('carousels.index')->with('success', 'Image supprimée !');
    }

    // Activer/Désactiver
    public function toggle(Carousel $carousel)
    {
        $carousel->actif = !$carousel->actif;
        $carousel->save();
        return redirect()->route('carousels.index');
    }
}
