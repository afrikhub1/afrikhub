<?php

namespace App\Http\Controllers;

use App\Models\Carousels; // L'importation cruciale
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    public function index()
    {
        // On utilise la classe ici
        $carousels = Carousels::orderBy('ordre')->get();
        return view('admin.carousel', compact('carousels'));
    }

    // ... (le reste de vos fonctions)
}
