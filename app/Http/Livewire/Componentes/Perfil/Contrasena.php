<?php

namespace App\Http\Livewire\Componentes\Perfil;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Contrasena extends Component
{
 	public $password, $password_confirmation;
    public function render()
    {

        return view('livewire.componentes.perfil.contrasena');
    }
     public function cambiarPassword()
    {
   	$this->validate([
			'password'              => 'required|min:8|max:15|confirmed',
			'password_confirmation' => 'required',

			
    ],[
			'password.required'              => 'La contraseña es requerida',
			'password_confirmation.required' => 'La contraseña es requerida',
			'password.confirmed'             => 'Las contraseñas no coinciden',
    ]);  

    $user = Auth::user();
    $user->password  = Hash::make($this->password); 
    $user->save();

	$this->password              = null;
	$this->password_confirmation = null;
     $this->emit('info',['mensaje' => 'Contrasena Actualizada Correctamente']);

    }
}
