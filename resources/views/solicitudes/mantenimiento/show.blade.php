@extends('layouts.nav')
@section('breadcrumb')
    <li class=""><a href=" {{ route('solicitudes.mis-solicitudes') }}"><i class="fas fa-clipboard"></i>
        Mis
        Solicitudes</a></li>
    <li class="active"><a><i class="fas fa-file-contract"></i> Detalles de Mantenimiento</a>
    </li>
@endsection
@section('titulo', '| Detalle de Solicitud de mantenimiento')

@section('content')
    <h1 class="text-center font-weight-bold text-danger">Detalle de Solicitud - Mantenimiento</h1>
    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-4">
            <div class="card author-box">
                <div class="card-body">
                    <div class="author-box-center">
                        <img alt="image" src="{{ Avatar::create($solicitud->descripcion)->setFontSize(35)->setChars(2) }}"
                            class="rounded-circle author-box-picture">
                        <div class="clearfix"></div>
                        <div class="author-box-name">
                            <a href="#">{{ $solicitud->nombre }}</a>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="author-box-description">
                            <p>
                                {{ $solicitud->adquisicion }}
                            </p>
                        </div>
                        <div class="mb-2 mt-3">
                            <div class="text-small font-weight-bold">{{ $solicitud->descripcion }}</div>
                        </div>

                        <div class="w-100 d-sm-none"></div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Datos de la Solicitud</h4>
                </div>
                <div class="card-body">
                    <div>
                        {{-- <p class="clearfix">
                            <span class="float-left font-weight-bold">
                                Dependencia
                            </span>
                            <span class="float-right ">
                                {{ $solicitud->dependencia->nombre }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left font-weight-bold">
                                Departamento
                            </span>
                            <span class="float-right">
                                {{ $solicitud->departamento->nombre }}
                            </span>
                        </p> --}}
                        <p class="clearfix">
                            <span class="float-left font-weight-bold">
                                N° Solicitud
                            </span>
                            <span class="float-right text-muted text-capitalize">
                                {{ $solicitud->id }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left font-weight-bold">
                                Fecha
                            </span>
                            <span class="float-right text-muted text-capitalize">
                                {{ $solicitud->fecha_creacion }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left font-weight-bold">
                                Estado
                            </span>
                            <span class="float-right text-capitalize badge {{ verificarStarus($solicitud->estado) }}">
                                {{ $solicitud->estado }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left font-weight-bold">
                                Total Neto
                            </span>
                            <span class="float-right  text-capitalize  badge {{ ramdomBadge() }}">
                                {{ number_format($solicitud->total_neto, 2, ',', '.') }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left font-weight-bold">
                                Iva
                            </span>
                            <span class="float-right text-capitalize badge {{ ramdomBadge() }}">
                                {{ number_format($solicitud->iva, 2, ',', '.') }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left font-weight-bold">
                                Total
                            </span>
                            <span class="float-right text-capitalize badge {{ ramdomBadge() }}">
                                {{ number_format($solicitud->total, 2, ',', '.') }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-8">
            <div class="card">
                <div wire:ignore.self class="padding-20">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" wire:ignore role="presentation">
                            <a class="nav-link active" id="detalles-tab" data-toggle="tab" href="#detalles" role="tab"
                                aria-controls="detalles" aria-selected="false">Detalles</a>
                        </li>
                        <li class="nav-item" wire:ignore role="presentation">
                            <a class="nav-link " id="productos-tab" data-toggle="tab" href="#productos" role="tab"
                                aria-controls="productos" aria-selected="true">Productos</a>
                        </li>


                        <li class="nav-item" wire:ignore role="presentation">
                            <a class="nav-link" id="solicitante-tab" data-toggle="tab" href="#solicitante" role="tab"
                                aria-controls="solicitante" aria-selected="false">Solicitante</a>
                        </li>
                        <li class="nav-item" wire:ignore role="presentation">
                            <a class="nav-link" id="aprobaciones-tab" data-toggle="tab" href="#aprobaciones"
                                role="tab" aria-controls="aprobaciones" aria-selected="false">Aprobaciones</a>
                        </li>
                        @if ($solicitud->estado == 'completada' || $solicitud->estado == 'recepcionada' || $solicitud->estado == 'recepcion-parcial' || $solicitud->estado == 'completada-parcial')
                            <li class="nav-item" wire:ignore role="presentation">
                                <a class="nav-link" id="orden-tab" data-toggle="tab" href="#orden" role="tab"
                                    aria-controls="orden" aria-selected="false">Ordenes de Compra</a>
                            </li>
                        @endif
                    </ul>
                    <div wire:ignore.self class="tab-content tab-bordered" id="myTab3Content">
                        <div class="tab-pane fade " id="productos" role="tabpanel" aria-labelledby="productos-tab"
                            wire:ignore.self>
                            <h3 class="text-center font-weight-bold text-danger">Productos</h3>
                            <div class="table-responsive" style="height: 450px; overflow-y: scroll;">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Producto</th>
                                            <th class="text-center">Detalle</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (json_decode($solicitud->mantenimiento->productos) as $producto)
                                            <tr>
                                                <td class="text-capitalize text-center">{{ $producto->nombre }}
                                                </td>
                                                <td class="text-center">{{ $producto->detalle }}</td>
                                                <td class="text-center">
                                                    {{ $producto->pivot->cantidad }}
                                                </td>
                                                <td class="text-center text-capitalize">
                                                    {{ number_format($producto->pivot->neto, 2, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                            <div class="row justify-content-center">
                            </div>
                        </div>
                        <div class="tab-pane fade " id="aprobaciones" role="tabpanel" aria-labelledby="aprobaciones-tab"
                            wire:ignore.self>
                            <h3 class="text-center font-weight-bold text-danger">Aprobaciones</h3>
                            <div class="table-responsive" style="height: 450px; overflow-y: scroll;">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Departamento</th>
                                            <th class="text-center">Encargado</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Observación</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($solicitud->aprobaciones as $aprobacion)
                                            <tr>
                                                <td class="text-capitalize text-center">{{ $aprobacion->tipo }}
                                                </td>
                                                <td class="text-center">{{ $aprobacion->encargado->nombres }}</td>
                                                <td class="text-center text-capitalize">
                                                    <span
                                                        class="badge {{ verificarStarus($aprobacion->estado) }}">{{ $aprobacion->estado }}</span>

                                                </td>
                                                <td class="text-center text-capitalize">
                                                    @if ($aprobacion->estado == 'rechazado')
                                                        {{ $aprobacion->rechazo->nombre }}
                                                    @else
                                                        {{ $aprobacion->observacion }}

                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                            <div class="row justify-content-center">
                            </div>
                        </div>
                        <div class="tab-pane fade show active" id="detalles" role="tabpanel" aria-labelledby="detalles-tab"
                            wire:ignore.self>
                            <h2 class="text-center">
                                Detalles de la Solicitud
                            </h2>
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label for="">Dependencia</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $solicitud->dependencia->nombre }}"></label>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="">Departamento</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $solicitud->departamento->nombre }}">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="">Adquisición</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $solicitud->adquisicion }}">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="">Descripción</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $solicitud->descripcion }}">
                                </div>
                            </div>
                            <p class="clearfix">
                                <span class="float-left font-weight-bold">
                                    Cotizacion:
                                </span>
                                <span class="float-right text-muted text-capitalize">
                                    @isset($solicitud->documento)
                                        <a class="text-primary" target="_blank"
                                            href="{{ asset($solicitud->documento->archivo) }}">{{ $solicitud->documento->nombre }}</a>
                                    @endisset
                                </span>
                            </p>
                            <h4 class="text-center text-info mt-2">
                                Uso Exclusivo Unidad De Finanzas
                            </h4>
                            <div class="table-responsiv">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Cuenta</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="tab-pane fade " id="solicitante" role="tabpanel" aria-labelledby="solicitante-tab"
                            wire:ignore.self>
                            <h2 class="text-center">
                                Datos del Solicitante
                            </h2>
                            <div class="form-row">
                                <div class="form-group col-lg-4">
                                    <label for="">Nombre</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $solicitud->solicitante->nombres }}"></label>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="">Correo</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $solicitud->solicitante->email }}">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="">Fono</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $solicitud->solicitante->fono }}">
                                </div>

                            </div>
                        </div>
                        @if ($solicitud->estado == 'completada' || $solicitud->estado == 'recepcionada' || $solicitud->estado == 'recepcion-parcial' || $solicitud->estado == 'completada-parcial')
                            <div class="tab-pane fade " id="orden" role="tabpanel" aria-labelledby="orden-tab">
                                <h2 class="text-center text-danger">
                                    Ordenes de Compra
                                </h2>
                                <div class="table-responsive">
                                    <div class="row table-responsive">
                                        <table class="table table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th style="vertical-align: middle" width="180"
                                                        class="px-4 py-2 text-center "><a class="text-primary"
                                                            wire:click.prevent="sortBy('proveedors.nombre')" role="button"
                                                            href="#">
                                                            Proveedor
                                                        </a></th>
                                                    <th style="vertical-align: middle" width="180"
                                                        class="px-4 py-2 text-center"><a class="text-primary"
                                                            wire:click.prevent="sortBy('orden_compras.num_orden')"
                                                            role="button" href="#">
                                                            Numero Orden
                                                        </a></th>
                                                    <th style="vertical-align: middle" width="150"
                                                        class="px-4 py-2 text-center "><a class="text-primary"
                                                            wire:click.prevent="sortBy('orden_compras.valor_total')"
                                                            role="button" href="#">
                                                            Valor Total
                                                        </a></th>
                                                    <th style="vertical-align: middle" width="150"
                                                        class="px-4 py-2 text-center"><a class="text-primary"
                                                            wire:click.prevent="sortBy('orden_compras.tipo_compra')"
                                                            role="button" href="#">
                                                            Tipo Compra
                                                        </a></th>
                                                    <th style="vertical-align: middle" width="180"
                                                        class="px-4 py-2 text-center "><a class="text-primary">
                                                            Documento Anexo
                                                        </a></th>
                                                    <th style="vertical-align: middle" width="150"
                                                        class="px-4 py-2 text-center"><a class="text-primary"
                                                            wire:click.prevent="sortBy('orden_compras.created_at')"
                                                            role="button" href="#">
                                                            Fecha Registro
                                                        </a></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($solicitud->ordenes as $orden)
                                                    <tr>
                                                        <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                                            @if ($orden->tipo_compra == 'compra-menor' || $orden->tipo_compra == 'moneda')
                                                                {{ $orden->proveedo }}
                                                            @else
                                                                {{ $orden->nom_proveedor }}
                                                            @endif
                                                        </td>
                                                        <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                                            <a class="link-badge-info" target="_blank"
                                                                href="{{ asset($orden->fileorden->archivo) }}"><i
                                                                    class="fa {{ getIconOrder($orden->fileorden->extension) }}"></i>
                                                                {{ $orden->num_orden }}</a>
                                                        </td>
                                                        <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                                            <span class="badge {{ ramdomBadge() }}">
                                                                {{ number_format($orden->valor_total, 2, ',', '.') }}</span>

                                                        </td>

                                                        <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                                            {{ $orden->tipo_compra }}</td>
                                                        <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                                            @isset($orden->documento)
                                                                <a class="link-badge-info" target="_blank"
                                                                    href="{{ asset($orden->documento->archivo) }}"><i
                                                                        class="fa {{ getIconOrder($orden->documento->extension) }}"></i>
                                                                    Documento Anexo</a>
                                                            @endisset
                                                        </td>
                                                        <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                                            {{ $orden->created_at }}</td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{-- <div class="form-row">
                                    <div class="form-group col-lg-4">
                                        <label for="">Num° Orden</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ $solicitud->orden->num_orden }}"></label>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="">Total</label>
                                        <input type="text" class="form-control text-right" disabled
                                            value="{{ number_format($solicitud->orden->valor_total, 2, '.', ',') }}"></label>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="">Tipo de Compra</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ $solicitud->orden->tipo_compra }}"></label>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="">Rut Proveedor</label>
                                        @if ($solicitud->orden->tipo_compra == 'compra-menor' || $solicitud->orden->tipo_compra == 'moneda')
                                            <input type="text" class="form-control" disabled
                                                value="{{ $solicitud->orden->proveedor->rut }}">
                                        @else
                                            <input type="text" class="form-control" disabled
                                                value="{{ $solicitud->orden->codigo_proveedor }}">
                                        @endif
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="">Proveedor</label>
                                        @if ($solicitud->orden->tipo_compra == 'compra-menor' || $solicitud->orden->tipo_compra == 'moneda')
                                            <input type="text" class="form-control" disabled
                                                value="{{ $solicitud->orden->proveedor->nombre }}">
                                        @else
                                            <input type="text" class="form-control" disabled
                                                value="{{ $solicitud->orden->nom_proveedor }}">
                                        @endif
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="">Ejecutivo de Compra</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ $solicitud->orden->encargado->nombres }}"></label>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label class="font-weight-bold" for="">Orden de Compra:</label>
                                        <a target="_blank" class="link-badge-info"
                                            href="{{ $solicitud->orden->fileorden->archivo }}">
                                            {{ $solicitud->orden->fileorden->nombre }}</a>
                                        </label>
                                    </div>
                                </div> --}}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
