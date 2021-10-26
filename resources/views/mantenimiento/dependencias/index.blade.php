@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-layer-group"></i> Dependencias</a></li>

@endsection
@section('content')
@section('titulo', '| Administrar Dependencias')
<div>
    <h1 class="text-danger text-center font-weight-bold">Administración De Dependencias</h1>
    <br>
    <!-- aqui va el componente livewire -->
    @livewire('mantenimiento.dependencias.dependencias')

</div>
@endsection
