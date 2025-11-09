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

        // On garde les checks de tout à l’heure :
        if (!$reservation) {
            return back()->with('error', '❌ Réservation introuvable.');
        }
        if (!$reservation->user) {
            return back()->with('error', '❌ Aucun utilisateur associé.');
        }
        if (!$reservation->user->email) {
            return back()->with('error', '❌ Email introuvable.');
        }
        if (!$reservation->total || $reservation->total <= 0) {
            return back()->with('error', '❌ Montant invalide.');
        }

        $amount = $reservation->total * 100; // Paystack veut les montants en kobo

        // ✅ TEST : Afficher la réponse Paystack brute
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.paystack.secret'),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post(config('services.paystack.payment_url') . '/transaction/initialize', [
            'email' => $reservation->user->email,
            'amount' => $amount,
            'callback_url' => route('paiement.callback') // callback simple pour éviter les erreurs
        ]);

        // Retour direct de la réponse Paystack -> écran
        return back()->with('info', json_encode($response->json(), JSON_PRETTY_PRINT));
    }
}
