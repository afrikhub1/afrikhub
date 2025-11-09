<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Reservation;

class PaiementController extends Controller
{
    // Déclenche le paiement
    public function index(Reservation $reservation)
    {
        // 1) Vérifier que la réservation existe
        if (!$reservation) {
            return back()->with('error', '❌ Réservation introuvable.');
        }

        // 2) Vérifier que l'utilisateur lié existe
        if (!$reservation->user) {
            return back()->with('error', '❌ Aucun utilisateur associé à cette réservation.');
        }

        // 3) Vérifier que l'email existe
        if (!$reservation->user->email) {
            return back()->with('error', '❌ Impossible de récupérer l’email du client.');
        }

        // 4) Vérifier le montant
        if (!$reservation->total || $reservation->total <= 0) {
            return back()->with('error', '❌ Montant de réservation invalide.');
        }

        // 5) Vérifier APP_URL (important sur Laravel Cloud)
        if (empty(config('app.url'))) {
            return back()->with('error', '❌ APP_URL non défini dans le .env');
        }

        // ✅ Si tout est bon → afficher CONFIRMATION avant Paystack
        return back()->with(
            'success',
            "✅ Données OK\n" .
                "ID réservation : {$reservation->id}\n" .
                "Utilisateur : {$reservation->user->name}\n" .
                "Email : {$reservation->user->email}\n" .
                "Montant : {$reservation->total}"
        );
    }
}
