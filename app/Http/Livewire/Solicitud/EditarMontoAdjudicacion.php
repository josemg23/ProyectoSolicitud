<?php

namespace App\Http\Livewire\Solicitud;

use App\MontoAdjudicacion;
use App\Solicitud;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Traits\SolicitudTrait;
use Illuminate\Database\Eloquent\Builder;

class EditarMontoAdjudicacion extends Component
{
    use SolicitudTrait;
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['editarSolicitud'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];
    public $perPage        = 10;
    public $search         = '';
    public $orderBy        = 'monto_adjudicacions.id';
    public $orderAsc       = true;
    public $estado         = 'activo';
    public $editMode       = false;
    public $monto_actual, $monto_nuevo, $monto_adj_id, $motivo;
    public function render()
    {
        $montos = MontoAdjudicacion::join('solicituds', 'monto_adjudicacions.solicitud_id', '=', 'solicituds.id')
            // ->where('solicituds.estado', 'completada-parcial')
            // ->whereHas('solicitud', function (Builder $query) {
            //     $query->where('estado', 'completada-parcial');
            // })
            ->select('monto_adjudicacions.*', 'solicituds.tipo as tipo_solicitud', 'solicituds.id as id_solicitud')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.solicitud.editar-monto-adjudicacion', compact('montos'));
    }
    public function editarMonto(MontoAdjudicacion $montoAdjudicacion)
    {
        $this->monto_actual = $montoAdjudicacion->monto;
        $this->monto_adj_id = $montoAdjudicacion->id;
    }
    public function resetModal()
    {
        $this->reset('monto_actual', 'monto_nuevo', 'monto_adj_id', 'motivo');
        $this->resetValidation();
    }
    public function actualizarMonto()
    {
        $this->validate([
            'monto_nuevo' => 'required|numeric',
            // 'motivo' => 'required'
        ], [
            'monto_nuevo.required' => 'El monto nuevo es requerido',
            // 'motivo.required' => 'El motivo es requerido'
        ]);
        if ($this->monto_nuevo <  $this->monto_actual) {
            return  $this->emit('error', ['mensaje' => 'El nuevo monto no puede ser menor al monto actual']);
        }
        $monto_adjudicacion = MontoAdjudicacion::find($this->monto_adj_id);
        $monto_adjudicacion->monto = $this->monto_nuevo;
        $monto_adjudicacion->save();
        $this->resetModal();
        $this->emit('success', ['mensaje' => 'Monto Actualizado Correctamente', 'modal' => '#modalAdjudicacion']);
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
}
