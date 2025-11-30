<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client',
        'reservation_code',
        'residence_id',
        'proprietaire_id',
        'date_arrivee',
        'date_depart',
        'date_validation',
        'personnes',
        'total',
        'status',
    ];

    protected $casts = [
        'date_arrivee' => 'datetime',
        'date_depart' => 'datetime',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function residence()
    {
        return $this->hasMany(Residence::class);
    }

}
