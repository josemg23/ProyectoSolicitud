@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-layer-group"></i> Unidad</a></li>
@endsection
@section('content')
@section('titulo', '| Administrar Medidas')
<div>
    <h1 class="text-danger text-center font-weight-bold">Administración de Unidades de Medida</h1>
    <br>
    <!-- aqui va el componente livewire -->
    @livewire('mantenimiento.medidas.unidad')

</div>
@endsection
