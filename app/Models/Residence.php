<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residence extends Model
{
    use HasFactory;

    protected $table = 'residences';

    protected $fillable = [
        'proprietaire_id', 
        'nom',
        'details',
        'nombre_chambres',
        'nombre_salons',
        'prix_journalier',
        'status',
        'disponible',
        'ville',
        'pays',
        'quartier',
        'adresse',
        'date_disponible_apres',
        'img',
        'geolocalisation',
        'type_residence',
        'details_position',
        'commodites',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'img' => 'array',
        'disponible' => 'boolean',
        'prix_journalier' => 'decimal:2',
        'date_disponible_apres' => 'datetime',
        'autres_details' => 'array',
        'details_position' => 'array',
    ];


    /**
     * Relation : une résidence appartient à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'proprietaire_id');
    }

    /**
     * Relation : une résidence peut avoir plusieurs réservations
     */
    public function reservation()
    {
        return $this->hasMany(Reservation::class, 'residence_id');
    }
    public function reservations()
    {
        // On lie la résidence aux réservations via le champ 'residence_id'
        return $this->hasMany(Reservation::class, 'residence_id');
    }

    public function dateDisponibleAvecNettoyage(int $joursNettoyage = 1)
    {
        // Si la résidence est libre dar disponible est un bouleen
        if ($this->disponible) {
            return now()->toDateString();
        }

        // Si la résidence est occupée, on prend la date de disponibilité + jours de nettoyage
        if ($this->date_disponible_apres) {
            return \Carbon\Carbon::parse($this->date_disponible_apres)
                ->addDays($joursNettoyage)
                ->toDateString();
        }

        // Fallback si pas de date enregistrée
        return now()->addDays($joursNettoyage)->toDateString();
    }
}
