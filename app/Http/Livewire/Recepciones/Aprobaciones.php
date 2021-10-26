<?php

namespace App\Http\Livewire\Recepciones;

use App\Recepcion;
use App\Traits\SortBy;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Aprobaciones extends Component
{
    use WithPagination, SortBy;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $queryString     = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];
    public $perPage      = 10;
    public $search       = '';
    public $orderBy      = 'recepcions.id';
    public $orderAsc     = true;
    public $rol          = '';
    public $aprobacion   = '';
    public $estado       = 'activo';
    public $editMode     = false;
    public $creatingMode = false;

    public function render()
    {
        $recepciones = Recepcion::join('orden_compras', 'recepcions.orden_compra_id', '=', 'orden_compras.id')
            ->join('solicituds', 'orden_compras.solicitud_id', '=', 'solicituds.id')
            ->join('users', 'solicituds.user_id', '=', 'users.id')
            ->whereIn('recepcions.estado', ['pendiente'])
            ->where(function ($query) {
                $query->where('users.nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.id', 'like', '%' . $this->search . '%')
                    ->orWhere('recepcions.num_documento', 'like', '%' . $this->search . '%')
                    ->orWhere('recepcions.monto_total', 'like', '%' . $this->search . '%')
                    ->orWhere('recepcions.documento', 'like', '%' . $this->search . '%');
            })
            ->where(function ($query) {
                if (getRoleName() == 'finanzas') {
                    $query->where('aprobacion', 'fiannzas');
                } elseif (getRoleName() == 'abastecimiento') {
                    $query->where('aprobacion', 'abastecimiento');
                }
            })
            ->select('recepcions.*', 'users.nombres as user_solicitante')
            ->with(['document', 'orden'])
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.recepciones.aprobaciones', compact('recepciones'));
    }
    public function aprobarRecepcion($id, $aprobacion)
    {
        if ($aprobacion == 'finanzas') {
            return  redirect()->route('recepciones.aprobaciones.finanzas.create', $id);
        } else {
            return redirect()->route('recepciones.aprobaciones.abastecimiento.create', $id);
        }
    }
}
