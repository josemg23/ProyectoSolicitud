@extends('layouts.nav')
@section('breadcrumb')
    <li class=""><a href="{{ route('evaluacion.contrato-suministro.index') }}"><i class="fas fa-archive"></i>
            Solicitudes por aprobar</a></li>
    <li class="active"><a><i class="fas fa-file-contract"></i> Aprobacion de Contrato de
            Suministros</a>
    </li>
@endsection
@role('finanzas')
@include('evaluaciones.contrato_suministro.encargados.finanzas')
@endrole
@role('administracion-gestion')
@include('evaluaciones.contrato_suministro.encargados.administracion_gestion')
@endrole
@role('director')
@include('evaluaciones.contrato_suministro.encargados.direccion')
@endrole
@role('abastecimiento')
@include('evaluaciones.contrato_suministro.encargados.abastecimiento')
@endrole
