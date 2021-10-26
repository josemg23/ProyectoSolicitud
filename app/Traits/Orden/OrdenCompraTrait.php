<?php

namespace App\Traits\Orden;

use App\HistorialCuenta;
use App\OrdenCompra;


trait OrdenCompraTrait
{
    public function asignarCuentas(OrdenCompra $ordenCompra, $cuentas, $operacion)
    {
        foreach ($cuentas as $key => $cuenta) {
            if ($cuenta->monto !== 0) {
                $this->setHistorial($ordenCompra, $cuenta->id, $operacion, $cuenta->monto);
            }
        }
        $response = array('mensaje' => "Registro Realizado Correctamente");
        return $response;
    }
    public function setHistorial(OrdenCompra $ordenCompra,  $id, $operacion, $monto)
    {
        $detalle = "Monto de {$operacion} generado en la Orden de Compra N° {$ordenCompra->num_orden}";
        $historial    = new HistorialCuenta(['cuenta_id' => $id, 'detalle' => $detalle, 'cantidad' =>  $monto, 'type' => $operacion]);
        $ordenCompra->historiales()->save($historial);
        syncMonto($id, $monto, $operacion);
    }
}
