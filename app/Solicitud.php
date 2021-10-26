<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Alexmg86\LaravelSubQuery\Traits\LaravelSubQueryTrait;

class Solicitud extends Model
{
    protected $tip;
    use SoftDeletes, LaravelSubQueryTrait;
    protected $appends = ['solicitud'];

    public function documento()
    {
        return $this->morphOne('App\Document', 'documentable');
    }
    public function logs_montos()
    {
        return $this->morphMany('Spatie\Activitylog\Models\Activity', 'subject')->where('log_name', 'cambiar-monto');
    }
    public function historiales()
    {
        return $this->morphMany('App\HistorialCuenta', 'historial_cuentable');
    }
    public function contrato()
    {
        return $this->hasOne('App\SolicitudContrato');
    }
    /**
     * Scope a query to only include
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindByTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }
    public function scopeFindByTipoIndex($query, $tipo)
    {
        $this->tip = $tipo;
        $rol = getRole();
        return $query->where('tipo', $tipo)
            ->whereNotIn('solicituds.estado', ['borrador', 'rechazada'])
            ->where(function ($query) {
                if ($this->tip == 'contrato-suministros') {
                    if (Auth::user()->hasRole('finanzas')) {
                        $query->doesntHave('aprobaciones');
                    } elseif (Auth::user()->hasRole('administracion-gestion')) {
                        $query
                            // ->has('aprobaciones', '=', 1)
                            ->whereHas('aprobaciones', function (Builder $quer) {
                                $quer->where('tipo', 'finanzas')->where('estado', 'aprobado');
                            }, 1)->whereDoesntHave('aprobaciones', function (Builder $q3) {
                                $q3->where('tipo', 'administracion-gestion');
                            });
                    } elseif (Auth::user()->hasRole('director')) {
                        $query
                            ->whereHas('aprobaciones', function (Builder $quer) {
                                $quer->where('tipo', 'administracion-gestion')->where('estado', 'aprobado');
                            }, 1)->whereDoesntHave('aprobaciones', function (Builder $q3) {
                                $q3->where('tipo', 'direccion');
                            });
                    } elseif (Auth::user()->hasRole('abastecimiento')) {
                        $query
                            ->whereHas('aprobaciones', function (Builder $quer) {
                                $quer->where('tipo', 'direccion')->where('estado', 'aprobado');
                            }, 1)->whereDoesntHave('aprobaciones', function (Builder $q3) {
                                $q3->where('tipo', 'abastecimiento');
                            });
                    } elseif (Auth::user()->hasRole('super-admin')) {
                    } else {
                        $query->where('estado', 'null');
                    }
                }
            })
            ->where(function ($query) {
                if ($this->tip == 'insumos') {
                    if (Auth::user()->hasRole('finanzas')) {
                        $query->doesntHave('aprobaciones');
                    } elseif (Auth::user()->hasRole('administracion-gestion')) {
                        $query
                            // ->has('aprobaciones', '=', 1)
                            ->whereHas('aprobaciones', function (Builder $quer) {
                                $quer->where('tipo', 'finanzas')->where('estado', 'aprobado');
                            }, 1)->whereDoesntHave('aprobaciones', function (Builder $q3) {
                                $q3->where('tipo', 'administracion-gestion');
                            });
                    } elseif (Auth::user()->hasRole('director')) {
                        $query
                            ->whereHas('aprobaciones', function (Builder $quer) {
                                $quer->where('tipo', 'administracion-gestion')->where('estado', 'aprobado');
                            }, 1)->whereDoesntHave('aprobaciones', function (Builder $q3) {
                                $q3->where('tipo', 'direccion');
                            });
                    } elseif (Auth::user()->hasRole('abastecimiento')) {
                        $query
                            ->whereHas('aprobaciones', function (Builder $quer) {
                                $quer->where('tipo', 'direccion')->where('estado', 'aprobado');
                            }, 1)->whereDoesntHave('aprobaciones', function (Builder $q3) {
                                $q3->where('tipo', 'abastecimiento');
                            });
                    } elseif (Auth::user()->hasRole('super-admin')) {
                    } else {
                        $query->where('estado', 'null');
                    }
                }
            })
            ->where(function ($query) {
                if ($this->tip == 'convenios') {
                    if (Auth::user()->hasRole('encargado-convenio')) {
                        $query->doesntHave('aprobaciones');
                    } elseif (Auth::user()->hasRole('finanzas')) {
                        $query
                            // ->has('aprobaciones', '=', 1)
                            ->whereHas('aprobaciones', function (Builder $quer) {
                                $quer->where('tipo', 'encargado-convenio')->where('estado', 'aprobado');
                            }, 1)->whereDoesntHave('aprobaciones', function (Builder $q3) {
                                $q3->where('tipo', 'finanzas');
                            });
                    } elseif (Auth::user()->hasRole('administracion-gestion')) {
                        $query
                            // ->has('aprobaciones', '=', 1)
                            ->whereHas('aprobaciones', function (Builder $quer) {
                                $quer->where('tipo', 'finanzas')->where('estado', 'aprobado');
                            }, 1)->whereDoesntHave('aprobaciones', function (Builder $q3) {
                                $q3->where('tipo', 'administracion-gestion');
                            });
                    } elseif (Auth::user()->hasRole('director')) {
                        $query
                            ->whereHas('aprobaciones', function (Builder $quer) {
                                $quer->where('tipo', 'administracion-gestion')->where('estado', 'aprobado');
                            }, 1)->whereDoesntHave('aprobaciones', function (Builder $q3) {
                                $q3->where('tipo', 'direccion');
                            });
                    } elseif (Auth::user()->hasRole('abastecimiento')) {
                        $query
                            ->whereHas('aprobaciones', function (Builder $quer) {
                                $quer->where('tipo', 'direccion')->where('estado', 'aprobado');
                            }, 1)->whereDoesntHave('aprobaciones', function (Builder $q3) {
                                $q3->where('tipo', 'abastecimiento');
                            });
                    } elseif (Auth::user()->hasRole('super-admin')) {
                    } else {
                        $query->where('estado', 'null');
                    }
                }
            })
            ->where(function ($query) {
                if ($this->tip == 'mantenimiento') {
                    if (Auth::user()->hasRole('encargado-mantenimiento')) {
                        $query->doesntHave('aprobaciones');
                    } elseif (Auth::user()->hasRole('finanzas')) {
                        $query
                            // ->has('aprobaciones', '=', 1)
                            ->whereHas('aprobaciones', function (Builder $quer) {
                                $quer->where('tipo', 'encargado-mantenimiento')->where('estado', 'aprobado');
                            }, 1)->whereDoesntHave('aprobaciones', function (Builder $q3) {
                                $q3->where('tipo', 'finanzas');
                            });
                    } elseif (Auth::user()->hasRole('administracion-gestion')) {
                        $query
                            // ->has('aprobaciones', '=', 1)
                            ->whereHas('aprobaciones', function (Builder $quer) {
                                $quer->where('tipo', 'finanzas')->where('estado', 'aprobado');
                            }, 1)->whereDoesntHave('aprobaciones', function (Builder $q3) {
                                $q3->where('tipo', 'administracion-gestion');
                            });
                    } elseif (Auth::user()->hasRole('director')) {
                        $query
                            ->whereHas('aprobaciones', function (Builder $quer) {
                                $quer->where('tipo', 'administracion-gestion')->where('estado', 'aprobado');
                            }, 1)->whereDoesntHave('aprobaciones', function (Builder $q3) {
                                $q3->where('tipo', 'direccion');
                            });
                    } elseif (Auth::user()->hasRole('abastecimiento')) {
                        $query
                            ->whereHas('aprobaciones', function (Builder $quer) {
                                $quer->where('tipo', 'direccion')->where('estado', 'aprobado');
                            }, 1)->whereDoesntHave('aprobaciones', function (Builder $q3) {
                                $q3->where('tipo', 'abastecimiento');
                            });
                    } elseif (Auth::user()->hasRole('super-admin')) {
                    } else {
                        $query->where('estado', 'null');
                    }
                }
            });
    }
    public function historialesContrato()
    {
        return $this->morphMany('App\HistorialContrato', 'historial_contratable');
    }
    /**
     * Scope a query to only include
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindByEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }
    public function scopeFindByEstados($query, array $estados)
    {
        return $query->whereIn('estado', $estados)
            ->whereHas('ordenes', function (Builder $q) {
                $q->whereIn('recepcion', ['pendiente', 'recepcionada-parcial']);
            });
    }
    public function dependencia()
    {
        return $this->belongsTo('App\Dependencia');
    }
    public function departamento()
    {
        return $this->belongsTo('App\Departamento');
    }
    public function solicitante()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function insumo()
    {
        return $this->hasOne('App\Insumos');
    }

    public function convenio()
    {
        return $this->hasOne('App\SolicitudConvenio');
    }

    public function mantenimiento()
    {
        return $this->hasOne('App\Smantenimiento');
    }
    public function aprobaciones()
    {
        return $this->hasMany('App\Aprobacion', 'solicitud_id');
    }
    public function recepciones()
    {
        return $this->hasManyThrough('App\Recepcion', 'App\OrdenCompra');
    }
    public function getSolicitudAttribute()
    {
        $tipo = ucwords(str_replace("-", " ", $this->tipo));
        $adquisicion = str_replace("\t", " ", $this->adquisicion);
        $formato = number_format($this->total, 2, ',', '.');
        return "{$tipo} N° {$this->id} - {$adquisicion} | Total: {$formato} CLP";
    }
    public function getRecepcionSumTotalAttribute()
    {
        $recepcion = collect($this->recepciones->where('estado', 'aprobada'))->sum('monto_total');

        return $recepcion;
    }
    public function getRecepcionAttribute()
    {
        $tipo = ucwords(str_replace("-", " ", $this->tipo));
        $formato = null;
        $orden = null;
        $proveedor = null;
        if (isset($this->orden)) {
            $formato = number_format($this->orden->valor_total, 2, ',', '.');
            $orden = $this->orden->num_orden;
            if ($this->orden->tipo_compra == 'compra-menor' || $this->orden->tipo_compra == 'moneda') {
                $proveedor =   $this->orden->proveedor->nombre;
            } else {
                $proveedor =   $this->orden->nom_proveedor;
            }
        }
        return "N° {$this->id} - {$this->solicitante->nombres} | Pro: {$proveedor}, N°: {$orden} | Total: {$formato}CLP";
    }
    public function ordenes()
    {
        return $this->hasMany('App\OrdenCompra');
    }
    public function decreto()
    {
        return $this->hasOne('App\Decreto');
    }
    public function monto_adj()
    {
        return $this->hasOne('App\MontoAdjudicacion');
    }
    public function criterios()
    {
        return $this->belongsToMany('App\Criterio', 'criterio_solicitud')->withPivot('porcentaje');
    }
}
