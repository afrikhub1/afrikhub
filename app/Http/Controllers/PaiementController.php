<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Reservation;

class PaiementController extends Controller
{
    // Affiche la page de paiement
    public function index(Reservation $reservation)
    {
        return view('paiement.index', compact('reservation'));
    }

    // Callback après paiement
    public function callback(Request $request)
    {
        $transactionId = $request->transaction_id ?? null;
        $reservationId = $request->reservation_id ?? null;

        if (!$transactionId || !$reservationId) {
            return response()->json(['status' => 'error', 'message' => 'Transaction ou réservation manquante']);
        }

        // Vérification via API Kkiapay
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.kkiapay.private')
        ])->get("https://api.kkiapay.me/v1/transactions/{$transactionId}");

        if ($response->failed()) {
            return response()->json(['status' => 'error', 'message' => 'Impossible de vérifier la transaction']);
        }

        $transaction = $response->json();
        $status = $transaction['status'] ?? 'UNKNOWN';

        // Enregistrer le paiement
        DB::table('paiements')->insert([
            'reservation_id' => $reservationId,
            'transaction_id' => $transactionId,
            'status' => $status,
            'payload' => json_encode($transaction),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Mettre à jour le statut de la réservation si paiement réussi
        if ($status === 'SUCCESS') {
            Reservation::where('id', $reservationId)->update([
                'status' => 'confirmée'
            ]);

            return response()->json(['status' => 'ok', 'message' => 'Paiement réussi']);
        }

        return response()->json(['status' => 'error', 'message' => 'Paiement échoué']);
    }
}
