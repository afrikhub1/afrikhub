<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Residence;
use App\Models\Reservation;
use App\Models\InterruptionRequest;
use Illuminate\Support\Facades\Auth;

class SejourController extends Controller
{
    /**
     * Afficher le formulaire pour interrompre un séjour
     */
    public function interrompreForm($id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return redirect()->back()->with('error', 'Réservation introuvable.');
        }

        $residence = $reservation->residence; // Relation Eloquent Reservation -> Residence

        $userId = Auth::id();

        // Vérifie si la réservation appartient bien à l'utilisateur
        if ($reservation->user_id !== $userId) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas interrompre ce séjour.');
        }

        return view('pages.interrompre', compact('residence', 'reservation'));
    }


    /**
     * Envoyer la demande d'interruption
     */
    public function demanderInterruption(Request $request, $id)
    {
        $residence = Residence::find($id);
        if (!$residence) {
            return redirect()->back()->with('error', 'Résidence introuvable.');
        }

        $user = $request->user();

        // Vérifie que l'utilisateur a une réservation
        $reservation = Reservation::where('residence_id', $residence->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$reservation) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas interrompre ce séjour.');
        }

        try {
            InterruptionRequest::create([
                'user_id' => $user->id,
                'residence_id' => $residence->id,
                'status' => 'en attente'
            ]);

            return redirect()->back()->with('success', 'Votre demande a été envoyée à l’admin.');
        } catch (\Exception $e) {
            // Affiche l'erreur si quelque chose ne va pas
            return redirect()->back()->with('error', 'Erreur lors de l’envoi de la demande : ' . $e->getMessage());
        }
    }
}
