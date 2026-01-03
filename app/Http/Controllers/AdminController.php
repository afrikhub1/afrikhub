<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Residence;
use App\Models\Reservation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationStatusMail;

class AdminController extends Controller
{
    // =================================================================
    // |             FONCTIONS D'AFFICHAGE ET DE STATISTIQUES          |
    // =================================================================

    // Affiche le tableau de bord principal de l'administration.
    // Cette fonction récupère toutes les statistiques agrégées pour les cartes d'aperçu.
    public function dashboard()
    {
        // Récupération des compteurs simples
        $totalUsers = User::count();            // Nombre total d'utilisateurs.
        $totalResidences = Residence::count();  // Nombre total de résidences enregistrées.
        $totalReservation = Reservation::count(); // Nombre total de réservations (tous statuss).

        // Calcul du gain total (somme des montants 'total' pour les réservations non 'en attente').
        $totalGain = Reservation::where('status', '==', 'payée')->sum('total');

        // Récupération des résidences nécessitant une action administrative (vérification).
        $pendingResidences = Residence::whereIn('status', ['en attente', 'suspendue'])->get();

        // Récuperation des residence actives
        $residencesactives = Residence::where('status', 'verifiée')->count();

        // Calcul du Taux d'Occupation
        $residencesOccupees = Residence::where('disponible', 0)->count();
        // Calcul du pourcentage, évite la division par zéro.
        $tauxOccupation = $residencesOccupees > 0 ? round(($residencesOccupees/ $totalResidences) * 100, 2) : 0;

        // Passe toutes les statistiques à la vue 'admin.admin' (le tableau de bord).
        return view('admin.admin', compact(
            'totalUsers',
            'totalResidences',
            'totalReservation',
            'pendingResidences',
            'totalGain',
            'tauxOccupation',
            'residencesactives'
        ));
    }

    // Récupère tous les utilisateurs pour l'affichage dans la liste d'administration.
    public function utilisateurs()
    {
        // Récupère l'intégralité des utilisateurs.
        $utilisateurs = User::all();

        // Envoie la collection à la vue 'admin.utilisateurs'.
        return view('admin.utilisateurs', compact('utilisateurs'));
    }

    // Récupère les résidences avec pagination pour la liste d'administration.
    public function residences()
    {
        // Récupère les résidences, triées par ID descendant, avec 9 éléments par page.
        $residences = Residence::orderBy('id', 'desc')->paginate(9);

        // Récupère les résidences, triées par ID descendant, avec 9 éléments par page.
        $reservations = Reservation::orderBy('id', 'desc')->get(); // <- récupère la collection


        // Ajoute la prochaine date disponible à chaque résidence
        foreach ($residences as $residence) {
            $residence->date_disponible = $residence->dateDisponibleAvecNettoyage();
        }
        // Envoie la collection paginée à la vue 'admin.residences'.
        return view('admin.residences', compact('residences','reservations'));
    }

    // Affiche le formulaire d'édition pour une résidence spécifique.
    // Utilise le Model Binding implicite de Laravel pour injecter l'objet Residence.
    public function modification(Residence $residence)
    {
        // Envoie l'objet Residence à la vue d'édition.
        return view('admin.residence_edit', compact('residence'));
    }

    // Récupère toutes les réservations avec les données liées (utilisateur et résidence).
    public function reservations()
    {
        // Récupère les réservations avec Eager Loading des relations 'user' et 'residence'.
        $reservations = Reservation::with(['user', 'residence'])
            ->orderBy('created_at', 'desc') // Trie par date de création récente.
            ->get();

        // Envoie la collection à la vue 'admin.reservations'.
        return view('admin.reservations', compact('reservations'));
    }

    // =================================================================
    // |                 FONCTIONS D'ACTION (UPDATES/DELETE)           |
    // =================================================================



    public function update(Request $request, Residence $residence)
    {
        // 1. Validation des données du formulaire
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix_journalier' => 'required|numeric|min:0',
            'pays' => 'required|string|max:100',
            'ville' => 'required|string|max:100',
            'quartier' => 'nullable|string|max:100',

            // Validation du status avec les valeurs autorisées
            'status' => ['required', Rule::in(['vérifiée', 'en_attente', 'suspendue'])],

            'is_suspended' => 'nullable|boolean',

            // Validation des images
            'img' => 'nullable|array|max:5', // Limite à 5 images
            'img.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // 2. Mise à jour des champs simples
        $residence->fill([
            'nom' => $validated['nom'],
            'description' => $validated['description'],
            'prix_journalier' => $validated['prix_journalier'],
            'pays' => $validated['pays'],
            'ville' => $validated['ville'],
            'quartier' => $validated['quartier'],
            'status' => $validated['status'],
            'disponible' => !$request->has('is_suspended'),

        ]);


        // 3. Gestion de l'upload des nouvelles images
        if ($request->hasFile('img')) {
            // Supprimer les anciennes images du S3
            if (!empty($residence->img)) {
                foreach ($residence->img as $oldImageUrl) {
                    // extraire le path relatif depuis l'URL publique
                    $parsedPath = str_replace(Storage::disk('s3')->url(''), '', $oldImageUrl);
                    Storage::disk('s3')->delete($parsedPath);
                }
            }

            // Upload des nouvelles images
            $newImagePaths = [];
            foreach ($request->file('img') as $image) {
                $path = $image->store('residences/' . $residence->id, 's3');
                $newImagePaths[] = Storage::disk('s3')->url($path); // stocker les URLs complètes
            }

            $residence->img = $newImagePaths;
        }


        // 4. Sauvegarde finale et redirection
        $residence->save();

        return redirect()->route('admin.residences')
            ->with('success', 'La résidence "' . $residence->nom . '" a été mise à jour avec succès.');
    }

