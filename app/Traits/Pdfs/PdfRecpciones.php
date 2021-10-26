<?php

namespace App\Traits\Pdfs;

use App\Recepcion;
use App\Solicitud;
use Illuminate\Support\Str;
use App\Fpdf\PdfRecepcion as PDF;

trait PdfRecpciones
{
    public function generatePdf(Recepcion $recepcion)
    {
        $tipo = Str::ucfirst($recepcion->tipo);
        $fpdf = new PDF();
        $fpdf->AliasNbPages();
        $fpdf->SetTitle("Recepcion-{$recepcion->num_documento}.pdf");
        $fpdf->setTitulo($tipo);
        $fpdf->setTipo('insumos');
        $fpdf->setWatermark($recepcion->estado);
        $fpdf->AddPage();
        $recepcion->orden->proveedor !== null ? $fpdf->setProveedor($recepcion->orden->proveedor->nombre, $recepcion->orden->proveedor->rut) :  $fpdf->setProveedor($recepcion->orden->nom_proveedor, $recepcion->orden->codigo_proveedor);
        $fpdf->setMarco($recepcion->only('id', 'created_at', 'documento', 'num_documento', 'orden'));
        $fpdf->setObservacion($recepcion->observacion);
        $recepcion->aprobante !== null ?  $fpdf->setAprobacion($recepcion->aprobante, $recepcion->aprobacion, $recepcion->estado, $recepcion->observacion_aprobacion) : '';
        $fpdf->SetY(225);
        $fpdf->setTotales($recepcion->monto_total, $recepcion->orden->valor_total, $recepcion->orden->solicitud->total, $recepcion->orden->solicitud->monto_adj->monto);
        // $fpdf->setCriterios($recepcion->modalidad_compra, $recepcion->criterios);
        // $fpdf->setAprobaciones($recepcion->aprobaciones);
        // $fpdf->setRechazos($recepcion->solicitante);
        // $fpdf->showAprobaciones();
        // $fpdf->getOrdenes($recepcion->ordenes, $recepcion->modalidad_compra);
        $fpdf->Output('I', "Recepcion-{$recepcion->num_documento}.pdf");
    }
}
