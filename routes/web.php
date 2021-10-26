<?php

use App\Fpdf\PDF;
use App\Solicitud;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/hola', function () {
    $data = 'insumos';
    $solicitud = Solicitud::with([
        'aprobaciones',
        'dependencia' => function ($query) use ($data) {
            $query->select('id', 'nombre');
        },
        'departamento' => function ($query) use ($data) {
            $query->select('id', 'nombre');
        },
        'contrato',
        'convenio' => function ($query) use ($data) {
            if ($data == 'convenios') {
                $query->with(['products']);
            }
        }, 'insumo' => function ($query) use ($data) {
            if ($data == 'insumos') {
                $query->with(['products']);
            }
        }
    ])->find(16);
    // return $solicitud;
    $datos = array('solicitud' => $solicitud);
    $pdf = PDF::loadView('pdf.invoce', $datos);
    return $pdf->stream();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('index');
