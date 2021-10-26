<?php

namespace App\Http\Controllers\Solicitudes;

use App\Medida;
use App\Product;
use App\LogError;
use App\Proveedor;
use App\Solicitud;
use App\Dependencia;
use App\Departamento;
use App\SolicitudContrato;
use Illuminate\Http\Request;
use App\Traits\ContratoTraits;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContratoSuministroRequest;

class ContratoSuministroController extends Controller
{
    use ContratoTraits;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dependencias = Dependencia::all(['id', 'nombre']);
        $medidas = Medida::all(['id', 'nombre']);
        $proveedores = Proveedor::all(['id', 'nombre', 'rut']);
        // return $proveedores;


        if ($request->has('solicitud')) {
            $solicitud = Solicitud::with(['contrato'])->findOrFail($request->get('solicitud'));
            if ($solicitud->estado !== 'borrador') {
                return redirect()->back()->with('message', 'Esta solicitud no es borrador!');
            }
            $conteo = $request->get('solicitud');
            return view('solicitudes.contrato_suministro.index', compact('medidas', 'dependencias', 'solicitud', 'conteo', 'proveedores'));
        } else {
            $conteo = null;
            return view('solicitudes.contrato_suministro.index', compact('medidas', 'dependencias', 'conteo', 'proveedores'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * METODO PARA CREAR UNA  NUEVA SOLICITUD.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContratoSuministroRequest $request)
    {
        DB::beginTransaction();
        try {
            // return $request->all();
            $result = $request->edit == 'si' ? $this->updateSolicitud($request) : $this->createSolicitud($request);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $error = LogError::create(['payload' => 'Error al generar una solicitud de contrato de suministro', 'exception' => $e->getMessage()]);
            throw new \Exception('Ocurrio un error al realizar el proceso, revisa tu registro de errores');
        }
        return response()->json($result, 201);
    }

    public function getDepartamentos(Request $request)
    {
        $id = $request->id;
        $departamentos = Departamento::onDopendencias($id);
        return response()->json($departamentos, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            'contrato'
        ])->find($id);
        // return $solicitud;

        return view('solicitudes.contrato_suministro.show', compact('solicitud'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
