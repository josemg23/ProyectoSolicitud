<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', 'Admin\AdminController@index')->name('admin.index');
    Route::get('/mi-perfil', 'Admin\AdminController@perfil')->name('admin.perfil.me');
    Route::group(['middleware' => ['role_or_permission:super-admin|usuarios']], function () {
        //RUTAS DE USUARIOS
        Route::get('/usuarios', 'Admin\UserController@index')->name('admin.usuario.index');
    });

    Route::group(['middleware' => ['role_or_permission:super-admin|convenios']], function () {
        Route::get('/convenios', 'Admin\ConvenioController@index')->name('admin.convenio.index');
    });
    Route::group(['middleware' => ['role_or_permission:super-admin|proveedores']], function () {
        Route::get('/proveedores', 'Admin\ProveedorController@index')->name('admin.proveedor.index');
    });
    Route::group(['middleware' => ['role_or_permission:super-admin|cuentas']], function () {
        Route::get('/cuentas', 'CuentaController@index')->name('admin.cuenta.index');
        Route::get('/cuenta/{cuenta}/show', 'CuentaController@show')->name('admin.cuenta.show');
    });
    //RUTA DE CUENTA
    Route::group(['middleware' => ['role_or_permission:super-admin|unidades medidas']], function () {
        Route::get('/unidades-medida', 'CuentaController@index1')->name('admin.unidades-medida.index');
    });
    //RUTA DE UNIDADES DE MEDIDA
    Route::group(['middleware' => ['role_or_permission:super-admin|dependencias']], function () {
        Route::get('/dependencias', 'DependeciaController@index')->name('admin.dependencias.index');
    });
    Route::group(['middleware' => ['role_or_permission:super-admin|departamentos']], function () {
        Route::get('/departamentos', 'DepartamentoController@index')->name('admin.departamentos.index');
    });
    Route::group(['middleware' => ['role_or_permission:super-admin|roles']], function () {
        Route::get('/roles', 'RolesController@index')->name('admin.roles.index');
    });
    Route::group(['middleware' => ['role_or_permission:super-admin|productos']], function () {
        Route::get('/productos', 'Admin\ProductosController@index')->name('admin.productos.index');
    });
    Route::group(['middleware' => ['role_or_permission:super-admin|tipos-contratos']], function () {
        Route::get('/tipos-contratos', 'Admin\ContratoSuministroController@tiposContrato')->name('admin.tipos-contratos.index');
    });
    Route::group(['middleware' => ['role_or_permission:super-admin|contrato-suministro']], function () {
        Route::get('/contrato-suministro', 'Admin\ContratoSuministroController@index')->name('admin.contrato-suministro.index');
        Route::get('/contrato-suministro/{contrato}/show', 'Admin\ContratoSuministroController@show')->name('admin.contrato-suministro.show');
        Route::get('/contrato-suministro/create', 'Admin\ContratoSuministroController@create')->name('admin.contrato-suministro.create');
        Route::post('/contrato-suministro/proveedores', 'Admin\ContratoSuministroController@searchProveedores')->name('admin.contrato-suministro.producto');
        Route::post('/contrato-suministro/productos', 'Admin\ContratoSuministroController@searchProducto')->name('admin.contrato-suministro.producto');
        Route::post('/contrato-suministro/store', 'Admin\ContratoSuministroController@store')->name('admin.contrato-suministro.store');
    });

    Route::group(['middleware' => ['role_or_permission:super-admin|rechazos']], function () {
        Route::get('/estados-rechazados', 'Admin\RechazadosController@index')->name('admin.rechazo.index');
    });

    Route::group(['middleware' => ['role_or_permission:super-admin|criterios.adjudicacion']], function () {
        Route::get('/criterios-adjudicacion', 'Admin\CriteriosController@index')->name('admin.criterios.index');
    });
});
