<?php

namespace App\Http\Controllers\Ordenes;

use App\Document;
use App\LogError;
use App\Proveedor;
use App\Solicitud;
use App\Aprobacion;
use App\FileOrden;
use App\OrdenCompra;
use Illuminate\Http\Request;
use App\Http\Requests\XmlRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\MontoAdjudicacion;
use App\Traits\Orden\OrdenCompraTrait;
use Illuminate\Support\Facades\Auth;

class OrdenesCompraController extends Controller
{
    use OrdenCompraTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ordenes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $solicitudes = Solicitud::select('id', 'tipo', 'adquisicion', 'total', 'estado')
            ->where('ejecutivo_id', Auth::id())
            ->whereIn('estado', ['aprobado', 'completada-parcial'])
            ->whereNotIn('tipo', ['contrato-suministros'])
            ->with([
                'aprobaciones' => fn ($query) => $query->whereIn('tipo', ['finanzas', 'abastecimiento'])->where('estado', 'aprobado'),
                'monto_adj',
                'ordenes' => fn ($query) => $query->withSum('recepciones:monto_total as total_recepcionado')
            ])
            ->get();
        // return $solicitudes;
        return view('ordenes.create', compact('solicitudes'));
    }

    public function getCuentas(Aprobacion $aprobacion)
    {
        return response()->json(['msg' => 'Cuentas cargadas', 'cuentas' => $aprobacion->cuentas], 200);
    }
    public function proveedores()
    {
        $proveedores = Proveedor::select('id', 'nombre', 'rut')->get();
        return response()->json(['mensaje' => 'Proveedores cargados correctamente', 'data' => $proveedores], 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $ordenCompra = new OrdenCompra();
            $ordenCompra->solicitud_id = $request->solicitud_id;
            $ordenCompra->valor_total = $request->total;
            $ordenCompra->tipo_compra = $request->tipo_compra;
            $ordenCompra->num_orden = $request->orden_compra;
            $ordenCompra->encargado_id = Auth::id();
            if ($request->tipo_compra == 'compra-menor' || $request->tipo_compra == 'moneda') {
                $ordenCompra->proveedor_id = $request->proveedor_id;
            } else {
                $ordenCompra->xml_data = $request->jsonxml;
                $ordenCompra->codigo_proveedor = $request->rut;
                $ordenCompra->nom_proveedor = $request->proveedor;
            }
            if ($request->has('monto_adjudicacion')) {
                $monto = new MontoAdjudicacion;
                $monto->solicitud_id = $request->solicitud_id;
                $monto->monto = $request->monto_adjudicacion;
                if ($request->has('multiples_ordenes')) {
                    $monto->multiple = true;
                } else {
                    $monto->multiple = false;
                }
                $monto->save();
            }
            $ordenCompra->save();
            $solicitud = Solicitud::find($request->solicitud_id);
            if ($request->tipo_compra == 'licitacion' && $request->metodo == 'guardar') {
                $solicitud->estado = 'completada-parcial';
                $solicitud->save();
            } else if ($request->tipo_compra == 'licitacion' && $request->metodo == 'finalizar' || $request->tipo_compra !== 'licitacion' && $request->metodo == 'guardar') {
                if ($request->has('diferencia')) {
                    if ($request->has('multiple')) {
                        $this->asignarCuentas($ordenCompra, json_decode($request->cuentas), $request->operacion);
                    } else {
                        $diferencia_monto = $solicitud->total > $ordenCompra->valor_total ? $solicitud->total -
                            $ordenCompra->valor_total : $ordenCompra->valor_total - $solicitud->total;
                        $this->setHistorial($ordenCompra,  $request->cuenta_id,  $request->operacion, $diferencia_monto);
                    }
                }
                $solicitud->estado = 'completada';
                $solicitud->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $error = LogError::create(['payload' => 'Error al generar una Orden de Compra', 'exception' => $e->getMessage()]);
            throw new \Exception('Ocurrio un error al realizar el proceso, revisa tu registro de errores');
        }
        if ($request->tipo_compra == 'compra-menor' || $request->tipo_compra == 'moneda') {
            if ($request->hasFile('pdf')) {
                $archivo = $request->pdf;
                $nombre       = time() . '_' . $archivo->getClientOriginalName();
                $urldocumento = '/orden_compras/' . $nombre;
                $archivo->storeAs('orden_compras',  $nombre, 'public_upload');
                $documento    = new FileOrden(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
                $ordenCompra->fileorden()->save($documento);
            }
        } else {
            if ($request->hasFile('xml')) {
                $archivo = $request->xml;
                $nombre       = time() . '_' . $archivo->getClientOriginalName();
                $urldocumento = '/orden_compras/' . $nombre;
                $archivo->storeAs('orden_compras',  $nombre, 'public_upload');
                $documento    = new FileOrden(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
                $ordenCompra->fileorden()->save($documento);
            }
        }
        if ($request->hasFile('anexo')) {
            $archivo = $request->anexo;
            $nombre       = time() . '_' . $archivo->getClientOriginalName();
            $urldocumento = '/orden_compras/' . $nombre;
            $archivo->storeAs('orden_compras',  $nombre, 'public_upload');
            $documento    = new Document(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
            $ordenCompra->documento()->save($documento);
        }

        return response()->json(['msg' => 'Orden de Compra generada correctamente', 'ruta' => route('ordenes.index')], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function readXml(XmlRequest $request)
    {
        // $xmlString = file_get_contents(public_path('sample.xml'));
        if ($request->hasFile('xml')) {
            $xmlString = $request->xml;
            // $xmlString = file_get_contents(public_path('/xml/sample.xml'));
            $xmlObject = simplexml_load_file($xmlString);
            $json = json_encode($xmlObject);
            $phpArray = json_decode($json, true);
            if (isset($phpArray['OrdersList']['Order']['OrderHeader']['OrderNumber']['BuyerOrderNumber'])) {
                return response()->json($phpArray, 200);
            } else {
                return response()->json(['msg' => 'El archivo xml no es una orden de compra'], 501);
            }
        } else {
            return response()->json(['msg' => 'No has enviado un archivo XML'], 501);
        }
    }
}
