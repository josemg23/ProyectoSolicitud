<?php

namespace App\Traits\Evaluacion;

use App\Solicitud;
use App\Aprobacion;
use App\HistorialCuenta;
use App\HistorialContrato;

trait EvaluacionMantenimientoTrait
{
    public function asignarCuentas(Aprobacion $aprobacion, $cuentas, $solicitud)
    {
        $cuenta = $cuentas;
        $conversion = $this->convArray($cuenta);
        $aprobacion->cuentas()->sync($conversion);
        foreach ($cuenta as $key => $value) {
            $this->setHistorial($aprobacion, $solicitud, $value['id'], $value['monto']);
        }
        $response = array('mensaje' => "Registro Realizado Correctamente");
        return $response;
    }

    public function convArray($cuentas)
    {
        $conv = [];
        foreach ($cuentas as $key => $value) {
            $conv[$value['id']] = array(
                "monto"   => $value['monto'],
                'created_at' => now(),
                'updated_at' => now(),
            );
        }
        return $conv;
    }
    public function setHistorial(Aprobacion $aprobacion, $solicitud, $id, $monto)
    {
        $detalle = "Monto asignado a la Solicitud N° {$solicitud->id} de Mantenimiento";
        $historial    = new HistorialCuenta(['cuenta_id' => $id, 'detalle' => $detalle, 'cantidad' =>  $monto, 'type' => 'egreso']);
        $aprobacion->historiales()->save($historial);
        syncMonto($id, $monto, 'egreso');
    }
    public function storeCriterios($criterios, Solicitud $solicitud)
    {
        $ids = $this->convCriterio($criterios);
        $solicitud->criterios()->sync($ids);
    }
    public function convCriterio($criterios)
    {
        $conv = [];
        foreach ($criterios as $key => $value) {
            $conv[$value['id']] = array(
                "porcentaje"   => $value['porcentaje'],
                'created_at' => now(),
                'updated_at' => now(),
            );
        }
        return $conv;
    }
}
