@extends('layouts.nav')
@section('breadcrumb')
    <li class=""><a href="{{ route('evaluacion.convenio.index') }}"><i class="fas fa-archive"></i>
            Solicitudes por aprobar</a></li>
    <li class="breadcrumb-item active" aria-current="page"><a><i class="fas fa-file-contract"></i> Aprobacion de
            Convenios</a>
    </li>
@endsection
@role('encargado-convenio')
@include('evaluaciones.convenios.encargados.encargado')
@endrole
@role('finanzas')
@include('evaluaciones.convenios.encargados.finanzas')
@endrole
@role('administracion-gestion')
@include('evaluaciones.convenios.encargados.administracion-gestion')
@endrole
@role('director')
@include('evaluaciones.convenios.encargados.direccion')
@endrole
@role('abastecimiento')
@include('evaluaciones.convenios.encargados.abastecimiento')
@endrole
