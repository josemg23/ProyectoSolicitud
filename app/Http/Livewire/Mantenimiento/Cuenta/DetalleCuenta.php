<?php

namespace App\Http\Livewire\Mantenimiento\Cuenta;

use App\Cuenta;
use Livewire\Component;

class DetalleCuenta extends Component
{
    public $cuenta_id;
    public $cuenta;
    public function mount($id)
    {
        $this->cuenta_id = $id;
    }
    public function render()
    {
        $this->cuenta = Cuenta::with('historial')->withcount('historial')->find($this->cuenta_id);
        // dd($this->cuenta);

        return view('livewire.mantenimiento.cuenta.detalle-cuenta');
    }
}
