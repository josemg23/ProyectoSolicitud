<?php

use Illuminate\Support\Facades\Route;

Route::prefix('reportes')->middleware('auth')->group(function () {
    //RUTAS DE REPORTES DE SOLICITUDES
    Route::group(['middleware' => ['role_or_permission:super-admin|reportes']], function () {
        Route::get('/reporte-mis-solicitudes', 'Reportes\ReporteController@Reporte_solicitud')->name('reportes.solicitudes'); //reporte de solicitudes
        Route::get('/reporte-solicitudes-convenios', 'Reportes\ReporteController@Reporte_solicitud_convenio')->name('reportes.solicitudes.convenio'); //reporte de solicitudes convenios
        Route::get('/reporte-solicitudes-insumos', 'Reportes\ReporteController@Reporte_solicitud_insumos')->name('reportes.solicitudes.insumos'); //reporte de solicitudes  insumos
        Route::get('/reporte-solicitudes-mantenimiento', 'Reportes\ReporteController@Reporte_solicitud_mantenimiento')->name('reportes.solicitudes.mantenimiento'); //reporte de solicitudes mantenimiento
        Route::get('/reporte-solicitudes-contrato-suministro', 'Reportes\ReporteController@Reporte_solicitud_contrato_suministro')->name('reportes.solicitudes.contrato.suministro'); //reporte de solicitudes mantenimiento

    });
});
