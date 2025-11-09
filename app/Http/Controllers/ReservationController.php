<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Residence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function store(Request $request, $residenceId)
    {
        $request->validate([
            'date_arrivee' => 'required|date|after_or_equal:today',
            'date_depart' => 'required|date|after:date_arrivee',
            'personnes' => 'required|integer|min:1',
        ]);

        $residence = Residence::findOrFail($residenceId);

        // Calcul du nombre de nuits
        $nbJours = (new \DateTime($request->date_arrivee))->diff(new \DateTime($request->date_depart))->days;

        // Calcul du total
        $total = $nbJours * $residence->prix_journalier;
        do {
            $code = 'RES-' . strtoupper(Str::random(6)); // Ex : RES-A1B2C3
        } while (Reservation::where('reservation_code', $code)->exists());

        $date_validation = null;

        // Enregistrement de la réservation
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'client' =>  Auth::user()->name,
            'reservation_code' => $code,
            'residence_id' => $residence->id,
            'proprietaire_id' => $residence->proprietaire_id,
            'date_arrivee' => $request->date_arrivee,
            'date_depart' => $request->date_depart,
            'date_validation'=> $date_validation,
            'personnes' => $request->personnes,
            'total' => $total,
        ]);

        return redirect()->route('historique')->with('success', 'Réservation enregistrée avec succès !');
    }

    public function historique()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->with('residence')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reservations.historique', compact('reservations'));
    }

    // Paiement
    public function annuler($id)
    {
        $reservation = Reservation::findOrFail($id);
        // Ici tu peux intégrer un paiement avec Stripe, PayPal, etc.
        $reservation->status = 'annulée';
        $reservation->save();

        return redirect()->back()->with('danger', 'Réservation annuléé.');
    }

    public function rebook($id)
    {
        // Exemple simple : récupérer la réservation et la renvoyer à une vue
        $reservation = Reservation::findOrFail($id);

        // Ici tu peux préparer la logique de rebooking

        return view('reservations.rebook', compact('reservation'));
    }

    public function mesDemandes()
    {
        // Récupérer les réservations de l'utilisateur connecté
        $demandes = Reservation::where('proprietaire_id', Auth::id())->get();

        return view('reservations.mes_demandes', compact('demandes'));
    }

    public function accepter($id)
    {
        Reservation::where('id', $id)->update([
            'status' => 'confirmée',
            'date_validation' => now(), // date et heure actuelles
        ]);

        Residence::where('id', $id)->update([
            'disponible' => 0,
        ]);
        return back()->with('success', 'Réservation acceptée ✅');
    }

    public function refuser($id)
    {

        Reservation::where('id', $id)->update([
            'status' => 'refusée',
            'date_validation' => now(), // date et heure actuelles
        ]);

        return back()->with('success', 'Réservation refusée ❌');
    }

}
