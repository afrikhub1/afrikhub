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
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à votre historique.');
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
            return redirect()->route('login')->with('error', 'Veuillez vous connecter.');
        }

        $userId = Auth::id();

        // Récupère uniquement les réservations qui peuvent servir de facture (payées, terminées ou confirmées)
        $reservations = Reservation::where('user_id', $userId)   //  Cible les réservations du client connecté
            ->whereIn('status', ['confirmée','payé', 'terminée'])  // status pour facture
            ->with('residence')  // Charger la résidence
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
        // 1. Recherche sécurisée (404 si non trouvé ou n'appartient pas à l'utilisateur)
        $reservation = Reservation::where('id', $reservationId)
            ->where('user_id', Auth::id())
            ->with('residence', 'user')
            ->firstOrFail();

        // 2. Génération du PDF
        $pdf = Pdf::loadView('pages.client_facture_imprime', compact('reservation'));

        // 3. Nommage du fichier et téléchargement
        $nomFichier = 'facture-' . $reservation->id . '.pdf';

        return $pdf->download($nomFichier);
    }

    // Vous pouvez ajouter ici d'autres méthodes comme annulerReservation(), payer(), etc.
}
