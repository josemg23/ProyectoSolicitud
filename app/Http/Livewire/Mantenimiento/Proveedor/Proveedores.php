<?php

namespace App\Http\Livewire\Mantenimiento\Proveedor;

use App\Proveedor;
use App\TipoContrato;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\ProveedorTrait;

class Proveedores extends Component
{
    use WithPagination, ProveedorTrait;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarProveedor', 'storeProveedor', 'updateProveedor'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page'
    ];
    public $perPage      = 10;
    public $search       = '';
    public $orderBy      = 'id';
    public $orderAsc     = true;
    public $proveedor_id = '';
    public $tipo_contrato = '';
    public $encargados   = [];
    public $tipos   = [];
    public $editMode     = false;
    public $nombre, $rut, $giro, $direccion, $email, $tipos_contratos = [];
    public function render()
    {
        $this->tipos = TipoContrato::all(['id', 'nombre']);
        $proveedores = Proveedor::where(function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('rut', 'like', '%' . $this->search . '%')
                ->orWhere('giro', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%')
                ->orWhere('direccion', 'like', '%' . $this->search . '%');
        })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.mantenimiento.proveedor.proveedores', compact('proveedores'));
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
    public function resetModal()
    {
        $this->reset(['nombre', 'rut', 'giro', 'email', 'direccion', 'editMode', 'tipos_contratos']);
        $this->resetValidation();
        $this->emit('reset');
    }
    public function storeProveedor($tipos)
    {
        $this->tipos_contratos = $tipos;
        $this->validate([
            'rut'    => 'required|cl_rut|unique:proveedors,rut',
            'nombre' => 'required',
            // 'tipo_contrato' => 'required',
            'tipos_contratos' => 'array|min:1'

        ], [
            'rut.required'    => 'El RUT es requerido',
            'rut.unique'      => 'Este RUT ya se encuentra registrado',
            'nombre.required' => 'La Razon Social es requerida',
            'tipos_contratos.min' => 'Debes seleccionar al menos un Tipo de Contrato',

        ]);
        $proveedor            = new Proveedor;
        $proveedor->rut       = $this->rut;
        $proveedor->nombre    = $this->nombre;
        $proveedor->giro      = $this->giro;
        $proveedor->direccion = $this->direccion;
        $proveedor->email     = $this->email;
        // $proveedor->tipo_contrato_id     = $this->tipo_contrato;
        $proveedor->save();
        $proveedor->tiposcontratos()->sync($this->tipos_contratos);
        $this->resetModal();
        $this->emit('success', ['mensaje' => 'Proveedor Registrado Correctamente', 'modal' => '#crearProveedor']);
        $this->emit('reset');
    }
    public function editProveedor(Proveedor $proveedor)
    {

        $this->proveedor_id = $proveedor->id;
        $this->nombre    = $proveedor->nombre;
        $this->giro      = $proveedor->giro;
        $this->rut       = $proveedor->rut;
        $this->direccion = $proveedor->direccion;
        $this->email     = $proveedor->email;
        $this->tipos_contratos     = $proveedor->tiposcontratos->pluck('id');
        $this->editMode  = true;
        $this->emit('edit', ['tipos' => $this->tipos_contratos]);
    }
    public function updateProveedor($tipos)
    {
        $this->tipos_contratos = $tipos;

        $this->validate([
            'rut'    => 'required|cl_rut|unique:proveedors,rut,' . $this->proveedor_id,
            'nombre' => 'required',
            // 'tipo_contrato' => 'required'
            'tipos_contratos' => 'array|min:1'


        ], [
            'rut.required'    => 'El RUT es requerido',
            'rut.unique'      => 'Este RUT ya se encuentra registrado',
            'nombre.required' => 'La Razon Social es quererida',
            'tipos_contratos.min' => 'Debes seleccionar al menos un Tipo de Contrato',

        ]);

        $proveedor            = Proveedor::find($this->proveedor_id);
        $proveedor->rut       = $this->rut;
        $proveedor->nombre    = $this->nombre;
        $proveedor->giro      = $this->giro;
        $proveedor->direccion = $this->direccion;
        $proveedor->email     = $this->email;
        // $proveedor->tipo_contrato_id     = $this->tipo_contrato;

        $proveedor->save();
        $proveedor->tiposcontratos()->sync($this->tipos_contratos);
        $this->resetModal();

        $this->emit('info', ['mensaje' => 'Proveedor Actualizado Correctamente', 'modal' => '#crearProveedor']);
    }
    public function eliminarProveedor(Proveedor $proveedor)
    {
        $proveedor->delete();
    }
}
