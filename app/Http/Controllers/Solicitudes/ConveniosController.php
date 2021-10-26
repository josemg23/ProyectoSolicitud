<?php

namespace App\Http\Controllers\Solicitudes;

use App\Medida;
use App\Product;
use App\Convenio;
use App\LogError;
use App\Proveedor;
use App\Solicitud;
use App\Dependencia;
use App\Departamento;
use App\ContratoSuministro;
use Illuminate\Http\Request;
use App\Traits\ConvenioTraits;
use App\Exceptions\MontoException;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ConvenioRequest;

class ConveniosController extends Controller
{
    use ConvenioTraits;

    public function index(Request $request)
    {

        $dependencias = Dependencia::all(['id', 'nombre']);
        $convenios = Convenio::all(['id', 'nombre']);
        $medidas = Medida::all(['id', 'nombre']);

        if ($request->has('solicitud')) {
            $solicitud = Solicitud::with(['convenio', 'convenio.products', 'convenio.products.medida'])->findOrFail($request->get('solicitud'));
            if ($solicitud->estado != 'borrador') {
                return redirect()->back()->with('message', 'Esta solicitud no es borrador!');
            }
            $conteo = $request->get('solicitud');
            return view('solicitudes.convenios.index', compact('conteo', 'dependencias', 'convenios', 'medidas', 'solicitud'));
        } else {
            $conteo = null;
            return view('solicitudes.convenios.index', compact('conteo', 'dependencias', 'convenios', 'medidas'));
        }
    }

    public function getContratos()
    {

        $contratos = ContratoSuministro::with(['tipo' => fn ($query) => $query->select('id', 'nombre'), 'proveedor' => fn ($query) => $query->select('id', 'nombre', 'rut'), 'productos'])->getContrato();
        $data =  array('message' => "Contratos cargados satisfactoriamente", 'data' => $contratos);

        return response()->json(collect($data), 200);
    }


    public function Store(ConvenioRequest $request)
    {
        DB::beginTransaction();
        try {
            $result = $request->edit == 'si' ? $this->updateSolicitudConvenio($request) : $this->createSolicitudConvenio($request);
            //return $request;
            DB::commit();
        } catch (MontoException $e) {
            DB::rollback();
            $error = LogError::create(['payload' => 'Error al generar una solicitud de  Convenio', 'exception' => $e->getMessage()]);
            return response()->json(['msg' => $e->getMessage()], 501);
        } catch (\Exception $e) {
            DB::rollback();
            $error = LogError::create(['payload' => 'Error al generar una solicitud DE Convenio', 'exception' => $e->getMessage()]);
            return response()->json(['msg' => 'Ocurrio un error al realizar el proceso, revisa tu registro de errores'], 501);
        }
        return response()->json($result, 201);
    }

    public function getDepartamentos(Request $request)
    {
        $id = $request->id;
        $departamentos = Departamento::onDopendencias($id);
        return response()->json($departamentos, 200);
    }




    public function getProveedores(Request $request)
    {
        $proveedores = Proveedor::findByTipo($request->id);
        $data =  array('message' => "Proveedores cargados satisfactoriamente", 'data' => $proveedores);
        return response()->json(collect($data), 200);
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
            'convenio'
        ])->find($id);
        // return $solicitud;

        return view('solicitudes.convenios.show', compact('solicitud'));
    }
}
