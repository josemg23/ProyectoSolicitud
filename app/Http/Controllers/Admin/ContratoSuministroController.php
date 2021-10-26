<?php

namespace App\Http\Controllers\Admin;

use App\Cuenta;
use App\Medida;
use App\Periodo;
use App\Product;
use App\LogError;
use App\Proveedor;
use App\Solicitud;
use App\TipoContrato;
use App\HistorialCuenta;
use App\HistorialContrato;
use App\ContratoSuministro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Traits\ContratoSuministroTrait;

class ContratoSuministroController extends Controller
{
    use ContratoSuministroTrait;
    public function tiposContrato()
    {
        return view('mantenimiento.tiposcontratos.index');
    }
    public function index()
    {
        return view('mantenimiento.contrato_suministro.index');
    }
    public function create()
    {
        $proveedores = Proveedor::all(['id', 'nombre']);
        $medidas = Medida::all(['id', 'nombre']);
        $tipos = TipoContrato::all(['id', 'nombre']);
        $cuentas = Cuenta::all(['id', 'nombre', 'saldo_a', 'descripcion']);
        $solicitudes = Solicitud::findByTipo('contrato-suministros')->findByEstado('en proceso')->with(['contrato'])->get();
        return view('mantenimiento.contrato_suministro.create', compact('proveedores', 'medidas', 'solicitudes', 'tipos', 'cuentas'));
    }
    public function searchProducto(Request $request)
    {
        $productos = Product::with(['medida'])->getByProveedor($request->id, $request->tipo_contrato_id)->get();
        $data =  array(
            'message' => 'Productos Obtenidos Correctamente',
            'data' => $productos
        );
        return response()->json($data, 200);
    }
    public function searchProveedores(Request $request)
    {
        $tipocontrato = TipoContrato::getProveedores()->find($request->id);
        $data =  array(
            'message' => 'Proveedores Obtenidos Correctamente',
            'data' => $tipocontrato->proveedores
        );
        return response()->json($data, 200);
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $contrato = ContratoSuministro::create($request->except(['productos', 'fecha_inicio_periodo', 'fecha_termino_periodo']));
            $data = array(
                'fecha_inicio_periodo' => $request->fecha_inicio_periodo,
                'fecha_termino_periodo' => $request->fecha_termino_periodo,
                'monto_inicial' => $request->monto_periodo,
                'monto_actual' => $request->monto_periodo,
                'contrato_suministro_id' => $contrato->id
            );
            $periodo = Periodo::create($data);
            $productos = collect($request->productos)->pluck('producto_id');
            $contrato->productos()->sync($productos);
            $detalle = "Monto asignado al Periodo Inicial";
            $historial    = new HistorialContrato(['contrato_suministro_id' => $contrato->id, 'periodo_id' => $periodo->id, 'detalle' => $detalle, 'cantidad' =>  $request->monto_periodo, 'type' => 'ingreso']);
            $contrato->historialesContrato()->save($historial);
            // syncMontoContrato($contrato->id, $request->monto_periodo, 'ingreso');
            // $detalle = "Monto asignado al Contrato de Suministro N° {$contrato->id}";
            // $historial    = new HistorialCuenta(['cuenta_id' => $request->cuenta_id, 'detalle' => $detalle, 'cantidad' =>  $request->monto_periodo, 'type' => 'egreso']);
            // $contrato->historiales()->save($historial);
            // syncMonto($request->cuenta_id, $request->monto_periodo, 'egreso');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $error = LogError::create(['payload' => 'Error al crear un contrato de suministro', 'exception' => $e->getMessage()]);
            throw new \Exception('Ocurrio un error al realizar el proceso, revisa tu registro de errores');
        }

        $data = array(
            "status" => 201,
            "message" => "Contrato Creado Correctamente",
        );
        return response()->json($data, 201);
    }
    public function show($id)
    {
        $contrato = ContratoSuministro::with([
            'solicitud',
            'productos',
            'proveedor',
            'tipo',
            'cuenta',
            'periodos' => fn ($query) =>
            $query->latest()->first()
        ])->find($id);
        $historiales = HistorialContrato::where('contrato_suministro_id', $contrato->id)->where('periodo_id', $contrato->periodos[0]->id)->get();
        // return $historiales;

        return view('mantenimiento.contrato_suministro.show', compact('contrato', 'historiales'));
    }
}
