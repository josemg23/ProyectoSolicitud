<?php

namespace App\Http\Controllers\Recepciones;

use App\Anexo;
use App\Document;
use App\LogError;
use App\Recepcion;
use App\Solicitud;
use App\Aprobacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\OrdenCompra;
use App\Traits\Pdfs\PdfRecpciones;
use Illuminate\Support\Facades\Auth;
use App\Traits\Recepcion\RecepcionTrait;
use Illuminate\Database\Eloquent\Builder;

class RecepcionController extends Controller
{
    use RecepcionTrait, PdfRecpciones;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ->
        // $solicitudes = Solicitud::get()->append('recepcion');
        // return $solicitudes;
        return view('recepciones.index');
    }
    public function getpdf(Recepcion $recepcion)
    {
        $this->generatePdf($recepcion);
    }
    public function aprobaciones(Recepcion $recepcion)
    {
        if ($recepcion->estado != 'pendiente') {
            abort(403, 'Esta Recepción ya se encuentra aprobada');
        }
        $recepcion->solicitud;
        $vista = $recepcion->aprobacion == 'finanzas' ? 'recepciones.aprobaciones.finanzas.evaluar' : 'recepciones.aprobaciones.abastecimiento.evaluar';
        return view($vista, compact('recepcion'));
    }
    public function aprobacionFinanzas()
    {
        // $recepciones = Recepcion::findByStatus('pendiente')->findByAprobacion('finanzas')->get();
        // // return $recepciones;
        return view('recepciones.aprobaciones.finanzas.index');
    }
    public function storeFinanzas(Recepcion $recepcion, Request $request)
    {
        DB::beginTransaction();
        try {
            if ($recepcion->estado == 'aprobada') {
                throw new \Exception("La Recepcion {$recepcion->id} ya ha sido aprobada", 501);
            }
            $recepcion->estado = $request->estado;
            $recepcion->observacion_aprobacion = $request->observacion;
            $recepcion->aprobacion_id = Auth::id();
            $recepcion->save();
            if ($request->estado == 'aprobada') {

                $this->completarRecepcion($recepcion, $recepcion->orden->solicitud, 'completa', true, $recepcion->diferencia, $recepcion->tipo_diferencia);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $error = LogError::create(['payload' => 'Error al aprobar la recepción de finanzas', 'exception' => "{$e->getMessage()} en la linea {$e->getLine()} del archivo {$e->getTrace()}"]);
            return response()->json(['msg' => 'Ocurrio un error al realizar el proceso, revisa tu registro de errores'], 501);
        }
        return response()->json(['msg' => 'Recepción evaluada satisfactoriamente'], 201);
    }
    public function storeAprobaciones(Recepcion $recepcion, Request $request)
    {
        DB::beginTransaction();
        try {
            if ($recepcion->estado == 'aprobada') {
                throw new \Exception("La Recepcion {$recepcion->id} ya ha sido aprobada", 501);
            }
            $recepcion->estado = $request->estado;
            $recepcion->observacion_aprobacion = $request->observacion;
            $recepcion->aprobacion_id = Auth::id();
            $recepcion->save();
            if ($request->estado == 'aprobada') {
                $this->cancelarRecepcion($recepcion, $recepcion->solicitud, 'ingreso', $this->getActivo($recepcion->solicitud));
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $error = LogError::create(['payload' => 'Error al aprobar la recepción de finanzas', 'exception' => "{$e->getMessage()} en la linea {$e->getLine()} del archivo {$e->getFile()}"]);
            return response()->json(['msg' => 'Ocurrio un error al realizar el proceso, revisa tu registro de errores'], 501);
        }
        if ($request->estado == 'aprobada') {
            if ($request->hasFile('documento')) {
                $archivo = $request->documento;
                $nombre       = time() . '_' . $archivo->getClientOriginalName();
                $urldocumento = '/anexos/' . $nombre;
                $archivo->storeAs('anexos',  $nombre, 'public_upload');
                $documento    = new Anexo(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
                $recepcion->anexo()->save($documento);
            }
        }
        return response()->json(['msg' => 'Recepción evaluada satisfactoriamente'], 201);
    }
    public function aprobacionAbas()
    {
        // $recepciones = Recepcion::findByStatus('pendiente')->findByAprobacion('abastecimiento')->get();
        // // return $recepciones;
        return view('recepciones.aprobaciones.abastecimiento.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $solicitudes = Solicitud::findByEstados(['completada', 'completada-parcial'])
            ->orWhere(function ($query) {
                $query->where('estado', 'recepcion-parcial')
                    ->whereHas('recepciones', function (Builder $q) {
                        $q->where('estado', 'aprobada')
                            ->whereNotIn('estado', ['pendiente'])
                            ->whereNull('aprobacion_id');
                    });
            })
            ->select(['id', 'user_id', 'tipo', 'adquisicion', 'estado', 'total', 'modalidad_compra'])
            ->withSum('ordenes:valor_total as total_ordenes',)
            ->withSum('recepciones:monto_total as total_recepciones')
            ->where('estado', '!=', 'recepcionada')
            ->with([
                'ordenes' => function ($query) {
                    $query->select(['id', 'valor_total', 'solicitud_id', 'num_orden', 'tipo_compra', 'proveedor_id', 'nom_proveedor', 'recepcion'])->whereIn('recepcion', ['pendiente', 'recepcionada-parcial']);
                }, 'solicitante' => function ($query) {
                    $query->select('id', 'nombres');
                }, 'ordenes.recepciones' => function ($query) {
                    $query->select('id', 'orden_compra_id', 'monto_total', 'estado', 'solicitud_id', 'num_documento', 'aprobacion_id')->where('estado', 'aprobada');
                }, 'monto_adj'
            ])
            ->get();
        // ->append(['recepcion']);
        // return $solicitudes;
        return view('recepciones.create', compact('solicitudes'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrdenCompra $ordenCompra, Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->tipo_compra !== 'licitacion') {
                $recepcion =  $this->createRecepcionNormal($ordenCompra, $request);
            } else {
                $recepcion =  $this->createLicitacionPublica($ordenCompra, $request);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $error = LogError::create(['payload' => 'Error al generar la recepción', 'exception' => "{$e->getMessage()} en la linea {$e->getLine()} del archivo {$e->getFile()}"]);
            return response()->json(['msg' => 'Ocurrio un error al realizar el proceso, revisa tu registro de errores'], 501);
        }
        if ($request->hasFile('documento')) {
            $archivo = $request->documento;
            $nombre       = time() . '_' . $archivo->getClientOriginalName();
            $urldocumento = '/recepciones/' . $nombre;
            $archivo->storeAs('recepciones',  $nombre, 'public_upload');
            $documento    = new Document(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
            $recepcion->document()->save($documento);
        }
        return response()->json(['msg' => 'Recepción generada correctamente', 'ruta' => route('recepciones.index')], 201);
    }
}
