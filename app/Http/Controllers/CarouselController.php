<?php
// app/Http/Controllers/CarouselController.php

namespace App\Http\Controllers;

use App\Models\Carousels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;
use App\Models\ActivityLog;

class CarouselController extends Controller
{
    // Liste des images du carrousel
    public function index()
    {
        $carousels = Carousels::orderBy('ordre')->get();
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
            'lien' => 'nullable|url',
            'ordre' => 'nullable|integer',
        ]);

        $path = $request->file('image')->store('galerie/carousels', 's3');

        Carousels::create([
            'lien' => $request->lien,
            'ordre' => $request->ordre ?? 0,
            'image' => $path,
            'actif' => true,
        ]);

        $ip = request()->ip();
        $position = Location::get($ip);
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'creation_carousel publicitaire',
            'description' => 'Creation de carousel publicitaire.',
            'ip_address' => $ip,
            'pays'       => $position ? $position->countryName : null,
            'ville'      => $position ? $position->cityName : null,
            'latitude'   => $position ? $position->latitude : null,
            'longitude'  => $position ? $position->longitude : null,
            'code_pays'  => $position ? $position->countryCode : null,
            'user_agent' => request()->header('User-Agent'), // Navigateur et OS
        ]);

        return redirect()->route('carousels.index')->with('success', 'Image ajoutée !');
    }

    // Formulaire modification
    public function edit(Carousels $carousel)
    {
        return view('admin.carousel_edit', compact('carousel'));
    }

    // Modifier
    public function update(Request $request, Carousels $carousel)
    {
        $request->validate([
            'image' => 'nullable|image',
            'lien' => 'nullable|url',
            'ordre' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('carousels', 'public');
            $carousel->image = $path;
        }

        $carousel->lien = $request->lien;
        $carousel->ordre = $request->ordre ?? 0;
        $carousel->save();

        return redirect()->route('carousels.index')->with('success', 'Image modifiée !');
    }

    // Supprimer
    public function destroy(Carousels $carousel)
    {
        $carousel->delete();
        return redirect()->route('carousels.index')->with('success', 'Image supprimée !');
    }

    // Activer/Désactiver
    public function toggle(Carousels $carousel)
    {
        $carousel->actif = !$carousel->actif;
        $carousel->save();
        return redirect()->route('carousels.index');
    }
}