    // Active une résidence et la marque comme 'vérifiée'.
    public function activation($id)
    {
        // Met à jour le status de la résidence ciblée.
        Residence::where('id', $id)->update([
            'status' => 'vérifiée',
        ]);

        // Redirige l'utilisateur vers la page précédente avec un message de succès.
        return back()->with('success', 'Résidence marquée comme vérifiée ');
    }

    // Désactive une résidence et la marque comme 'en attente'.
    public function desactivation($id)
    {
        // Met à jour le status de la résidence ciblée.
        Residence::where('id', $id)->update([
            'status' => 'suspendue',
        ]);

        // Redirige l'utilisateur vers la page précédente avec un message d'avertissement.
        return back()->with('error', 'Résidence désactivée');
    }

    // Supprime une résidence spécifique.
    public function suppression(Residence $residence)
    {
        // Sauvegarde le nom avant la suppression pour l'utiliser dans le message.
        $nom = $residence->nom;
        $residence->delete();  // Exécute la suppression.

        // Redirige vers la page précédente avec un message de confirmation de suppression.
        return back()->with('error', 'La résidence "' . $nom . '" a été supprimée avec succès.');
    }


    // Récupère et affiche les résidences liées à un utilisateur
    public function showUserResidences(\App\Models\User $user)
    {
        // On pagine (9 cartes par page)
        $residences = $user->residence()
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        // Ajoute la prochaine date disponible à chaque résidence
        foreach ($residences as $residence) {
            $residence->date_disponible = $residence->dateDisponibleAvecNettoyage();
        }

        return view('admin.user_residences', compact('user', 'residences'));
    }


    // Fonction pour suspendre ou réactiver l'utilisateur en utilisant la colonne 'status'.
    public function toggleUserSuspension(User $user)
    {
        // Vérifie le status actuel de l'utilisateur.
        if ($user->status === 'suspendu') {
            // Si suspendu, on le réactive.
            $user->status = 'actif';
            $message = "L'utilisateur {$user->name} a été réactivé .";
        } else {
            // Si actif (ou autre), on le suspend.
            $user->status = 'suspendu';
            $message = "L'utilisateur {$user->name} a été suspendu .";
        }

        // Sauvegarde la modification dans la base de données.
        $user->save();

        // Redirige vers la page précédente avec le message approprié.
        return back()->with('success', $message);
    }


    // Fonction pour supprimer l'utilisateur
    public function destroyUser(User $user)
    {
        $name = $user->name;
        $user->delete();

        return back()->with('error', "L'utilisateur {$name} a été supprimé définitivement.");
    }

    public function libererResidence($id)
    {
        // Récupère la résidence
        $residence = Residence::findOrFail($id);

        // Marque la résidence comme disponible
        $residence->disponible = 1;
        $residence->date_disponible_apres = null;
        $residence->save();

        // Met à jour toutes les réservations associées en "interrompue"
        $reservations = Reservation::where('residence_id', $residence->id)->get();

        foreach ($reservations as $reservation) {
            $reservation->status = 'interrompue';
            $reservation->save();
        }

        return back()->with('success', 'Résidence libérée et toutes les réservations associées interrompues.');
    }

    public function accepter($id)
    {
        $reservation = Reservation::findOrFail($id);
        $residence = $reservation->residence;

        $reservationArrivee = \Carbon\Carbon::parse($reservation->date_arrivee);
        $reservationDepart  = \Carbon\Carbon::parse($reservation->date_depart);

        // Date à partir de laquelle la résidence sera libre
        $dateDisponible = $residence->dateDisponibleAvecNettoyage();

        // Vérifie si la nouvelle réservation chevauche la période occupée
        if ($reservationArrivee->lt($dateDisponible)) {
            return back()->with('error', 'Impossible de confirmer : la résidence n’est pas disponible à ces dates.');
        }


        $reservation->status = 'confirmée';
        $reservation->date_validation = now();
        $reservation->save();

        $residence->disponible = 0;
        $residence->date_disponible_apres = $reservationDepart;
        $residence->save();

        Mail::to($reservation->user->email)->send(new ReservationStatusMail(
            $reservation,
            "Réservation confirmée !",
            "Bonne nouvelle ! Votre réservation pour {$reservation->residence->nom} a été acceptée."
        ));

        return back()->with('success', 'Réservation confirmée avec succès !');
    }


    public function refuser($id)
    {

        Reservation::where('id', $id)->update([
            'status' => 'refusée',
            'date_validation' => now(), // date et heure actuelles
        ]);

        $reservation = Reservation::find($id); // Récupérer l'objet pour le mail
        Mail::to($reservation->user->email)->send(new ReservationStatusMail(
            $reservation,
            "Demande de réservation refusée",
            "Désolé, votre demande pour {$reservation->residence->nom} n'a pas pu être acceptée."
        ));

        return back()->with('success', 'Réservation refusée');
    }

    public function marquer_payé($id)
    {


        // Génération d'une référence unique (ex: ADMIN-6591A2B3C4D5E)
        $reference = 'ADMIN-' . strtoupper(uniqid());

        Reservation::where('id', $id)->update([
            'status' => 'payée', // Assurez-vous que votre base accepte l'accent ou utilisez 'payee'
            'reference' => $reference,
            'date_paiement' => now(),
        ]);

        return back()->with('success', 'Réservation marquée comme payée. Référence : ' . $reference);
    }

    public function logs()
    {
        $logs = ActivityLog::with('user')->latest()->paginate(20);
        return view('admin.logs', compact('logs'));
    }
}
