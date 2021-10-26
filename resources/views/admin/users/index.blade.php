@extends('layouts.nav')
@section('breadcrumb')
    {{-- <li class="active"><i class="fas fa-users"></i> Usuarios</li> --}}
    <li class="active"><a>
            <i class="fas fa-users"></i> Usuarios</li>
    </a></li>
@endsection
@section('content')
@section('titulo', '| Administrar Usuarios')
<div>
    <h1 class="text-danger text-center font-weight-bold">Administración de Usuarios</h1>
    <br>
    @livewire('admin.user.usuarios')
</div>
@endsection
