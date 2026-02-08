<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <!-- Page d'accueil -->
    <url>
        <loc>{{ url('/') }}</loc>
        <priority>1.0</priority>
        <changefreq>daily</changefreq>
    </url>

    <!-- Pages résidences -->
    @foreach($residences as $residence)
    <url>
        <loc>{{ url('/details/'.$residence->id.'-'.Str::slug($residence->nom)) }}</loc>
        <priority>0.8</priority>
        <changefreq>weekly</changefreq>
    </url>
    @endforeach

</urlset>
