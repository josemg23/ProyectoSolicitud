@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-shopping-bag"></i> Lista de Ordenes de Compra</a></li>
@endsection
@section('content')
@section('titulo', '| Lista de Ordenes de Compra')
<div>
    <h1 class="text-danger text-center font-weight-bold">Lista de Ordenes de Compra</h1>
    <br>
    @livewire('ordenes.ordenes-compras')
</div>
@endsection
