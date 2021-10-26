<?php

namespace App\Traits\Pdfs;

use App\Fpdf\PDF;
use App\Solicitud;

trait PdfTrait
{

    public function solicitudInsumo(Solicitud $solicitud)
    {
        $fpdf = new PDF();
        $fpdf->AliasNbPages();
        $fpdf->setTitulo('INSUMOS Y SERVICIOS');
        $fpdf->setTipo('insumos');
        $fpdf->setWatermark($solicitud->estado);
        $fpdf->AddPage();
        $fpdf->setMarcoInsumo($solicitud->only('id', 'created_at', 'dependencia', 'departamento', 'adquisicion', 'descripcion'));
        $fpdf->Ln(10);
        $fpdf->setThead();
        $solicitud->insumo->tipo_in == 'contrato' ?  $fpdf->products($solicitud->insumo->products) :  $fpdf->productos($solicitud->insumo->productos);
        $fpdf->GetY() > 170 ? $fpdf->AddPage() : '';
        $fpdf->SetY(150);
        $fpdf->setTotales($solicitud->total_neto, $solicitud->iva, $solicitud->total);
        $fpdf->setCriterios($solicitud->modalidad_compra, $solicitud->criterios);
        $fpdf->setAprobaciones($solicitud->aprobaciones);
        $fpdf->setRechazos($solicitud->solicitante);
        $fpdf->showAprobaciones();
        $fpdf->getOrdenes($solicitud->ordenes, $solicitud->modalidad_compra);
        $fpdf->Output('I', "Solicitud-Insumos-{$solicitud->id}.pdf");
    }
    public function solicitudContrato(Solicitud $solicitud)
    {
    }
    public function solicitudMantenimiento(Solicitud $solicitud)
    {
        $fpdf = new PDF();
        $fpdf->AliasNbPages();
        $fpdf->setTitulo('INFRAESTRUCTURA');
        $fpdf->setTipo('mantenimiento');

        $fpdf->setWatermark($solicitud->estado);
        $fpdf->AddPage();
        $fpdf->setMarcoInsumo($solicitud->only('id', 'created_at', 'dependencia', 'departamento', 'adquisicion', 'descripcion'));
        $fpdf->Ln(10);
        $fpdf->setThead();
        $fpdf->products($solicitud->mantenimiento->productos);
        $fpdf->GetY() > 170 ? $fpdf->AddPage() : '';
        $fpdf->SetY(150);
        $fpdf->setTotales($solicitud->total_neto, $solicitud->iva, $solicitud->total);
        $fpdf->setCriterios($solicitud->modalidad_compra, $solicitud->criterios);
        $fpdf->setAprobaciones($solicitud->aprobaciones);
        $fpdf->setRechazos($solicitud->solicitante);
        $fpdf->showAprobaciones();
        $fpdf->getOrdenes($solicitud->ordenes, $solicitud->modalidad_compra);
        $fpdf->Output('I', "Solicitud-Infraestructura-{$solicitud->id}.pdf");
    }
    public function solicitudCovenio(Solicitud $solicitud)
    {
        $fpdf = new PDF();
        $fpdf->AliasNbPages();
        $fpdf->setTitulo('CONVENIO');
        $fpdf->setTipo('convenios');
        $fpdf->setHasConvenio(true);
        $fpdf->setConvenio($solicitud->convenio);
        $fpdf->setWatermark($solicitud->estado);
        $fpdf->AddPage();
        $fpdf->setMarcoInsumo($solicitud->only('id', 'created_at', 'dependencia', 'departamento', 'adquisicion', 'descripcion'));
        $fpdf->Ln(10);
        $fpdf->setThead();
        $solicitud->convenio->tipo_c == 'contrato' ?  $fpdf->products($solicitud->convenio->products) :  $fpdf->productos($solicitud->convenio->productos);
        $fpdf->GetY() > 170 ? $fpdf->AddPage() : '';
        $fpdf->SetY(140);
        $fpdf->setTotales($solicitud->total_neto, $solicitud->iva, $solicitud->total);
        $fpdf->setCriterios($solicitud->modalidad_compra, $solicitud->criterios);
        $fpdf->setAprobaciones($solicitud->aprobaciones);
        $fpdf->setRechazos($solicitud->solicitante);
        $fpdf->Ln(3);

        $fpdf->showAprobaciones();
        $fpdf->getOrdenes($solicitud->ordenes, $solicitud->modalidad_compra);
        $fpdf->Output('I', "Solicitud-Convenio-{$solicitud->id}.pdf");
    }
}
