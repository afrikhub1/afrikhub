<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
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

        // Vérification de la disponibilité par date
        $dateArrivee = Carbon::parse($request->date_arrivee);
        $dateDisponibleApres = $residence->date_disponible_apres ? Carbon::parse($residence->date_disponible_apres) : null;

        if ($dateDisponibleApres && $dateArrivee < $dateDisponibleApres) {
            return back()
                ->withErrors(['date_arrivee' => 'Cette résidence n’est pas disponible à la date choisie.'])
                ->withInput();
        }

        // Calcul du nombre de nuits
        $nbJours = (new \DateTime($request->date_arrivee))
            ->diff(new \DateTime($request->date_depart))
            ->days;

        // Calcul du total
        $total = $nbJours * $residence->prix_journalier;

        // Génération du code réservation unique
        do {
            $code = 'RES-' . strtoupper(Str::random(6));
        } while (Reservation::where('reservation_code', $code)->exists());

        // Création de la réservation
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'client' => Auth::user()->name,
            'reservation_code' => $code,
            'residence_id' => $residence->id,
            'proprietaire_id' => $residence->proprietaire_id,
            'date_arrivee' => $request->date_arrivee,
            'date_depart' => $request->date_depart,
            'date_validation' => null,
            'personnes' => $request->personnes,
            'total' => $total,
            'status' => 'en attente',
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
        $demandes = Reservation::where('proprietaire_id', Auth::id())
            ->with('residence')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reservations.mes_demandes', compact('demandes'));
    }

    public function accepter($id)
    {
        // Récupérer la réservation et la résidence
        $reservation = Reservation::findOrFail($id);
        $residence = $reservation->residence;

        // Vérifier si la résidence est libre
        if ($residence->disponible == 0) {
            return back()->with('danger', 'Impossible de confirmer : la résidence est actuellement occupée.');
        }

        // Confirmer la réservation
        Reservation::where('id', $id)->update([
            'status' => 'confirmée',
            'date_validation' => now(),
        ]);

        $dateDisponible = Carbon::parse($reservation->date_depart);


        Residence::where('id', $reservation->residence_id)->update([
            'disponible' => 0, // ou 1 si tu veux qu'elle reste disponible après ces 2 jours
            'date_disponible_apres' => $dateDisponible,
        ]);

        return back()->with('success', 'Réservation acceptée ✅, date de disponibilité mise à jour');

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
