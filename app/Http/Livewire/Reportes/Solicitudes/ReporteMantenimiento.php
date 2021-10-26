<?php

namespace App\Http\Livewire\Reportes\Solicitudes;

use Livewire\Component;
use App\Solicitud;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Exports\ReportemantenimientoExport;
use App\Proveedor;
use Maatwebsite\Excel\Facades\Excel;
class ReporteMantenimiento extends Component
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
    public $proveedorall  = [];
    public $select_pro ='';

    public function mount(){
     
        $this->from = starMonth();
        $this->to   =  finalMes();
        
    }

    public function render()
    {
                    $this->proveedorall= Proveedor::all(['id', 'nombre']);


                    $solicitudes  = Solicitud::rightjoin('smantenimientos','smantenimientos.solicitud_id' ,'=', 'solicituds.id')
                    ->leftjoin('proveedors', 'smantenimientos.proveedor_id', '=', 'proveedors.id')
                    ->join('departamentos', 'solicituds.departamento_id', '=', 'departamentos.id')
                    ->join('dependencias','solicituds.dependencia_id','=','dependencias.id')
                    ->join('users', 'solicituds.user_id', '=', 'users.id')
                    ->where('solicituds.tipo', '=', 'mantenimiento')
                
                ->where(function($query){
                    $query->where('solicituds.estado', 'like', '%'. $this->search . '%')
                    ->orWhere('solicituds.adquisicion', 'like', '%' . $this->search . '%');
                
                })
                
                ->where(function($query){
                    if($this->estado !== ''){
                    $query->where('solicituds.estado', $this->estado);
                }
                })
                ->whereBetween('fecha_creacion', [$this->from, $this->to])                          
                ->select('solicituds.*','departamentos.nombre as departamento',  'users.nombres as nombre','proveedors.nombre as proveedor', 'dependencias.nombre as dependencia')
                ->where(function($query){
                    if($this->select_pro !== ''){
                    $query->where( 'smantenimientos.proveedor_id', $this->select_pro);
                }
                }) 
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage);

         
        return view('livewire.reportes.solicitudes.reporte-mantenimiento', compact('solicitudes'));
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




    public function GenerarExcelReporteMantenimiento()
    {

        $this->proveedorall= Proveedor::all(['id', 'nombre']);


        $solicitudes  = Solicitud::rightjoin('smantenimientos','smantenimientos.solicitud_id' ,'=', 'solicituds.id')
        ->leftjoin('proveedors', 'smantenimientos.proveedor_id', '=', 'proveedors.id')
        ->join('departamentos', 'solicituds.departamento_id', '=', 'departamentos.id')
        ->join('dependencias','solicituds.dependencia_id','=','dependencias.id')
        ->join('users', 'solicituds.user_id', '=', 'users.id')
        ->where('solicituds.tipo', '=', 'mantenimiento')
    
    ->where(function($query){
        $query->where('solicituds.estado', 'like', '%'. $this->search . '%')
        ->orWhere('solicituds.adquisicion', 'like', '%' . $this->search . '%');
    
    })
    
    ->where(function($query){
        if($this->estado !== ''){
        $query->where('solicituds.estado', $this->estado);
    }
    })
    ->whereBetween('fecha_creacion', [$this->from, $this->to])                          
    ->select('solicituds.*','departamentos.nombre as departamento',  'users.nombres as nombre','proveedors.nombre as proveedor', 'dependencias.nombre as dependencia')
    ->where(function($query){
        if($this->select_pro !== ''){
        $query->where( 'smantenimientos.proveedor_id', $this->select_pro);
    }
    }) 
    ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
      
    ->get();

        return Excel::download(new ReportemantenimientoExport($solicitudes), 'reporte-mantenimiento_'.now().'.xlsx');


    }


}
