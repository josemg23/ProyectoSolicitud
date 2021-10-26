<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\Exportable;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UserExport implements FromView
{
	use Exportable;
    protected $usuarios;
    
    public function __construct($datos)
    {
        $this->usuarios = $datos;
    }
   

   public function view(): View
   {
             return view('reportes.admin.usuarios',[
                 'usuarios' => $this->usuarios
             ]);
   }
}
