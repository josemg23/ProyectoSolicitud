<?php

namespace App\Http\Livewire\Evaluaciones;

use App\Solicitud;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\Evaluacion\EvaluacionDireccionTrait;

class Evaluaciones extends Component
{
    use WithPagination, EvaluacionDireccionTrait;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarSolicitud'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];
    public $perPage        = 10;
    public $search         = '';
    public $orderAsc       = true;
    public $orderBy        = 'solicituds.id';
    public $rol            = '';
    public $tipo;
    public $selectioncompleta  = false;
    public $selecionados = [];
    public function mount($tipo = null)
    {
        $this->tipo = $tipo;
    }
    public function render()
    {
        $solicitudes =  Solicitud::join('dependencias', 'solicituds.dependencia_id', '=', 'dependencias.id')
            ->join('departamentos', 'solicituds.departamento_id', '=', 'departamentos.id')
            ->where('solicituds.tipo', $this->tipo)
            ->whereNotIn('solicituds.estado', ['borrador', 'rechazada'])
            ->where(function ($query) {
                if ($this->tipo == 'contrato-suministros') {
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
                    }
                }
            })
            ->where(function ($query) {
                if ($this->tipo == 'insumos') {
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
                    }
                }
            })
            ->where(function ($query) {
                if ($this->tipo == 'convenios') {
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
                    }
                }
            })
            ->where(function ($query) {
                if ($this->tipo == 'mantenimiento') {
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
                    }
                }
            })

            ->join('users', 'solicituds.user_id', '=', 'users.id')
            ->where(function ($query) {
                $query->where('solicituds.tipo', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.total', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.adquisicion', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.descripcion', 'like', '%' . $this->search . '%')
                    ->orWhere('users.nombres', 'like', '%' . $this->search . '%');
            })
            ->select('solicituds.*', 'dependencias.nombre as dependencia', 'departamentos.nombre as departamento', 'users.nombres as creador_solicitud')
            ->with('aprobaciones')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        //     ->get();
        // dd($solicitudes);
        return view('livewire.evaluaciones.evaluaciones', compact('solicitudes'));
    }
    public function sortBy($field)
    {
        if ($this->orderBy === $field) {
            $this->orderAsc = !$this->orderAsc;
        } else {
            $this->orderAsc = true;
        }
        $this->orderBy = $field;
    }
    public function aprobarSolicitud($tipo, $id)
    {

        if ($tipo == 'contrato-suministros') {
            return redirect()->route('evaluacion.contrato-suministro.aprobacion', $id);
        } elseif ($tipo == 'insumos') {
            return redirect()->route('evaluacion.insumo.aprobacion', $id);
        } elseif ($tipo == 'convenios') {
            return redirect()->route('evaluacion.convenios.aprobacion', $id);
        } elseif ($tipo == 'mantenimiento') {
            return redirect()->route('evaluacion.mantenimientos.aprobacion', $id);
        }
    }
    public function cambioSelectos()
    {
        if ($this->selectioncompleta) {
            $this->selectionAll();
        } else {
            $this->selecionados = [];
        }
    }
    public function selectionAll()
    {
        $solicitudes =  Solicitud::join('dependencias', 'solicituds.dependencia_id', '=', 'dependencias.id')
            ->join('departamentos', 'solicituds.departamento_id', '=', 'departamentos.id')
            ->where('solicituds.tipo', $this->tipo)
            ->where('solicituds.estado', '!=', 'borrador')
            ->where('solicituds.estado', '!=', 'rechazada')
            ->where(function ($query) {
                if ($this->tipo == 'contrato-suministros') {
                    if (Auth::user()->hasRole('administracion-gestion')) {
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
                    }
                }
            })
            ->where(function ($query) {
                if ($this->tipo == 'insumos') {
                    if (Auth::user()->hasRole('administracion-gestion')) {
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
                    }
                }
            })
            ->where(function ($query) {
                if ($this->tipo == 'convenios') {
                    if (Auth::user()->hasRole('administracion-gestion')) {
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
                    }
                }
            })
            ->where(function ($query) {
                if ($this->tipo == 'mantenimiento') {
                    if (Auth::user()->hasRole('administracion-gestion')) {
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
                    }
                }
            })
            ->join('users', 'solicituds.user_id', '=', 'users.id')
            ->where(function ($query) {
                $query->where('solicituds.tipo', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.total', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.adquisicion', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.descripcion', 'like', '%' . $this->search . '%')
                    ->orWhere('users.nombres', 'like', '%' . $this->search . '%');
            })
            ->select('solicituds.*', 'dependencias.nombre as dependencia', 'departamentos.nombre as departamento', 'users.nombres as creador_solicitud')
            ->with('aprobaciones')
            ->pluck('id');
        $this->selecionados = [];
        foreach ($solicitudes as $re) {
            $this->selecionados[] = "$re";
        }
    }
    public function aprobarSeleccion()
    {
        if (count($this->selecionados) == 0) {
            $this->emit('error', ['mensaje' => 'No has seleccionado ninguna solicitud']);
        } else {
            $this->aprobacionMasiva($this->selecionados);
            $this->reset(['selectioncompleta']);
        }
    }
}
