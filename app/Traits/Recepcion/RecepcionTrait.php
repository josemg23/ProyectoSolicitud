<?php

namespace App\Traits\Recepcion;

use App\Recepcion;
use App\Solicitud;
use App\Aprobacion;
use App\OrdenCompra;
use App\HistorialCuenta;
use Illuminate\Http\Request;

trait RecepcionTrait
{

    // SOLICITUD SIN LICITACION PUBLICA
    public function createRecepcionNormal(OrdenCompra $ordenCompra, Request $request)
    {
        $recepcion = new Recepcion();
        $recepcion->orden_compra_id = $ordenCompra->id;
        $recepcion->tipo = $request->tipo;
        $recepcion->documento = $request->tipo_documento;
        $recepcion->num_documento = $request->n_documento;
        $recepcion->monto_documento = $request->monto_documento;
        $recepcion->monto_total = $request->monto_recepcion;
        $recepcion->observacion = $request->observacion;
        $recepcion->estado = $request->estado;
        if ($request->mode == 'guardar') {
            if ($request->estado == 'pendiente') {
                $recepcion->aprobacion = $request->aprobacion;
                if ($request->has('diferencia')) {
                    $recepcion->diferencia = $request->diferencia;
                    $recepcion->detalle = $request->detalle_diferencia;
                    $recepcion->tipo_diferencia = $request->tipo_diferencia;
                }
                $recepcion->save();
            } elseif ($request->estado == 'aprobada' && $request->has('diferencia')) {
                $recepcion->save();
                $this->completarRecepcion($recepcion, $ordenCompra->solicitud, $request->tipo, true, $request->diferencia, $request->tipo_diferencia);
            } elseif ($request->estado == 'aprobada' && !$request->has('diferencia')) {
                $recepcion->save();
                $this->completarRecepcion($recepcion, $ordenCompra->solicitud, $request->tipo);
            }
        } else if ($request->mode == 'finalizar') {
            if ($request->estado == 'pendiente') {
                $recepcion->aprobacion = $request->aprobacion;
                if ($request->has('diferencia')) {
                    $recepcion->diferencia = $request->diferencia;
                    $recepcion->detalle = $request->detalle_diferencia;
                    $recepcion->tipo_diferencia = $request->tipo_diferencia;
                }
                $recepcion->save();
            } elseif ($request->estado == 'aprobada' && $request->has('diferencia')) {
                $recepcion->save();
                $this->completarRecepcion($recepcion, $ordenCompra->solicitud, 'completa', true, $request->diferencia, $request->tipo_diferencia);
            } elseif ($request->estado == 'aprobada' && !$request->has('diferencia')) {
                $recepcion->save();
                $this->completarRecepcion($recepcion, $ordenCompra->solicitud, 'completa');
            }
        } else {
            $recepcion->aprobacion = $request->aprobacion;
            $recepcion->save();
            $this->completarRecepcion($recepcion, $ordenCompra->solicitud, 'pendiente');
        }
        return $recepcion;
    }
    public function completarRecepcion(Recepcion $recepcion, Solicitud $solicitud, $tipo, $diferencia = false, $total_diferencia = null, $tipo_diferencia = null)
    {
        if ($tipo == 'completa') {
            $solicitud->estado = 'recepcionada';
            $solicitud->save();
            if ($diferencia) {
                $cuenta_id =  $this->getCuenta($solicitud->id);
                $this->setHistorial($recepcion, $solicitud, $cuenta_id, $tipo_diferencia, $total_diferencia);
            }
        } else if ($tipo == 'parcial') {
            $solicitud->estado = 'recepcion-parcial';
            $solicitud->save();
        }
    }

