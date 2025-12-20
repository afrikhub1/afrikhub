<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    use HasFactory;

    // Autorise l'insertion de ces colonnes en base de données
    protected $fillable = [
        'titre',
        'image',
        'lien',
        'ordre',
        'actif'
    ];

    // Force le cast de la colonne actif en booléen
    protected $casts = [
        'actif' => 'boolean',
    ];
}
