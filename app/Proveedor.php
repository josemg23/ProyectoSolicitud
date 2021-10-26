<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use SoftDeletes;

    protected $appends = ['proveedor'];

    public function productos()
    {
        return $this->hasMany('App\Product');
    }
    /**
     * Scope a query to only include
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindByTipo($query, $id)
    {
        return $query->where('tipo_contrato_id', $id)->select('id', 'nombre', 'rut')->get();
    }
    public function tiposcontratos()
    {

        return $this->belongsToMany('App\TipoContrato', 'proveedor_tipo_contrato')->withTimestamps();
    }
    public function scopeGetByTipoContrato($query, $id)
    {
        return $query->where('tipo_contrato_id', $id)->get();
    }
    public function getProveedorAttribute()
    {
        return "{$this->nombre} - RUT: {$this->rut}";
    }
}
