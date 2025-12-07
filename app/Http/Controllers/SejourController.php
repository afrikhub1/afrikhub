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
        $reservation = Reservation::where('id', $reservationId)->first();
        if (!$reservation) {
            return redirect()->back()->with('error', 'Réservation introuvable.');
        }

        $residence = Residence::where('id', $reservation->residence_id)->first();
        if (!$residence) {
            return redirect()->back()->with('error', 'Résidence introuvable.');
        }

        $userId = Auth::id();
        if ($reservation->user_id != $userId) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas interrompre ce séjour.');
        }

        return view('pages.interrompre', compact('residence', 'reservation'));
    }

    /**
     * Envoyer la demande d'interruption
     */
    public function demanderInterruption(Request $request, $reservation)
    {

        $reservation = Reservation::where('id', $reservation)->first();
        if (!$reservation) {
            return redirect()->back()->with('error', 'Réservation introuvable.');
        }

        $residence = Residence::where('id', $reservation->residence_id)->first();
        if (!$residence) {
            return redirect()->back()->with('error', 'Résidence introuvable.');
        }

        $user = $request->user();
        if ($reservation->user_id != $user->id) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas interrompre ce séjour.');
        }

        if ($reservation->user_id === $residence->id_proprietaire) {
            $demandeur= 'proprietaire';
        }
        else{
            $demandeur='client';
        }

        InterruptionRequest::create([
            'type_compte'=> $demandeur,
            'user_id' => $user->id,
            'residence_id' => $residence->id,
            'reservation_id' => $reservation->id,
            'status' => 'en_attente'
        ]);

        $user_type= Auth::user()->type_compte;
        // on verifie si le l'utilisateur est un client
        if ($user_type== 'client') {

            $route = 'clients_historique';
        }
        // sinon il est forcement un user pro
        else {
            $route = 'pro.dashboard';
        }


        return redirect()->route($route)->with('success', 'Votre demande a été envoyée à l’admin.');
    }

    /**
     * Liste des demandes pour l'admin
     */
    public function adminDemandes()
    {
        // On récupère toutes les demandes avec uniquement les IDs, pas de relations
        $demandes = InterruptionRequest::all();
        return view('admin.admin_interruptions', compact('demandes'));
    }

    /**
     * Valider une demande (admin) avec where et IDs
     */
    public function validerDemande($id)
    {
        $demande = InterruptionRequest::where('id', $id)->first();
        if (!$demande) {
            return back()->with('error', 'Demande introuvable.');
        }

        $residence = Residence::where('id', $demande->residence_id)->first();
        if (!$residence) {
            return back()->with('error', 'Résidence introuvable pour cette demande.');
        }

        $reservation = Reservation::where('id', $demande->reservation_id)
            ->where('residence_id', $demande->residence_id)
            ->first();
        if (!$reservation) {
            return back()->with('error', 'Réservation introuvable ou ne correspond pas à la résidence.');
        }

        // Libérer la résidence
        $residence->disponible = 1;
        $residence->date_disponible_apres = null;
        $residence->save();

        // Mettre à jour le status de la réservation
        $reservation->status = 'interrompue';
        $reservation->save();

        // Mettre à jour le status de la demande
        $demande->status = 'validee';
        $demande->save();

        return back()->with('success', 'Demande validée, résidence libérée.');
    }

    /**
     * Rejeter une demande (admin)
     */
    public function rejeterDemande($id)
    {
        $demande = InterruptionRequest::where('id', $id)->first();
        if (!$demande) {
            return back()->with('error', 'Demande introuvable.');
        }

        $demande->status = 'rejete';
        $demande->save();

        return back()->with('success', 'Demande rejetée.');
    }
}
