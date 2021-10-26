<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aprobacion extends Model
{
    public function encargado()
    {
        return $this->belongsTo('App\User', 'encargado_id');
    }
    public function historiales()
    {
        return $this->morphMany('App\HistorialCuenta', 'historial_cuentable');
    }
    public function cuentas()
    {
        return $this->belongsToMany('App\Cuenta', 'aprobacion_cuenta');
    }
    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta', 'cuenta_id');
    }
    public function rechazo()
    {
        return $this->belongsTo('App\Rechazo', 'rechazo_id');
    }
}
