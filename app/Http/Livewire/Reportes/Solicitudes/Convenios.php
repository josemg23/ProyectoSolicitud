<?php

namespace App\Http\Livewire\Reportes\Solicitudes;

use App\Convenio;
use App\Solicitud;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Exports\ReporteconvenioExport;
use Maatwebsite\Excel\Facades\Excel;

class Convenios extends Component
{  
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    protected $queryString     = [
        'search' => ['except' => ''],
        'page' ,
       
    ];


    public $perPage  = 10;
    public $search   ='';
    public $orderBy =  'solicituds.id';
    public $orderAsc = true;
    public $select_convenio ='';
    public $estado         = '';
    public $from           ;
    public $to             ;
    public $conveniosall  = [];
    





    public function mount(){
     
        $this->from = starMonth();
        $this->to   =  finalMes();
        
    }

    public function render()
    {    
        $this->conveniosall= Convenio::all(['id', 'nombre']);

        $solicitudes  = Solicitud::rightjoin('solicitud_convenios','solicitud_convenios.solicitud_id' ,'=', 'solicituds.id')
                                    ->leftjoin('proveedors', 'solicitud_convenios.proveedor_id', '=', 'proveedors.id')
                                    ->leftjoin('contrato_suministros', 'solicitud_convenios.contrato_id', '=', 'contrato_suministros.id')
                                    ->leftjoin('tipo_contratos', 'solicitud_convenios.tipo_contrato_id', '=', 'tipo_contratos.id')
                                    ->join('departamentos', 'solicituds.departamento_id', '=', 'departamentos.id')
                                    ->join('users', 'solicituds.user_id', '=', 'users.id')
                                  
                                    ->where('solicituds.tipo' ,'=' , 'convenios')
                                ->where(function($query){
                                    $query->where('solicituds.estado', 'like', '%'. $this->search . '%')
                                     ->orWhere('solicituds.adquisicion', 'like', '%' . $this->search . '%')
                                     ->orWhere('solicitud_convenios.tipo_c', 'like', '%'. $this->search . '%');
                                })
                                  
                                  ->where(function($query){
                                    if($this->estado !== ''){
                                     $query->where('solicituds.estado', $this->estado);
                                 }
                                })
                                ->whereBetween('fecha_creacion', [$this->from, $this->to])                          
                                ->select('solicituds.*','solicitud_convenios.tipo_c as tipo_c','departamentos.nombre as departamento',  'users.nombres as nombre','proveedors.nombre as proveedor','contrato_suministros.licitacion as licitacion','tipo_contratos.nombre as tipo_contrato')
                                ->where(function($query){
                                    if($this->select_convenio !== ''){
                                     $query->where( 'solicitud_convenios.convenio_id', $this->select_convenio);
                                 }
                                }) 
                                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                                 ->paginate($this->perPage);
        
             //dd($solicitudes);
        return view('livewire.reportes.solicitudes.convenios', compact('solicitudes'));
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



    public function GenerarExcelSolicitud()
    {
        $this->conveniosall= Convenio::all(['id', 'nombre']);

        $solicitudes  = Solicitud::rightjoin('solicitud_convenios','solicitud_convenios.solicitud_id' ,'=', 'solicituds.id')
                                    ->join('departamentos', 'solicituds.departamento_id', '=', 'departamentos.id')
                                    ->join('users', 'solicituds.user_id', '=', 'users.id')
                                    ->leftjoin('proveedors', 'solicitud_convenios.proveedor_id', '=', 'proveedors.id')
                                    ->leftjoin('contrato_suministros', 'solicitud_convenios.contrato_id', '=', 'contrato_suministros.id')
                                    ->leftjoin('tipo_contratos', 'solicitud_convenios.tipo_contrato_id', '=', 'tipo_contratos.id')
                                    ->where('solicituds.tipo' ,'=' , 'convenios')
                                ->where(function($query){
                                    $query->where('solicituds.estado', 'like', '%'. $this->search . '%')
                                     ->orWhere('solicituds.adquisicion', 'like', '%' . $this->search . '%')
                                     ->orWhere('solicitud_convenios.tipo_c', 'like', '%'. $this->search . '%');
                                })
                                  
                                  ->where(function($query){
                                    if($this->estado !== ''){
                                     $query->where('solicituds.estado', $this->estado);
                                 }
                                })
                                ->whereBetween('fecha_creacion', [$this->from, $this->to])                          
                                ->select('solicituds.*','solicitud_convenios.tipo_c as tipo_c','departamentos.nombre as departamento',  'users.nombres as nombre','proveedors.nombre as proveedor','contrato_suministros.licitacion as licitacion','tipo_contratos.nombre as tipo_contrato')
                                ->where(function($query){
                                    if($this->select_convenio !== ''){
                                     $query->where( 'solicitud_convenios.convenio_id', $this->select_convenio);
                                 }
                                }) 
                                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                             ->get();

        return Excel::download(new ReporteconvenioExport($solicitudes), 'solicitudes_'.now().'.xlsx');


    }


}
