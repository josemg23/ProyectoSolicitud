@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-file-archive"></i> Tipos de Contratos</a></li>
@endsection
@section('content')
@section('titulo', '| Administrar Productos')
<div>
    <h1 class="text-danger text-center font-weight-bold">Administración de Tipos de Contratos</h1>
    <br>
    <!-- aqui va el componente livewire -->
    @livewire('mantenimiento.tipo-contratos.tipos-contratos')

</div>
@endsection
