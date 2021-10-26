@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-clipboard"></i> Mis Solicitudes</a>
    </li>
@endsection
@section('titulo', '| Mis Solicitudes')
@section('content')
    <h1 class="text-center text-danger font-weight-bold">MIS SOLICITUDES</h1>
    @livewire('solicitud.mis-solicitudes')
@endsection
