<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Residence;
use App\Models\Reservation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

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
        $totalReservation = Reservation::count(); // Nombre total de réservations (tous statuts).

        // Calcul du gain total (somme des montants 'total' pour les réservations non 'en attente').
        $totalGain = Reservation::where('status', '==', 'payé')->sum('total');

        // Récupération des résidences nécessitant une action administrative (vérification).
        $pendingResidences = Residence::whereIn('statut', ['en attente', 'suspendue'])->get();

        // Récuperation des residence actives
        $residencesactives = Residence::where('statut', 'verifiée')->count();

        // Calcul du Taux d'Occupation
        $residencesOccupees = Residence::where('disponible', 0)->count();
        // Calcul du pourcentage, évite la division par zéro.
        $tauxOccupation = $totalResidences > 0 ? round(($totalResidences / $residencesOccupees) * 100, 2) : 0;

        // Passe toutes les statistiques à la vue 'admin.admin' (le tableau de bord).
        return view('admin.admin', compact(
            'totalUsers',
            'totalResidences',
            'totalReservation',
            'pendingResidences',
            'totalGain',
            'tauxOccupation'
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

        // Ajoute la prochaine date disponible à chaque résidence
        foreach ($residences as $residence) {
            $residence->date_disponible = $residence->dateDisponibleAvecNettoyage();
        }
        // Envoie la collection paginée à la vue 'admin.residences'.
        return view('admin.residences', compact('residences'));
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



    // N'oubliez pas d'inclure les autres méthodes (index, destroy, etc.) ici..

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

            // Validation du statut avec les valeurs autorisées
            'statut' => ['required', Rule::in(['vérifiée', 'en_attente', 'suspendue'])],

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
            'statut' => $validated['statut'],

            // Assurez-vous d'utiliser le nom de champ correct pour la suspension/disponibilité
            'disponible' => !$request->has('is_suspended'),

        ]);
        // Note: La sauvegarde des champs simples sera faite par le fill/save ci-dessus.

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
        // Met à jour le statut de la résidence ciblée.
        Residence::where('id', $id)->update([
            'statut' => 'vérifiée',
        ]);

        // Redirige l'utilisateur vers la page précédente avec un message de succès.
        return back()->with('success', 'Résidence marquée comme vérifiée ✅');
    }

    // Désactive une résidence et la marque comme 'en attente'.
    public function desactivation($id)
    {
        // Met à jour le statut de la résidence ciblée.
        Residence::where('id', $id)->update([
            'statut' => 'suspendue',
        ]);

        // Redirige l'utilisateur vers la page précédente avec un message d'avertissement.
        return back()->with('danger', 'Résidence désactivée');
    }

    // Supprime une résidence spécifique.
    public function suppression(Residence $residence)
    {
        // Sauvegarde le nom avant la suppression pour l'utiliser dans le message.
        $nom = $residence->nom;
        $residence->delete();  // Exécute la suppression.

        // Redirige vers la page précédente avec un message de confirmation de suppression.
        return back()->with('danger', 'La résidence "' . $nom . '" a été supprimée avec succès.');
    }


    // Récupère et affiche les résidences liées à un utilisateur
    public function showUserResidences(\App\Models\User $user)
    {
        // On pagine (9 cartes par page)
        $residences = $user->residences()
            ->orderBy('created_at', 'desc')
            ->paginate(9);
        // Ajoute la prochaine date disponible à chaque résidence
        foreach ($residences as $residence) {
            $residence->date_disponible = $residence->dateDisponibleAvecNettoyage();
        }

        return view('admin.user_residences', compact('user', 'residences'));
    }


    // Fonction pour suspendre ou réactiver l'utilisateur en utilisant la colonne 'statut'.
    public function toggleUserSuspension(User $user)
    {
        // Vérifie le statut actuel de l'utilisateur.
        if ($user->statut === 'suspendu') {
            // Si suspendu, on le réactive.
            $user->statut = 'actif';
            $message = "L'utilisateur {$user->name} a été réactivé ✅.";
        } else {
            // Si actif (ou autre), on le suspend.
            $user->statut = 'suspendu';
            $message = "L'utilisateur {$user->name} a été suspendu 🔒.";
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

        return back()->with('danger', "L'utilisateur {$name} a été supprimé définitivement.");
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
}
