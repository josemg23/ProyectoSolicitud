<?php

namespace App\Http\Controllers\Solicitudes;

use App\Solicitud;
use Illuminate\Http\Request;
use App\Traits\Pdfs\PdfTrait;
use App\Http\Controllers\Controller;

class SolicitudController extends Controller
{
    use PdfTrait;

    public function solicitudes()
    {
        return view('solicitudes.missolicitudes');
    }
    public function borradores()
    {
        return view('solicitudes.borradores');
    }
    public function solicitudPdf(Solicitud $solicitud, $tipo)
    {
        if ($tipo == 'insumos') {
            $this->solicitudInsumo($solicitud);
        } else if ($tipo == 'convenios') {
            $this->solicitudCovenio($solicitud);
        } else if ($tipo == 'mantenimiento') {
            $this->solicitudMantenimiento($solicitud);
        }
    }
    public function edit()
    {
        return view('solicitudes.editar_solicitudes');
    }
    public function montosAdjudicacion()
    {
        return view('solicitudes.editar_monto_adjudicacion');
    }
}
