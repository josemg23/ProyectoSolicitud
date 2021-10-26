<?php

namespace App;

use App\HistorialContrato;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContratoSuministro extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'licitacion',
        'decreto_adjudicacion',
        'fecha_inicio',
        'fecha_termino',
        'monto',
        'fecha_inicio_periodo',
        'fecha_termino_periodo',
        'monto_disponible',
        'tipo_contrato_id',
        'solicitud_id',
        'proveedor_id',
        'cuenta_id',
    ];
    protected $appends = ['monto_actual', 'fecha_actual'];

    public function productos()
    {
        return $this->belongsToMany('App\Product', 'contrato_suministro_product');
    }
    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }
    public function historiales()
    {
        return $this->morphMany('App\HistorialCuenta', 'historial_cuentable');
    }
    public function historialesContrato()
    {
        return $this->morphMany('App\HistorialContrato', 'historial_contratable');
    }
    public function historial()
    {
        return $this->hasMany('App\HistorialContrato', 'contrato_suministro_id');
    }
    /**
     * Scope a query to only include
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetContrato($query)
    {
        return $query->select('id', 'nombre', 'tipo_contrato_id', 'proveedor_id')->get();
    }
    public function tipo()
    {
        return $this->belongsTo('App\TipoContrato', 'tipo_contrato_id');
    }
    public function cuenta()
    {
        return $this->belongsTo('App\Cuenta', 'cuenta_id');
    }
    public function solicitud()
    {
        return $this->belongsTo('App\Solicitud', 'solicitud_id');
    }
    public function getMontoActualAttribute()
    {
        $suma = Periodo::where('contrato_suministro_id', $this->id)->get()->last();
        return $suma->monto_actual;
    }
    public function getFechaActualAttribute()
    {
        $suma = Periodo::where('contrato_suministro_id', $this->id)->get()->last();
        return $suma->fecha_termino_periodo;
    }
    public function periodos()
    {
        return $this->hasMany('App\Periodo', 'contrato_suministro_id');
    }
}
