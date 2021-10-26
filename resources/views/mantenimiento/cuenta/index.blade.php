@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-money-bill-wave-alt"></i> Cuentas</a></li>
@endsection
@section('content')
@section('titulo', '| Administrar Cuentas')
<div>
    <h1 class="text-danger text-center font-weight-bold">Administración de Cuentas</h1>
    <br>
    <!-- aqui va el componente livewire -->
    @livewire('mantenimiento.cuentas')

</div>
@endsection
