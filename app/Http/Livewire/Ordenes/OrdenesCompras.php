<?php

namespace App\Http\Livewire\Ordenes;

use App\OrdenCompra;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class OrdenesCompras extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarOrden', 'cancelarOrden'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page' => ['except' => 1]
    ];
    public $perPage        = 10;
    public $search         = '';
    public $orderBy        = 'orden_compras.id';
    public $orderAsc       = true;
    public $rol            = '';
    public $estado         = 'activo';
    public $editMode       = false;
    public $creatingMode   = false;

    public function render()
    {
        $ordenes =  OrdenCompra::leftJoin('proveedors', 'orden_compras.proveedor_id', '=', 'proveedors.id')
            ->leftJoin('solicituds', 'orden_compras.solicitud_id', '=', 'solicituds.id')
            ->where(function ($query) {
                $query->where('orden_compras.codigo_proveedor', 'like', '%' . $this->search . '%')
                    ->orWhere('orden_compras.nom_proveedor', 'like', '%' . $this->search . '%')
                    ->orWhere('orden_compras.num_orden', 'like', '%' . $this->search . '%')
                    ->orWhere('orden_compras.tipo_compra', 'like', '%' . $this->search . '%')
                    ->orWhere('proveedors.nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.adquisicion', 'like', '%' . $this->search . '%')
                    ->orWhere('solicituds.descripcion', 'like', '%' . $this->search . '%')
                    ->orWhere('orden_compras.valor_total', 'like', '%' . $this->search . '%');
            })
            ->select('orden_compras.*', 'solicituds.adquisicion', 'solicituds.descripcion', 'proveedors.nombre as proveedo')

            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->withTrashed()
            ->paginate($this->perPage);
        return view('livewire.ordenes.ordenes-compras', compact('ordenes'));
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
    public function cancelarOrden(OrdenCompra $ordenCompra)
    {
        if ($ordenCompra->tipo_compra == 'licitacion') {
            $multiple = $ordenCompra->solicitud->monto_adj->multiple;
            if ($multiple) {
                $this->emit('error', ['mensaje' => 'No puedes cancelar este proceso, porque es una licitación con varias ordenes']);
            } else {
                $ordenCompra->recepcion = 'cancelada';
                $ordenCompra->save();
                $ordenCompra->solicitud->estado = 'cancelada';
                $ordenCompra->solicitud->save();
            }
        } else {
            $ordenCompra->recepcion = 'cancelada';
            $ordenCompra->save();
            $ordenCompra->solicitud->estado = 'cancelada';
            $ordenCompra->solicitud->save();
        }
    }
    public function eliminarOrden(OrdenCompra $ordenCompra)
    {
        if ($ordenCompra->recepcion == 'pendiente') {
            $ordenCompra->recepcion = 'eliminada';
            // $ordenCompra->solicitud_id = null;
            $ordenCompra->save();
            $ordenCompra->delete();
        } else {
            $this->emit('error', ['mensaje' => 'Esta Orden de Compra ya fue recepcionada']);
        }
    }
}
