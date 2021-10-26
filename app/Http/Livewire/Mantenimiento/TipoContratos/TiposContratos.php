<?php

namespace App\Http\Livewire\Mantenimiento\TipoContratos;

use App\TipoContrato;
use Livewire\Component;
use Livewire\WithPagination;

class TiposContratos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarTipo'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page'
    ];
    public $perPage     = 10;
    public $search      = '';
    public $filterPro      = '';
    public $orderBy     = 'id';
    public $orderAsc    = true;
    public $tipo_id   = '';
    public $editMode    = false;
    public $nombre, $descripcion, $estado = 'activo';
    public function render()
    {
        $tipos = TipoContrato::where(function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%');
        })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.mantenimiento.tipo-contratos.tipos-contratos', compact('tipos'));
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
    public function crearTipo()
    {
        $this->validate([
            'nombre'       => 'required',
        ], [
            'nombre.required'       => 'El Nombre es requerido',
        ]);
        $tipo               = new TipoContrato;
        $tipo->nombre       = $this->nombre;
        $tipo->descripcion        = $this->descripcion;
        $tipo->estado        = $this->estado;
        $tipo->save();
        $this->resetModal();
        $this->emit('success', ['mensaje' => 'Tipo de Contrato Registrado Correctamente', 'modal' => '#crearTipo']);
    }
    public function resetModal()
    {
        $this->reset(['nombre', 'descripcion', 'editMode', 'estado']);
        $this->resetValidation();
    }
    public function updateSearch()
    {
        $this->resetPage();
    }
    public function editTipo($id)
    {
        $c                 = TipoContrato::find($id);
        $this->tipo_id     = $id;
        $this->nombre      = $c->nombre;
        $this->descripcion = $c->descripcion;
        $this->estado      = $c->estado;
        $this->editMode    = true;
    }
    public function updateTipo(TipoContrato $tipoContrato)
    {
        $this->validate([
            'nombre' => 'required',
        ], [
            'nombre.required'       => 'El Nombre es requerido',
        ]);

        $tipo              = TipoContrato::find($this->tipo_id);
        $tipo->nombre      = $this->nombre;
        $tipo->descripcion = $this->descripcion;
        $tipo->estado      = $this->estado;
        $tipo->save();
        $this->resetModal();
        $this->emit('info', ['mensaje' => 'Tipo de Contrato Actualizado Correctamente', 'modal' => '#crearTipo']);
    }
    public function deleteTipo(TipoContrato $tipoContrato)
    {
    }
}
