@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-file-contract"></i> Convenios</a></li>
@endsection
@section('content')
@section('titulo', '| Convenios')
<div>
    <h1 class="text-danger text-center font-weight-bold">Solicitudes por Abrobar - Convenios</h1>
    <br>
    @livewire('evaluaciones.evaluaciones', ['tipo' => 'convenios'])
</div>
@endsection
