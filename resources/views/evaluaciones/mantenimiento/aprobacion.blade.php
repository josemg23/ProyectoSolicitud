@extends('layouts.nav')
@section('breadcrumb')
    <li class=""><a href="{{ route('evaluacion.mantenimiento.index') }}"><i class="fas fa-archive"></i>
            Solicitudes por aprobar</a></li>
    <li class="active"><a><i class="fas fa-equals"></i> Aprobacion de Mantenimiento</a>
    </li>
@endsection
@role('encargado-mantenimiento')
@include('evaluaciones.mantenimiento.encargados.encargado_mantenimiento')
@endrole
@role('finanzas')
@include('evaluaciones.mantenimiento.encargados.finanzas')
@endrole
@role('administracion-gestion')
@include('evaluaciones.mantenimiento.encargados.administracion_gestion')
@endrole
@role('director')
@include('evaluaciones.mantenimiento.encargados.direccion')
@endrole
@role('abastecimiento')
@include('evaluaciones.mantenimiento.encargados.abastecimiento')
@endrole
