<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Reservation;
use App\Models\Residence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Stevebauman\Location\Facades\Location;
use App\Models\ActivityLog;
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
                ->withErros(['date_arrivee' => 'Cette résidence n’est pas disponible à la date choisie.'])
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

        // Journalisation de l'activité
        $ip = request()->ip();
        $position = Location::get($ip);
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'reservation',
            'description' => 'Utilisateur a effectué une réservation.',
            'ip_address' => $ip,
            'pays'       => $position ? $position->countryName : null,
            'ville'      => $position ? $position->cityName : null,
            'latitude'   => $position ? $position->latitude : null,
            'longitude'  => $position ? $position->longitude : null,
            'code_pays'  => $position ? $position->countryCode : null,
            'user_agent' => request()->header('User-Agent'), // Navigateur et OS
        ]);

        // Redirection vers l'historique des réservations avec message de succès
            $route = 'clients_historique';
        return redirect()->route($route)->with('success', 'Réservation confirmée avec succès ! Votre demande est actuellement en attente de confirmation.');

    }

    // annuler une réservation
    public function annuler($id)
    {
        // Journalisation de l'activité
        $ip = request()->ip();
        $position = Location::get($ip);
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'reservation',
            'description' => 'Utilisateur a annulé une réservation.',
            'ip_address' => $ip,
            'pays'       => $position ? $position->countryName : null,
            'ville'      => $position ? $position->cityName : null,
            'latitude'   => $position ? $position->latitude : null,
            'longitude'  => $position ? $position->longitude : null,
            'code_pays'  => $position ? $position->countryCode : null,
            'user_agent' => request()->header('User-Agent'), // Navigateur et OS
        ]);

        // Annulation de la réservation
        $reservation = Reservation::findOrFail($id);

        $reservation->status = 'annulée';
        $reservation->save();

        return redirect()->back()->with('error', 'Réservation annuléé.');
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
            ->where('status', 'en attente')
            ->with('residence')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reservations.mes_demandes', compact('demandes'));
    }

    public function accepter($id)
    {
        // Journalisation de l'activité
        $ip = request()->ip();
        $position = Location::get($ip);
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'réservation',
            'description' => 'Utilisateur a accepté une réservation.',
            'ip_address' => $ip,
            'pays'       => $position ? $position->countryName : null,
            'ville'      => $position ? $position->cityName : null,
            'latitude'   => $position ? $position->latitude : null,
            'longitude'  => $position ? $position->longitude : null,
            'code_pays'  => $position ? $position->countryCode : null,
            'user_agent' => request()->header('User-Agent'), // Navigateur et OS
        ]);

        // accepter une réservation
        $reservation = Reservation::findOrFail($id);
        $residence = $reservation->residence;

        $reservationArrivee = \Carbon\Carbon::parse($reservation->date_arrivee);
        $reservationDepart  = \Carbon\Carbon::parse($reservation->date_depart);

        // Date à partir de laquelle la résidence sera libre
        $dateDisponible = $residence->dateDisponibleAvecNettoyage();

        // Vérifie si la nouvelle réservation chevauche la période occupée
        if ($reservationArrivee->lt($dateDisponible)) {
            return back()->with('error', 'Impossible de confirmer : la résidence n’est pas disponible à ces dates.');
        }

        $reservation->status = 'confirmée';
        $reservation->date_validation = now();
        $reservation->save();

        $residence->disponible = 0;
        $residence->date_disponible_apres = $reservationDepart;
        $residence->save();

        return back()->with('success', 'Réservation confirmée avec succès !');
    }


    public function refuser($id)
    {

        // Journalisation de l'activité
        $ip = request()->ip();
        $position = Location::get($ip);
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'réfu de reservation',
            'description' => 'Utilisateur à réfusé une reservation avec succès.',
            'ip_address' => $ip,
            'pays'       => $position ? $position->countryName : null,
            'ville'      => $position ? $position->cityName : null,
            'latitude'   => $position ? $position->latitude : null,
            'longitude'  => $position ? $position->longitude : null,
            'code_pays'  => $position ? $position->countryCode : null,
            'user_agent' => request()->header('User-Agent'), // Navigateur et OS
        ]);

        // annulation
        Reservation::where('id', $id)->update([
            'status' => 'refusée',
            'date_validation' => now(), // date et heure actuelles
        ]);

        return back()->with('success', 'Réservation refusée avec succès !');
    }

}
