<?php

namespace App\Fpdf;

use App\Solicitud;
use Codedge\Fpdf\Fpdf\Fpdf;

class PDF extends Fpdf
{
    protected $titulo = '';
    protected $tipo = '';
    protected $watermark = 'img/logocentro.jpg';
    protected $aprobaciones = [];
    protected $proveedor = [
        'nombre' => '',
        'rut' => '',
    ];
    protected $convenio;
    protected $hasConvenio = false;
    //Cabecera de página
    function Header()
    {
        $this->SetLeftMargin(15);
        $this->SetRightMargin(15);
        //Logo
        // $this->Image('assets/img/impr_izquierda.jpeg', 20, 5, 28);
        $this->Image(asset('img/impr_izquierda.jpeg'), 20, 5, 28);
        //$this->Image('assets/img/impr_derecho.jpg',245,4,45);
        $this->Image(asset($this->watermark), 5, 65, 200);
        $this->SetXY(130, 8); //posicion fecha de impresion
        $this->SetFont('Arial', '', 8); //taaño y tipo Fecha de Impresión
        $this->Cell(50, 4, "Fecha imp.: ", 0, 0, "R");
        $this->Cell(5, 4, date('d') . ' /', 0, 0, "C");
        $this->Cell(5, 4, date('m') . ' /', 0, 0, "C");
        $this->Cell(7, 4, date('Y'), 0, 1, "C");
        $this->SetFont('Arial', 'B', 10);
        $this->SetY(10);

        $this->Cell(0, 7, utf8_decode("SOLICITUD DE ADQUISICIÓN " . 'NUEVA'), 0, 1, "C");
        $this->Cell(0, 4, utf8_decode("DSM MUNICIPALIDAD DE LAUTARO"), 0, 1, "C");
        $this->Cell(0, 4, utf8_decode($this->titulo), 0, 1, "C");
    }

