@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-file-archive"></i> Lista de Convenios</a></li>
@endsection
@section('content')
@section('titulo', '| Administrar Convenios')
<div>
    <h1 class="text-danger text-center font-weight-bold">Administración de Convenios</h1>
    <br>
    @livewire('mantenimiento.convenio.convenios')
</div>
@endsection
