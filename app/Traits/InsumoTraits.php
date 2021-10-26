<?php

namespace App\Traits;

use App\Insumos;
use App\Document;
use App\Solicitud;
use App\ContratoSuministro;
use App\Exceptions\MontoException;
use Illuminate\Support\Facades\Auth;

trait InsumoTraits
{


    public function createInsumo($request)
    {

        $solicitud                  = new Solicitud();
        $solicitud->tipo            = 'insumos';
        $solicitud->user_id         = Auth::id();
        $solicitud->adquisicion     = $request->adquisicion;
        $solicitud->descripcion     = $request->descripcion;
        $solicitud->fecha_creacion  = today();
        $solicitud->dependencia_id  = $request->dependencia_id;
        $solicitud->departamento_id = $request->departamento_id;
        $solicitud->total_neto      = $request->total_neto;
        $solicitud->iva             = $request->iva;
        $solicitud->total           = $request->total;
        $solicitud->estado          = $request->estado;
        $solicitud->proveedor_id          = $request->id_proveedor;

        $solicitud->save();
        $tipoContrato = null;

        $productos = $request->productos;

        if ($request->tipo_in == 'contrato') {
            $contrato = ContratoSuministro::find($request->contrato_id);
            if ($request->total > $contrato->monto_actual) {
                throw new MontoException('Hubo un cambio en el monto de Contrato de Suministro mientras se realizaba el proceso, el total es superior al monto');
            }
            $tipoContrato = array(
                "tipo_contrato_id" => $request->tipo_contrato_id,
                "proveedor_id" => $request->proveedor_id,
                "contrato_id" => $request->contrato_id,
            );
            $productos = $this->convArray(json_decode($request->productos));
        }

        $this->syncInsumo($solicitud->id, $request->tipo_in, $productos, $tipoContrato);

        if ($request->hasFile('cotizacion')) {
            $archivo = $request->cotizacion;
            $nombre       = time() . '_' . $archivo->getClientOriginalName();
            $urldocumento = '/solicitudes/' . $nombre;
            $archivo->storeAs('solicitudes',  $nombre, 'public_upload');
            $documento    = new Document(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
            $solicitud->documento()->save($documento);
        }
        $response = array('mensaje' => "Registro Realizado Correctamente");
        return $response;
    }


    public function updateInsumo($request)
    {

        $solicitud                  = Solicitud::find($request->solicitud_id);
        $solicitud->user_id         = Auth::id();
        $solicitud->adquisicion     = $request->adquisicion;
        $solicitud->descripcion     = $request->descripcion;
        $solicitud->fecha_creacion  = today();
        $solicitud->dependencia_id  = $request->dependencia_id;
        $solicitud->departamento_id = $request->departamento_id;
        $solicitud->total_neto      = $request->total_neto;
        $solicitud->iva             = $request->iva;
        $solicitud->total           = $request->total;
        $solicitud->estado          = $request->estado;
        $solicitud->proveedor_id          = $request->id_proveedor;

        $solicitud->save();

        $tipoContrato = null;
        $productos = $request->productos;
        if ($request->tipo_in == 'contrato') {
            $contrato = ContratoSuministro::find($request->contrato_id);
            if ($request->total > $contrato->monto_actual) {
                throw new MontoException('Hubo un cambio en el monto de Contrato de Suministro mientras se realizaba el proceso, el total es superior al monto');
            }
            $tipoContrato = array(
                "tipo_contrato_id" => $request->tipo_contrato_id,
                "proveedor_id" => $request->proveedor_id,
                "contrato_id" => $request->contrato_id,
            );
            $productos = $this->convArray(json_decode($request->productos));
        }

        $this->syncInsumo($solicitud->id, $request->tipo_in, $productos, $tipoContrato);

        if ($request->hasFile('cotizacion')) {
            if (isset($solicitud->documento)) {
                $image_path = public_path() . $solicitud->documento->archivo;
                unlink($image_path);
            }
            $archivo = $request->cotizacion;
            $nombre       = time() . '_' . $archivo->getClientOriginalName();
            $urldocumento = '/solicitudes/' . $nombre;
            $archivo->storeAs('solicitudes',  $nombre, 'public_upload');
            $documento    = new Document(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
            $solicitud->documento()->save($documento);
        }
        $response = array('mensaje' => "Registro Actualizado Correctamente");
        return $response;
    }



    public function syncInsumo(int $id, string $tipo_in, $productos, $tipoContrato)
    {
        if ($tipo_in == 'contrato') {
            $insumo = Insumos::updateOrCreate(
                ['solicitud_id' => $id],
                ['productos' => null, 'tipo_in' => $tipo_in, 'proveedor_id' => $tipoContrato['proveedor_id'], 'contrato_id' => $tipoContrato['contrato_id'], 'tipo_contrato_id' => $tipoContrato['tipo_contrato_id']],
            );
            $insumo->products()->sync($productos);
        } else {
            $insumo = Insumos::updateOrCreate(
                ['solicitud_id' => $id],
                ['productos' => $productos, 'tipo_in' => $tipo_in],
            );
        }
    }
    public function convArray($productos)
    {
        $conv = [];
        foreach ($productos as $key => $value) {
            $conv[$value->producto] = array(
                "cantidad"   => $value->cantidad,
                "neto"       => $value->total,
                'created_at' => now(),
                'updated_at' => now(),
            );
        }
        return $conv;
    }
}
