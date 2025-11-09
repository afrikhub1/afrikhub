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
        if (!$reservation) {
            return "❌ Réservation introuvable";
        }

        if (!$reservation->user) {
            return "❌ Aucun utilisateur associé à cette réservation";
        }

        if (!$reservation->total || $reservation->total <= 0) {
            return "❌ Montant invalide";
        }

        // Générer une référence unique
        $reservation->reference = 'RES-' . strtoupper(uniqid()) . '-' . time();
        $reservation->save();

        $amount = $reservation->total * 100; // Paystack = kobo

        // Appel API Paystack
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.paystack.secret'),
                'Content-Type' => 'application/json',
            ])->post('https://api.paystack.co/transaction/initialize', [
                'email' => $reservation->user->email,
                'amount' => $amount,
                'reference' => $reservation->reference,
                'callback_url' => route('paiement.callback'),
            ]);
        } catch (\Exception $e) {
            return "❌ Erreur API Paystack : " . $e->getMessage();
        }

        $data = $response->json();

        if (!isset($data['status']) || $data['status'] !== true) {
            return "❌ Erreur Paystack : " . ($data['message'] ?? 'Réponse inattendue');
        }

        return redirect()->away($data['data']['authorization_url']);
    }

    // Callback après paiement
    public function callback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect()->route('historique')->with('error', 'Référence de paiement manquante.');
        }

        $reservation = Reservation::where('reference', $reference)->first();

        if (!$reservation) {
            return redirect()->route('historique')->with('error', 'Réservation introuvable.');
        }

        // On laisse le webhook mettre à jour le statut
        return redirect()->route('historique')->with('success', 'Paiement en cours de traitement. Le statut sera mis à jour automatiquement.');
    }

    // Webhook Paystack
    public function webhook(Request $request)
    {
        $signature = $request->header('x-paystack-signature');
        $secret = config('services.paystack.secret');

        if (!$signature || $signature !== hash_hmac('sha512', $request->getContent(), $secret)) {
            Log::warning('Webhook Paystack : signature invalide', $request->all());
            return response()->json(['status' => 'error', 'message' => 'Signature invalide'], 400);
        }

        $payload = $request->all();
        Log::info('Webhook Paystack reçu :', $payload);

        if (isset($payload['event']) && $payload['event'] === 'charge.success') {
            $reference = $payload['data']['reference'];
            $reservationId = $payload['data']['metadata']['reservation_id'] ?? null;

            if ($reservationId) {
                $reservation = Reservation::find($reservationId);
                if ($reservation && $reservation->status !== 'payé') {
                    $reservation->status = 'payé';
                    $reservation->save();
                    Log::info("Réservation ID {$reservation->id} mise à jour en PAYÉ via webhook.");
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}
