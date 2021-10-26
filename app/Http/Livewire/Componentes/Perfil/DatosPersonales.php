<?php

namespace App\Http\Livewire\Componentes\Perfil;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DatosPersonales extends Component
{
   public $user, $telefono, $celular, $domicilio, $nombres, $fono;
    public function render()
    {
		$this->user = Auth::user();
		$this->nombres   = $this->user->nombres;
		$this->telefono   = $this->user->telefono;
		$this->celular    = $this->user->celular;
        return view('livewire.componentes.perfil.datos-personales');
    }
     public function updateDate()
    {
		$user       = Auth::user();
		$user->fono = $this->fono;
		$user->save();

     $this->emit('info',['mensaje' => 'Datos Actualizados Correctamente']);

    }
}
