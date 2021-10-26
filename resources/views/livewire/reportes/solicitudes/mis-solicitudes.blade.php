<div>
    <button type="button" class="btn btn-outline-success mb-2" wire:click.prevent="GenerarExcelSolicitud()">
        <i class="fa fa-file-excel"></i> Generar Reporte
    </button>

    <div class="card">
        <div class="card-body">
            <div class="row mb-4 justify-content-between">
                <div class="col-lg-3 form-inline">
                    Por Pagina: &nbsp;
                    <select wire:model="perPage" class="form-control form-control-sm">
                        <option>10</option>
                        <option>15</option>
                        <option>25</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </div>
                <div class="col-lg-3 form-inline ">
                    Desde: &nbsp;
                    <input type="date" wire:model="from" class="form-control">

                </div>
                <div class="col-lg-3 form-inline ">
                    Hasta: &nbsp;
                    <input type="date" wire:model="to" class="form-control">
                </div>
                <div class="col-lg-2">
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Solicitud...">
                </div>
                <div class="col-lg-4 form-inline ">
                    Estado: &nbsp;
                    <select wire:model="estado" class="form-control form-control-sm">
                        <option value="">Todas</option>
                        <option value="rechazada">Rechazada</option>
                        <option value="en proceso">En Proceso</option>
                        <option value="borrador">Borrador</option>
                        <option value="completada">completada</option>
                        <option value="aprobada">Aprobada</option>
                    </select>
                </div>
            </div>

            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
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
                                    wire:click.prevent="sortBy('solicituds.total')" role="button" href="#">
                                    Total Costo
                                    @include('includes._sort-icon', ['field' => 'solicituds.total'])
                                </a></th>
                            <th class="px-4 py-2 text-center ">Orden C.</th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('solicituds.estado')" role="button" href="#">
                                    Estado
                                    @include('includes._sort-icon', ['field' => 'solicituds.estado'])
                                </a></th>
                            <th class="px-4 py-2 text-center" colspan="3">Accion</th>
                        </tr>
                    </thead>
                    <tbody class="text-center text-dark">
                        @if ($solicitudes->isNotEmpty())
                            @foreach ($solicitudes as $data)
                                <tr>
                                    <td class="p-1 text-center  text-dark">{{ $data->tipo }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $data->departamento }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $data->adquisicion }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $data->total }}</td>
                                    <td class="p-1 text-center  text-dark"> </td>
                                    <td class="p-1 text-center  text-dark"><span
                                            class="badge badge-danger text-capitalize">{{ $data->estado }}</span>
                                    </td>
                                    <td class="p-1 text-center" width="25">
                                        <a class="btn btn-sm btn-primary text-dark">
                                            <i class="fa fa-print"></i>
                                        </a>
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
