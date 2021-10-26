@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-shopping-bag"></i> Solicitudes Con Recepciones</a></li>
@endsection
@section('content')
@section('titulo', '| Lista de Solicitudes Con Recepciones')
<div>
    <h1 class="text-danger text-center font-weight-bold">Lista de Recepciones Realizadas</h1>
    <br>
    @livewire('recepciones.recepciones')
</div>
@endsection
