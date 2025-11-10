<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Reservation;
use Illuminate\Support\Str;

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

        // 1. Générer une référence unique
        $reservation->reference = 'RES-' . strtoupper(Str::random(10)) . '-' . time();
        $reservation->save();

        $amount = $reservation->total * 100; // Paystack = kobo

        // 2. Préparation des métadonnées pour Paystack
        // L'ID de la réservation est crucial pour le webhook
        $metadata = [
            'reservation_id' => $reservation->id,
            'custom_fields' => [
                [
                    'display_name' => "Réservation ID",
                    'variable_name' => "reservation_id",
                    'value' => $reservation->id
                ]
            ]
        ];

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
                'metadata' => $metadata, // <-- Ajout des métadonnées ici
            ]);
        } catch (\Exception $e) {
            Log::error("Erreur API Paystack lors de l'initialisation : " . $e->getMessage());
            return "❌ Erreur API Paystack : " . $e->getMessage();
        }

        $data = $response->json();

        if (!isset($data['status']) || $data['status'] !== true) {
            Log::error("Erreur Paystack - Échec de l'initialisation", $data);
            return "❌ Erreur Paystack : " . ($data['message'] ?? 'Réponse inattendue');
        }

        return redirect()->away($data['data']['authorization_url']);
    }

    // Callback après paiement
    public function callback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            // Log::warning('Callback Paystack: Référence manquante.', $request->all());
            return redirect()->route('historique')->with('error', 'Référence de paiement manquante. Le statut de paiement sera mis à jour par le webhook.');
        }

        // On laisse le webhook mettre à jour le statut, et le callback rassure l'utilisateur
        return redirect()->route('historique')->with('success', 'Paiement en cours de vérification. Le statut de votre réservation sera mis à jour sous peu.');
    }

    // Webhook Paystack
    public function webhook(Request $request)
    {
        // 1. Répondre immédiatement (le plus important)
        // La réponse HTTP 200 doit être envoyée rapidement, même si le traitement est différé.
        // Si vous utilisez une file d'attente (Jobs), vous retournerez 200 ici et dispatcherez le Job.

        $signature = $request->header('x-paystack-signature');
        $secret = config('services.paystack.secret');
        $payload = $request->getContent(); // Utiliser getContent() pour la vérification de signature

        // 2. Vérification de la signature (Sécurité)
        if (!$signature || $signature !== hash_hmac('sha512', $payload, $secret)) {
            Log::warning('Webhook Paystack : signature invalide', $request->all());
            return response()->json(['status' => 'error', 'message' => 'Signature invalide'], 401); // 401 Unauthorized
        }

        $data = json_decode($payload, true);
        Log::info('Webhook Paystack reçu (signature OK) :', $data);

        // 3. Traitement de l'événement charge.success
        if (isset($data['event']) && $data['event'] === 'charge.success') {

            // On récupère l'ID de réservation envoyé par la méthode index()
            $reservationId = $data['data']['metadata']['reservation_id'] ?? null;

            if ($reservationId) {
                $reservation = Reservation::find($reservationId);

                if ($reservation) {
                    // Vérifier si le paiement a été effectué avec succès et que le statut est différent
                    $status_paystack = $data['data']['status'] ?? 'non-défini';

                    if ($status_paystack === 'success' && $reservation->status !== 'payé') {
                        // Mettre à jour la DB
                        $reservation->status = 'payé';
                        $reservation->transaction_id = $data['data']['id']; // Optionnel : enregistrer l'ID Paystack
                        $reservation->save();

                        Log::info("Réservation ID {$reservation->id} mise à jour en PAYÉ via webhook. Référence: {$reservation->reference}");
                    } else {
                        Log::info("Webhook Paystack : Réservation ID {$reservation->id} déjà payée ou statut Paystack: {$status_paystack}.");
                    }
                } else {
                    Log::error("Webhook Paystack : Réservation introuvable avec l'ID $reservationId.");
                }
            } else {
                Log::error("Webhook Paystack : reservation_id manquant dans les métadonnées.");
            }
        }

        // 4. Toujours retourner 200 OK pour accuser réception
        return response()->json(['status' => 'success'], 200);
    }
}
