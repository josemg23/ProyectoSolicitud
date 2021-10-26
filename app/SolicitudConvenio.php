<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudConvenio extends Model
{
    protected $fillable = [
        'solicitud_id',
        'productos',
        'convenio_id',
        'tipo_c',
        'tipo_contrato_id',
        'proveedor_id',
        'contrato_id',
    ];



    public function products()
    {
        return $this->belongsToMany('App\Product', 'solicitudconvenio_product', 'solicitud_convenios_id', 'product_id')->withPivot('cantidad', 'neto');
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
    public function convenio()
    {
        return $this->belongsTo('App\Convenio');
    }
}
