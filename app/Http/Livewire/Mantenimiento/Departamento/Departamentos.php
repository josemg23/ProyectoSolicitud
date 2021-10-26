<?php

namespace App\Http\Livewire\Mantenimiento\Departamento;

use Livewire\Component;
use App\Departamento;
use App\Dependencia;
use Livewire\WithPagination;

class Departamentos extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarDepartamento'];
    protected $queryString     =['search' => ['except' => ''],
    'page',
];


    public $perPage         = 10;
    public $search          = '';
    public $orderBy         = 'id';
    public $orderAsc        = true;
    public $departamento_id ='';
    public $estado          ='activo';
    public $dependencias          =[];

    public $editMode        = false;
    public $creatingMode    = false;
	public $filterDep       = '';

    public $nombre, $dependencia_id='';



    public function render()
    {
        $this->dependencias =Dependencia::where('estado', 'activo')->get(['id', 'nombre']);
        $data = Departamento::join('dependencias', 'dependencias.id', '=' , 'departamentos.dependencia_id')
                ->where(function($query){
                $query->where('departamentos.nombre', 'like', '%'.$this->search.'%');
                })
                ->where(fn($query)=>$this->filterDep ? $query->where('dependencias.nombre',$this->filterDep) : '')
                ->select('departamentos.*','dependencias.nombre as dependencia')
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage);
        return view('livewire.mantenimiento.departamento.departamentos', compact('data'));
    }

    public function resetInput ()
    {
        $this->nombre            = null;
        $this->estado            = "activo";
        $this->dependencia_id   = "";
        $this->editMode          = false;
    }


    public function crearDepartamento()
    {
        $this->validate([
            'nombre'   => 'required',
            'dependencia_id'         => 'required',

        ],[
            'nombre.required'   => 'No has agregado el nombre del Departamento',

        ]);
             $this->creatingMode = true;

        $d                     = new Departamento;
        $d->nombre             = $this->nombre;
        $d->estado             = $this->estado == 'activo' ? 'activo' : 'inactivo';
        $d->dependencia_id     = $this->dependencia_id;
        $d->save();
        $this->resetInput();
        $this->emit('success',['mensaje' => 'Departamento Registrado Correctamente', 'modal' => '#createDepartamento']);

        $this->creatingMode = false;

    }


    public function editDepartamento($id)
    {
        $c                  = Departamento::find($id);
        $this->departamento_id    = $id;
        $this->nombre            = $c->nombre;
        $this->estado            = $c->estado;
        $this->dependencia_id    = $c->dependencia_id;
        $this->editMode          = true;

    }

    public function updateDepartamento()
    {

        $this->validate([
            'nombre'                 => 'required',
            'dependencia_id'         => 'required',

        ],[
            'nombre.required'   => 'No has agregado el nombre del Departamento',

        ]);

        $a                    = Departamento::find($this->departamento_id);
        $a->nombre             = $this->nombre;
        $a->dependencia_id     = $this->dependencia_id;
		$a->estado             = $this->estado;
        $a->save();

        $this->resetInput();
        $this->emit('info',['mensaje' => 'Departamento Actualizado Correctamente', 'modal' => '#createDepartamento']);

    }

    public function eliminarDepartamento($id)
    {
        $d = Departamento::find($id);
        $d->delete();
        $this->emit('info',['mensaje' => 'Departamento Eliminada Correctamente']);
    }

    public function estadochange($id)
    {

        $estado = Departamento::find($id);
        $estado->estado = $estado->estado == 'activo' ? 'inactivo' : 'activo';
        $estado->save();

         $this->emit('info',['mensaje' => $estado->estado == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

    }





}
