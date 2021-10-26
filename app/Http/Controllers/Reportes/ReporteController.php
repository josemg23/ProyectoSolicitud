<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReporteController extends Controller
{

    public function Reporte_solicitud(){

        return view('reportes.vista.reporte-solicitudes');
    }


    public function Reporte_solicitud_convenio(){

        return view('reportes.vista.reporte-solicitudes-convenio');
    }

    public function Reporte_solicitud_insumos(){

        return view('reportes.vista.reporte-solicitudes-insumos');
    }

    public function Reporte_solicitud_mantenimiento(){

        return view('reportes.vista.reporte-solicitudes-mantenimiento');
    }

    public function Reporte_solicitud_contrato_suministro(){

        return view('reportes.vista.reporte-solicitudes-contrato-suministro');
    }


}
