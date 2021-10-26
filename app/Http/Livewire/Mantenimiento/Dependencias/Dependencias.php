<?php

namespace App\Http\Livewire\Mantenimiento\Dependencias;

use Livewire\Component;
use Livewire\WithPagination;
use App\Dependencia;

class Dependencias extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarDependencia'];
    protected $queryString     =['search' => ['except' => ''],
    'page',
];

    public $perPage        = 10;
    public $search         = '';
    public $orderBy        = 'id';
    public $orderAsc       = true;

    public $dependencia_id        ='';
    public $estado         ='activo';
    public $editMode       = false;
    public $creatingMode   = false;

    public $nombre;


    public function render()
    {

        $d = Dependencia::where(function($query)
        {
           $query->where('dependencias.nombre', 'like','%'.$this->search.'%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        return view('livewire.mantenimiento.dependencias.dependencias', compact('d'));
    }

    public function resetInput ()
    {
        $this->nombre      = null;
        $this->estado      = "activo";
        $this->editMode  = false;
    }



    public function crearDependencia()
    {
        $this->validate([
            'nombre' =>'required',

        ],[
            'nombre.required'      => 'No has agregado el nombre de la Dependencia',
        ]);
        $this->creatingMode = true;

        $m               = new Dependencia;
        $m->nombre       =$this->nombre;
        $m->estado       = $this->estado == 'activo' ? 'activo' : 'inactivo';
        $m->save();
        $this->resetInput();
        $this->emit('success',['mensaje' => 'Dependencia Registrada Correctamente', 'modal' => '#createDependencia']);

        $this->creatingMode = false;
    }

    public function editDependencia ($id)
    {
        $c                  = Dependencia::find($id);
        $this->dependencia_id    = $id;
        $this->nombre       =$c->nombre;
        $this->estado       = $c->estado;
        $this->editMode     = true;
   }


   public function updateDependencia()
   {

    $this->validate([
        'nombre' =>'required',
    ],[
        'nombre.required'      => 'No has agregado el nombre de la Dependencia',
    ]);

    $m     = Dependencia::find($this->dependencia_id);
    $m->nombre         = $this->nombre;
    $m->estado         = $this->estado;
    $m->save();
    $this->resetInput();
    $this->emit('info',['mensaje' => 'Dependencia Actualizada Correctamente', 'modal' => '#createDependencia']);

   }
   public function estadochange($id)
   {

       $estado = Dependencia::find($id);
       $estado->estado = $estado->estado == 'activo' ? 'inactivo' : 'activo';
       $estado->save();

        $this->emit('info',['mensaje' => $estado->estado == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);

   }

   public function eliminarDependencia($id)
   {
       $c = Dependencia::find($id);
       $c->delete();
       $this->emit('info',['mensaje' => 'Dependencia Eliminada Correctamente']);
   }




}
