@extends('layouts.nav')
@section('css')
    <link href="{{ asset('assets/css/dashboard/dash_2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('content')
    <div class="">
        <div class="row">
            <div class="col-xl-4 col-lg-6 ">
                <div class="card l-bg-cyan">
                    <div class="card-statistic-3">
                        <div class="card-icon card-icon-large"><i class="fa fa-file-contract"></i></div>
                        <div class="card-content">
                            <h4 class="card-title text-light">Mis Solicitudes </h4>
                            <span class="font-weight-bold text-center"
                                style="font-size: 40px">{{ $misSolicitudes }}</span><br>

                            @if ($misSolicitudes >= 1)
                                <a href="{{ route('solicitudes.mis-solicitudes') }}"
                                    class="linked btn btn-light btn-sm">Ver Lista<i
                                        class="fas fa-arrow-alt-circle-right"></i></a>
                            @else
                                <a class="linked btn btn-light btn-sm disabled">Sin Solicitudes<i
                                        class="fas fa-window-close "></i></a>
                            @endif
                            {{-- <a class="linked btn btn-light btn-sm">Mostrar<i class="fas fa-arrow-alt-circle-right"></i></a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 ">
                <div class="card l-bg-cyan">
                    <div class="card-statistic-3">
                        <div class="card-icon card-icon-large"><i class="fa fa-file-contract"></i></div>
                        <div class="card-content">
                            <h4 class="card-title text-light">Insumos </h4>
                            <span class="font-weight-bold text-center"
                                style="font-size: 40px">{{ $insumos }}</span><br>
                            @if ($insumos >= 1)
                                <a href="{{ route('evaluacion.insumo.index') }}"
                                    class="linked btn btn-light btn-sm">Evaluar
                                    Ahora<i class="fas fa-arrow-alt-circle-right"></i></a>
                            @else
                                <a class="linked btn btn-light btn-sm disabled">Sin Solicitudes<i
                                        class="fas fa-window-close "></i></a>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6">
                <div class="card l-bg-green">
                    <div class="card-statistic-3">
                        <div class="card-icon card-icon-large"><i class="fa fa-file-contract"></i></div>
                        <div class="card-content">
                            <h4 class="card-title text-light">Convenios </h4>
                            <span class="font-weight-bold text-center" style="font-size: 40px">{{ $convenios }}</span>
                            <br>
                            @if ($convenios >= 1)
                                <a href="{{ route('evaluacion.convenio.index') }}"
                                    class="linked btn btn-light btn-sm">Evaluar
                                    Ahora<i class="fas fa-arrow-alt-circle-right"></i></a>
                            @else
                                <a class="linked btn btn-light btn-sm disabled">Sin Solicitudes<i
                                        class="fas fa-window-close "></i></a>
                            @endif

                            {{-- <a href="{{ route('admin.usuario.index') }}" class="linked btn btn-light btn-sm">Mostrar<i
                                    class="fas fa-arrow-alt-circle-right"></i></a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6">
                <div class="card l-bg-orange">
                    <div class="card-statistic-3">
                        <div class="card-icon card-icon-large"><i class="fa fa-file-contract"></i></div>
                        <div class="card-content">
                            <h4 class="card-title text-light">Mantenimiento </h4>
                            <span class="font-weight-bold text-center"
                                style="font-size: 40px">{{ $mantenimiento }}</span><br>
                            @if ($mantenimiento >= 1)
                                <a href="{{ route('evaluacion.mantenimiento.index') }}"
                                    class="linked btn btn-light btn-sm">Evaluar
                                    Ahora<i class="fas fa-arrow-alt-circle-right"></i></a>
                            @else
                                <a class="linked btn btn-light btn-sm disabled">Sin Solicitudes<i
                                        class="fas fa-window-close "></i></a>
                            @endif
                            {{-- <a href="{{ route('admin.informe.index') }}" class="linked btn btn-light btn-sm">Mostrar<i
                                    class="fas fa-arrow-alt-circle-right"></i></a> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6">
                <div class="card l-bg-yellow">
                    <div class="card-statistic-3">
                        <div class="card-icon card-icon-large"><i class="fa fa-file-signature"></i></div>
                        <div class="card-content">
                            <h4 class="card-title text-light">Contratos de Suministro </h4>
                            <span class="font-weight-bold text-center"
                                style="font-size: 40px">{{ $contratos }}</span><br>
                            @if ($contratos >= 1)
                                <a href="{{ route('evaluacion.contrato-suministro.index') }}"
                                    class="linked btn btn-light btn-sm">Evaluar
                                    Ahora<i class="fas fa-arrow-alt-circle-right"></i></a>
                            @else
                                <a class="linked btn btn-light btn-sm disabled">Sin Solicitudes<i
                                        class="fas fa-window-close "></i></a>
                            @endif
                            {{-- <a href="{{ route('admin.solicitud.index') }}" class="linked btn btn-light btn-sm">Mostrar<i
                                    class="fas fa-arrow-alt-circle-right"></i></a> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xl-4 col-lg-6">
                <div class="card l-bg-red">
                    <div class="card-statistic-3">
                        <div class="card-icon card-icon-large"><i class="fa fa-user-tag"></i></div>
                        <div class="card-content">
                            <h4 class="card-title text-light">Postulantes Pendiente</h4>
                            <span class="font-weight-bold text-center"
                                style="font-size: 40px">{{ $postulantes }}</span><br>
                            <a href="{{ route('admin.postulacion.index') }}"
                                class="linked btn btn-light btn-sm">Mostrar<i class="fas fa-arrow-alt-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="col-xl-4 col-lg-6">
                <div class="card l-bg-purple-dark">
                    <div class="card-statistic-3">
                        <div class="card-icon card-icon-large"><i class="fa fa-shopping-bag"></i></div>
                        <div class="card-content">
                            <h4 class="card-title text-light">Dotaciones</h4>
                            <span class="font-weight-bold text-center"
                                style="font-size: 40px">{{ $products }}</span><br>
                            <a href="{{ route('admin.inventario.productos') }}"
                                class="linked btn btn-light btn-sm">Mostrar<i class="fas fa-arrow-alt-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
@endsection
