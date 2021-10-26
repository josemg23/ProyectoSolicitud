<?php

namespace App\Http\Livewire\Mantenimiento\Criterios;

use App\Criterio;
use App\Traits\SortBy;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class CriteriosAdjudicacion extends Component
{
    use WithPagination, SortBy;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarCriterio'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page',
    ];
    public $perPage        = 10;
    public $search         = '';
    public $orderBy        = 'id';
    public $orderAsc       = true;
    public $criterio_id        = '';
    public $estado         = 'activo';
    public $editMode       = false;
    public $creatingMode   = false;
    public $nombre;

    public function render()
    {
        $criterios = Criterio::where(function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%');
        })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.mantenimiento.criterios.criterios-adjudicacion', compact('criterios'));
    }
    public function createCriterio()
    {

        $this->validate([
            'nombre' => 'required',

        ], [
            'nombre.required'      => 'No has agregado el nombre del criterio de adjudicación',
        ]);
        $m               = new Criterio;
        $m->nombre       = $this->nombre;
        $m->estado       = $this->estado == 'activo' ? 'activo' : 'inactivo';
        $m->save();
        $this->resetInput();
        $this->emit('success', ['mensaje' => 'Criterio de Adjudicación Registrado Correctamente', 'modal' => '#createCriterio']);
    }
    public function resetInput()
    {
        $this->nombre      = null;
        $this->estado      = "activo";
        $this->editMode  = false;
    }
    public function estadochange($id)
    {
        $criterio = Criterio::find($id);
        $criterio->estado = $criterio->estado == 'activo' ? 'inactivo' : 'activo';
        $criterio->save();
        $this->emit('info', ['mensaje' => $criterio->estado == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);
    }
    public function editCriterio($id)
    {
        $c                  = Criterio::find($id);
        $this->criterio_id    = $id;
        $this->nombre       = $c->nombre;
        $this->estado       = $c->estado;
        $this->editMode     = true;
    }
    public function updateCriterio()
    {
        $this->validate([
            'nombre' => 'required',
        ], [
            'nombre.required'      => 'No has agregado el nombre del criterio de adjudicación',
        ]);

        $m     = Criterio::find($this->criterio_id);
        $m->nombre         = $this->nombre;
        $m->estado         = $this->estado;
        $m->save();
        $this->resetInput();
        $this->emit('info', ['mensaje' => 'Criterio de Adjudicación Actualizado Correctamente', 'modal' => '#createCriterio']);
    }
    public function eliminarCriterio($id)
    {
        $c = Criterio::find($id);
        $c->delete();
        $this->emit('info', ['mensaje' => 'Criterio de Adjudicación Eliminado Correctamente']);
    }
}
