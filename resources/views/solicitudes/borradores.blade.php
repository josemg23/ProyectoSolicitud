@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-clipboard"></i> Mis Borradores</a>
    </li>
@endsection
@section('titulo', '| Borradores')
@section('content')
    <h1 class="text-center text-danger font-weight-bold">MIS BORRADORES</h1>
    @livewire('solicitud.mis-solicitudes',[true])
@endsection
