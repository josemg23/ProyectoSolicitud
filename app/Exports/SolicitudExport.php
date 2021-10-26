<?php

namespace App\Exports;

use App\Solicitud;
use Maatwebsite\Excel\Concerns\Exportable;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SolicitudExport implements FromView
{
    use Exportable;
    protected $solicitudes;

    public function __construct($datos)
    {
        $this->solicitudes = $datos;
    }


    public function view(): View
   {
             return view('reportes.excel.reporte-solicitudes',[
                 'solicitudes' => $this->solicitudes
             ]);
   }

}
