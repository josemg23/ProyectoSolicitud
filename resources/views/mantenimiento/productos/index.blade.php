@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-shopping-cart"></i> Productos</a></li>
@endsection
@section('content')
@section('titulo', '| Administrar Productos')
<div>
    <h1 class="text-danger text-center font-weight-bold">Administración de Productos</h1>
    <br>
    <!-- aqui va el componente livewire -->
    @livewire('mantenimiento.producto.productos')

</div>
@endsection
