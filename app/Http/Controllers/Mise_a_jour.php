<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Residence;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Mise_a_jour extends Controller
{
    /**
     * Marque les réservations du jour comme terminées
     * et libère les résidences.
     */
    public function terminerReservationsDuJour()
    {
        $today = Carbon::today();

        // Récupérer les réservations dont la date de départ = aujourd'hui
        $reservations = Reservation::whereDate('date_depart', $today)
            ->where('status', 'confirmée') // uniquement celles en cours
            ->with('residence')
            ->get();

        foreach ($reservations as $reservation) {

            // 1) Marquer la réservation comme terminée
            $reservation->status = 'terminée';
            $reservation->save();

            // 2) Libérer la résidence si nécessaire
            $res = $reservation->residence;

            if ($res) {
                $res->disponible = 1;
                $res->date_disponible_apres = null; // libre immédiatement
                $res->save();
            }
        }

        return response()->json([
            'message' => 'Réservations du jour terminées et résidences libérées.',
            'total' => $reservations->count()
        ]);
    }
}
