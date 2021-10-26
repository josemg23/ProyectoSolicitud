<?php

namespace App;

use App\SolicutMantenimiento;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $with = ['medida'];
    protected $table = 'products';

    public function medida()
    {
        return $this->belongsTo('App\Medida');
    }
    /**
     * Scope a query to only include
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetByProveedor($query, $id, $tipo_contrato_id)
    {
        return $query->where('proveedor_id', $id)->where('tipo_contrato_id', $tipo_contrato_id)->select('id', 'nombre', 'valor', 'detalle', 'medida_id');
    }
    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }


    public function scopeProveedores($query, $id)
    {
        return $query->where('proveedor_id', $id)->get();
    }

    public function solicitudmantenimientos()
    {
        return $this->belongsToMany('App\Smantenimiento', 'products_smantenimientos');
    }
}
