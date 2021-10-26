@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-shopping-bag"></i> Lista de Decretos de Adjudicación</a></li>
@endsection
@section('content')
@section('titulo', '| Lista de Decretos de Adjudicación')
<div>
    <h1 class="text-danger text-center font-weight-bold">Lista de Decretos de Adjudicación</h1>
    <br>
    @livewire('decretos.decretos-adjudicacion')
</div>
@endsection
