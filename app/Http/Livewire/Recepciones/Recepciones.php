<?php

namespace App\Http\Livewire\Recepciones;

use App\Recepcion;
use App\Solicitud;
use App\Traits\SortBy;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Recepciones extends Component
{
    use WithPagination, SortBy;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarSolicitud'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];
    public $perPage        = 10;
    public $search         = '';
    public $orderBy        = 'solicituds.id';
    public $orderAsc       = true;
    public $rol            = '';
    public $estado         = 'activo';
    public $editMode       = false;
    public $creatingMode   = false;
    public function render()
    {
        // $solicitudes =  Solicitud::join('users', 'solicituds.user_id', '=', 'users.id')
        //     // ->join('orden_compras', 'solicituds.id', '=', 'orden_compras.solicitud_id')
        //     // ->leftJoin('proveedors', 'orden_compras.proveedor_id', '=', 'proveedors.id')
        //     ->whereIn('solicituds.estado', ['recepcionada', 'recepcion-parcial'])
        //     ->where(function ($query) {
        //         $query->where('users.nombres', 'like', '%' . $this->search . '%')
        //             ->orWhere('solicituds.id', 'like', '%' . $this->search . '%');
        //         // ->orWhere('orden_compras.valor_total', 'like', '%' . $this->search . '%')
        //         // ->orWhere('proveedors.nombre', 'like', '%' . $this->search . '%');
        //         // ->orWhere('orden_compras.num_orden', 'like', '%' . $this->search . '%')
        //         // ->orWhere('orden_compras.nom_proveedor', 'like', '%' . $this->search . '%');
        //     })
        //     ->select('solicituds.*', 'users.nombres as user_solicitante')
        //     ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        //     ->paginate($this->perPage);

        $solicitudes = Recepcion::join('orden_compras', 'recepcions.orden_compra_id', '=', 'orden_compras.id')
            ->leftJoin('proveedors', 'orden_compras.proveedor_id', '=', 'proveedors.id')
            ->join('solicituds', 'orden_compras.solicitud_id', '=', 'solicituds.id')
            ->join('users', 'solicituds.user_id', '=', 'users.id')
            ->whereNull('orden_compras.deleted_at')
            // ->whereIn('solicituds.estado', ['recepcionada', 'recepcion-parcial'])
            ->where(function ($query) {
                $query->where('users.nombres', 'like', '%' . $this->search . '%')
                    ->orWhere('recepcions.num_documento', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.id', 'like', '%' . $this->search . '%')
                    ->orWhere('orden_compras.valor_total', 'like', '%' . $this->search . '%')
                    ->orWhere('proveedors.nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('orden_compras.num_orden', 'like', '%' . $this->search . '%')
                    ->orWhere('orden_compras.nom_proveedor', 'like', '%' . $this->search . '%');
            })
            ->select('recepcions.*', 'users.nombres as user_solicitante', 'proveedors.nombre as user_proveedor')
            ->with(['orden.fileorden'])
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        // dd($solicitudes);
        return view('livewire.recepciones.recepciones', compact('solicitudes'));
    }
}
