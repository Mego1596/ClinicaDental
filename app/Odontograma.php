<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Odontograma extends Model
{

    public function cita()
    {
        return $this->belongsTo('App\Cita','cita_id');
    }
}
