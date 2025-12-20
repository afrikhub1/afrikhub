<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carousels extends Model
{
    use HasFactory;

    // Autorise l'insertion de ces colonnes en base de données
    protected $fillable = [
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
