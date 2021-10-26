<?php

use Illuminate\Support\Facades\Route;

Route::prefix('decretos')->middleware('auth')->group(function () {
    Route::post('/xml-file', 'Decretos\DecretosController@readXml')->name('decretos.readXml');
    Route::get('/{aprobacion}/cuentas', 'Decretos\DecretosController@getCuentas')->name('decretos.cuentas');
    Route::get('/proveedores', 'Decretos\DecretosController@proveedores')->name('decretos.proveedores');


    //RUTAS DE ORDENES DE COMPRAS
    Route::group(['middleware' => ['role_or_permission:super-admin|decretos']], function () {
        Route::get('/lista-de-decretos', 'Decretos\DecretosController@index')->name('decretos.index');
        Route::get('/create', 'Decretos\DecretosController@create')->name('decretos.create');
        Route::post('/store', 'Decretos\DecretosController@store')->name('decretos.store');
    });
});
