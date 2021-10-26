<?php

use Illuminate\Support\Facades\Route;

Route::prefix('evaluacion')->middleware('auth')->group(function () {
    //SOLICITUDES GENERALES

    Route::get('/criterios', 'Evaluaciones\EvaluacionController@criterios')->name('evaluacion.criterios');
    Route::get('/ejecutivos', 'Evaluaciones\EvaluacionController@ejecutivos')->name('evaluacion.ejecutivos');
    Route::get('/departamentos', 'Evaluaciones\EvaluacionController@departamentos')->name('evaluacion.departamentos');
    Route::get('/proveedores', 'Evaluaciones\EvaluacionController@proveedores')->name('evaluacion.proveedores');
    Route::group(['middleware' => ['role_or_permission:super-admin|e-insumos']], function () {
        //RUTAS DE EVALUACIONES
        Route::get('/insumos-y-servicios', 'Evaluaciones\InsumoServicioController@index')->name('evaluacion.insumo.index');
        Route::get('/insumos-y-servicios/{solicitud}/aprobacion', 'Evaluaciones\InsumoServicioController@aprobacion')->name('evaluacion.insumo.aprobacion');
        Route::post('/insumos-y-servicios/{solicitud}/aprobacion/finanzas', 'Evaluaciones\InsumoServicioController@finanzas')->name('evaluacion.insumo.finanzas');
        Route::post('/insumos-y-servicios/{solicitud}/aprobacion/admin-gestion', 'Evaluaciones\InsumoServicioController@adminGestion')->name('evaluacion.insumo.admin-gestion');
        Route::post('/insumos-y-servicios/{solicitud}/aprobacion/direccion', 'Evaluaciones\InsumoServicioController@direccion')->name('evaluacion.insumo.direccion');
        Route::post('/insumos-y-servicios/{solicitud}/aprobacion/abastecimiento', 'Evaluaciones\InsumoServicioController@abastecimiento')->name('evaluacion.insumo.abastecimiento');
    });

    //RUTAS DE CONVENIO
    Route::group(['middleware' => ['role_or_permission:super-admin|e-convenios']], function () {
        Route::get('/convenios', 'Evaluaciones\ConvenioController@index')->name('evaluacion.convenio.index');
        Route::get('/convenios/{solicitud}/aprobacion', 'Evaluaciones\ConvenioController@aprobacion')->name('evaluacion.convenios.aprobacion');
        Route::post('/convenios/{solicitud}/aprobacion/encargado-convenio', 'Evaluaciones\ConvenioController@encargadoConvenio')->name('evaluacion.convenios.encargado-convenio');
        Route::post('/convenios/{solicitud}/aprobacion/finanzas', 'Evaluaciones\ConvenioController@finanzas')->name('evaluacion.convenios.finanzas');
        Route::post('/convenios/{solicitud}/aprobacion/admin-gestion', 'Evaluaciones\ConvenioController@adminGestion')->name('evaluacion.convenios.admin-gestion');
        Route::post('/convenios/{solicitud}/aprobacion/direccion', 'Evaluaciones\ConvenioController@direccion')->name('evaluacion.convenios.direccion');
        Route::post('/convenios/{solicitud}/aprobacion/abastecimiento', 'Evaluaciones\ConvenioController@abastecimiento')->name('evaluacion.convenios.abastecimiento');
    });

    //RUTAS DE MANTENIMIENTO
    Route::group(['middleware' => ['role_or_permission:super-admin|e-mantenimientos']], function () {
        Route::get('/mantenimientos', 'Evaluaciones\MantenimientoController@index')->name('evaluacion.mantenimiento.index');
        Route::get('/mantenimientos/{solicitud}/aprobacion', 'Evaluaciones\MantenimientoController@aprobacion')->name('evaluacion.mantenimientos.aprobacion');
        Route::post('/mantenimientos/{solicitud}/aprobacion/encargado-mantenimiento', 'Evaluaciones\MantenimientoController@encargadoMantenimiento')->name('evaluacion.mantenimientos.encargado-convenio');
        Route::post('/mantenimientos/{solicitud}/aprobacion/finanzas', 'Evaluaciones\MantenimientoController@finanzas')->name('evaluacion.mantenimientos.finanzas');
        Route::post('/mantenimientos/{solicitud}/aprobacion/admin-gestion', 'Evaluaciones\MantenimientoController@adminGestion')->name('evaluacion.mantenimientos.admin-gestion');
        Route::post('/mantenimientos/{solicitud}/aprobacion/direccion', 'Evaluaciones\MantenimientoController@direccion')->name('evaluacion.mantenimientos.direccion');
        Route::post('/mantenimientos/{solicitud}/aprobacion/abastecimiento', 'Evaluaciones\MantenimientoController@abastecimiento')->name('evaluacion.mantenimientos.abastecimiento');
    });

    //RUTAS DE CONTRATO DE SUMINISTRO
    Route::group(['middleware' => ['role_or_permission:super-admin|e-contratos suministros']], function () {
        Route::get('/contrato-suministros', 'Evaluaciones\ContratoSuministroController@index')->name('evaluacion.contrato-suministro.index');
        Route::get('/contrato-suministros/{solicitud}/aprobacion', 'Evaluaciones\ContratoSuministroController@aprobacion')->name('evaluacion.contrato-suministro.aprobacion');
        Route::post('/contrato-suministros/{solicitud}/aprobacion/finanzas', 'Evaluaciones\ContratoSuministroController@finanzas')->name('evaluacion.contrato-suministro.finanzas');
        Route::post('/contrato-suministros/{solicitud}/aprobacion/admin-gestion', 'Evaluaciones\ContratoSuministroController@adminGestion')->name('evaluacion.contrato-suministro.admin-gestion');
        Route::post('/contrato-suministros/{solicitud}/aprobacion/direccion', 'Evaluaciones\ContratoSuministroController@direccion')->name('evaluacion.contrato-suministro.direccion');
        Route::post('/contrato-suministros/{solicitud}/aprobacion/abastecimiento', 'Evaluaciones\ContratoSuministroController@abastecimiento')->name('evaluacion.contrato-suministro.abastecimiento');
    });
});
