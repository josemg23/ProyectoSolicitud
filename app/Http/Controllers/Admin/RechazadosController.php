<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Rechazo;
use Illuminate\Http\Request;

class RechazadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mantenimiento.rechazado.index');
    }
}
