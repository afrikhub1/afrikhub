<?php

namespace App\Http\Controllers;

use App\Models\Residence;
use Illuminate\Support\Str;

class SitemapController extends Controller
{
    /**
     * Génère le sitemap XML pour AFRIK'HUB
     */
    public function index()
    {
        // Résidences actives uniquement
        $residences = Residence::where('statut', 'active')
            ->latest()
            ->get();

        return response()
            ->view('sitemap', compact('residences'))
            ->header('Content-Type', 'application/xml');
    }
}
