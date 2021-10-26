<?php

namespace App\Http\Controllers\Evaluaciones;

use App\Cuenta;
use App\LogError;
use App\Solicitud;
use App\Aprobacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Traits\Evaluacion\EvaluacionContratoTrait;

class ContratoSuministroController extends Controller
{
    use EvaluacionContratoTrait;

    public function index()
    {
        return view('evaluaciones.contrato_suministro.index');
    }
    public function aprobacion($id)
    {
        $cuentas = Cuenta::select('id', 'nombre', 'descripcion', 'saldo_a')->get();
        // return $cuentas;
        $solicitud = Solicitud::with([
            'documento',
            'solicitante',
            'dependencia' => function ($query) {
                $query->select('id', 'nombre');
            },
            'departamento' => function ($query) {
                $query->select('id', 'nombre');
            },
            'contrato'
        ])->where('estado', '!=', 'rechazada')->findOrFail($id);
        $estados = $this->getStatus();
        return view('evaluaciones.contrato_suministro.aprobacion', compact('solicitud', 'cuentas', 'estados'));
    }
    public function finanzas(Solicitud $solicitud, Request $request)
    {
        DB::beginTransaction();
        try {
            $aprobacion = new Aprobacion;
            $aprobacion->tipo = getRoleName();
            $aprobacion->solicitud_id = $solicitud->id;
            $aprobacion->estado = $request->estado;
            $aprobacion->observacion = $request->observacion;
            $aprobacion->encargado_id = Auth::id();
            $aprobacion->multiple = $request->multiple ? true : false;
            $aprobacion->rechazo_id = $request->estado == 'rechazado' ?  $request->rechazo_id : null;

            if ($request->has('cuenta_id')) {
                $aprobacion->cuenta_id = $request->cuenta_id;
            }
            $aprobacion->save();
            if ($request->estado == 'aprobado') {
                if ($request->multiple) {
                    $this->asignarCuentas($aprobacion, $request->cuentas, $solicitud);
                }
            } else {
                $solicitud->estado = 'rechazada';
                $solicitud->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $error = LogError::create(['payload' => "Error al aprobar la solicitud de finanzas en la linea {$e->getLine()} del archivo {$e->getFile()}", 'exception' => $e->getMessage()]);
            throw new \Exception('Ocurrio un error al realizar el proceso, revisa tu registro de errores');
        }

        return response()->json(['mensaje' => 'Aprobación realizada correctamente'], 201);
    }
    public function adminGestion(Solicitud $solicitud, Request $request)
    {
        $aprobacion = new Aprobacion;
        $aprobacion->tipo = 'administracion-gestion';
        $aprobacion->solicitud_id = $solicitud->id;
        $aprobacion->estado = $request->estado;
        $aprobacion->observacion = $request->observacion;
        $aprobacion->encargado_id = Auth::id();
        $aprobacion->rechazo_id = $request->estado == 'rechazado' ?  $request->rechazo_id : null;
        $aprobacion->save();
        if ($request->estado == 'rechazado') {
            $solicitud->estado = 'rechazada';
            $solicitud->save();
        }
        return response()->json(['mensaje' => 'Aprobación realizada correctamente'], 201);
    }
    public function direccion(Solicitud $solicitud, Request $request)
    {
        $aprobacion = new Aprobacion;
        $aprobacion->tipo = 'direccion';
        $aprobacion->solicitud_id = $solicitud->id;
        $aprobacion->estado = $request->estado;
        $aprobacion->observacion = $request->observacion;
        $aprobacion->encargado_id = Auth::id();
        $aprobacion->rechazo_id = $request->estado == 'rechazado' ?  $request->rechazo_id : null;
        $aprobacion->save();
        if ($request->estado == 'rechazado') {
            $solicitud->estado = 'rechazada';
            $solicitud->save();
        }
        return response()->json(['mensaje' => 'Aprobación realizada correctamente'], 201);
    }
    public function abastecimiento(Solicitud $solicitud, Request $request)
    {
        DB::beginTransaction();
        try {
            $aprobacion = new Aprobacion;
            $aprobacion->tipo = 'abastecimiento';
            $aprobacion->solicitud_id = $solicitud->id;
            $aprobacion->estado = $request->estado;
            $aprobacion->observacion = $request->observacion;
            $aprobacion->encargado_id = Auth::id();
            $aprobacion->modalidad_compra = $request->tipo_compra;
            $aprobacion->rechazo_id = $request->estado == 'rechazado' ?  $request->rechazo_id : null;
            $aprobacion->save();
            if ($request->estado == 'aprobado') {
                // $solicitud->proveedor_id = $request->proveedor_id;
                $solicitud->estado = 'aprobado';
                $solicitud->modalidad_compra = $request->tipo_compra;
                $solicitud->ejecutivo_id = $request->ejecutivo_id;
                $solicitud->save();
            } elseif ($request->estado == 'rechazado') {
                $solicitud->estado = 'rechazada';
                $solicitud->save();
            }
            if ($request->tipo_compra == 'licitacion') {
                if ($request->has('criterios')) {
                    $this->storeCriterios($request->criterios, $solicitud);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $error = LogError::create(['payload' => "Error al aprobar la solicitud de abastecimiento, en la linea {$e->getLine()} del archivo {$e->getFile()}", 'exception' => $e->getMessage()]);
            throw new \Exception('Ocurrio un error al realizar el proceso, revisa tu registro de errores');
        }
        return response()->json(['mensaje' => 'Aprobación realizada correctamente'], 201);
    }
}
