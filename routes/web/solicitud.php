<?php

use Illuminate\Support\Facades\Route;

Route::prefix('solicitudes')->middleware('auth')->group(function () {
    Route::get('/pdf-solicitud/{solicitud}/{tipo}', 'Solicitudes\SolicitudController@solicitudPdf')->name('pdf-solicitud');
    Route::group(['middleware' => ['role_or_permission:super-admin|insumos']], function () {
        //RUTAS DE USUARIOS
        Route::get('/insumos-y-servicios', 'Solicitudes\InsumoController@index')->name('solicitudes.insumos.index');
        Route::get('/insumos-y-servicios/{solicitud}/show', 'Solicitudes\InsumoController@show')->name('solicitudes.insumos.show');
        Route::post('/insumos-y-servicios', 'Solicitudes\InsumoController@store')->name('solicitudes.insumos.store');
        Route::post('/obtener-departamentos-insumos', 'Solicitudes\InsumoController@getDepartamentos')->name('solicitudes.insumos.departamentos'); //obtener los departamentos insumos
        Route::get('/obtener-contratos-suministros-insumos', 'Solicitudes\InsumoController@getContratos')->name('solicitudes.insumos.contratos'); //obtener los departamentos insumos
        Route::post('/obtener-proveedores-insumos', 'Solicitudes\InsumoController@getProveedores')->name('solicitudes.insumos.proveedores'); //obtener los departamentos insumos
        Route::post('/obtener-productos-insumos', 'Solicitudes\InsumoController@getProductos')->name('solicitudes.insumos.productos');
    });
    Route::group(['middleware' => ['role_or_permission:super-admin|convenios']], function () {
        //RUTAS DE USUARIOS
        Route::get('/convenios', 'Solicitudes\ConveniosController@index')->name('solicitudes.convenios.index');
        Route::get('/convenios/{solicitud}/show', 'Solicitudes\ConveniosController@show')->name('solicitudes.convenios.show');
        Route::post('/convenios', 'Solicitudes\ConveniosController@Store')->name('solicitudes.convenios.store');
        Route::post('/obtener-departamentos-convenio', 'Solicitudes\ConveniosController@getDepartamentos')->name('solicitudes.convenios.departamentos'); //obtener los departamentos convenios
        Route::get('/obtener-contratos-suministros-convenios', 'Solicitudes\ConveniosController@getContratos')->name('solicitudes.convenios.contratos'); //obtener los contratos convenios
        Route::post('/obtener-proveedores-convenios', 'Solicitudes\ConveniosController@getProveedores')->name('solicitudes.convenios.proveedores'); //obtener los departamentos convenios
        Route::post('/obtener-productos-convenios', 'Solicitudes\ConveniosController@getProductos')->name('solicitudes.convenios.productos');
    });
    Route::group(['middleware' => ['role_or_permission:super-admin|solicitud mantenimiento']], function () {
        //RUTAS DE USUARIOS
        Route::get('/mantenimiento', 'Solicitudes\MantenimientoController@index')->name('solicitudes.mantenimiento.index');
        Route::get('/mantenimiento/{solicitud}/show', 'Solicitudes\MantenimientoController@show')->name('solicitudes.mantenimiento.show');
        Route::post('/mantenimiento', 'Solicitudes\MantenimientoController@Store')->name('solicitudes.mantenimiento.store');
        Route::post('/obtener-productos', 'Solicitudes\MantenimientoController@getProductos')->name('solicitudes.mantenimiento.productos');
        Route::post('/obtener-productos-relacionados', 'Solicitudes\MantenimientoController@editProducts')->name('solicitudes.mantenimiento.productos.relacionados');
    });
    Route::group(['middleware' => ['role_or_permission:super-admin|solicitudes']], function () {
        //RUTAS DE USUARIOS
        Route::get('/montos-adjudicacion', 'Solicitudes\SolicitudController@montosAdjudicacion')->name('solicitudes.montos-adjudicacion')->middleware(['permission:editar-monto']);
        Route::get('/editar-montos', 'Solicitudes\SolicitudController@edit')->name('solicitudes.editar-solicitudes')->middleware(['permission:editar-solicitud']);
        Route::get('/contratos-suministros', 'Solicitudes\ContratoSuministroController@index')->name('solicitudes.suministros.index');
        Route::get('/contratos-suministros/{solicitud}/show', 'Solicitudes\ContratoSuministroController@show')->name('solicitudes.suministros.show');
        Route::post('/contratos-suministros', 'Solicitudes\ContratoSuministroController@store')->name('solicitudes.suministros.store');
        Route::post('/obtener-departamentos', 'Solicitudes\ContratoSuministroController@getDepartamentos')->name('solicitudes.suministros.departamentos');
    });
    //RUTAS DE USUARIOS
    Route::get('/mis-solicitudes', 'Solicitudes\SolicitudController@solicitudes')->name('solicitudes.mis-solicitudes');
    Route::get('/mis-borradores', 'Solicitudes\SolicitudController@borradores')->name('solicitudes.mis-borradores');
});
