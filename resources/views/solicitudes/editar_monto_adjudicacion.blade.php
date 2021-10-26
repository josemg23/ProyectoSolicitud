@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-clipboard"></i> Editar Monto de Adjudicación</a>
    </li>
@endsection
@section('titulo', '| Editar Monto de Adjudicación')
@section('content')
    <h1 class="text-center text-danger font-weight-bold">Editar Monto de Adjudicación</h1>
    @livewire('solicitud.editar-monto-adjudicacion')
@endsection
