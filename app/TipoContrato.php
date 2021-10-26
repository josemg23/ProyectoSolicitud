<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoContrato extends Model
{
    use SoftDeletes;

    public function proveedores()
    {
        return $this->belongsToMany('App\Proveedor', 'proveedor_tipo_contrato')->withTimestamps();
    }
    public function scopeGetProveedores($query)
    {
        return $query->with(['proveedores' => fn ($query) => $query->select('proveedors.id', 'proveedors.nombre')]);
    }
}
