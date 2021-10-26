<?php

use Illuminate\Support\Facades\Route;

Route::prefix('ordenes')->middleware('auth')->group(function () {
    Route::post('/xml-file', 'Ordenes\OrdenesCompraController@readXml')->name('ordenes.readXml');
    Route::get('/{aprobacion}/cuentas', 'Ordenes\OrdenesCompraController@getCuentas')->name('ordenes.cuentas');
    Route::get('/proveedores', 'Ordenes\OrdenesCompraController@proveedores')->name('ordenes.proveedores');


    //RUTAS DE ORDENES DE COMPRAS
    Route::group(['middleware' => ['role_or_permission:super-admin|ordenes']], function () {
        Route::get('/lista-de-ordenes', 'Ordenes\OrdenesCompraController@index')->name('ordenes.index');
        Route::get('/create', 'Ordenes\OrdenesCompraController@create')->name('ordenes.create')->middleware('role:ejecutivo-compras');
        Route::post('/store', 'Ordenes\OrdenesCompraController@store')->name('ordenes.store')->middleware('role:ejecutivo-compras');
    });
});
