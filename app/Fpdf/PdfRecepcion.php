<?php

namespace App\Fpdf;

use App\Solicitud;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Str;

class PdfRecepcion extends Fpdf
{
    protected $titulo = '';
    protected $tipo = '';
    protected $watermark = 'img/logocentro.jpg';
    protected $aprobaciones = [];
    protected $proveedor;
    protected $rut;
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

        $this->Cell(0, 7, utf8_decode("RECEPCIÓN DE ORDEN DE COMPRA "), 0, 1, "C");
        $this->Cell(0, 4, utf8_decode("DSM MUNICIPALIDAD DE LAUTARO"), 0, 1, "C");
        $this->Cell(0, 4, utf8_decode($this->titulo), 0, 1, "C");
    }

    //Pie de página
    function Footer()
    {
        $this->SetY(-22);
        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(100, 3, "", 0, 0, "");
        // $this->SetFillColor(0, 191, 191);
        // $this->Cell(0, 5, utf8_decode("VºBº  Jefe de Finanzas Departamento de Salud"), 1, 1, "C", 1);
        // $this->SetFillColor(255, 255, 255);
        // $this->SetFont('Arial', '', 9);
        // $date = date_create('200-05-20');
        // $this->Cell(100, 5, "", 0, 0, "");
        // $this->Cell(20, 5, "Fecha:", 1, 0, "");
        // $this->Cell(0, 5, ('200-05-20' != ' - -') ? date_format($date, "d/m/Y h:i A") : ' - -', 1, 1, "");
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
    public function setMarco($recepcion)
    {
        $this->Ln(1);
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(230);
        $this->SetXY(150, 22);
        $this->RoundedRect(13, 32, 185, 20, 5, '13', 'DF');
        // $ancho = strlen($recepcion['descripcion']) >= 85 ? 25 : 20;
        // $this->tipo == 'convenios' ?  $this->RoundedRect(13, 32, 185, $ancho + 5, 5, '13', 'DF') :  $this->RoundedRect(13, 32, 185, $ancho, 5, '13', 'DF');
        // $this->RoundedRect(13, 32, 185, 20, 5, '13', 'DF');
        $date = date_create($recepcion['created_at']);
        $this->Cell(20, 4, "Fecha:", 0, 0, "");
        $this->Cell(35, 4, date_format($date, "d-m-Y"), 0, 1, "");
        $this->SetX(150);
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(255, 0, 0);
        $this->Cell(20, 4, utf8_decode("N°:"), 0, 0, "");
        $this->Cell(35, 4, $recepcion['id'], 0, 1, "", 1);
        $this->SetTextColor(0, 0, 0);
        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 9);
        $this->Ln(3);

        // //DEPENDENCIA
        $this->Cell(30, 4, "Tipo Documento:", 0, 0, "");
        $this->SetFont('Arial', '', 10);
        $this->Cell(100, 4, Str::ucfirst($recepcion['documento']), 0, 0, "");
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(23, 4, utf8_decode("N° Documento:"), 0, 0, "R");
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 4, utf8_decode($recepcion['num_documento']), 0, 1, "");
        $this->SetFont('Arial', 'B', 9);


        $this->Cell(30, 4, "Orden De Compra:", 0, 0, "");
        $this->SetFont('Arial', '', 10);
        $this->Cell(95, 4, $recepcion['orden']['num_orden'], 0, 0, "");
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 4, utf8_decode("Tipo de Compra: "), 0, 0, "");
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 4, utf8_decode($recepcion['orden']['tipo_compra']), 0, 1, "");
        // $this->Ln(1);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(30, 4, "Proveedor:", 0, 0, "");
        $this->SetFont('Arial', '', 10);
        $this->Cell(95, 4, $this->proveedor, 0, 0, "");
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(10, 4, utf8_decode("Rut: "), 0, 0, "");
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 4, utf8_decode($this->rut), 0, 1, "");
        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(33, 4, utf8_decode("Proveedor: "), 0, 0, "");
        // $this->SetFont('Arial', '', 9);
        // $this->Cell(102, 4, utf8_decode($this->proveedor['nombre']), 0, 0, "");
        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(10, 4, utf8_decode("RUT: "), 0, 0, "");
        // $this->SetFont('Arial', '', 9);
        // $this->Cell(0, 4, utf8_decode($this->proveedor['rut']), 0, 1, "");
    }
    public function setObservacion($observacion)
    {

        $so = $this->GetY();
        $this->SetXY(0, $so + 10);
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 14);
        $this->SetFillColor(0, 191, 191);
        $this->Cell(0, 5, 'Detalles', 1, 1, 'C', 1);
        $this->SetFillColor(255, 255, 255);
        // $this->Ln();
        $this->SetFont('Arial', '', 12);
        // $this->Cell(10, 2, 'Aprobaciones.', 0, 1, 'C');
        $this->MultiCell(0, 5, utf8_decode($observacion), 1, 1, "");
        $this->Ln();
    }
    public function setTotales($total_orden, $total_recepcion, $total_solicitud, $monto_adj = null)
    {
        $this->Cell(119, 4, "", 0, 0, "");
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(37, 7, "Total Solicitud $", 1, 0, "R");
        $this->Cell(0, 7, number_format($total_solicitud, 2, ",", "."), 1, 1, "R");
        if (isset($monto_adj)) {
            $this->Cell(119, 4, "", 0, 0, "");
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(37, 7, "Monto Adj. $", 1, 0, "R");
            $this->Cell(0, 7, number_format($monto_adj, 2, ",", "."), 1, 1, "R");
        }
        $this->Cell(119, 4, "", 0, 0, "");
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(37, 7, "Total Orden $", 1, 0, "R");
        $this->Cell(0, 7, number_format($total_recepcion, 2, ",", "."), 1, 1, "R");


        $this->SetFont('Arial', '', 9);
        $this->Cell(119, 4, "", 0, 0, "");
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255, 255, 255);
        $this->SetFont('Arial', 'B', 9);

        $this->Cell(37, 7, utf8_decode("Total Recepción $"), 1, 0, "R", 1);

        $this->Cell(0, 7, number_format($total_orden, 2, ",", "."), 1, 1, "R", 1);
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0, 0, 0);
    }
    public function setAprobacion($aprobacion, $tipo, $estado, $observacion)
    {
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(0, 191, 191);
        $this->Cell(80, 5, utf8_decode("Aprobación: {$estado}"), 1, 0, "", 1);
        $this->SetFillColor(255, 255, 255);
        $this->Cell(10, 5, "", 0, 0, "");
        $this->SetFillColor(0, 191, 191);
        $this->Cell(0, 5, utf8_decode("Observación de Aprobación: "), 1, 1, "", 1);

        $this->SetFillColor(255, 255, 255);
        $this->SetFont('Arial', '', 10);
        $y = $this->GetY();
        $this->MultiCell(80, 4, utf8_decode("Usuario: " . $aprobacion->nombres), 0, '');
        $this->MultiCell(80, 4, utf8_decode("Tipo: " . $aprobacion->nombres), 0, '');

        $this->SetY($y);
        $this->Cell(80, 10, "", 1, 0, "");
        $y2 = $this->GetY() + 13;
        $this->Cell(10, 5, "", 0, 0, "");
        $this->SetXY(105, $y);
        //$this->Cell(35,5, utf8_decode($row_abast["modalidadcompra"]),0,1,"");
        // $this->Cell(90, 4, "", 0, 0, "");
        $this->SetFont('Arial', 'B', 8);
        $this->MultiCell(0, 5, utf8_decode($observacion), 1, 1, "");
        $this->SetFont('Arial', '', 7);
        $this->SetY($y2);
    }

    /**
     * Set the value of proveedor
     *
     * @return  self
     */
    public function setProveedor($proveedor, $rut)
    {
        $this->proveedor = $proveedor;
        $this->rut = $rut;
    }
}
