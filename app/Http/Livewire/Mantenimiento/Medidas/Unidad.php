<?php

namespace App\Http\Livewire\Mantenimiento\Medidas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Medida;

class Unidad extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarUnidad'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page',
    ];


    public $perPage        = 10;
    public $search         = '';
    public $orderBy        = 'id';
    public $orderAsc       = true;

    public $medida_id        = '';
    public $estado         = 'activo';
    public $editMode       = false;
    public $creatingMode   = false;

    public $nombre;

    public function render()
    {
        $medidas = Medida::where(function ($query) {
            $query->where('medidas.nombre', 'like', '%' . $this->search . '%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.mantenimiento.medidas.unidad', compact('medidas'));
    }

    public function resetInput()
    {
        $this->nombre      = null;
        $this->estado      = "activo";
        $this->editMode  = false;
    }


    public function crearMedida()
    {
        $this->validate([
            'nombre' => 'required',

        ], [
            'nombre.required'      => 'No has agregado el nombre de la Unidad de Medida',
        ]);
        $this->creatingMode = true;

        $m               = new Medida;
        $m->nombre       = $this->nombre;
        $m->estado       = $this->estado == 'activo' ? 'activo' : 'inactivo';
        $m->save();
        $this->resetInput();
        $this->emit('success', ['mensaje' => 'Unidad de Medida Registrado Correctamente', 'modal' => '#createMedida']);

        $this->creatingMode = false;
    }



    public function editMedida($id)
    {
        $c                  = Medida::find($id);
        $this->medida_id    = $id;
        $this->nombre       = $c->nombre;
        $this->estado       = $c->estado;
        $this->editMode     = true;
    }

    public function updateMedida()
    {

        $this->validate([
            'nombre' => 'required',
        ], [
            'nombre.required'      => 'No has agregado el nombre de la Unidad de Medida',
        ]);

        $m     = Medida::find($this->medida_id);
        $m->nombre         = $this->nombre;
        $m->estado         = $this->estado;
        $m->save();
        $this->resetInput();
        $this->emit('info', ['mensaje' => 'Unidad de Medida Actualizado Correctamente', 'modal' => '#createMedida']);
    }



    public function eliminarMedida($id)
    {
        $c = Medida::find($id);
        $c->delete();
        $this->emit('info', ['mensaje' => 'Unidad de Medida Eliminado Correctamente']);
    }

    public function estadochange($id)
    {

        $estado = Medida::find($id);
        $estado->estado = $estado->estado == 'activo' ? 'inactivo' : 'activo';
        $estado->save();
        $this->emit('info', ['mensaje' => $estado->estado == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);
    }
}
