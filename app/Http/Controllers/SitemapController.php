<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Residence; // si tu veux inclure les résidences dynamiques

class SitemapController extends Controller
{
    public function index()
    {
        // Pages statiques publiques
        $urls = [
            ['loc' => url('/'), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => url('/login'), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => url('/message'), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => url('/conditions-generales'), 'changefreq' => 'yearly', 'priority' => '0.4'],
            ['loc' => url('/mentions-legales'), 'changefreq' => 'yearly', 'priority' => '0.4'],
            ['loc' => url('/politique-confidentialite'), 'changefreq' => 'yearly', 'priority' => '0.4'],
            ['loc' => url('/faq'), 'changefreq' => 'monthly', 'priority' => '0.6'],
        ];

        // Ajouter les résidences dynamiques
        $residences = Residence::all(); // ou filtrer selon besoin
        foreach ($residences as $res) {
            $urls[] = [
                'loc' => route('details', ['id' => $res->id]),
                'lastmod' => $res->updated_at->tz('UTC')->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.8'
            ];
        }

        // Retourner la vue sitemap avec header XML
        return response()->view('sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }
}
