@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-layer-group"></i> Estados de Rechazo</a></li>
@endsection
@section('content')
@section('titulo', '| Administrar Estados de Rechazos')
<div>
    <h1 class="text-danger text-center font-weight-bold">Administración de Estados de Rechazo</h1>
    <br>
    <!-- aqui va el componente livewire -->
    @livewire('mantenimiento.rechazado.estados-rechazados')

</div>
@endsection
