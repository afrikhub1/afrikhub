<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InterruptionRequest;
use App\Models\Residence;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class SejourController extends Controller
{
    /**
     * Afficher le formulaire pour interrompre un séjour
     */
    public function interrompreForm($reservationId)
    {
        // Utilisation de find() pour plus de simplicité
        $reservation = Reservation::find($reservationId);

        if (!$reservation) {
            return redirect()->back()->with('error', 'Réservation introuvable.');
        }

        $residence = Residence::find($reservation->residence_id);

        if (!$residence) {
            return redirect()->back()->with('error', 'Résidence introuvable.');
        }

        $userId = Auth::id();
        // Vérification stricte : seul le client lié à la réservation accède au formulaire
        if ($reservation->user_id != $userId) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas interrompre ce séjour.');
        }

        return view('pages.interrompre', compact('residence', 'reservation'));
    }

    /**
     * Envoyer la demande d'interruption
     */
    public function demanderInterruption(Request $request, $reservationId)
    {
        $reservation = Reservation::find($reservationId);

        if (!$reservation) {
            return redirect()->back()->with('error', 'Réservation introuvable.');
        }

        $userId = Auth::id();

        // --- CORRECTION LOGIQUE ICI ---
        // On vérifie si l'utilisateur est SOIT le client (user_id), SOIT le propriétaire
        $isClient = ($reservation->user_id == $userId);
        $isProprietaire = ($reservation->proprietaire_id == $userId);

        if (!$isClient && !$isProprietaire) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à demander cette interruption.');
        }

        // Détermination du rôle du demandeur
        $demandeur = $isProprietaire ? 'proprietaire' : 'client';

        // Création de la demande
        InterruptionRequest::create([
            'type_compte'    => $demandeur,
            'user_id'        => $userId,
            'residence_id'   => $reservation->residence_id,
            'reservation_id' => $reservation->reservation_code,
            'status'         => 'en_attente'
        ]);

        // Redirection dynamique selon le type de compte
        $route = (Auth::user()->type_compte == 'client') ? 'clients_historique' : 'pro.dashboard';

        return redirect()->route($route)->with('success', 'Votre demande d’interruption a été transmise à l’administration.');
    }

    /**
     * Liste des demandes pour l'admin
     */
    public function adminDemandes()
    {
        // Récupération par ordre de création (les plus récentes en premier)
        $demandes = InterruptionRequest::latest()->get();
        return view('admin.admin_interruptions', compact('demandes'));
    }

    /**
     * Valider une demande (admin)
     */
    public function validerDemande($id)
    {
        $demande = InterruptionRequest::find($id);

        if (!$demande) {
            return back()->with('error', 'Demande introuvable.');
        }

        // On cherche les modèles liés
        $residence = Residence::find($demande->residence_id);
        $reservation = Reservation::where('reservation_code', $demande->reservation_id)->first();

        if (!$residence || !$reservation) {
            return back()->with('error', 'Impossible de lier la demande à une résidence ou une réservation existante.');
        }

        // 1. Libérer la résidence
        $residence->update([
            'disponible' => 1,
            'date_disponible_apres' => null
        ]);

        // 2. Mettre à jour le statut de la réservation
        $reservation->update(['status' => 'interrompue']);

        // 3. Valider la demande d'interruption
        $demande->update(['status' => 'validee']);

        return back()->with('success', 'Séjour interrompu avec succès. La résidence est à nouveau disponible.');
    }

    /**
     * Rejeter une demande (admin)
     */
    public function rejeterDemande($id)
    {
        $demande = InterruptionRequest::find($id);

        if (!$demande) {
            return back()->with('error', 'Demande introuvable.');
        }

        $demande->update(['status' => 'rejete']);

        return back()->with('success', 'La demande d’interruption a été rejetée.');
    }
}
