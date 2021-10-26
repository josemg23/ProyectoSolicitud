<?php

namespace App\Http\Livewire\Reportes\Solicitudes;

use Livewire\Component;
use App\Solicitud;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Exports\ReportinsumoExport;
use Maatwebsite\Excel\Facades\Excel;

class ReporteInsumos extends Component
{
    use WithFileUploads;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString     = [
        'search' => ['except' => ''],
        'page' ,       
    ];

    public $perPage   = 10;
    public $search    ='';
    public $orderBy   =  'solicituds.id';
    public $orderAsc  = true;
    public $estado         = '';
    public $from           ;
    public $to             ;
    
    

    public function mount(){
     
        $this->from = starMonth();
        $this->to   =  finalMes();
        
    }

    public function render()
    {
        $solicitudes  = Solicitud::join('insumos','insumos.solicitud_id' ,'=', 'solicituds.id')
        ->leftjoin('proveedors', 'insumos.proveedor_id', '=', 'proveedors.id')
        ->leftjoin('contrato_suministros', 'insumos.contrato_id', '=', 'contrato_suministros.id')
        ->leftjoin('tipo_contratos', 'insumos.tipo_contrato_id', '=', 'tipo_contratos.id')
        ->join('departamentos', 'solicituds.departamento_id', '=', 'departamentos.id')
        ->join('dependencias','solicituds.dependencia_id','=','dependencias.id')
        ->join('users', 'solicituds.user_id', '=', 'users.id')
        ->where('solicituds.tipo', '=', 'insumos')
        ->where(function($query){
            $query->where('solicituds.estado', 'like', '%'. $this->search . '%')
            ->orWhere('solicituds.adquisicion', 'like', '%' . $this->search . '%')
            ->orWhere('insumos.tipo_in', 'like', '%'. $this->search . '%');
        
        })
        ->where(function($query){
            if($this->estado !== ''){
            $query->where('solicituds.estado', $this->estado);
        }
        })
        ->whereBetween('fecha_creacion', [$this->from, $this->to])
        ->select('solicituds.*', 'insumos.tipo_in as tipo_in', 'users.nombres as nombre', 'departamentos.nombre as departamento', 'dependencias.nombre as dependencia','proveedors.nombre as proveedor','contrato_suministros.licitacion as licitacion','tipo_contratos.nombre as tipo_contrato')

        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                        ->paginate($this->perPage);
               
        return view('livewire.reportes.solicitudes.reporte-insumos', compact('solicitudes'));
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

    public function GenerarExcelReporteInsumos()
    {
        $solicitudes  = Solicitud::join('insumos','insumos.solicitud_id' ,'=', 'solicituds.id')
        ->leftjoin('proveedors', 'insumos.proveedor_id', '=', 'proveedors.id')
        ->leftjoin('contrato_suministros', 'insumos.contrato_id', '=', 'contrato_suministros.id')
        ->leftjoin('tipo_contratos', 'insumos.tipo_contrato_id', '=', 'tipo_contratos.id')
        ->join('departamentos', 'solicituds.departamento_id', '=', 'departamentos.id')
        ->join('dependencias','solicituds.dependencia_id','=','dependencias.id')
        ->join('users', 'solicituds.user_id', '=', 'users.id')
        ->where('solicituds.tipo', '=', 'insumos')
        ->where(function($query){
            $query->where('solicituds.estado', 'like', '%'. $this->search . '%')
            ->orWhere('solicituds.adquisicion', 'like', '%' . $this->search . '%')
            ->orWhere('insumos.tipo_in', 'like', '%'. $this->search . '%');
        
        })
        ->where(function($query){
            if($this->estado !== ''){
            $query->where('solicituds.estado', $this->estado);
        }
        })
        ->whereBetween('fecha_creacion', [$this->from, $this->to])
        ->select('solicituds.*', 'insumos.tipo_in as tipo_in', 'users.nombres as nombre', 'departamentos.nombre as departamento', 'dependencias.nombre as dependencia','proveedors.nombre as proveedor','contrato_suministros.licitacion as licitacion','tipo_contratos.nombre as tipo_contrato')

        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->get();

        return Excel::download(new ReportinsumoExport($solicitudes), 'reporte-insumos_'.now().'.xlsx');


    }



}
