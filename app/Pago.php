<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    public function cita()
    {
        return $this->belongsTo('App\Cita','cita_id');
    }
}