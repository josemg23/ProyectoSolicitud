<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialCuenta extends Model
{

    protected $fillable = [
        'cuenta_id', 'cantidad', 'detalle', 'type'
    ];
    public function historial_cuentable()
    {
        return $this->morphTo();
    }
}
