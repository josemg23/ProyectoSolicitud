<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdenCompra extends Model
{
    use LaravelSubQueryTrait, SoftDeletes;
    // protected $appends = ['recepcion_sum_total'];

    public function solicitud()
    {
        return $this->belongsTo('App\Solicitud');
    }
    public function encargado()
    {
        return $this->belongsTo('App\User', 'encargado_id');
    }
    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor', 'proveedor_id');
    }
    public function documento()
    {
        return $this->morphOne('App\Document', 'documentable');
    }
    public function fileorden()
    {
        return $this->morphOne('App\FileOrden', 'ordenable');
    }
    public function historiales()
    {
        return $this->morphMany('App\HistorialCuenta', 'historial_cuentable');
    }
    /**
     * Get all of the comments for the OrdenCompra
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recepciones()
    {
        return $this->hasMany('App\Recepcion');
    }
    public function getRecepcionSumTotalAttribute()
    {
        $recepcion = collect($this->recepciones->where('estado', 'aprobada'))->sum('monto_total');

        return $recepcion;
    }
}
