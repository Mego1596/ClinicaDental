<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
