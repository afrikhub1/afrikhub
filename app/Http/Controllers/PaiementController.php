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
        \Log::info('---- Début Paiement ----');
        \Log::info('ID réservation : ' . $reservation->id);
        \Log::info('Email utilisateur : ' . $reservation->user->email);
        \Log::info('Montant total : ' . $reservation->total);

        $amount = $reservation->total * 100;

        // Forcer une référence unique
        if (!$reservation->reference) {
            $reservation->reference = 'RES-' . uniqid();
            $reservation->save();
            \Log::info('Nouvelle référence générée : ' . $reservation->reference);
        }

        // Appel à Paystack
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.paystack.secret'),
            'Content-Type' => 'application/json',
        ])->post(config('services.paystack.payment_url') . '/transaction/initialize', [
            'email' => $reservation->user->email,
            'amount' => $amount,
            'reference' => $reservation->reference,
            'callback_url' => route('paiement.callback'),
        ]);

        \Log::info('Réponse Paystack : ' . $response->body());

        // Vérification
        if (!$response->successful()) {
            \Log::error('Paystack API a échoué');
            return redirect()->back()->with('error', 'Erreur API Paystack.');
        }

        $body = $response->json();

        if (!isset($body['status']) || $body['status'] !== true) {
            \Log::error('Paystack renvoie un status FALSE');
            return redirect()->back()->with('error', 'Paiement non accepté par Paystack.');
        }

        // 🚨 LE POINT IMPORTANT ICI 🚨
        if (!isset($body['data']['authorization_url'])) {
            \Log::error('⚠️ authorization_url manquante !');
            return redirect()->back()->with('error', 'URL Paystack introuvable.');
        }

        \Log::info('✅ REDIRECTION => ' . $body['data']['authorization_url']);

        return redirect()->away($body['data']['authorization_url']);
    }
}
