@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-layer-group"></i> Criterios de Adjudicación</a></li>
@endsection
@section('content')
@section('titulo', '| Administrar Criterios de Adjudicación')
<div>
    <h1 class="text-danger text-center font-weight-bold">Administración de Criterios de Adjudicación</h1>
    <br>
    <!-- aqui va el componente livewire -->
    @livewire('mantenimiento.criterios.criterios-adjudicacion')

</div>
@endsection
