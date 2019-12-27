<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Procedimiento extends Model
{
	public function citas()
    {
        return $this->belongsToMany('App\Cita');
    }
}
