@extends('layouts.nav')
@section('breadcrumb')
    <li class=""><a href="{{ route('evaluacion.insumo.index') }}"><i class="fas fa-archive"></i>
            Solicitudes por aprobar</a></li>
    <li class="active"><a><i class="fas fa-file-contract"></i> Aprobacion de Insumos Y Servicios</a>
    </li>
@endsection
@role('finanzas')
@include('evaluaciones.insumos_servicios.encargados.finanzas')
@endrole
@role('administracion-gestion')
@include('evaluaciones.insumos_servicios.encargados.administracion-gestion')
@endrole
@role('director')
@include('evaluaciones.insumos_servicios.encargados.direccion')
@endrole
@role('abastecimiento')
@include('evaluaciones.insumos_servicios.encargados.abastecimiento')
@endrole
