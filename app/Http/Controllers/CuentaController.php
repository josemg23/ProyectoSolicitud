<?php

namespace App\Http\Controllers;

use App\Cuenta;
use Illuminate\Http\Request;

class CuentaController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('mantenimiento.cuenta.index');
    }


    /**
     *  ruta de mantenimiento de cuenta
     */

    public function index1()
    {
        return view('mantenimiento.unidades.index');
    }
    public function show(Cuenta $cuenta)
    {
        return view('mantenimiento.cuenta.show', compact('cuenta'));
    }
}
