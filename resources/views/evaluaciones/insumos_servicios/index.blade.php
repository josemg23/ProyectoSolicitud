@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-file-contract"></i> Insumos y Servicios</a></li>
@endsection
@section('content')
@section('titulo', '| Insumos y Servicios')
<div>
    <h1 class="text-danger text-center font-weight-bold">Solicitudes por Abrobar - Insumos y Servicios</h1>
    <br>
    @livewire('evaluaciones.evaluaciones', ['tipo' => 'insumos'])
</div>
@endsection
