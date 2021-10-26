<?php

namespace App\Http\Livewire\Mantenimiento\Convenio;

use App\User;
use App\Cuenta;
use App\Convenio;
use App\LogError;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Convenios extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners       = ['eliminarConvenio', 'crearConvenio', 'updateConvenio'];
    protected $queryString     = [
        'search' => ['except' => ''],
        'page'
    ];
    public $perPage     = 10;
    public $search      = '';
    public $orderBy     = 'convenios.id';
    public $orderAsc    = true;
    public $convenio_id = '';
    public $encargados = [], $ids = [], $cuentas = [], $seleccion = [], $encarg = [];
    public $editMode = false;
    public $nombre, $nota, $encargado_id = '', $presupuesto, $saldo, $cuenta_id = '';
    public function render()
    {
        $this->cuentas = Cuenta::where(function ($query) {
            if (count($this->ids) > 0 and $this->editMode) {
                $query->whereNotIn('id', $this->ids);
            } elseif (count($this->ids) > 0 and !$this->editMode) {
                $query->whereNotIn('id', $this->ids)
                    ->whereNull('convenio_id');
            } elseif (!$this->editMode) {
                $query->whereNull('convenio_id');
            }
        })->select('id', 'descripcion', 'saldo_i', 'saldo_a')->get();
        $this->encargados = User::where('id', '!=', 1)->role('encargado-convenio')->get(['id', 'nombres']);
        $convenios = Convenio::where(function ($query) {
            $query->where('convenios.nombre', 'like', '%' . $this->search . '%')
                ->orWhere('convenios.saldo', 'like', '%' . $this->search . '%')
                ->orWhere('convenios.presupuesto', 'like', '%' . $this->search . '%');
        })
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.mantenimiento.convenio.convenios', compact('convenios'));
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
    public function crearConvenio($encargados)
    {
        $this->encarg = $encargados;

        $this->validate([
            'nombre'       => 'required',
            'encarg' => 'array|min:1'
        ], [
            'nombre.required'       => 'El Nombre es requerido',
            'encarg.min' => 'Debes seleccionar al menos un Encargado',
        ]);
        DB::beginTransaction();
        try {
            $convenio              = new Convenio;
            $convenio->nombre      = $this->nombre;
            $convenio->nota        = $this->nota;
            $convenio->presupuesto = $this->presupuesto;
            $convenio->saldo       = $this->presupuesto;
            $convenio->save();
            $this->cargarCuentas($convenio->id);
            $convenio->encargados()->sync($this->encarg);

            $this->reset(['nombre', 'encargado_id', 'nota', 'presupuesto', 'saldo', 'cuenta_id', 'seleccion', 'ids']);
            $this->emit('success', ['mensaje' => 'Convenio Creado Correctamente', 'modal' => '#createConvenio']);
            $this->emit('reset');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $error = LogError::create(['payload' => 'Error al aprobar la solicitud de finanzas', 'exception' => $e->getMessage()]);
            $this->emit('error', ['mensaje' => 'Ocurrio un error al realizar el proceso, revisa el registro de errores']);
        }
    }
    public function cargarCuentas(int $id)
    {
        foreach ($this->ids as $i) {
            $cuenta = Cuenta::find($i);
            $cuenta->convenio_id = $id;
            $cuenta->save();
        }
    }
    public function agregarCuenta()
    {
        $this->validate([
            'cuenta_id'       => 'required',

        ], [
            'cuenta_id.required'       => 'No has seleccionado la cuenta',

        ]);
        $cuentas = collect($this->cuentas);
        $cuenta = $cuentas->first(
            fn ($value) =>  $value->id == $this->cuenta_id
        );
        $this->seleccion[] = array(
            'id' => $cuenta->id,
            'nombre' => $cuenta->nombre,
            'descripcion' => $cuenta->descripcion,
            'saldo_i' => $cuenta->saldo_i,
            'saldo_a' => $cuenta->saldo_a,
        );
        $this->ids[] =  intval($this->cuenta_id);
        $this->reset(['cuenta_id']);
        $this->calculoPre();
    }
    public function editConvenio(int $id)
    {
        $this->convenio_id = $id;
        $convenio = Convenio::with(['cuentas'])->find($id);
        $this->nombre      = $convenio->nombre;
        $this->encargado_id = $convenio->encargado_id;
        $this->nota        = $convenio->nota;
        $this->presupuesto = $convenio->presupuesto;
        $this->saldo       = $convenio->presupuesto;
        $this->encarg = $convenio->encargados->pluck('id');


        foreach ($convenio->cuentas as $key => $cuenta) {
            $this->seleccion[] = array(
                'id' => $cuenta->id,
                'nombre' => $cuenta->nombre,
                'descripcion' => $cuenta->descripcion,
                'saldo_i' => $cuenta->saldo_i,
                'saldo_a' => $cuenta->saldo_a,
            );
            $this->ids[] =  $cuenta->id;
            $this->calculoPre();
        }
        $this->editMode = true;
        $this->emit('edit', ['encargados' => $this->encarg]);
    }
    public function updateConvenio($encargados)
    {
        $this->encarg = $encargados;

        $this->validate([
            'nombre'       => 'required',
            'encarg' => 'array|min:1'
        ], [
            'nombre.required'       => 'El Nombre es requerido',
            'encarg.min' => 'Debes seleccionar al menos un Encargado',
        ]);
        DB::beginTransaction();
        try {
            $convenio               = Convenio::find($this->convenio_id);
            $convenio->nombre       = $this->nombre;
            $convenio->nota         = $this->nota;
            $convenio->presupuesto  = $this->presupuesto;
            $convenio->saldo        = $this->presupuesto;
            $convenio->save();
            $this->syncCuentas($convenio->id);
            $convenio->encargados()->sync($this->encarg);
            $this->reset(['nombre', 'encargado_id', 'nota', 'presupuesto', 'saldo', 'cuenta_id', 'seleccion', 'ids']);
            $this->emit('success', ['mensaje' => 'Convenio Creado Correctamente', 'modal' => '#createConvenio']);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $error = LogError::create(['payload' => 'Error al aprobar la solicitud de finanzas', 'exception' => $e->getMessage()]);
            $this->emit('error', ['mensaje' => 'Ocurrio un error al realizar el proceso, revisa el registro de errores']);
        }
    }
    public function syncCuentas($id)
    {
        $cuentas = Cuenta::where('convenio_id', $id)->update(['convenio_id' => null]);
        foreach ($this->ids as $i) {
            $cuenta = Cuenta::find($i);
            $cuenta->convenio_id = $id;
            $cuenta->save();
        }
    }
    public function eliminarCuenta($key, $id)
    {
        unset($this->seleccion[$key]);
        $identi = collect($this->ids);
        $this->ids =  $identi->filter(fn ($value) => $value !== $id);
        $this->calculoPre();
    }
    public function resetModal()
    {
        $this->reset(['nombre', 'nota', 'encargado_id', 'editMode', 'seleccion', 'ids', 'presupuesto', 'saldo']);
        $this->resetValidation();
        $this->emit('reset');
    }
    private function calculoPre()
    {

        $colleccion = collect($this->seleccion);
        $total = $colleccion->reduce(function ($inicio, $cuenta) {
            return $inicio + $cuenta['saldo_a'];
        }, 0);
        $this->presupuesto = $total;
    }
    public function eliminarConvenio(Convenio $convenio)
    {

        if (count($convenio->solicitudconvenio) >= 1) {
            $this->emit('error', ['mensaje' => 'No puedes Eliminar este convenio porque ya tiene solicitudes asignadas']);
        } else {
            $cuentas = Cuenta::where('convenio_id', $convenio->id)->update(['convenio_id' => null]);
            $convenio->delete();
            $this->emit('success', ['mensaje' => 'Convenio eliminado Correctamente']);
        }
    }
}
