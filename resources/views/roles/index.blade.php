@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-shield-alt"></i> Roles</a></li>
@endsection
@section('content')
@section('titulo', '| Administrar Roles')
<div>
    <h1 class="text-danger text-center font-weight-bold">Administración de Roles</h1>
    <br>
    @livewire('rol.roles')
</div>
@endsection
