<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Reservation;
use Illuminate\Support\Str;

class PaiementController extends Controller
{
    // *** NOTE : Le constructeur pour l'exclusion CSRF est retiré ici.
    // L'exclusion se fait dans routes/web.php via withoutMiddleware(). ***

    /**
     * Déclenche le processus d'initialisation du paiement Paystack.
     * @param Reservation $reservation
     * @return \Illuminate\Http\RedirectResponse|string
     */
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

        $amount = $reservation->total * 100; // Paystack utilise Kobo

        // 2. Préparation des métadonnées pour Paystack (pour identifier la réservation dans le webhook)
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

        // Appel API Paystack pour initialisation
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.paystack.secret'),
                'Content-Type' => 'application/json',
            ])->post('https://api.paystack.co/transaction/initialize', [
                'email' => $reservation->user->email,
                'amount' => $amount,
                'reference' => $reservation->reference,
                'callback_url' => route('paiement.callback'),
                'metadata' => $metadata,
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

        // Rediriger l'utilisateur vers la page de paiement Paystack
        return redirect()->away($data['data']['authorization_url']);
    }

    /**
     * Gère le retour de l'utilisateur après le paiement.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect()->route('historique')->with('error', 'Référence de paiement manquante. Le statut de paiement sera mis à jour par le webhook.');
        }

        // Le callback rassure l'utilisateur en l'informant que la vérification est en cours.
        return redirect()->route('historique')->with('success', 'Paiement en cours de vérification. Le statut de votre réservation sera mis à jour sous peu.');
    }

    /**
     * Gère les notifications de paiement de serveur à serveur (Webhook).
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function webhook(Request $request)
    {
        // 1. Répondre immédiatement (le plus important pour Paystack)

        $signature = $request->header('x-paystack-signature');
        $secret = config('services.paystack.secret');
        $payload = $request->getContent(); // Corps brut pour la vérification de signature

        // 2. Vérification de la signature (Sécurité)
        if (!$signature || $signature !== hash_hmac('sha512', $payload, $secret)) {
            Log::warning('Webhook Paystack : signature invalide', $request->all());
            return response()->json(['status' => 'error', 'message' => 'Signature invalide'], 401); // 401 Unauthorized
        }

        $data = json_decode($payload, true);
        Log::info('Webhook Paystack reçu (signature OK) :', $data);

        // 3. Traitement de l'événement charge.success
        if (isset($data['event']) && $data['event'] === 'charge.success') {

            $reservationId = $data['data']['metadata']['reservation_id'] ?? null;

            if ($reservationId) {
                $reservation = Reservation::find($reservationId);

                if ($reservation) {
                    $status_paystack = $data['data']['status'] ?? 'non-défini';

                    if ($status_paystack === 'success' && $reservation->status !== 'payé') {
                        // Mettre à jour la DB
                        $reservation->status = 'payé';
                        $reservation->reference = $data['data']['id'];
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
