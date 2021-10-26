<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha_inicio_periodo',
        'fecha_termino_periodo',
        'monto_inicial',
        'monto_actual',
        'contrato_suministro_id',
    ];
    public function contrato()
    {
        return $this->belongsTo('App\ContratoSuministro', 'contrato_suministro_id');
    }
}
