@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-clipboard"></i> Editar Solicitudes</a>
    </li>
@endsection
@section('titulo', '| Editar Solicitudes')
@section('content')
    <h1 class="text-center text-danger font-weight-bold">Editar Solicitudes</h1>
    @livewire('solicitud.editar-solicitudes')
@endsection
