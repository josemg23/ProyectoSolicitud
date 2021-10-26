@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-file-invoice"></i> Expedientes de Pago</a></li>
@endsection
@section('content')
@section('titulo', '| Expedientes de Pago')
<div>
    <h1 class="text-danger text-center font-weight-bold">LLista de Expedientes de Pago</h1>
    <br>
    @livewire('expedientes-pago.expedientes')
</div>
@endsection
