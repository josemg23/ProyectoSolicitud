@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-file-contract"></i> Mantenimiento</a></li>
@endsection
@section('content')
@section('titulo', '| Mantenimiento')
<div>
    <h1 class="text-danger text-center font-weight-bold">Solicitudes por Abrobar - Mantenimiento</h1>
    <br>
    @livewire('evaluaciones.evaluaciones', ['tipo' => 'mantenimiento'])
</div>
@endsection
