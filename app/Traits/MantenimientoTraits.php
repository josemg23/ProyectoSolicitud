<?php

namespace App\Traits;

use App\Document;
use App\Solicitud;
use App\Smantenimiento;
use Illuminate\Support\Facades\Auth;

trait MantenimientoTraits
{

    public function createSolicitudMantenimiento($request)
    {

        $solicitud                  = new Solicitud();
        $solicitud->tipo            = 'mantenimiento';
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
        $solicitud->save();

        $prod = $this->convArray(json_decode($request->productos));
        $this->syncMantenimiento($solicitud->id, $request->proveedor_id, $prod);

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



    public function updateSolicitudMantenimiento($request)
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
        $solicitud->save();

        $prod = $this->convArray(json_decode($request->productos));
        $this->synEdit($solicitud->id, $request->proveedor_id, $prod);

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





    public function syncMantenimiento(int $id, int $proveedor_id, $prod)
    {
       

        $con = new Smantenimiento();
        $con->solicitud_id = $id;
        $con->proveedor_id = $proveedor_id;
        $con->save();
        $con->productos()->sync($prod);
    }

    public function synEdit(int $id, int $proveedor_id, $prod)
    {

        $con = Smantenimiento::where('solicitud_id', $id)->first();
        $con->proveedor_id = $proveedor_id;
        $con->save();
        $con->productos()->sync($prod);
    }


    public function convArray($productos)
    {

        $conv = [];
        foreach ($productos as $key => $value) {
            $conv[$value->producto_id] = array(
                "cantidad" => $value->cantidad,
                "neto"   =>  $value->total,
                'created_at'                => now(),
                'updated_at'                => now(),
            );
        }
        return $conv;
    }
}
