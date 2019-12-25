<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    public function pago()
    {
        return $this->hasOne('App\Pago');
    }


}
