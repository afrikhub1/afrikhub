<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PaiementController extends Controller
{
    public function callback(Request $request)
    {
        $transactionId = $request->transaction_id ?? null;

        if (!$transactionId) {
            return response()->json(['status' => 'error', 'message' => 'Transaction ID manquant']);
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

        // Enregistrement dans la table de test
        DB::table('paiements_tests')->insert([
            'transaction_id' => $transactionId,
            'status' => $status,
            'payload' => json_encode($transaction),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => $status]);
    }
}
