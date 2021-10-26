<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorialContrato extends Model
{
    protected $fillable = [
        'contrato_suministro_id', 'cantidad', 'detalle', 'type', 'periodo_id'
    ];
    public function historial_contratable()
    {
        return $this->morphTo();
    }
}
