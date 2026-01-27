<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InterruptionRequest;
use App\Models\Residence;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationStatusMail; // Assure-toi que ce Mailable existe

class SejourController extends Controller
{
    /**
     * Afficher le formulaire pour interrompre un séjour
     */
    public function interrompreForm($reservationId)
    {
        // On récupère la réservation ou on échoue proprement
        $reservation = Reservation::findOrFail($reservationId);

        $userId = Auth::id();

        // Vérification : Seul le client ou le propriétaire peut voir le formulaire
        $isClient = ($reservation->user_id == $userId);
        $isProprietaire = ($reservation->proprietaire_id == $userId);

        if (!$isClient && !$isProprietaire) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à accéder à ce formulaire.');
        }

        $residence = $reservation->residence;

        return view('pages.interrompre', compact('residence', 'reservation'));
    }

    /**
     * Envoyer la demande d'interruption
     */
    public function demanderInterruption(Request $request, $reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        $userId = Auth::id();

        $isClient = ($reservation->user_id == $userId);
        $isProprietaire = ($reservation->proprietaire_id == $userId);

        if (!$isClient && !$isProprietaire) {
            return redirect()->back()->with('error', 'Action non autorisée.');
        }

        $demandeurType = $isProprietaire ? 'proprietaire' : 'client';

        // Création de la demande
        InterruptionRequest::create([
            'type_compte'    => $demandeurType,
            'user_id'        => $userId,
            'residence_id'   => $reservation->residence_id,
            'reservation_id' => $reservation->reservation_code,
            'status'         => 'en_attente'
        ]);

        $route = (Auth::user()->type_compte == 'client') ? 'clients_historique' : 'pro.dashboard';

        return redirect()->route($route)->with('success', 'Votre demande d\'interruption a été envoyée avec succès.');
    }

    /**
     * Liste des demandes pour l'admin (Optimisée)
     */
    public function adminDemandes()
    {
        // Utilisation de eager loading pour éviter l'erreur "property of null" dans la vue
        $demandes = InterruptionRequest::with(['residence', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.admin_interruptions', compact('demandes'));
    }

    /**
     * Valider une demande (admin)
     */
    public function validerDemande($id)
    {
        $demande = InterruptionRequest::with(['residence', 'user'])->find($id);

        if (!$demande) {
            return back()->with('error', 'Demande introuvable.');
        }

        $reservation = Reservation::where('reservation_code', $demande->reservation_id)->first();

        if (!$reservation) {
            return back()->with('error', 'La réservation associée est introuvable.');
        }

        // 1. Libérer la résidence (Accès via la relation sécurisée)
        $residence = $demande->residence;
        if ($residence->exists) {
            $residence->update([
                'disponible' => 1,
                'date_disponible_apres' => null
            ]);
        }

        // 2. Mettre à jour les statuts
        $reservation->update(['status' => 'interrompue']);
        $demande->update(['status' => 'validee']);

        // 3. Notification par mail (Optionnel mais recommandé)
        try {
            Mail::to($reservation->user->email)->send(new ReservationStatusMail(
                $reservation,
                "Séjour interrompu",
                "Votre demande d'interruption pour la résidence {$residence->nom} a été validée par l'administration."
            ));
        } catch (\Exception $e) {
            // On ignore l'erreur de mail pour ne pas bloquer la validation
        }

        return back()->with('success', 'Demande validée. La résidence est de nouveau disponible.');
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
