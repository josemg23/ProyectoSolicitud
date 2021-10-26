<?php

namespace App\Http\Livewire\Mantenimiento\Rechazado;

use App\Rechazo;
use App\Traits\SortBy;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class EstadosRechazados extends Component
{
    use WithPagination, SortBy;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarRechazo'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page',
    ];
    public $perPage        = 10;
    public $search         = '';
    public $orderBy        = 'id';
    public $orderAsc       = true;
    public $motivo_id        = '';
    public $estado         = 'activo';
    public $editMode       = false;
    public $creatingMode   = false;
    public $nombre, $slug;

    public function render()
    {
        $estados = Rechazo::where(function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%');
        })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.mantenimiento.rechazado.estados-rechazados', compact('estados'));
    }
    public function createMotivo()
    {
        $this->slug = Str::slug($this->nombre, '-');

        $this->validate([
            'nombre' => 'required',

        ], [
            'nombre.required'      => 'No has agregado el nombre del Motivo de Rechazo',
        ]);
        $m               = new Rechazo;
        $m->nombre       = $this->nombre;
        $m->slug       = $this->slug;
        $m->estado       = $this->estado == 'activo' ? 'activo' : 'inactivo';
        $m->save();
        $this->resetInput();
        $this->emit('success', ['mensaje' => 'Motivo de Rechazo Registrado Correctamente', 'modal' => '#createRechazo']);
    }
    public function resetInput()
    {
        $this->nombre      = null;
        $this->slug      = null;
        $this->estado      = "activo";
        $this->editMode  = false;
    }
    public function estadochange($id)
    {
        $estado = Rechazo::find($id);
        $estado->estado = $estado->estado == 'activo' ? 'inactivo' : 'activo';
        $estado->save();
        $this->emit('info', ['mensaje' => $estado->estado == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);
    }
    public function editMotivo($id)
    {
        $c                  = Rechazo::find($id);
        $this->motivo_id    = $id;
        $this->nombre       = $c->nombre;
        $this->estado       = $c->estado;
        $this->editMode     = true;
    }
    public function updateMotivo()
    {
        $this->slug = Str::slug($this->nombre, '-');

        $this->validate([
            'nombre' => 'required',
        ], [
            'nombre.required'      => 'No has agregado el nombre del motivo de rechazo',
        ]);

        $m     = Rechazo::find($this->motivo_id);
        $m->nombre         = $this->nombre;
        $m->slug         = $this->slug;
        $m->estado         = $this->estado;
        $m->save();
        $this->resetInput();
        $this->emit('info', ['mensaje' => 'Motivo de rechazo Actualizado Correctamente', 'modal' => '#createRechazo']);
    }
    public function eliminarMotivo($id)
    {
        $c = Rechazo::find($id);
        $c->delete();
        $this->emit('info', ['mensaje' => 'Motivo de Rechazo Eliminado Correctamente']);
    }
}
