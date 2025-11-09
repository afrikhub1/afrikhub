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
        // Générer une référence unique si elle n'existe pas
        if (!$reservation->reference) {
            $reservation->reference = 'RSV-' . strtoupper(uniqid());
            $reservation->save();
        }

        $amount = $reservation->total * 100; // montant en kobo

        // URL de callback complète avec https
        $callbackUrl = route('paiement.callback', ['reservation' => $reservation->id], true);

        Log::info("Paiement déclenché pour la réservation {$reservation->id}, callback: {$callbackUrl}");

        // Initialiser le paiement
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.paystack.secret')
        ])->post(config('services.paystack.payment_url') . '/transaction/initialize', [
            'email' => $reservation->user->email,
            'amount' => $amount,
            'reference' => $reservation->reference,
            'callback_url' => $callbackUrl,
        ]);

        $body = $response->json();
        Log::info('Réponse Paystack initialize : ', $body);

        if (isset($body['status']) && $body['status'] === true && isset($body['data']['authorization_url'])) {
            return redirect($body['data']['authorization_url']);
        }

        Log::error('Impossible d’initialiser le paiement.', ['reservation_id' => $reservation->id]);
        return redirect()->back()->with('error', 'Impossible d’initialiser le paiement.');
    }

    // Callback après paiement
    public function callback(Request $request)
    {
        $reference = $request->query('reference');
        Log::info("Callback reçu pour la référence : {$reference}");

        if (!$reference) {
            return redirect()->route('historique')->with('error', 'Référence de paiement manquante.');
        }

        $reservation = Reservation::where('reference', $reference)->first();
        if (!$reservation) {
            return redirect()->route('historique')->with('error', 'Réservation introuvable.');
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.paystack.secret')
        ])->get(config('services.paystack.payment_url') . "/transaction/verify/{$reference}");

        $body = $response->json();
        Log::info('Réponse Paystack verify : ', $body);

        if (isset($body['status']) && $body['status'] === true && $body['data']['status'] === 'success') {
            $reservation->status = 'payé';
            $reservation->save();

            return redirect()->route('historique')->with('success', 'Paiement effectué avec succès !');
        }

        return redirect()->route('historique')->with('error', 'Paiement échoué ou annulé.');
    }

    // Webhook Paystack
    public function webhook(Request $request)
    {
        $signature = $request->header('x-paystack-signature');
        if (!$signature) {
            return response()->json(['status' => 'error', 'message' => 'Signature manquante'], 400);
        }

        $payload = $request->all();
        Log::info('Webhook Paystack reçu : ', $payload);

        if (isset($payload['event']) && $payload['event'] === 'charge.success') {
            $reference = $payload['data']['reference'] ?? null;
            $reservationId = $payload['data']['metadata']['reservation_id'] ?? null;

            if ($reservationId) {
                $reservation = Reservation::find($reservationId);
                if ($reservation && $reservation->status != 'payé') {
                    $reservation->status = 'payé';
                    $reservation->save();
                    Log::info("Paiement confirmé via webhook pour réservation {$reservation->id}");
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
