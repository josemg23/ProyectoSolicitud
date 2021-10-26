<?php

namespace App\Traits;

use App\Document;
use App\Solicitud;
use App\SolicitudContrato;
use Illuminate\Support\Facades\Auth;

trait ContratoTraits
{
    /**
     * CREAR LA SOLICITUD DE CONTRATOS DESUMINISTROS
     *
     * @param object $request
     * @return array
     */
    public function createSolicitud($request)
    {
        $solicitud                  = new Solicitud;
        $solicitud->tipo            = 'contrato-suministros';
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
        $solicitud->proveedor_id          = $request->proveedor_id;
        $solicitud->save();

        $this->syncContrato($solicitud->id, $request->productos);
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
    public function updateSolicitud($request)
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
        $solicitud->proveedor_id          = $request->proveedor_id;

        $solicitud->save();

        $this->syncContrato($solicitud->id, $request->productos);
        if ($request->hasFile('cotizacion')) {
            if (isset($solicitud->documento)) {
                $image_path = public_path() . $solicitud->documento->archivo;
                unlink($image_path);
                // $solicitud->documento->delete();
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
    /**
     * Relacion de la Solicitud de Contrato
     *
     * @param integer $id
     * @param array $productos
     * @return void
     */
    public function syncContrato(int $id, string $productos)
    {
        $insumo = SolicitudContrato::updateOrCreate(
            ['solicitud_id' => $id],
            ['productos' => $productos]
        );
        // $insumo = new SolicitudContrato();
        // $insumo->solicitud_id = $id;
        // $insumo->productos = $productos;
        // $insumo->save();
    }
}
