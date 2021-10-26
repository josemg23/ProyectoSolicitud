<?php

use Illuminate\Support\Facades\Route;

Route::prefix('expedientes')->middleware('auth')->group(function () {
    //RUTAS DE EXPEDIENTES DE PAGO
    Route::group(['middleware' => ['role_or_permission:super-admin|expedientes']], function () {
        Route::get('/lista-de-expedientes', 'Expediente\ExpedienteController@index')->name('expediente.index');
        Route::get('/create', 'Expediente\ExpedienteController@create')->name('expediente.create');
    });
});
