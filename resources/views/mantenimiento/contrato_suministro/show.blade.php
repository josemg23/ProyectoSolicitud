@extends('layouts.nav')
@section('breadcrumb')
    <li class=""><a href="{{ route('admin.contrato-suministro.index') }}"><i class="fas fa-file-contract"></i>
            Contratos de Suministro</a></li>
    <li class="active"><a><i class="fas fa-eye"></i> Contrato de Suministro #
            {{ $contrato->id }}</a>
    </li>
@endsection
{{-- @section('titulo', '| Contrato de Suministro') --}}

@section('content')
    <h1 class="text-center font-weight-bold text-danger">Contrato de Suministros</h1>
    <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-4">
            <div class="card author-box">
                <div class="card-body">
                    <div class="author-box-center">
                        <img alt="image" src="{{ Avatar::create($contrato->nombre)->setFontSize(35)->setChars(2) }}"
                            class="rounded-circle author-box-picture">
                        <div class="clearfix"></div>
                        <div class="author-box-name">
                            <a href="#">{{ $contrato->nombre }}</a>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="author-box-description">
                            <p>
                                {{ $contrato->licitacion }}
                            </p>
                        </div>
                        <div class="mb-2 mt-3">
                            <div class="text-small font-weight-bold">{{ $contrato->decreto_adjudicacion }}</div>
                        </div>

                        <div class="w-100 d-sm-none"></div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Datos del Contrato</h4>
                </div>
                <div class="card-body">
                    <div>
                        {{-- <p class="clearfix">
                            <span class="float-left font-weight-bold">
                                Dependencia
                            </span>
                            <span class="float-right ">
                                {{ $contrato->dependencia->nombre }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left font-weight-bold">
                                Departamento
                            </span>
                            <span class="float-right">
                                {{ $contrato->departamento->nombre }}
                            </span>
                        </p> --}}

                        <p class="clearfix">
                            <span class="float-left font-weight-bold">
                                Fecha Inicio
                            </span>
                            <span class="float-right text-muted text-capitalize">
                                {{ $contrato->fecha_inicio }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left font-weight-bold">
                                Fecha Termino
                            </span>
                            <span class="float-right text-muted text-capitalize">
                                {{ $contrato->fecha_termino }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left font-weight-bold">
                                Tipo Contrato
                            </span>
                            <span class="float-right text-muted text-capitalize">
                                {{ $contrato->tipo->nombre }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left font-weight-bold">
                                Proveedor
                            </span>
                            <span class="float-right text-muted text-capitalize">
                                {{ $contrato->proveedor->nombre }}
                            </span>
                        </p>

                        <p class="clearfix">
                            <span class="float-left font-weight-bold">
                                Monto
                            </span>
                            <span class="float-right  text-capitalize  badge {{ ramdomBadge() }}">
                                {{ number_format($contrato->monto, 2, ',', '.') }}
                            </span>
                        </p>
                        <p class="clearfix">
                            <span class="float-left font-weight-bold">
                                Monto Disponible
                            </span> (Periodo Actual)
                            <span class="float-right  text-capitalize  badge {{ ramdomBadge() }}">
                                {{ number_format($contrato->monto_actual, 2, ',', '.') }}
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
                            <a class="nav-link " id="historial-tab" data-toggle="tab" href="#historial" role="tab"
                                aria-controls="historial" aria-selected="true">Historial de Contrato</a>
                        </li>
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
                                            <th class="text-center">Valor Neto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contrato->productos as $producto)
                                            <tr>
                                                <td class="text-capitalize text-center">{{ $producto->nombre }}
                                                </td>
                                                <td class="text-center">{{ $producto->detalle }}</td>
                                                <td class="text-center">
                                                    {{ number_format($producto->valor, 2, ',', '.') }}</td>
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
                                Detalles del Contrato
                            </h2>
                            <div class="form-row">
                                <div class="form-group col-lg-4">
                                    <label for="">Nombre del Contrato</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $contrato->nombre }}"></label>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="">Licitación</label>
                                    <input type="text" class="form-control" disabled value="{{ $contrato->licitacion }}">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="">Decreto de Adjudicación</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $contrato->decreto_adjudicacion }}">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="">Fecha Inicio</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $contrato->fecha_inicio }}">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="">Fecha Termino</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $contrato->fecha_termino }}">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="">Monto</label>
                                    <input type="text" class="form-control" disabled value="{{ $contrato->monto }}">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="">Fecha Inicio Periodo</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $contrato->periodos[0]->fecha_inicio_periodo }}">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="">Fecha Termino Periodo</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $contrato->periodos[0]->fecha_termino_periodo }}">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="">Monto Periodo</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $contrato->periodos[0]->monto_inicial }}">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="">Tipo Contrato</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $contrato->tipo->nombre }}">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="">Proveedor</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $contrato->proveedor->nombre }}">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="">Solicitud</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $contrato->solicitud->adquisicion }}">
                                </div>
                                @isset($contrato->cuenta)
                                    <div class="form-group col-lg-12">
                                        <label for="">Cuenta</label>
                                        <input type="text" class="form-control" disabled
                                            value="{{ $contrato->cuenta->cuenta }}">
                                    </div>
                                @endisset

                            </div>
                        </div>
                        <div class="tab-pane fade" id="historial" role="tabpanel" aria-labelledby="historial-tab"
                            wire:ignore.self>
                            <h3 class="text-center font-weight-bold text-danger">Historial de Periodo Actual</h3>
                            <div class="table-responsive" style="height: 500px; overflow-y: scroll;">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Modulo</th>
                                            <th>Detalle</th>
                                            <th>Cantidad</th>
                                            <th>Proceso</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($historiales as $his)
                                            <tr>
                                                <td class="text-capitalize">{{ $his->historial_contratable_type }}
                                                </td>
                                                <td>{{ $his->detalle }}</td>
                                                <td class="text-center">{{ number_format($his->cantidad, 2, ',', '.') }}
                                                </td>
                                                <td class="text-center text-capitalize">{{ $his->type }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row justify-content-center">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
