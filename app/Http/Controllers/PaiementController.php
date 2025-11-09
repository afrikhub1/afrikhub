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
        // Vérification des données
        $amount = $reservation->total * 100;

        // Générer une référence si pas présente
        if (!$reservation->reference) {
            $reservation->reference = 'RES-' . uniqid();
            $reservation->save();
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.paystack.secret'),
            'Content-Type' => 'application/json',
        ])->post(config('services.paystack.payment_url') . '/transaction/initialize', [
            'email' => $reservation->user->email,
            'amount' => $amount,
            'reference' => $reservation->reference,
            'callback_url' => route('paiement.callback'),
        ]);

        $body = $response->json();

        if (isset($body['status']) && $body['status'] === true) {
            // 👉 On redirige enfin vers Paystack 🎉
            return redirect()->away($body['data']['authorization_url']);
        }

        return redirect()->back()->with('error', 'Impossible d’initialiser le paiement.');
    }
}
