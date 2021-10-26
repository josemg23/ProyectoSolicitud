<?php

namespace App\Http\Controllers\Decretos;

use App\Decreto;
use App\Document;
use App\LogError;
use App\Solicitud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DecretosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('decretos.index');
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
            ->where('estado', 'aprobado')
            ->findByTipo('contrato-suministros')
            ->get();
        // return $solicitudes;
        return view('decretos.create', compact('solicitudes'));
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
            $decreto = new Decreto();
            $decreto->solicitud_id = $request->solicitud_id;
            $decreto->num_decreto = $request->num_decreto;
            $decreto->encargado_id = Auth::id();
            $decreto->save();
            $solicitud = Solicitud::find($request->solicitud_id);
            $solicitud->estado = 'completada';
            $solicitud->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $error = LogError::create(['payload' => 'Error al generar un Decreto de Adjudicación', 'exception' => "{$e->getMessage()} en la linea {$e->getLine()} del archivo {$e->getFile()}"]);
            throw new \Exception('Ocurrio un error al realizar el proceso, revisa tu registro de errores');
        }
        if ($request->hasFile('documento')) {
            $archivo = $request->documento;
            $nombre       = time() . '_' . $archivo->getClientOriginalName();
            $urldocumento = '/decretos/' . $nombre;
            $archivo->storeAs('decretos',  $nombre, 'public_upload');
            $documento    = new Document(['nombre' => $archivo->getClientOriginalName(), 'extension' => pathinfo($urldocumento, PATHINFO_EXTENSION), 'archivo' => $urldocumento]);
            $decreto->documento()->save($documento);
        }

        return response()->json(['msg' => 'Decreto de Adjudicación Generado Correctamente', 'ruta' => route('decretos.index')], 201);
    }
}
