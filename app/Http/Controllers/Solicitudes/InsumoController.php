<?php

namespace App\Http\Controllers\Solicitudes;

use App\Medida;
use App\Insumos;
use App\Product;
use App\LogError;
use App\Proveedor;
use App\Solicitud;
use App\Dependencia;
use App\Departamento;
use App\TipoContrato;
use App\ContratoSuministro;
use App\Traits\InsumoTraits;
use Illuminate\Http\Request;
use App\Exceptions\MontoException;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\InsumoServicioRequest;

class InsumoController extends Controller
{
    use InsumoTraits;
    public function index(Request $request)
    {
        $dependencias = Dependencia::all(['id', 'nombre']);
        $medidas =  Medida::all(['id', 'nombre']);


        if ($request->has('solicitud')) {
            $solicitud = Solicitud::with(['insumo', 'insumo.products', 'insumo.products.medida'])->findOrFail($request->get('solicitud'));
            if ($solicitud->estado !== 'borrador') {
                return redirect()->back()->with('message', 'Esta solicitud no es borrador!');
            }
            $conteo = $request->get('solicitud');
            return view('solicitudes.insumos.index', compact('medidas', 'conteo', 'dependencias', 'solicitud'));
        } else {
            $conteo = null;
            return view('solicitudes.insumos.index', compact('medidas', 'conteo', 'dependencias'));
        }
    }
    public function getDepartamentos(Request $request)
    {
        // funcion para obtener los departamentos dependientes de las dependencias
        $id = $request->id;
        $departamentos = Departamento::onDopendencias($id);
        return response()->json($departamentos, 200);
    }
    public function getContratos()
    {
        $contratos = ContratoSuministro::with(['tipo' => fn ($query) => $query->select('id', 'nombre'), 'proveedor' => fn ($query) => $query->select('id', 'nombre', 'rut'), 'productos'])->getContrato();
        $data =  array('message' => "Contratos cargados satisfactoriamente", 'data' => $contratos);
        return response()->json(collect($data), 200);
    }
    public function store(InsumoServicioRequest $request)
    {
        DB::beginTransaction();
        try {
            $result = $request->edit == 'si' ? $this->updateInsumo($request) : $this->createInsumo($request);
            DB::commit();
        } catch (MontoException $e) {
            DB::rollback();
            $error = LogError::create(['payload' => 'Error al generar una solicitud de insumo', 'exception' => $e->getMessage()]);
            return response()->json(['msg' => $e->getMessage()], 501);
        } catch (\Exception $e) {
            DB::rollback();
            $error = LogError::create(['payload' => 'Error al generar una solicitud de insumo', 'exception' => $e->getMessage()]);
            return response()->json(['msg' => 'Ocurrio un error al realizar el proceso, revisa tu registro de errores'], 501);
        }
        return response()->json($result, 201);
    }
    public function getProveedores()
    {
        $proveedores = Proveedor::all(['id', 'nombre', 'rut']);
        $data =  array('message' => "Proveedores cargados satisfactoriamente", 'data' => $proveedores);
        return response()->json($data, 200);
    }
    public function getProductos(Request $request)
    {
        $id = $request->id;
        $productos = Product::Proveedores($id);
        $data =  array('message' => "Productos cargados satisfactoriamente", 'data' => $productos);
        return response()->json(collect($data), 200);
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
            'insumo'
        ])->find($id);
        // return $solicitud;

        return view('solicitudes.insumos.show', compact('solicitud'));
    }
}
