<?php

namespace App\Traits;

use App\Solicitud;
use App\Aprobacion;
use App\HistorialCuenta;

trait SolicitudTrait
{
    public function getCuenta($id)
    {
        $aprobacion = Aprobacion::where('solicitud_id', $id)->where('tipo', 'finanzas')->first();
        return $aprobacion->multiple ? $this->cuentaMayor($aprobacion->cuentas) : $aprobacion->cuenta_id;
    }
    public function cuentaMayor($cuentas)
    {
        $collection = collect($cuentas)->sortByDesc('saldo_a');
        $cuenta = $collection->values()->first();
        return $cuenta['id'];
    }
    public function setHistorial(Solicitud $solicitud,  $id, $operacion, $monto, $detalle = null)
    {
        $msg = $detalle ?? "Monto de {$operacion} generado por el cambio del monto de la Solicitud N° {$solicitud->id}";
        $historial    = new HistorialCuenta(['cuenta_id' => $id, 'detalle' => $msg, 'cantidad' =>  $monto, 'type' => $operacion]);
        $solicitud->historiales()->save($historial);
        syncMonto($id, $monto, $operacion);
    }
}
