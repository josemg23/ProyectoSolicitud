<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recepcion extends Model
{
    public function solicitud()
    {
        return $this->belongsTo('App\Solicitud', 'solicitud_id');
    }
    public function historiales()
    {
        return $this->morphMany('App\HistorialCuenta', 'historial_cuentable');
    }
    /**
     * Scope a query to only include
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindByStatus($query, $estado)
    {
        return $query->where('estado', $estado);
    }
    /**
     * Scope a query to only include
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindByAprobacion($query, $role)
    {
        return $query->where('estado', $role);
    }
    public function document()
    {
        return $this->morphOne('App\Document', 'documentable');
    }
    public function anexo()
    {
        return $this->morphOne('App\Anexo', 'anexable');
    }
    public function orden()
    {
        return $this->belongsTo('App\OrdenCompra', 'orden_compra_id');
    }
    public function aprobante()
    {
        return $this->belongsTo('App\User', 'aprobacion_id');
    }
}
