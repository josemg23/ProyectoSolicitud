<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insumos extends Model
{
    protected $fillable = [
        'solicitud_id',
        'productos',
        'tipo_in',
        'tipo_contrato_id',
        'proveedor_id',
        'contrato_id',
    ];
    public function products()
    {
        return $this->belongsToMany('App\Product', 'insumo_product', 'insumo_id', 'product_id')->withPivot('cantidad', 'neto');
    }
    public function contrato()
    {
        return $this->belongsTo('App\ContratoSuministro', 'contrato_id');
    }
    public function tipo_contrato()
    {
        return $this->belongsTo('App\TipoContrato', 'tipo_contrato_id');
    }
    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor', 'proveedor_id');
    }
}
