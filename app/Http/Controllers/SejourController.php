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
        // On récupère la réservation avec find()
        $reservation = Reservation::find($reservationId);

        if (!$reservation) {
            return redirect()->back()->with('error', 'Réservation introuvable.');
        }

        $userId = Auth::id();

        // Vérification : Seul le client ou le propriétaire peut voir le formulaire
        $isClient = ($reservation->user_id == $userId);
        $isProprietaire = ($reservation->proprietaire_id == $userId);

        if (!$isClient && !$isProprietaire) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à accéder à ce formulaire.');
        }

        $residence = Residence::find($reservation->residence_id);

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

        // --- LOGIQUE DE VÉRIFICATION CORRIGÉE ---
        $isClient = ($reservation->user_id == $userId);
        $isProprietaire = ($reservation->proprietaire_id == $userId);

        // Si l'utilisateur n'est ni l'un ni l'autre, on bloque
        if (!$isClient && !$isProprietaire) {
            return redirect()->back()->with('error', 'Action non autorisée.');
        }

        // On définit qui est le demandeur pour l'admin
        $demandeurType = $isProprietaire ? 'proprietaire' : 'client';

        // Création de la demande d'interruption
        InterruptionRequest::create([
            'type_compte'    => $demandeurType,
            'user_id'        => $userId,
            'residence_id'   => $reservation->residence_id,
            'reservation_id' => $reservation->reservation_code, // On garde ton usage du code
            'status'         => 'en_attente'
        ]);

        // Redirection basée sur le type de compte de l'utilisateur connecté
        $userRole = Auth::user()->type_compte;
        $route = ($userRole == 'client') ? 'clients_historique' : 'pro.dashboard';

        return redirect()->route($route)->with('success', 'Votre demande d\'interruption a été envoyée avec succès.');
    }

    /**
     * Liste des demandes pour l'admin
     */
    public function adminDemandes()
    {
        // On récupère les demandes avec les infos de base
        $demandes = InterruptionRequest::orderBy('created_at', 'desc')->get();
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

        $residence = Residence::find($demande->residence_id);
        $reservation = Reservation::where('reservation_code', $demande->reservation_id)->first();

        if (!$residence || !$reservation) {
            return back()->with('error', 'Données liées (résidence ou réservation) introuvables.');
        }

        // 1. Libérer la résidence immédiatement
        $residence->update([
            'disponible' => 1,
            'date_disponible_apres' => null
        ]);

        // 2. Mettre à jour le statut du séjour
        $reservation->update(['status' => 'interrompue']);

        // 3. Clôturer la demande
        $demande->update(['status' => 'validee']);

        return back()->with('success', 'Demande validée. La résidence est de nouveau libre.');
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

        return back()->with('success', 'La demande a été rejetée.');
    }
}
