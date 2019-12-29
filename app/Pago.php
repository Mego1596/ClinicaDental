<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    public function cita()
    {
        return $this->belongsTo('App\Cita','cita_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
