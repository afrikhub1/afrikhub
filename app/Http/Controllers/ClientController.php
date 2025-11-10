<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation; // Assurez-vous d'avoir ce modèle
use Barryvdh\DomPDF\Facade\Pdf; // La Facade corrigée

class ClientController extends Controller
{
    /**
     * Affiche l'historique de toutes les réservations de l'utilisateur connecté.
     * Cette méthode est liée à la route 'historique'.
     */
    public function historiqueReservations()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('danger', 'Veuillez vous connecter pour accéder à votre historique.');
        }

        // Récupère toutes les réservations, y compris la résidence associée.
        $reservations = Reservation::where('user_id', Auth::id())
            ->with('residence') // Charger la relation 'residence'
            ->orderByDesc('created_at')
            ->get();

        return view('pages.client_dashboard', compact('reservations'));
    }

    // ----------------------------------------------------------------------
    // LOGIQUE DE FACTURATION (Basée sur la table 'reservations')
    // ----------------------------------------------------------------------

    /**
     * Affiche la liste des 'factures' (réservations payées/terminées).
     * Cette méthode est liée à la route 'factures'.
     */
    public function historiqueFactures()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('danger', 'Veuillez vous connecter.');
        }

        // Récupère uniquement les réservations qui peuvent servir de facture (payées, terminées ou confirmées)
        $reservations = Reservation::where('status', 'payé')
            ->with('residence') // Charger la relation 'residence'
            ->orderByDesc('created_at')
            ->get();

        // On passe la collection à la vue client_factures
        return view('pages.client_factures', compact('reservations'));
    }

    /**
     * Génère et télécharge une facture PDF basée sur une réservation spécifique.
     * Cette méthode est liée à la route 'facture.telecharger'.
     *
     * @param int $reservationId
     */
    public function telechargerFacture($reservationId)
    {
        if (!Auth::check()) {
            abort(403, 'Accès non autorisé.');
        }

        // 1. Recherche la réservation et s'assure qu'elle appartient à l'utilisateur
        $reservation = Reservation::where('id', $reservationId)
            ->where('user_id', Auth::id())
            ->with('residence', 'user') // Relations pour les détails
            ->firstOrFail();

        // 2. Génère le PDF
        // IMPORTANT : Utilise la vue 'pdf.facture_reservation_template'
        $pdf = Pdf::loadView('pdf.facture_reservation_template', compact('reservation'));

        // 3. Télécharge le fichier PDF
        $fileName = 'facture-res-' . $reservation->id . '-' . now()->format('Ymd') . '.pdf';
        return $pdf->download($fileName);
    }

    // Vous pouvez ajouter ici d'autres méthodes comme annulerReservation(), payer(), etc.
}
