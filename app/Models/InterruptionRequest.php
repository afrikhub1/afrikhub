<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterruptionRequest extends Model
{
    protected $fillable = ['user_id', 'residence_id', 'status','type_compte', 'reservation_id'];

    // relation entre les tables
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function residence()
    {
        return $this->belongsTo(Residence::class);
    }
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}

