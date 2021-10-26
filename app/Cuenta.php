<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuenta extends Model
{
    use SoftDeletes;

    protected $appends = ['cuenta'];
    protected $fillable = [
        'nombre', 'descripcion', 'saldo_i', 'saldo_a', 'convenio_id'
    ];
    public function historial()
    {
        return $this->hasMany('App\HistorialCuenta', 'cuenta_id');
    }
    public function historiales()
    {
        return $this->morphMany('App\HistorialCuenta', 'historial_cuentable');
    }
    public function getCuentaAttribute()
    {
        $formato = number_format($this->saldo_a, 2, ',', '.');
        return "{$this->nombre} - {$this->descripcion} | Saldo: {$formato}";
    }
}
