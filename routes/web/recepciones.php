<?php

use Illuminate\Support\Facades\Route;

Route::prefix('recepciones')->middleware('auth')->group(function () {
    Route::get('/pdf-recepcion/{recepcion}/', 'Recepciones\RecepcionController@getpdf')->name('recepciones.pdf-solicitud');
    //RUTAS DE ORDENES DE COMPRAS
    Route::group(['middleware' => ['role_or_permission:super-admin|recepciones']], function () {
        Route::get('/index', 'Recepciones\RecepcionController@index')->name('recepciones.index');
        Route::get('/create', 'Recepciones\RecepcionController@create')->name('recepciones.create');
        Route::post('/{orden_compra}/store/', 'Recepciones\RecepcionController@store')->name('recepciones.store');

        Route::get('/aprobaciones/finanzas', 'Recepciones\RecepcionController@aprobacionFinanzas')->name('recepciones.aprobaciones.finanzas');
        Route::get('/aprobaciones/abastecimiento', 'Recepciones\RecepcionController@aprobacionAbas')->name('recepciones.aprobaciones.abastecimiento');
        Route::get('/aprobaciones/finanzas/{recepcion}', 'Recepciones\RecepcionController@aprobaciones')->name('recepciones.aprobaciones.finanzas.create')->middleware('role:finanzas');
        Route::post('/aprobaciones/finanzas/{recepcion}', 'Recepciones\RecepcionController@storeFinanzas')->name('recepciones.aprobaciones.finanzas.store')->middleware('role:finanzas');
        Route::get('/aprobaciones/abastecimiento/{recepcion}', 'Recepciones\RecepcionController@aprobaciones')->name('recepciones.aprobaciones.abastecimiento.create')->middleware('role:abastecimiento');
        Route::post('/aprobaciones/abastecimiento/{recepcion}', 'Recepciones\RecepcionController@storeAprobaciones')->name('recepciones.aprobaciones.abastecimiento.store')->middleware('role:abastecimiento');
    });
});
