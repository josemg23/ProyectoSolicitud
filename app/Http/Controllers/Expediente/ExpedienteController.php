<?php

namespace App\Http\Controllers\Expediente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpedienteController extends Controller
{
    public function index()
    {
        return view('expedientes.index');
    }
    public function create()
    {
        return view('expedientes.create');
    }
}