    //Pie de página
    function Footer()
    {
        $this->SetY(-22);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(100, 3, "", 0, 0, "");
        $this->SetFillColor(0, 191, 191);
        $this->Cell(0, 5, utf8_decode("VºBº  Jefe de Finanzas Departamento de Salud"), 1, 1, "C", 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial', '', 9);
        $date = date_create('200-05-20');
        $this->Cell(100, 5, "", 0, 0, "");
        $this->Cell(20, 5, "Fecha:", 1, 0, "");
        $this->Cell(0, 5, ('200-05-20' != ' - -') ? date_format($date, "d/m/Y h:i A") : ' - -', 1, 1, "");
        //Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        //Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
    function RoundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));

        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));
        if (strpos($corners, '2') === false)
            $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $y) * $k));
        else
            $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);

        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
        if (strpos($corners, '3') === false)
            $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
        if (strpos($corners, '4') === false)
            $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);

        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
        if (strpos($corners, '1') === false) {
            $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $y) * $k));
            $this->_out(sprintf('%.2F %.2F l', ($x + $r) * $k, ($hp - $y) * $k));
        } else
            $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c ',
            $x1 * $this->k,
            ($h - $y1) * $this->k,
            $x2 * $this->k,
            ($h - $y2) * $this->k,
            $x3 * $this->k,
            ($h - $y3) * $this->k
        ));
    }
    /**
     * Set the value of tipo
     *
     * @return  self
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }
    public function setMarcoInsumo($solicitud)
    {
        $this->Ln(1);
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(230);
        $this->SetXY(150, 22);
        $ancho = strlen($solicitud['descripcion']) >= 85 ? 25 : 20;
        $this->tipo == 'convenios' ?  $this->RoundedRect(13, 32, 185, $ancho + 5, 5, '13', 'DF') :  $this->RoundedRect(13, 32, 185, $ancho, 5, '13', 'DF');
        // $this->RoundedRect(13, 32, 185, 20, 5, '13', 'DF');
        $date = date_create($solicitud['created_at']);
        $this->Cell(20, 4, "Fecha:", 0, 0, "");
        $this->Cell(35, 4, date_format($date, "d-m-Y"), 0, 1, "");
        $this->SetX(150);

        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(255, 0, 0);
        $this->Cell(20, 4, "Nro. :", 0, 0, "");
        $this->Cell(35, 4, $solicitud['id'], 0, 1, "", 1);
        $this->SetTextColor(0, 0, 0);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 9);

        $this->Ln(3);

        //DEPENDENCIA
        $this->Cell(30, 4, "Dependencia:", 0, 0, "");
        $this->SetFont('Arial', '', 9);
        $this->Cell(64, 4, $solicitud['dependencia']['nombre'], 0, 0, "");

        //DEPARTAMENTO

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(23, 4, "Depto./Unidad:", 0, 0, "R");
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 4, utf8_decode($solicitud['departamento']['nombre']), 0, 1, "");
        if ($this->hasConvenio) {
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(30, 4, "Convenio:", 0, 0, "");
            $this->SetFont('Arial', '', 9);
            $this->Cell(0, 4, $this->convenio['nombre'], 0, 1, "");
        }
        $this->Ln(1);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(33, 4, utf8_decode("Nombre Adquisición: "), 0, 0, "");
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 4, utf8_decode($solicitud['adquisicion']), 0, 1, "");
        $this->Ln(1);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(33, 4, utf8_decode("Descripción/Destino: "), 0, 0, "");
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(0, 4, utf8_decode($solicitud['descripcion']), 0, '');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(33, 4, utf8_decode("Proveedor: "), 0, 0, "");
        $this->SetFont('Arial', '', 9);
        $this->Cell(102, 4, utf8_decode($this->proveedor['nombre']), 0, 0, "");
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(10, 4, utf8_decode("RUT: "), 0, 0, "");
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 4, utf8_decode($this->proveedor['rut']), 0, 1, "");
    }
    public function setThead()
    {
        $this->SetFillColor(0, 191, 191); //color , jonas
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(30, 4, "Detalle de productos y/o servicios:", 0, 1, "");

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(5, 5, utf8_decode("N°"), 0, 0, "C", 1);
        $this->Cell(10, 5, "Cant", 0, 0, "C", 1);
        $this->Cell(17, 5, "Unidad", 0, 0, "C", 1);
        $this->Cell(50, 5, "Producto/Servicio", 0, 0, "C", 1);
        $this->Cell(50, 5, "Detalle", 0, 0, "C", 1);
        $this->Cell(22, 5, "Uni/neto", 0, 0, "R", 1);
        $this->Cell(0, 5, "Total/Neto", 0, 1, "R", 1);
    }
    public function productos($productos)
    {
        foreach (json_decode($productos)  as $key => $producto) {
            $this->SetFont('Arial', '', 8);
            $this->Cell(5, 4, $key + 1, 0, 0, "C");
            //number_format($numero, 3, ",", "");
            $this->Cell(10, 4, (int)($producto->cantidad), 0, 0, "C", 0);
            $this->Cell(17, 4, utf8_decode($producto->unidad_id), 0, 0, "C", 0);
            $y = $this->getY();
            $this->MultiCell(50, 4, utf8_decode($producto->producto), 0, '');
            $y1 = $this->getY();
            $this->setXY(105, $y);
            $this->MultiCell(50, 4, utf8_decode($producto->detalle), 0, 'J');
            $y2 = $this->getY();
            $this->setXY(155, $y);
            $this->Cell(22, 4, number_format($producto->neto, 2, ",", "."), 0, 0, "C", 0);  //netoitem
            $this->Cell(0, 4, number_format($producto->total, 2, ",", "."), 0, 1, "C", 0); //netounit
            //$this->Cell(20,4,'',0,1,"R",1);
            if ($y1 > $y2) {
                $this->setY($y1);
            } else {
                $this->setY($y2);
            }
            $y = $this->getY();
            $this->line(15, $y, 195, $y);

            //Si esta casi ultimo de la hoja entoncces ya dar salto de linea para que no se entrecorte
            if ($y > 256) {
                $this->AddPage();
                $this->Ln(8);
            }
        }
    }
    public function products($productos)
    {
        foreach ($productos  as $key => $producto) {
            $this->SetFont('Arial', '', 8);

            $this->Cell(5, 4, $key + 1, 0, 0, "C");
            //number_format($numero, 3, ",", "");
            $this->Cell(10, 4, (int)($producto->pivot->cantidad), 0, 0, "", 0);
            $this->Cell(17, 4, utf8_decode($producto->medida->nombre), 0, 0, "", 0);
            $y = $this->getY();
            $this->MultiCell(50, 4, utf8_decode($producto->nombre), 0, '');
            $y1 = $this->getY();
            $this->setXY(105, $y);
            $this->MultiCell(50, 4, utf8_decode($producto->detalle), 0, '');
            $y2 = $this->getY();
            $this->setXY(155, $y);
            $this->Cell(22, 4, number_format($producto->pivot->neto, 2, ",", "."), 0, 0, "L", 0);  //netoitem
            $this->Cell(0, 4, number_format($producto->pivot->neto, 2, ",", "."), 0, 1, "L", 0); //netounit
            //$this->Cell(20,4,'',0,1,"R",1);

            if ($y1 > $y2) {
                $this->setY($y1);
            } else {
                $this->setY($y2);
            }
            $y = $this->getY();
            $this->line(15, $y, 195, $y);

            //Si esta casi ultimo de la hoja entoncces ya dar salto de linea para que no se entrecorte
            if ($y > 256) {
                $this->AddPage();
                $this->Ln(8);
            }
        }
    }

    public function setTotales($total_neto, $iva, $total)
    {
        //Neto
        $neto = $total_neto; //1.19;//cambio Jonas  / por *
        $this->Cell(119, 4, "", 0, 0, "");
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(37, 7, "Total Neto $", 1, 0, "R");
        $this->Cell(0, 7, number_format($neto, 2, ",", "."), 1, 1, "R");

        //IVA
        $iva = $iva;     //-$neto;
        $this->Cell(119, 4, "", 0, 0, "");
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(37, 7, "IVA 19% $", 1, 0, "R");
        $this->Cell(0, 7, number_format($iva, 2, ",", "."), 1, 1, "R");

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(8, 4, "Nota", 0, 0, "");

        $this->SetFont('Arial', '', 9);
        $this->Cell(111, 4, "Si la cantidad de productos es mayor a 60 lineas, agregar una nueva solicitud", 0, 0, "");
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 9);

        $this->Cell(37, 7, "Total Costo Estimado $", 1, 0, "R", 1);

        $this->Cell(0, 7, number_format($total, 2, ",", "."), 1, 1, "R", 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
    }
    public function setCriterios($modalidad_compra, $criterios)
    {
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(0, 191, 191);
        $this->Cell(80, 5, "Condiciones de entrega:", 1, 0, "", 1);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(10, 5, "", 0, 0, "");
        $this->SetFillColor(0, 191, 191);
        $this->Cell(0, 5, utf8_decode("Modalidad de compra: ") . utf8_decode($modalidad_compra), 1, 1, "", 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial', '', 8);
        $y = $this->GetY();
        $this->MultiCell(80, 3, utf8_decode($modalidad_compra), 0, 'J');
        $this->SetY($y);
        $this->Cell(80, 20, "", 1, 0, "");
        $this->Cell(10, 5, "", 0, 0, "");

        $this->SetXY(107, $y);
        //$this->Cell(35,5, utf8_decode($row_abast["modalidadcompra"]),0,1,"");
        //$this->Cell(90,4,"",0,0,"");
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0, 4, utf8_decode("Criterios de Adjudicación: "), 0, 1, "");
        $this->SetFont('Arial', '', 7);
        foreach ($criterios as $key => $criterio) {
            $this->Cell(92, 4, "", 0, 0, "");
            $this->MultiCell(0, 3, utf8_decode($criterio->nombre . ': ' . $criterio->pivot->porcentaje . '%'), 0, '');
        }
        $this->SetXY(105, $y);
        if (count($criterios) >= 5) {
            $this->Cell(0, count($criterios) * 4, "", 1, 1, "");
        } else {
            $this->Cell(0, 20, "", 1, 1, "");
        }
    }
    public function setRechazos($solicitante)
    {
        // $this->Ln(1);
        $this->SetFont('Arial', 'B', 9);

        $this->SetFillColor(0, 191, 191);
        $this->Cell(80, 5, "Motivo de rechazo y/o Observacion:", 1, 0, "", 1);

        $this->SetFillColor(255, 255, 255);
        $this->Cell(10, 5, "", 0, 0, "");

        $this->SetFillColor(0, 191, 191);
        $this->Cell(0, 5, utf8_decode("Datos  de Contacto del Solicitante:"), 1, 1, "", 1);
        $this->SetFillColor(255, 255, 255);
        $ay = $this->GetY();
        $this->SetFont('Arial', '', 10);
        foreach ($this->aprobaciones as $apr => $aprobacion) {
            if ($aprobacion->estado == 'rechazado') {
                $estado =   $aprobacion->rechazo->nombre;
            } else {
                $estado = $aprobacion->observacion;
            }
            $this->MultiCell(80, 4, utf8_decode($aprobacion->tipo) . ': ' . $estado, 1, '');
        }
        $this->SetFont('Arial', '', 8);
        $this->SetXY(95, $ay);
        $this->Cell(10, 5, "", 0, 0, "");
        $this->Cell(0, 5, "Nombre: " . utf8_decode($solicitante->nombres), 1, 1, "");
        $this->Cell(90, 5, "", 0, 0, "");
        $this->Cell(0, 5, "Fono:     " . utf8_decode($solicitante->fono), 1, 1, "");
        $this->Cell(90, 5, "", 0, 0, "");
        $this->Cell(0, 5, "Email:    " . utf8_decode($solicitante->email), 1, 1, "");
    }
    public function showAprobaciones()
    {
        $so = $this->GetY();
        // $this->SetXY(0, $so + 8);
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 12);

        $this->Cell(0, 2, 'Aprobaciones.', 0, 1, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 8);

        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(57, 3, utf8_decode("Solicitante"), 0, 0, "");
        // $this->SetFont('Arial', '', 9);
        $header = array("Cargo.", "Usuario", "Fecha.", "Estado");
        $aprobaciones = $this->aprobaciones;
        $w = array(50, 50, 50, 0);
        for ($i = 0; $i < count($header); $i++) {
            $this->SetFont('Arial', 'B', 8);

            $this->Cell($w[$i], 5, $header[$i], 1, 0, 'C');
        }
        $this->Ln();
        foreach ($aprobaciones as $aprobacion) {
            $this->SetFont('Arial', 'B', 8);

            $this->Cell($w[0], 4, $aprobacion->tipo, 1);
            $this->SetFont('Arial', '', 8);

            $this->Cell($w[1], 4,  $aprobacion->encargado->nombres, 1);
            $this->Cell($w[2], 4,  $aprobacion->created_at, 1);
            $this->Cell($w[3], 4,  $aprobacion->estado, 1, '', 'C');

            $this->Ln();
        }
    }
    public function getOrdenes($ordenes, $modalidad_compra)
    {
        if (count($ordenes) >= 1 && $modalidad_compra == 'licitacion') {
            $this->setOrdenes($ordenes);
        } else {
            $lm = $this->GetY();
            $this->setOrden($ordenes);
        }
        // ob_get_clean();
    }
    public function setOrdenes($ordenes)
    {
        $this->AddPage();
        $this->SetY(35); //posion orden de compra
        $this->Ln(2);

        $y = $this->GetY();
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(0, 191, 191);
        $this->Cell(0, 4, 'ORDENES DE COMPRAS.', 0, 1, 'C',);
        // $this->Cell(80, 4, "ORDEN DE COMPRA", 1, 1, "C", 1);
        $this->SetFillColor(255, 255, 255);
        $this->Ln(0.5);
        $this->SetFont('Arial', 'B', 8);
        $header = array("N° Orden.", "Proveedor", "Rut.", "Valor");
        $aprobaciones = $this->aprobaciones;
        $w = array(35, 100, 20, 0);
        for ($i = 0; $i < count($header); $i++) {
            $this->SetFillColor(0, 191, 191);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell($w[$i], 5, utf8_decode($header[$i]), 'BT', 0, 'C', 1);
        }
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos
        $fill = false;
        foreach ($ordenes as $orden) {
            $this->SetFont('Arial', '', 8);
            $this->Cell($w[0], 4, $orden->num_orden, 'BT');
            $this->Cell($w[1], 4,  $orden->nom_proveedor, 'BT');
            $this->Cell($w[2], 4,  $orden->codigo_proveedor, 'BT');
            $this->Cell($w[3], 4, number_format($orden->valor_total, 2), 'BT', '', 'R');
            $this->Ln();
            $fill = !$fill;
        }
        $this->Cell(135, 4, '', 0);
        $this->SetFont('Arial', 'B', 9);
        $recepciones = number_format($ordenes->sum('valor_total'), 2);
        $this->Cell(20, 4, "Suma:", 1);
        $this->SetFont('Arial', 'B', 8);

        $this->Cell(0, 4, $recepciones, 1, 0, 'R');
    }
    public function setOrden($orden)
    {
        $ord = $orden[0] ?? null;
        $proveedor = null;
        $rut = null;
        $total = null;
        if (isset($ord)) {
            $proveedor = isset($ord->proveedor_id) ? $ord->proveedor->nombre : $ord->nom_proveedor;
            $rut = isset($ord->proveedor_id) ? $ord->proveedor->rut : $ord->codigo_proveedor;
            $total = number_format($ord->valor_total, 2);
        }
        $this->Ln(2);
        $this->SetY(250); //posion orden de compra
        $y = $this->GetY();
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(0, 191, 191);
        $this->Cell(80, 4, "ORDEN DE COMPRA", 1, 1, "C", 1);
        $this->SetFillColor(255, 255, 255);
        $this->Ln(0.5);
        $this->SetFont('Arial', 'B', 8);
        // if (isset($orden[0])) {
        $this->Cell(35, 3, utf8_decode("Número de OC : ") . utf8_decode(isset($orden[0]) ? $orden[0]->num_orden : ''), 0, 1, "");
        $this->Cell(15, 3, utf8_decode("Proveedor : "), 0, 0, "");
        $this->SetFont('Arial', 'B', 7);
        $this->MultiCell(70, 3, utf8_decode($proveedor), 0, '');
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(45, 3, utf8_decode("RUT : ") . utf8_decode($rut), 0, 1, "");
        $this->SetTextColor(255, 000, 000);

        $this->SetFont('Arial', 'B', 11);
        //$this->Cell(35,3, utf8_decode("Valor $ ").utf8_decode($row_xml['valortotal']),0,1,"",1);
        $this->Cell(35, 3, utf8_decode("Valor $ ") . $total, 0, 1, "", 1); //cambiar , por . en el formato del Monto

        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 8);

        $this->SetXY(105, $y);
        $this->SetFont('Arial', 'B', 9);
        //$this->SetTextColor(255,255,255);
        $this->SetFillColor(0, 191, 191);
        $this->Cell(0, 4, utf8_decode("Uso Exclusivo Unidad De Finanzas"), 1, 1, "C", 1);
        $this->SetFillColor(255, 255, 255);
        $this->Ln(0.5);
        $this->SetFillColor(76, 175, 80);
        $this->Cell(90, 3, '', 0, 0, "");
        $this->Cell(10, 4, "Linea", 0, 0, "C", 1);
        $this->Cell(0, 4, utf8_decode("Cuenta"), 0, 1, "C", 1);
        // }
    }

    /**
     * Set the value of watermark
     *
     * @return  self
     */
    public function setWatermark($watermark)
    {
        switch ($watermark) {
            case 'rechazada':
                $this->watermark = 'img/fondorechazo.jpg';
                break;
            case 'borrador':
                $this->watermark = 'img/fondoborrador.jpg';
                break;
            case 'eliminada':
                $this->watermark = 'img/fondoeliminada.jpg';
                break;
            default:
                $this->watermark = 'img/logocentro.jpg';
        }
        return $this;
    }
    /**
     * Set the value of aprobaciones
     *
     * @return  self
     */
    public function setAprobaciones($aprobaciones)
    {
        $this->aprobaciones = $aprobaciones;

        return $this;
    }
    /**
     * Set the value of titulo
     *
     * @return  self
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Set the value of hasConvenio
     *
     * @return  self
     */
    public function setHasConvenio($hasConvenio)
    {
        $this->hasConvenio = $hasConvenio;

        return $this;
    }

    /**
     * Set the value of convenio
     *
     * @return  self
     */
    public function setConvenio($convenio)
    {
        $this->convenio = $convenio;

        return $this;
    }
}
