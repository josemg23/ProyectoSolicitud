<?php

namespace App\Traits;

use App\Document;
use App\Solicitud;
use App\SolicitudConvenio;
use App\ContratoSuministro;
use App\Exceptions\MontoException;
use Illuminate\Support\Facades\Auth;

trait ConvenioTraits
{

    public function createSolicitudConvenio($request)
    {

        $solicitud                  = new Solicitud();
        $solicitud->tipo            = 'convenios';
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

        if ($request->tipo_c == 'contrato') {
            $contrato = ContratoSuministro::find($request->contrato_id);
            if ($request->total > $contrato->monto_actual) {
                throw new MontoException('Hubo un cambio en el monto del Contrato de Suministro mientras se realizaba el proceso, el total es superior al monto');
            }
            $tipoContrato = array(
                "tipo_contrato_id" => $request->tipo_contrato_id,
                "proveedor_id" => $request->proveedor_id,
                "contrato_id" => $request->contrato_id,
            );
            $productos = $this->convArray(json_decode($request->productos));
        }


        $this->syncConvenio($solicitud->id, $request->tipo_c, $request->convenio_id, $productos, $tipoContrato);

        if ($request->hasFile('cotizacion')) {
            $archivo = $request->cotizacion;
            $nombre       = time() . '_' . $archivo->getClientOriginalName();
            $urldocumento = '/insumos/' . $nombre;
            $archivo->storeAs('insumos',  $nombre, 'public_upload');
            $documento    = new Document(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
            $solicitud->documento()->save($documento);
        }

        $response = array('mensaje' => "Registro Realizado Correctamente");
        return $response;
    }

    public function updateSolicitudConvenio($request)
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

        if ($request->tipo_c == 'contrato') {
            $contrato = ContratoSuministro::find($request->contrato_id);
            if ($request->total > $contrato->monto_actual) {
                throw new MontoException('Hubo un cambio en el monto del Contrato de Suministro mientras se realizaba el proceso, el total es superior al monto');
            }
            $tipoContrato = array(
                "tipo_contrato_id" => $request->tipo_contrato_id,
                "proveedor_id" => $request->proveedor_id,
                "contrato_id" => $request->contrato_id,
            );
            $productos = $this->convArray(json_decode($request->productos));
        }


        $this->syncConvenio($solicitud->id, $request->tipo_c, $request->convenio_id, $productos, $tipoContrato);

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

        //return $request;
        $response = array('mensaje' => "Registro Actualizado Correctamente");
        return $response;
    }



    public function syncConvenio($id,  $tipo_c, $convenio_id,  $productos,  $tipoContrato)
    {

        if ($tipo_c == 'contrato') {
            $convenio = SolicitudConvenio::updateOrCreate(
                ['solicitud_id' => $id],
                ['proveedor_id' => $tipoContrato['proveedor_id'], 'tipo_c' => $tipo_c, 'contrato_id' => $tipoContrato['contrato_id'], 'tipo_contrato_id' => $tipoContrato['tipo_contrato_id']],
            );
            $convenio->products()->sync($productos);
        } else if ($tipo_c == 'convenio') {
            $convenio = SolicitudConvenio::updateOrCreate(
                ['solicitud_id' => $id, 'convenio_id' => $convenio_id],
                ['productos' => $productos, 'tipo_c' => $tipo_c]
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
