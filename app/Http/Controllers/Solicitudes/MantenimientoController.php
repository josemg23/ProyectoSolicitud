<?php

namespace App\Http\Controllers\Solicitudes;

use App\Medida;
use App\Product;
use App\LogError;
use App\Proveedor;
use App\Solicitud;
use App\Dependencia;
use App\Departamento;
use App\Smantenimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\MantenimientoTraits;
use App\Http\Controllers\Controller;
use App\Http\Requests\SolicitudMantenimientoRequest;

class MantenimientoController extends Controller
{
    use MantenimientoTraits;

    public function index(Request $request)
    {
        $dependencias = Dependencia::all(['id', 'nombre']);
        $proveedores = Proveedor::all(['id', 'nombre', 'rut']);

        if ($request->has('solicitud')) {
            $solicitud = Solicitud::with(['mantenimiento', 'mantenimiento.productos', 'mantenimiento.productos.medida'])->findOrFail($request->get('solicitud'));
            //return $solicitud;
            if ($solicitud->estado != 'borrador') {
                return redirect()->back()->with('message', 'Esta solicitud no es borrador!');
            }
            if ($solicitud->tipo == 'mantenimiento') {
                $product = Product::where('proveedor_id', $solicitud->mantenimiento->proveedor_id)->get();
            }
            $conteo = $request->get('solicitud');
            return view('solicitudes.mantenimiento.index', compact('conteo', 'dependencias', 'proveedores', 'solicitud', 'product'));
        } else {
            $conteo = null;
            return view('solicitudes.mantenimiento.index', compact('conteo', 'dependencias', 'proveedores'));
        }

        //    return $solicitud;
    }

    public function getProductos(Request $request)
    {

        $id = $request->id;
        $productos = Product::Proveedores($id);
        return response()->json($productos, 200);
    }

    public function Store(SolicitudMantenimientoRequest $request)
    {
        DB::beginTransaction();
        try {
            $result = $request->edit == 'si' ? $this->updateSolicitudMantenimiento($request) : $this->createSolicitudMantenimiento($request);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $error = LogError::create(['payload' => 'Error al generar una solicitud de Mantenimiento', 'exception' => "{$e->getMessage()} en la linea {$e->getLine()} del archivo {$e->getFile()}"]);
            throw new \Exception('Ocurrio un error al realizar el proceso, revisa tu registro de errores');
        }
        return response()->json($result, 201);
        // return response()->json($this->createSolicitudMantenimiento($request), 201);
    }
    public function show($id)
    {
        $solicitud = Solicitud::withTrashed()->with([
            'documento',
            'aprobaciones',
            'aprobaciones.encargado' => function ($query) {
                $query->select('id', 'nombres', 'email', 'fono');
            },
            'solicitante',
            'dependencia' => function ($query) {
                $query->select('id', 'nombre');
            },
            'departamento' => function ($query) {
                $query->select('id', 'nombre');
            },
            'mantenimiento',
            'mantenimiento.productos'

        ])->find($id);
        // return $solicitud;

        return view('solicitudes.mantenimiento.show', compact('solicitud'));
    }
}
