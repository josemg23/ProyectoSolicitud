@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-file-contract"></i> Contratos de Suministro</a></li>
@endsection
@section('content')
@section('titulo', '| Contrato de Suministros')
<div>
    <h1 class="text-danger text-center font-weight-bold">Contratos de Suministros</h1>
    <br>
    @livewire('mantenimiento.contrato-suministro.index')

</div>
@endsection

{{-- @section('js')
    <script>
        $(document).ready(function(e) {
            $('.sidebarCollapse').click();
        });
    </script>
@endsection --}}
