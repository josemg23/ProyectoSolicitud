<?php

namespace App\Http\Livewire\Mantenimiento\Producto;

use App\Medida;
use App\Product;
use App\Proveedor;
use Livewire\Component;
use Livewire\WithPagination;

class Productos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarProducto', 'cargartipos', 'cargarProveedores'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page'
    ];
    public $perPage     = 10;
    public $search      = '';
    public $filterPro      = '';
    public $orderBy     = 'products.id';
    public $orderAsc    = true;
    public $unidad_id   = '';
    public $producto_id = '';
    public $proveedor_id = '';
    public $unidades    = [];
    public $proveedores = [];
    public $editMode    = false;
    public $nombre, $detalle, $valor, $tipo_contrato_id;
    public function render()
    {
        $this->unidades = Medida::where('estado', 'activo')->get(['id', 'nombre']);
        $this->proveedores = Proveedor::all(['id', 'nombre']);
        $productos = Product::join('proveedors', 'proveedors.id', '=', 'products.proveedor_id')
            ->join('medidas', 'products.medida_id', '=', 'medidas.id')
            ->join('tipo_contratos', 'products.tipo_contrato_id', '=', 'tipo_contratos.id')
            ->where(function ($query) {
                $query->where('products.nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('products.detalle', 'like', '%' . $this->search . '%')
                    ->orWhere('medidas.nombre', 'like', '%' . $this->search . '%')
                    ->orWhere('products.valor', 'like', '%' . $this->search . '%');
            })
            ->where(fn ($query) => $this->filterPro ? $query->where('proveedors.nombre', $this->filterPro) : '')
            ->select('products.*', 'proveedors.nombre as proveedor', 'medidas.nombre as unidad', 'tipo_contratos.nombre as tipo_contrato')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.mantenimiento.producto.productos', compact('productos'));
    }
    public function cargartipos(Proveedor $proveedor)
    {
        $this->proveedor_id = $proveedor->id;
        $tipos = $proveedor->tiposcontratos;
        // dd($tipos);
        // foreach ($tipos as $key => $value) {
        //     $conversion[] = array('id' => $value->id, 'text' => $value->nombre);
        // }
        // dd(collect($conversion));
        $this->emit('setTipo', ['tipos' => $tipos]);
    }
    public function cargarProveedores()
    {
        // dd($this->proveedores);
        $this->emit('setProveedores', ['proveedores' => $this->proveedores]);
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
    public function storeProducto()
    {
        $this->validate([
            'nombre'       => 'required',
            'valor'       => 'required|numeric',
            'proveedor_id' => 'required',
            'unidad_id'    => 'required',
            'tipo_contrato_id'    => 'required'
        ], [
            'nombre.required'       => 'El Nombre es requerido',
            'valor.required'       => 'El Valor es requerido',
            'proveedor_id.required' => 'No has seleccionado un Proveedor',
            'unidad_id.required'    => 'No has seleccionado una Unidad',
            'tipo_contrato_id.required'    => 'No has seleccionado un Tipo de Contrato',
        ]);
        $producto               = new Product;
        $producto->nombre       = $this->nombre;
        $producto->valor        = $this->valor;
        $producto->detalle      = $this->detalle;
        $producto->proveedor_id = $this->proveedor_id;
        $producto->medida_id    = $this->unidad_id;
        $producto->tipo_contrato_id    = $this->tipo_contrato_id;
        $producto->save();
        $this->resetModal();
        $this->emit('success', ['mensaje' => 'Producto Registrado Correctamente', 'modal' => '#crearProducto']);
    }
    public function resetModal()
    {
        $this->reset(['nombre', 'valor', 'detalle', 'proveedor_id', 'unidad_id', 'editMode', 'tipo_contrato_id']);
        $this->emit('reset');
        $this->resetValidation();
    }
    public function editProducto(Product $product)
    {
        $this->producto_id = $product->id;
        $this->nombre       = $product->nombre;
        $this->valor        = $product->valor;
        $this->detalle      = $product->detalle;
        $this->proveedor_id = $product->proveedor_id;
        $this->unidad_id    = $product->medida_id;
        $this->tipo_contrato_id    = $product->tipo_contrato_id;
        $this->editMode     = true;
        $this->cargartipos($product->proveedor);
        $this->emit('edit', ['proveedor_id' => $product->proveedor_id, 'tipo_contrato_id' => $product->tipo_contrato_id]);
    }
    public function updateProducto()
    {
        $this->validate([
            'nombre'       => 'required',
            'valor'       => 'required|numeric',
            'proveedor_id' => 'required',
            'unidad_id'    => 'required',
            'tipo_contrato_id'    => 'required'

        ], [
            'nombre.required'       => 'El Nombre es requerido',
            'valor.required'       => 'El Valor es requerido',
            'proveedor_id.required' => 'No has seleccionado un Proveedor',
            'unidad_id.required'    => 'No has seleccionado una Unidad',
            'tipo_contrato_id.required'    => 'No has seleccionado un Tipo de Contrato',

        ]);
        $producto               = Product::find($this->producto_id);
        $producto->nombre       = $this->nombre;
        $producto->valor        = $this->valor;
        $producto->detalle      = $this->detalle;
        $producto->proveedor_id = $this->proveedor_id;
        $producto->medida_id    = $this->unidad_id;
        $producto->tipo_contrato_id    = $this->tipo_contrato_id;
        $producto->save();
        $this->resetModal();
        $this->emit('info', ['mensaje' => 'Producto Actualizado Correctamente', 'modal' => '#crearProducto']);
    }
    public function eliminarProducto(Product $product)
    {
        $product->delete();
    }
}
