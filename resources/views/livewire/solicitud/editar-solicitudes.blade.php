<div>
    @include('solicitudes.modal.editarmonto')
    <div class="card">
        <div class="card-body">
            <div class="row mb-4 justify-content-between">
                <div class="col-lg-4 form-inline">
                    Por Pagina: &nbsp;
                    <select wire:model="perPage" class="form-control form-control-sm">
                        <option>10</option>
                        <option>15</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </div>

                <div class="col-lg-2">
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Solicitud...">
                </div>
            </div>
            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('solicituds.id')" role="button" href="#">
                                    N°
                                    @include('includes._sort-icon', ['field' => 'solicituds.id'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('solicituds.tipo')" role="button" href="#">
                                    Tipo
                                    @include('includes._sort-icon', ['field' => 'solicituds.tipo'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('departamentos.nombre')" role="button" href="#">
                                    Dto/Unidad
                                    @include('includes._sort-icon', ['field' => 'departamentos.nombre'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('solicituds.adquisicion')" role="button" href="#">
                                    Adquisición
                                    @include('includes._sort-icon', ['field' => 'solicituds.adquisicion'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('logs_montos_count')" role="button" href="#">
                                    Cambios
                                    @include('includes._sort-icon', ['field' => 'logs_montos_count'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('solicituds.total')" role="button" href="#">
                                    Total Costo
                                    @include('includes._sort-icon', ['field' => 'solicituds.total'])
                                </a></th>
                            <th class="px-4 py-2 text-center" colspan="4">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($solicitudes->isNotEmpty())
                            @foreach ($solicitudes as $solicitud)
                                <tr>
                                    <td class="p-1 text-center  text-dark text-capitalize">{{ $solicitud->id }}</td>
                                    <td class="p-1 text-center  text-dark text-capitalize">{{ $solicitud->tipo }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $solicitud->departamento }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $solicitud->adquisicion }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $solicitud->logs_montos_count }}</td>
                                    <td class="p-1 text-center  text-dark">
                                        {{ number_format($solicitud->total, 2, ',', '.') }}</td>
                                    <td class="p-1 text-center" width="25">
                                        <a data-toggle="modal" data-target="#modalEditar"
                                            wire:click.prevent="editarMonto({{ $solicitud->id }})"
                                            class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10">
                                    <p class="text-center">No hay resultado para la busqueda
                                        <strong>{{ $search }}</strong> en la pagina
                                        <strong>{{ $page }}</strong> al mostrar <strong>{{ $perPage }}
                                        </strong> por pagina
                                    </p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col">
                    {{ $solicitudes->links() }}
                </div>
                <div class="col text-right text-muted">
                    Mostrar {{ $solicitudes->firstItem() }} a {{ $solicitudes->lastItem() }} de
                    {{ $solicitudes->total() }} registros
                </div>
            </div>
        </div>
    </div>

</div>
