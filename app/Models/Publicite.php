<?php

// app/Models/Publicite.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicite extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'icone',
        'lien',
        'actif',
        'ordre'
    ];
}
