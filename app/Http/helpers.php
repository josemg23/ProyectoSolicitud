<?php

use App\ContratoSuministro;
use App\Convenio;
use App\Cuenta;
use App\HistorialCuenta;
use App\Periodo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use App\Traits\RutasTraits;




/**
 * Cambiar Formato Fechas
 *
 * @param mixed $date
 * @param mixed $date_format
 * @return string
 */
if (!function_exists('changeDateFormate')) {
    function changeDateFormate($date, $date_format)
    {
        return Carbon::parse($date)->format($date_format);
    }
}
/**
 * Obtener Primer Dia Mes
 *
 * @param string $format
 * @return string
 */

if (!function_exists('starMonth')) {
    function starMonth($format = 'Y-m-d')
    {
        $s = Carbon::now()->startOfMonth();

        return $s->format($format);
    }
}


if (!function_exists('finalMes')) {
    function finalMes($format = 'Y-m-d')
    {
        $s = Carbon::now()->endOfMonth();

        return $s->format($format);
    }
}

/**
 * Obtener Fecha Formteada
 *
 * @param string $format
 * @return string
 */

if (!function_exists('fechaFormat')) {
    function fechaFormat($date)
    {

        return Carbon::parse($date)->formatLocalized('%d de %B %Y ');
    }
}
if (!function_exists('ramdomBadge')) {
    function ramdomBadge()
    {
        $badges = collect(['outline-badge-danger', 'outline-badge-success', 'outline-badge-primary', 'outline-badge-warning', 'outline-badge-info']);
        return $badges->random();
    }
}
if (!function_exists('fechaDiaMes')) {
    function fechaDiaMes($date)
    {

        return Carbon::parse($date)->formatLocalized('%d, %B %Y ');
    }
}

if (!function_exists('totalVentaCateforia')) {
    function totalVentaCateforia($productos, $columna)
    {
        return  $productos->reduce(function ($suma, $venta) use ($columna) {
            foreach ($venta->ventass as $k => $v) {
                $suma += $v[$columna];
            }
            return $suma;
        });
    }
}
if (!function_exists('active')) {
    function active($url)
    {
        return  Request::is($url) ? ' active' : '';
    }
}
if (!function_exists('submenu')) {
    function submenu($rutas)
    {
        foreach ($rutas as $key => $ruta) {
            if ($ruta->url == Request::is($ruta->url)) {
                return ' recent-submenu mini-recent-submenu show';
            }
        }
    }
}
if (!function_exists('getRole')) {
    function getRole()
    {
        return  auth()->user()->roles[0]->description;
    }
}
if (!function_exists('getRoleName')) {
    function getRoleName()
    {
        return  auth()->user()->roles[0]->name;
    }
}
if (!function_exists('activeAll')) {
    function activeAll($rutas)
    {
        foreach ($rutas as $key => $ruta) {
            if ($ruta->url == Request::is($ruta->url)) {
                return ' active';
            }
        }
    }
}
if (!function_exists('expanded')) {
    function expanded($rutas)
    {
        foreach ($rutas as $key => $ruta) {
            if ($ruta->url == Request::is($ruta->url)) {
                return 'true';
            } else {
                $data = 'false';
            }
        }
    }
}
if (!function_exists('syncMonto')) {
    function syncMonto(int $id, $monto, string $type)
    {

        $cuenta = Cuenta::find($id);
        $calculo = $type == 'ingreso' ? $cuenta->saldo_a + $monto : $cuenta->saldo_a - $monto;
        $cuen = Cuenta::find($id)
            ->update(['saldo_a' => $calculo]);

        // $cuenta->saldo_a = $calculo;
        // $cuenta->save();
    }
}
if (!function_exists('syncMontoContrato')) {
    function syncMontoContrato(int $id, $monto, string $type)
    {
        $periodo = Periodo::where('contrato_suministro_id', $id)->get()->last();
        $calculo = $type == 'ingreso' ? $periodo->monto_actual + $monto : $periodo->monto_actual - $monto;
        $periodo->monto_actual = $calculo;
        $periodo->save();
    }
}
if (!function_exists('lastPeriodo')) {
    function lastPeriodo(int $id)
    {
        $periodo = Periodo::where('contrato_suministro_id', $id)->get()->last();
        return $periodo->id;
    }
}
if (!function_exists('verificarStarus')) {
    function verificarStarus($estado)
    {
        switch ($estado) {
            case 'en proceso':
                echo 'text-capitalize badge-warning';
                break;
            case 'aprobado':
                echo 'text-capitalize badge-info';
                break;
            case 'rechazada':
                echo 'text-capitalize badge-danger';
                break;
            case 'completada':
                echo 'text-capitalize badge-success';
                break;
            case 'recepcionada':
                echo 'text-capitalize badge-dark';
                break;
            case 'recepcion-parcial':
                echo 'text-capitalize badge-green';
                break;
            case 'cancelada':
                echo 'text-capitalize badge-cancel';
                break;
            case 'eliminada':
                echo 'text-capitalize badge-delete';
                break;
            default:
                echo "text-capitalize badge-secondary";
        }
        // return $data;
    }
}
if (!function_exists('simpleStatus')) {
    function simpleStatus($estado)
    {
        switch ($estado) {
            case 'activo':
                echo 'text-capitalize badge-success';
                break;
            default:
                echo "text-capitalize badge-danger";
        }
        // return $data;
    }
}
if (!function_exists('syncConvenio')) {
    function syncConvenio($id)
    {
        $total = Cuenta::where('convenio_id', $id)->sum('saldo_a');
        $convenio = Convenio::find($id);
        $convenio->saldo = $total;
        $convenio->save();
    }
}
if (!function_exists('getIconOrder')) {
    function getIconOrder($extension)
    {
        switch ($extension) {
            case 'xml':
                echo 'fa-file';
                break;
            case 'pdf':
                echo 'fa-file-pdf';
                break;
            default:
                echo 'fa-file-image';
        }
    }
}
