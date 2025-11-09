<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Reservation;

class PaiementController extends Controller
{
    // Page ou déclenchement du paiement
    public function index(Reservation $reservation)
    {
        $amount = $reservation->total * 100; // en kobo

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.paystack.secret')
        ])->post(config('services.paystack.payment_url') . '/transaction/initialize', [
            'email' => $reservation->user->email,
            'amount' => $amount,
            'callback_url' => route('paiement.callback', ['reservation' => $reservation->id])
        ]);

        $body = $response->json();

        if (isset($body['status']) && $body['status'] === true) {
            return redirect($body['data']['authorization_url']);
        }

        return redirect()->back()->with('error', 'Impossible d’initialiser le paiement.');
    }

    // Callback après paiement
    public function callback(Request $request, Reservation $reservation)
    {
        $reference = $request->query('reference');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.paystack.secret')
        ])->get(config('services.paystack.payment_url') . "/transaction/verify/{$reference}");

        $body = $response->json();

        if (isset($body['status']) && $body['status'] === true && $body['data']['status'] === 'success') {
            // Marquer la réservation comme payée
            $reservation->status = 'payé';
            $reservation->save();

            return redirect()->route('historique')->with('success', 'Paiement effectué avec succès !');
        }

        return redirect()->route('historique')->with('error', 'Paiement échoué ou annulé.');
    }
}
