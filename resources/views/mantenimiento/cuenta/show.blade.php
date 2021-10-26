@extends('layouts.nav')
@section('breadcrumb')
    <li class=""><a href="{{ route('admin.cuenta.index') }}"><i class="fas fa-money-bill-wave-alt"></i>
            Cuentas</a></li>
    <li class="active"><a><i class="fas fa-eye"></i> Detalles de Cuenta</a></li>
@endsection
@section('content')
@section('titulo', '| Detalles de Cuenta')
<div>
    <h1 class="text-danger text-center font-weight-bold">Detalles de Cuenta</h1>
    <br>
    @livewire('mantenimiento.cuenta.detalle-cuenta', [$cuenta->id])

</div>
@endsection
