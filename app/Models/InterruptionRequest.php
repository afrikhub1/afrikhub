<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterruptionRequest extends Model
{
    protected $fillable = ['user_id', 'residence_id', 'status', 'type_compte', 'reservation_id'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'nom' => 'Utilisateur inconnu'
        ]);
    }

    public function residence()
    {
        // C'est cette ligne qui corrige ton erreur dans la vue admin
        return $this->belongsTo(Residence::class)->withDefault([
            'nom' => 'Résidence supprimée'
        ]);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class)->withDefault([
            'reservation_code' => 'N/A'
        ]);
    }
}
