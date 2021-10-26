@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-user-circle"></i> Proveedores</a></li>
@endsection
@section('content')
@section('titulo', '| Administrar Proveedores')
<div>
    <h1 class="text-danger text-center font-weight-bold">Administración de Proveedores</h1>
    <br>
    @livewire('mantenimiento.proveedor.proveedores')
</div>
@endsection
