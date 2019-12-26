<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procedimiento extends Model
{
    public function cita(){
        return $this->hasOne('App\Cita');
    }
}
