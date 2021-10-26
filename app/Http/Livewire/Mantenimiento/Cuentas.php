<?php

namespace App\Http\Livewire\Mantenimiento;

use App\Cuenta;
use Livewire\Component;
use App\HistorialCuenta;
use Livewire\WithPagination;

class Cuentas extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarCuenta'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page',
    ];
    public $perPage        = 10;
    public $search         = '';
    public $orderBy        = 'id';
    public $orderAsc       = true;

    public $cuenta_id        = '';
    public $estado         = 'activo';
    public $editMode       = false;
    public $creatingMode   = false;

    public $nombre, $descripcion, $saldo_i, $saldo_a;
    public function render()
    {
        //$cuentas = Cuenta::paginate(5);
        $cuentas = Cuenta::where(function ($query) {
            $query->where('cuentas.nombre', 'like', '%' . $this->search . '%')
                ->orWhere('cuentas.descripcion', 'like', '%' . $this->search . '%')
                ->orWhere('cuentas.saldo_a', 'like', '%' . $this->search . '%')
                ->orWhere('cuentas.saldo_i', 'like', '%' . $this->search . '%');
        })->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.mantenimiento.cuentas', compact('cuentas'));
    }


    public function resetInput()
    {
        $this->nombre      = null;
        $this->descripcion = null;
        $this->saldo_i     = null;
        $this->saldo_a     = null;
        $this->estado      = "activo";
        $this->editMode  = false;
        $this->resetValidation();
    }




    public function crearCuenta()
    {
        $this->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'saldo_i' => 'required|max:20',
            'saldo_a' => 'required|max:20',

        ], [
            'nombre.required'      => 'No has agregado el nombre de la cuenta',
            'descripcion.required' => 'No has agregado la descripción de la cuenta',
            'saldo_i.required'     => 'No has agregado el Saldo Inicial de la cuenta',
            'saldo_a.required'     => 'No has agregado el Saldo Actual de la cuenta',
        ]);
        $this->creatingMode = true;

        $c               = new Cuenta;
        $c->nombre       = $this->nombre;
        $c->descripcion  = $this->descripcion;
        $c->saldo_i      = $this->saldo_i;
        $c->saldo_a      = $this->saldo_a;
        $c->estado       = $this->estado == 'activo' ? 'activo' : 'inactivo';
        $c->save();

        $detalle = "Saldo Inicial Agregado";
        $historial    = new HistorialCuenta(['cuenta_id' => $c->id, 'detalle' => $detalle, 'cantidad' =>  $c->saldo_i, 'type' => 'ingreso']);
        $c->historiales()->save($historial);

        $this->resetInput();
        $this->emit('success', ['mensaje' => 'Cuenta Registrado Correctamente', 'modal' => '#createCuenta']);

        $this->creatingMode = false;
    }


    public function editCuenta($id)
    {
        $c                  = Cuenta::find($id);
        $this->cuenta_id    = $id;
        $this->nombre       = $c->nombre;
        $this->descripcion  = $c->descripcion;
        $this->saldo_i      = $c->saldo_i;
        $this->saldo_a      = $c->saldo_a;
        $this->estado       = $c->estado;
        $this->editMode     = true;
    }


    public function updateCuenta()
    {
        $this->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'saldo_i' => 'required|monto_cuenta:' . $this->cuenta_id,
            'saldo_a' => 'required',

        ], [
            'nombre.required'      => 'No has agregado el nombre de la cuenta',
            'descripcion.required' => 'No has agregado la descripción de la cuenta',
            'saldo_i.required'     => 'No has agregado el Saldo Inicial de la cuenta',
            'saldo_a.required'     => 'No has agregado el Saldo Actual de la cuenta',
        ]);


        $c                 = Cuenta::find($this->cuenta_id);
        $total =  $this->saldoActual($c->saldo_a, $c->saldo_i);
        $diferencia = $this->getDiferencia($c->saldo_a, $c->saldo_i);
        // dd($total);
        $c->nombre         = $this->nombre;
        $c->descripcion    = $this->descripcion;
        $c->saldo_i        = $this->saldo_i;
        $c->saldo_a        = $total;
        $c->estado         = $this->estado;
        $c->save();
        $this->resetInput();
        $this->storeHistorial($diferencia, $c);
        $this->emit('info', ['mensaje' => 'Cuenta Actualizado Correctamente', 'modal' => '#createCuenta']);
    }
    /**
     * Undocumented function
     *
     * @param int $total
     * @param Cuenta $cuenta
     * @return void
     */
    public function storeHistorial($total, Cuenta $cuenta)
    {

        $detalle = "Edicion del Saldo Inicia en la cuenta";
        $estado = $total < 0 ? 'egreso' : 'ingreso';
        $historial    = new HistorialCuenta(['cuenta_id' => $cuenta->id, 'detalle' => $detalle, 'cantidad' =>  abs($total), 'type' => $estado]);
        $cuenta->historiales()->save($historial);
    }
    public function saldoActual($saldo_a, $saldo_i)
    {
        $calculo = $this->saldo_i - $saldo_i;

        $diferencia = $saldo_a + $calculo;
        return $diferencia;
    }
    public function getDiferencia($saldo_a, $saldo_i)
    {
        $calculo = $this->saldo_i - $saldo_i;
        return $calculo;
    }

    public function eliminarCuenta($id)
    {
        $c = Cuenta::find($id);
        $c->delete();
        $this->emit('info', ['mensaje' => 'Cuenta Eliminado Correctamente']);
    }

    public function estadochange($id)
    {

        $estado = Cuenta::find($id);
        $estado->estado = $estado->estado == 'activo' ? 'inactivo' : 'activo';
        $estado->save();
        $this->emit('info', ['mensaje' => $estado->estado == 'activo' ? 'Estado Activado Correctamente' : 'Estado Desactivado Correctamente']);
    }
}
