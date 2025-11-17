<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Residence;
use App\Models\Reservation;
use App\Models\InterruptionRequest;
use Illuminate\Support\Facades\Auth;

class SejourController extends Controller
{
    // Page client : formulaire pour interrompre son séjour
    public function interrompreForm($id)
    {
        $residence = Residence::findOrFail($id);
        $userId = Auth::id();

        // Vérifie si l'utilisateur a bien une réservation pour cette résidence
        $reservation = Reservation::where('residence_id', $residence->id)
            ->where('user_id', $userId)
            ->first();

        if (!$reservation) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas interrompre ce séjour.');
        }

        return view('pages.interrompre', compact('residence', 'reservation'));
    }

    // Client : envoyer la demande d'interruption
    public function demanderInterruption(Request $request, $id)
    {
        $residence = Residence::findOrFail($id);
        $user = $request->user();

        // Vérifie si l'utilisateur a bien une réservation pour cette résidence
        $reservation = Reservation::where('residence_id', $residence->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$reservation) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas interrompre ce séjour.');
        }

        InterruptionRequest::create([
            'user_id' => $user->id,
            'residence_id' => $residence->id,
            'status' => 'en_attente'
        ]);

        return back()->with('success', 'Votre demande a été envoyée à l’admin.');
    }

    // Admin : voir toutes les demandes en attente
    public function adminDemandes()
    {
        $demandes = InterruptionRequest::where('status', 'en_attente')
            ->with(['user', 'residence'])
            ->get();

        return view('admin.admin_interruptions', compact('demandes'));
    }

    // Admin : valider une demande
    public function validerDemande($id)
    {
        $demande = InterruptionRequest::findOrFail($id);
        $residence = $demande->residence;

        $residence->disponible = 1;
        $residence->date_disponible_apres = null;
        $residence->save();

        $demande->status = 'validee';
        $demande->save();

        return back()->with('success', 'Demande validée, résidence libérée.');
    }

    // Admin : rejeter une demande
    public function rejeterDemande($id)
    {
        $demande = InterruptionRequest::findOrFail($id);
        $demande->status = 'rejete';
        $demande->save();

        return back()->with('success', 'Demande rejetée.');
    }
}
