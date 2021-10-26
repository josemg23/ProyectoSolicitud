<?php

namespace App\Traits\Evaluacion;

use App\Solicitud;
use App\Aprobacion;
use App\HistorialCuenta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

trait EvaluacionDireccionTrait
{
    public function aprobacionMasiva($solicitudes)
    {
        $rol = getRoleName();
        $tipo = $rol == 'director' ? 'direccion' : $rol;

        foreach ($solicitudes as $key => $solicitud) {
            $sol = Solicitud::whereDoesntHave('aprobaciones', function (Builder $q3) {
                $q3->where('tipo', 'direccion');
            })->find($solicitud);
            if (isset($sol)) {
                $aprobacion = new Aprobacion;
                $aprobacion->tipo = $tipo;
                $aprobacion->solicitud_id = $solicitud;
                $aprobacion->estado = 'aprobado';
                $aprobacion->observacion = 'OK';
                $aprobacion->encargado_id = Auth::id();
                $aprobacion->save();
            }
        }
    }
}
