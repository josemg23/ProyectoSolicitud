<?php

namespace App\Http\Controllers\Evaluaciones;

use App\User;
use App\Criterio;
use App\Proveedor;
use App\Departamento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluacionController extends Controller
{
    public function departamentos()
    {
        $departamentos = Departamento::select('id', 'nombre')->get();
        return response()->json(['mensaje' => 'Departamentos cargados correctamente', 'departamentos' => $departamentos], 200);
    }
    public function proveedores()
    {
        $proveedores = Proveedor::select('id', 'nombre', 'rut')->get();
        return response()->json(['mensaje' => 'Proveedores cargados correctamente', 'data' => $proveedores], 200);
    }
    public function ejecutivos(Request $request)
    {
        $ejecutivos = User::select('id', 'nombres')->role('ejecutivo-compras')->get();
        return response()->json(['mensaje' => 'Ejecutivos Cargados Correctamente', 'data' => $ejecutivos], 200);
    }
    public function criterios()
    {
        $criterios = Criterio::select('id', 'nombre')->get();
        return response()->json(['mensaje' => 'Criterios Cargados Correctamente', 'data' => $criterios], 200);
    }
}
