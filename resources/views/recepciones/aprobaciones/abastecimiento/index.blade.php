@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-shopping-bag"></i> Recepciones Pendientes de Aprobación</a></li>
    <li class="active"><a><i class="fas fa-shopping-bag"></i> Abastecimiento</a></li>
@endsection
@section('content')
@section('titulo', '| Lista de Recepciones Pendientes de Aprobación')
<div>
    <h1 class="text-danger text-center font-weight-bold">Lista de Recepciones Pendientes de Aprobación - Abastecimiento
    </h1>
    <br>
    @livewire('recepciones.aprobaciones')
</div>
@endsection
