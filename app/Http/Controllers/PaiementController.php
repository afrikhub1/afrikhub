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
        // Affichage debug
        echo "✅ Données OK<br>";
        echo "ID réservation : {$reservation->id}<br>";
        echo "Utilisateur : {$reservation->user->name}<br>";
        echo "Email : {$reservation->user->email}<br>";
        echo "Montant : {$reservation->total}<br><br>";

        $amount = $reservation->total * 100;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.paystack.secret'),
            'Content-Type' => 'application/json',
        ])->post(config('services.paystack.payment_url') . '/transaction/initialize', [
            'email' => $reservation->user->email,
            'amount' => $amount,
            'reference' => 'RES-' . uniqid(),   // temporaire
            'callback_url' => route('paiement.callback')
        ]);

        $body = $response->json();

        // AJOUT CLÉ : on montre la réponse de Paystack à l’écran
        echo "<pre>";
        print_r($body);
        echo "</pre>";

        exit(); // stop ici pour lire la réponse
    }
}
