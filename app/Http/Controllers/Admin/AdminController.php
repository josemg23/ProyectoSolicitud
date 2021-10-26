<?php

namespace App\Http\Controllers\Admin;

use App\Solicitud;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $trabajador = User::role('trabajador')->count();
        // $administradores = User::role('admin')->count();
        $insumos = Solicitud::findByTipoIndex('insumos')->count();
        $convenios = Solicitud::findByTipoIndex('convenios')->count();
        $mantenimiento = Solicitud::findByTipoIndex('mantenimiento')->count();
        $contratos = Solicitud::findByTipoIndex('contrato-suministros')->count();
        $misSolicitudes = Solicitud::where('user_id', Auth::id())->count();
        return view('admin.index', compact('insumos', 'convenios', 'mantenimiento', 'contratos', 'misSolicitudes'));
    }
    public function perfil()
    {
        return view('admin.perfil');
    }
}
