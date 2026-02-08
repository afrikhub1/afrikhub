<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Residence;

class SitemapController extends Controller
{
    public function index()
    {
        $residences = Residence::where('status', 'active')->get();

        $urls = [
            ['loc' => route('accueil'), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => route('faq'), 'changefreq' => 'monthly', 'priority' => '0.6'],
            ['loc' => route('conditions_generales'), 'changefreq' => 'yearly', 'priority' => '0.5'],
            ['loc' => route('mentions_legales'), 'changefreq' => 'yearly', 'priority' => '0.5'],
            ['loc' => route('politique_confidentialite'), 'changefreq' => 'yearly', 'priority' => '0.5'],
            ['loc' => route('residences.recherche'), 'changefreq' => 'daily', 'priority' => '0.8'],
        ];

        foreach ($residences as $residence) {
            $urls[] = [
                'loc' => route('details', $residence->id),
                'lastmod' => $residence->updated_at->tz('UTC')->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        $content = view('sitemap', compact('urls'));

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}