    public function cancelarRecepcion(Recepcion $recepcion, Solicitud $solicitud, $tipo, $diferencia)
    {
        $solicitud->estado = 'recepcion-parcial';
        $solicitud->save();
        $cuenta_id =  $this->getCuenta($solicitud->id);
        $detalle = "Monto reintegrado a la cuenta por una cancelación en la Recepcion N° {$recepcion->id}";
        $this->setHistorial($recepcion, $solicitud, $cuenta_id, $tipo, $diferencia, $detalle);
    }
    public function getActivo(Solicitud $solicitud)
    {
        $total_recepcion = $solicitud->append(['recepcion_sum_total'])->recepcion_sum_total;
        $total_orden = $solicitud->orden->valor_total;
        return $total_orden - $total_recepcion;
    }
    public function setHistorial(Recepcion $recepcion, Solicitud $solicitud,  $id, $operacion, $monto, $detalle = null)
    {
        $msg = $detalle == null ? "Monto de {$operacion} generado por la Recepcion N° {$recepcion->id}" : $detalle;
        $historial    = new HistorialCuenta(['cuenta_id' => $id, 'detalle' => $msg, 'cantidad' =>  $monto, 'type' => $operacion]);
        $recepcion->historiales()->save($historial);
        syncMonto($id, $monto, $operacion);
    }
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
    //SOLICITUD TIPO LICITACION PUBLICA

    /**
     * Undocumented function
     *
     * @param OrdenCompra $ordenCompra
     * @param Request $request
     * @return  App\Recepcion
     */
    public function createLicitacionPublica(OrdenCompra $ordenCompra, Request $request)
    {
        $recepcion = new Recepcion();
        $recepcion->orden_compra_id = $ordenCompra->id;
        $recepcion->tipo = $request->tipo;
        $recepcion->documento = $request->tipo_documento;
        $recepcion->num_documento = $request->n_documento;
        $recepcion->monto_documento = $request->monto_documento;
        $recepcion->monto_total = $request->monto_recepcion;
        $recepcion->observacion = $request->observacion;
        $recepcion->estado = 'aprobada';
        $recepcion->save();
        if ($request->mode == 'guardar' && $request->tipo == 'completa') {
            $ordenCompra->recepcion = 'recepcionada';
            $ordenCompra->save();
        } else if ($request->mode == 'guardar' && $request->tipo == 'parcial') {
            $ordenCompra->recepcion = 'recepcionada-parcial';
            $ordenCompra->save();
        } else if ($request->mode == 'cancelar' && $request->tipo == 'parcial' && $request->estado_cancelado == 'actualizar') {
            $ordenCompra->solicitud->monto_adj->monto = $request->monto_adjudicacion;
            $ordenCompra->solicitud->monto_adj->save();
            $ordenCompra->recepcion = 'recepcionada';
            $ordenCompra->save();
        } else if ($request->mode == 'cancelar' && $request->tipo == 'parcial' && $request->estado_cancelado == 'nueva_orden') {
            $ordenCompra->solicitud->estado = 'completada-parcial';
            $ordenCompra->solicitud->save();
            $ordenCompra->recepcion = 'recepcionada';
            $ordenCompra->save();
        } else if ($request->mode == 'finalizar' && $request->tipo == 'parcial') {
            $ordenCompra->recepcion = 'recepcionada';
            $ordenCompra->solicitud->estado = 'completada-parcial';
            $ordenCompra->solicitud->save();
            $ordenCompra->save();
        }
        if ($request->has('las_orden')) {
            $ordenCompra->solicitud->estado = 'recepcionada';
            $ordenCompra->solicitud->save();
            $diferencia = $ordenCompra->solicitud->total > $ordenCompra->solicitud->monto_adj->monto ? $ordenCompra->solicitud->total - $ordenCompra->solicitud->monto_adj->monto : $ordenCompra->solicitud->monto_adj->monto  - $ordenCompra->solicitud->total;
            $operacion = $ordenCompra->solicitud->total > $ordenCompra->solicitud->monto_adj->monto ? 'ingreso' : 'egreso';
            if ($diferencia > 0) {
                $cuenta_id =  $this->getCuenta($ordenCompra->solicitud->id);
                $detalle = "Monto generado por una diferencia entre el monto de Adjudicación y la Solicitud N° {$ordenCompra->solicitud->id}";
                $this->setHistorial($recepcion, $ordenCompra->solicitud, $cuenta_id, $operacion, $diferencia, $detalle);
            }
        }
        return $recepcion;
    }
}
