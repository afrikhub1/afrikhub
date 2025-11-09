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
        // 1) Vérifier la réservation
        if (!$reservation) {
            return "❌ ERREUR : Aucune réservation trouvée";
        }

        echo "✅ Étape 1 OK : Réservation trouvée (ID = {$reservation->id})<br>";

        // 2) Vérifier l'utilisateur
        if (!$reservation->user) {
            return "❌ ERREUR : Aucun utilisateur associé à la réservation";
        }

        echo "✅ Étape 2 OK : Utilisateur = {$reservation->user->name} ({$reservation->user->email})<br>";

        // 3) Vérifier le montant
        if (!$reservation->total || $reservation->total <= 0) {
            return "❌ ERREUR : Montant invalide";
        }

        echo "✅ Étape 3 OK : Montant = {$reservation->total}<br>";

        // 4) Générer une nouvelle référence unique (pour éviter l'erreur Paystack)
        $reservation->reference = 'RES-' . strtoupper(uniqid()) . '-' . time();
        $reservation->save();

        echo "✅ Étape 4 OK : Nouvelle référence = {$reservation->reference}<br>";

        // 5) Préparer montant (Paystack = montant * 100)
        $amount = $reservation->total * 100;

        echo "✅ Étape 5 OK : Montant Paystack = $amount<br>";

        // 6) Appel API Paystack
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
            return "❌ ERREUR API Paystack : " . $e->getMessage();
        }

        echo "✅ Étape 6 OK : Requête envoyée à Paystack<br>";

        // 7) Lire la réponse
        $data = $response->json();

        if (!isset($data['status']) || $data['status'] !== true) {

            echo "<br>❌ ERREUR PAYSTACK : " . ($data['message'] ?? "Réponse inattendue") . "<br>";
            echo "<pre>";
            print_r($data);
            echo "</pre>";
            dd("---- FIN : Paystack a renvoyé une erreur ----");
        }

        echo "✅ Étape 7 OK : Paystack a accepté la demande<br>";

        // 8) Rediriger vers Paystack
        echo "<br>✅ Étape 8 OK : Redirection vers Paystack...<br>";

        return redirect($data['data']['authorization_url']);
    }

    public function callback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect()->route('historique')->with('error', 'Référence de paiement manquante.');
        }

        // Juste récupérer la réservation pour info (optionnel)
        $reservation = Reservation::where('reference', $reference)->first();

        if (!$reservation) {
            return redirect()->route('historique')->with('error', 'Réservation introuvable.');
        }

        // Laisser le webhook mettre à jour le statut en 'payé'
        return redirect()->route('historique')->with('success', 'Paiement en cours de traitement. Le statut sera mis à jour automatiquement.');
    }

    public function webhook(Request $request)
    {
        // 1️⃣ Vérifier la signature pour s'assurer que c'est Paystack
        $signature = $request->header('x-paystack-signature');
        $secret = config('services.paystack.secret');

        if (!$signature || $signature !== hash_hmac('sha512', $request->getContent(), $secret)) {
            \Log::warning('Webhook Paystack : signature invalide', $request->all());
            return response()->json(['status' => 'error', 'message' => 'Signature invalide'], 400);
        }

        // 2️⃣ Récupérer le payload
        $payload = $request->all();
        \Log::info('Webhook Paystack reçu :', $payload);

        // 3️⃣ Vérifier le type d'événement
        if (isset($payload['event']) && $payload['event'] === 'charge.success') {
            $reference = $payload['data']['reference'];
            $reservationId = $payload['data']['metadata']['reservation_id'] ?? null;

            // 4️⃣ Mettre à jour la réservation si elle existe
            if ($reservationId) {
                $reservation = Reservation::find($reservationId);
                if ($reservation && $reservation->status !== 'payé') {
                    $reservation->status = 'payé';
                    $reservation->save();
                    \Log::info("Réservation ID {$reservation->id} mise à jour en PAYÉ via webhook.");
                }
            }
        }

        // 5️⃣ Réponse à Paystack
        return response()->json(['status' => 'success']);
    }
}
