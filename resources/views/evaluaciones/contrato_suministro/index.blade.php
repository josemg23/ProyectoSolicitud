@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-file-contract"></i> Contrato Suministro</a>
    </li>
@endsection
@section('content')
@section('titulo', '| Contrato de Suministros')
<div>
    <h1 class="text-danger text-center font-weight-bold">Solicitudes por Abrobar - Contratos de Suministros</h1>
    <br>
    @livewire('evaluaciones.evaluaciones', ['tipo' => 'contrato-suministros'])
</div>
@endsection
