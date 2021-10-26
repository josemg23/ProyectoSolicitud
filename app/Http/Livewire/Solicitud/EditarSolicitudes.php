<?php

namespace App\Http\Livewire\Solicitud;

use App\Solicitud;
use App\Traits\SolicitudTrait;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Database\Eloquent\Builder;

class EditarSolicitudes extends Component
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
    public $orderBy        = 'solicituds.id';
    public $orderAsc       = true;
    public $estado         = 'activo';
    public $editMode       = false;
    public $monto_actual, $monto_nuevo, $solicitud_id, $motivo;
    public function render()
    {
        $solicitudes =  Solicitud::join('dependencias', 'solicituds.dependencia_id', '=', 'dependencias.id')
            ->join('departamentos', 'solicituds.departamento_id', '=', 'departamentos.id')
            ->where(function ($query) {
                $query->where('solicituds.tipo', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.id', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.total', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.adquisicion', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.descripcion', 'like', '%' . $this->search . '%');
            })
            ->whereDoesntHave('aprobaciones', function (Builder $query) {
                $query->where('tipo', 'abastecimiento');
            })
            ->select('solicituds.*', 'dependencias.nombre as dependencia', 'departamentos.nombre as departamento')
            ->withCount('logs_montos')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.solicitud.editar-solicitudes', compact('solicitudes'));
    }
    public function editarMonto(Solicitud $solicitud)
    {
        $this->monto_actual = $solicitud->total;
        $this->solicitud_id = $solicitud->id;
    }
    public function resetModal()
    {
        $this->reset('monto_actual', 'monto_nuevo', 'solicitud_id', 'motivo');
        $this->resetValidation();
    }
    public function actualizarMonto()
    {
        $this->validate([
            'monto_nuevo' => 'required|numeric',
            'motivo' => 'required'
        ], [
            'monto_nuevo.required' => 'El monto nuevo es requerido',
            'motivo.required' => 'El motivo es requerido'
        ]);
        $solicitud = Solicitud::find($this->solicitud_id);
        $solicitud->total = $this->monto_nuevo;
        $solicitud->save();
        if (count($solicitud->aprobaciones->where('tipo', 'finanzas')) == 1) {
            $diferencia = $this->monto_actual > $this->monto_nuevo ? $this->monto_actual - $this->monto_nuevo :  $this->monto_nuevo - $this->monto_actual;
            $tipo = $this->monto_actual > $this->monto_nuevo ? 'ingreso' : 'egreso';
            $cuenta_id =  $this->getCuenta($solicitud->id);
            $this->setHistorial($solicitud, $cuenta_id, $tipo, $diferencia);
        }
        activity('cambiar-monto')
            ->performedOn($solicitud)
            ->log($this->motivo);
        $this->resetModal();
        $this->emit('success', ['mensaje' => 'Monto Actualizado Correctamente', 'modal' => '#modalEditar']);
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
