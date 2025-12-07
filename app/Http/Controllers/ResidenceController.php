<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Residence;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResidenceController extends Controller
{
    // Affiche le formulaire
    public function create()
    {
        return view('pages.mise_en_ligne');
    }

    // Traite la soumission du formulaire
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
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagesPath = [];

        if ($request->hasFile('images')) {
            $nomDossier = 'residences/' . Str::slug($request->nom_residence) . '_' . time();

            foreach ($request->file('images') as $image) {
                // Stocker sur S3
                $path = $image->store($nomDossier, 's3');
                $imagesPath[] = Storage::disk('s3')->url($path); // récupérer l'URL publique
            }
        }

        // Récupérer les commodités
        $comodites = $request->input('autres_details', []); // [] si rien coché
        $comoditesTexte = collect($comodites)
            ->map(fn($c) => htmlspecialchars($c)) // sécurise le texte
            ->implode(' - '); // transforme en chaîne séparée par " - "

        // Création de la résidence
        Residence::create([
            'proprietaire_id' => Auth::id(), // relation avec User
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
            'status' => 'en_attente',
            'commodites' => $comoditesTexte,
        ]);

        return redirect()->route('message')
            ->with('success', '✅ Résidence ajoutée avec succès ! Elle est en attente de validation.');
    }

    public function index()
    {
        // On récupère toutes les résidences du user connecté
        $residences = Residence::where('proprietaire_id', Auth::id())->get();

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
            ->get();

        // Ajout de la date de disponibilité à chaque résidence
        foreach ($recherches as $residence) {
            $residence->date_disponible = $residence->dateDisponibleAvecNettoyage();
        }

        return view('pages.recherche', compact('recherches'));
    }



    public function accueil()
    {



        // Récupération des résidences disponibles pour l'affichage

        $residences = Residence::where('status', 'vérifiée')
            ->where('disponible', 1) // 1 -> résidences disponibles
            ->get();

        // Ajoute la prochaine date disponible à chaque résidence (si nécessaire)
        foreach ($residences as $residence) {
            $residence->date_disponible = $residence->dateDisponibleAvecNettoyage();
        }


        // Passage des données à la vue accueil
        return view('accueil', compact('residences'));
    }


    // Réserver à nouveau
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
        // On récupère les résidences occupées appartenant à l'utilisateur connecté
        $residences_occupees = Residence::where('proprietaire_id', $userId)
            ->where('disponible', 0)
            ->get();

        // On récupère les résidences occupées appartenant à l'utilisateur connecté
        $reservation = Reservation::where('proprietaire_id', $userId)
            ->where('status', 'payé')
            ->get();

        return view('reservations.occupees', compact('residences_occupees', 'reservation'));
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


