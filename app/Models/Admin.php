<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    // Utiliser un guard spécifique si nécessaire
    protected $guard = 'admin';

    /**
     * Les champs assignables en masse
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Les champs cachés pour la sérialisation
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les champs à caster automatiquement
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
