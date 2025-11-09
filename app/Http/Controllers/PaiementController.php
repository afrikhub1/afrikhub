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
}
