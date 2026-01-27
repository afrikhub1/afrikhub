<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Residence;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Stevebauman\Location\Facades\Location;
use App\Models\ActivityLog;

class ResidenceController extends Controller
{
    // Affiche le formulaire
    public function create()
    {
        return view('pages.mise_en_ligne');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_residence' => 'required|string|max:255',
            'pays' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'type_residence' => 'required|string|max:255',
            'nb_chambres' => 'required|integer|min:1',
            'nb_salons' => 'required|integer|min:0',
            'prix_jour' => 'required|numeric|min:1',
            'details' => 'required|string|max:2000',
            'details_position' => 'required|string|max:255',
            'geolocalisation' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'images' => 'required|array|max:10',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'commodites' => 'nullable|array', // On valide que c'est un tableau
        ]);

        // 1. Gestion des Images sur S3
        $imagesPath = [];
        if ($request->hasFile('images')) {
            $nomDossier = 'residences/' . Str::slug($request->nom_residence) . '_' . time();
            foreach ($request->file('images') as $image) {
                $path = $image->store($nomDossier, 's3');
                $imagesPath[] = Storage::disk('s3')->url($path);
            }
        }

        // 2. TRAITEMENT DES COMMODITÉS (La correction est ici)
        $comoditesFinales = [];
        if ($request->has('commodites')) {
            foreach ($request->commodites as $label => $data) {
                // On vérifie si la case est cochée (active == 1)
                if (isset($data['active']) && $data['active'] == "1") {
                    // Si une valeur (nombre de chambres, pouces TV, etc.) est saisie, on l'ajoute au label
                    $valeur = !empty($data['value']) ? " : " . $data['value'] : "";
                    $comoditesFinales[] = $label . $valeur;
                }
            }
        }

        // On transforme le tableau en chaîne de caractères "Wi-Fi - Piscine - Télévision : 55"
        $comoditesTexte = implode(' - ', $comoditesFinales);

        // 3. Création de la résidence
        Residence::create([
            'proprietaire_id' => Auth::id(),
            'nom' => $request->nom_residence,
            'details' => $request->details,
            'quartier' => $request->details_position,
            'nombre_chambres' => $request->nb_chambres,
            'type_residence' => $request->type_residence,
            'nombre_salons' => $request->nb_salons,
            'prix_journalier' => $request->prix_jour,
            'ville' => $request->ville,
            'pays' => $request->pays,
            'geolocalisation' => $request->geolocalisation,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'img' => json_encode($imagesPath),
            'status' => 'en attente',
            'commodites' => $comoditesTexte, // Sauvegarde la chaîne propre
        ]);

        // log d'activité
        $ip = request()->ip();
        $position = Location::get($ip);
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'ajout de résidence',
            'description' => 'Utilisateur à ajouté une residence avec succès.',
            'ip_address' => $ip,
            'pays'       => $position ? $position->countryName : null,
            'ville'      => $position ? $position->cityName : null,
            'latitude'   => $position ? $position->latitude : null,
            'longitude'  => $position ? $position->longitude : null,
            'code_pays'  => $position ? $position->countryCode : null,
            'user_agent' => request()->header('User-Agent'), // Navigateur et OS
        ]);

        return redirect()->route('pro.dashboard')
            ->with('success', ' Résidence ajoutée avec succès ! Elle est en attente de validation.');
    }

    public function index()
    {
        // On récupère toutes les résidences du user connecté
        $residences = Residence::where('proprietaire_id', Auth::id())->where('status', 'vérifiée')->get();

        if (! $residences instanceof \Illuminate\Support\Collection) {
            dd($residences); // debug si ce n'est pas une Collection
        }

        return view('pages.residences', compact('residences'));
    }


    public function recherche_img(Request $request)
    {
        $ville = $request->input('ville_quartier');

        // Recherche des résidences selon la ville
        $recherches = Residence::where('ville', 'LIKE', "%{$ville}%")
            ->where('status', 'vérifiée')
            ->get();

        // Ajout de la date de disponibilité à chaque résidence
        foreach ($recherches as $residence) {
            $residence->date_disponible = $residence->dateDisponibleAvecNettoyage();
        }

        return view('pages.recherche', compact('recherches'));
    }


    public function recherche(Request $request)
    {
        $query = Residence::query();

        if ($request->filled('chambres')) {
            $query->where('nombre_chambres', '>=', $request->chambres);
        }

        if ($request->filled('salons')) {
            $query->where('nombre_salons', '>=', $request->salons);
        }

        if ($request->filled('ville')) {
            $query->where('ville', 'LIKE', '%' . $request->ville . '%');
        }

        if ($request->filled('quartier')) {
            $query->where('quartier', 'LIKE', '%' . $request->quartier . '%');
        }

        if ($request->filled('prix')) {
            $query->where('prix_journalier', '<=', $request->prix);
        }

        if ($request->filled('type')) {
            $query->where('type_residence', $request->type);
        }

        $residences = $query->latest()->paginate(9)->withQueryString();

        return view('residences.recherche', compact('residences'));
    }


    // Détails d'une résidence
    public function details($id)
    {
        $residences_details = Residence::findOrFail($id);
        return view('pages.details', compact('residences_details'));
    }

    // Réserver à nouveau
    public function dashboard_resi_reserv()
    {

        $userId= Auth::id();
        // Résidences du propriétaire (table residences)
        $residences = Residence::where('proprietaire_id', $userId)->get();

        $residences_occupees = Residence::where('proprietaire_id', $userId)
            ->where('disponible', 0)
            ->get();

        // Réservations confirmées ou gestionnées (table reservations)
        $reservation_reçu = Reservation::where('proprietaire_id', $userId)->get();

        // Passe les 3 variables à la vue
        return view('pages.dashboard', compact('residences', 'reservation_reçu', 'residences_occupees'));
    }

    public function occupees()
    {
        $userId = Auth::id();

        // On récupère les résidences occupées AVEC leur réservation confirmée
        $residences_occupees = Residence::where('proprietaire_id', $userId)
            ->where('disponible', 0)
            ->with(['reservations' => function ($query) {
                $query->where('status', 'confirmée'); // On cible le séjour en cours
            }])
            ->get();

        return view('reservations.occupees', compact('residences_occupees'));
    }


    public function reservationRecu()
    {
        $userId = Auth::id();
        $reservationsRecu = Reservation::where('proprietaire_id', $userId)->get();

        // Ajouter la prochaine date disponible pour chaque résidence de la réservation
        foreach ($reservationsRecu as $reservation) {
            if ($reservation->residence) { // Vérifie que la relation existe
                $reservation->residence->date_disponible = $reservation->residence->dateDisponibleAvecNettoyage();
            }
        }

        return view('reservations.historique', compact('reservationsRecu'));
    }
}


