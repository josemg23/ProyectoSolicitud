<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Convenio extends Model
{
    use SoftDeletes;

    public function cuentas()
    {
        return $this->hasMany('App\Cuenta');
    }

    public function encargados()
    {
        return $this->belongsToMany('App\User', 'convenio_user', 'convenio_id', 'encargado_id');
    }
    public function solicitudconvenio()
    {
        return $this->hasMany('App\SolicitudConvenio');
    }
}
