<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleReceta extends Model
{
    public function receta()
    {
        return $this->belongsTo('App\Receta','receta_id');
    }
}
