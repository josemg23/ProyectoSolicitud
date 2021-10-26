<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Decreto extends Model
{
    public function documento()
    {
        return $this->morphOne('App\Document', 'documentable');
    }
    public function solicitud()
    {
        return $this->belongsTo('App\Solicitud');
    }
    public function encargado()
    {
        return $this->belongsTo('App\User', 'encargado_id');
    }
}
