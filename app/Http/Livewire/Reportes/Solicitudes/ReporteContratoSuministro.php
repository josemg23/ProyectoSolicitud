<?php

namespace App\Http\Livewire\Reportes\Solicitudes;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Exports\ReportecontratosuministroExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Solicitud;

class ReporteContratoSuministro extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    protected $queryString     =['search' => ['except' => ''],
    'page' => ['except' => 1]
    ];

    public $perPage        = 10;
    public $search         = '';
    public $orderBy        = 'solicituds.id';
    public $orderAsc       = true;
    public $estado         = '';
    public $from           ;
    public $to             ;

    public function mount(){
     
        $this->from = starMonth();
        $this->to   =  finalMes();
        
    }



    public function render()
    {

        $solicitudes  = Solicitud::join('solicitud_contratos','solicitud_contratos.solicitud_id' ,'=', 'solicituds.id')
        ->join('departamentos', 'solicituds.departamento_id', '=', 'departamentos.id')
        ->join('dependencias', 'solicituds.dependencia_id', '=', 'dependencias.id')
        ->join('users', 'solicituds.user_id', '=', 'users.id')
        ->where(function($query){
            $query->where('solicituds.estado', 'like', '%'. $this->search . '%')
            ->orWhere('solicituds.adquisicion', 'like', '%' . $this->search . '%')
            ->orWhere('solicituds.tipo', 'like', '%'. $this->search . '%');
           
        })
        ->where(function($query){
            if($this->estado !== ''){
             $query->where('solicituds.estado', $this->estado);
         }
        })
       ->whereBetween('fecha_creacion', [$this->from, $this->to])
        ->select('solicituds.*', 'users.nombres as nombre', 'departamentos.nombre as departamento','dependencias.nombre as dependencias')
      
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        
        return view('livewire.reportes.solicitudes.reporte-contrato-suministro', compact('solicitudes'));
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


   public function GenerarExcelContrato()
    {
        
        $solicitudes  = Solicitud::join('solicitud_contratos','solicitud_contratos.solicitud_id' ,'=', 'solicituds.id')
        ->join('departamentos', 'solicituds.departamento_id', '=', 'departamentos.id')
        ->join('dependencias', 'solicituds.dependencia_id', '=', 'dependencias.id')
        ->join('users', 'solicituds.user_id', '=', 'users.id')
        ->where(function($query){
            $query->where('solicituds.estado', 'like', '%'. $this->search . '%')
            ->orWhere('solicituds.adquisicion', 'like', '%' . $this->search . '%')
            ->orWhere('solicituds.tipo', 'like', '%'. $this->search . '%');
           
        })
        ->where(function($query){
            if($this->estado !== ''){
             $query->where('solicituds.estado', $this->estado);
         }
        })
       ->whereBetween('fecha_creacion', [$this->from, $this->to])
        ->select('solicituds.*', 'users.nombres as nombre', 'departamentos.nombre as departamento','dependencias.nombre as dependencias')
      
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->get();

        return Excel::download(new ReportecontratosuministroExport($solicitudes), 'reporte-contrato-suministros_'.now().'.xlsx');


    }



}
