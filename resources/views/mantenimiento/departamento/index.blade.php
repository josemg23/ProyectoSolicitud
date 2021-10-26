@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-house-damage"></i> Departamentos</a></li>
@endsection
@section('content')
@section('titulo', '| Administrar Departamentos')
<div>
    <h1 class="text-danger text-center font-weight-bold">Administración De Departamentos</h1>
    <br>
    <!-- aqui va el componente livewire -->
    @livewire('mantenimiento.departamento.departamentos')

</div>
@endsection
