<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    public function cita()
    {
        return $this->belongsTo('App\Cita','cita_id');
    }

    public function detalle_receta()
    {
    	return $this->hasMany('App\DetalleReceta');
    }
}
