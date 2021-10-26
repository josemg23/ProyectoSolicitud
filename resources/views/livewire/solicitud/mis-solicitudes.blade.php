<div>
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
                                    wire:click.prevent="sortBy('solicituds.total')" role="button" href="#">
                                    Total Costo
                                    @include('includes._sort-icon', ['field' => 'solicituds.total'])
                                </a></th>
                            @if (!$borrador)
                                <th class="px-4 py-2 text-center "><a class="text-primary">
                                        Ordenes C.

                                    </a></th>
                                <th class="px-4 py-2 text-center "><a class="text-primary"
                                        wire:click.prevent="sortBy('solicituds.estado')" role="button" href="#">
                                        Estado
                                        @include('includes._sort-icon', ['field' => 'solicituds.estado'])
                                    </a></th>
                            @endif

                            <th class="px-4 py-2 text-center" colspan="4">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($solicitudes->isNotEmpty())
                            @foreach ($solicitudes as $solicitud)
                                <tr>
                                    <td class="p-1 text-center  text-dark">{{ $solicitud->id }}</td>
                                    <td class="p-1 text-center  text-dark text-capitalize">{{ $solicitud->tipo }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $solicitud->departamento }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $solicitud->adquisicion }}</td>
                                    <td class="p-1 text-center  text-dark">
                                        {{ number_format($solicitud->total, 2, ',', '.') }}</td>
                                    @if (!$borrador)
                                        <td class="p-1 text-left text-dark">
                                            @if ($solicitud->estado == 'completada' || $solicitud->estado == 'recepcionada' || $solicitud->estado == 'recepcion-parcial' || $solicitud->estado == 'completada-parcial')
                                                @forelse ( $solicitud->ordenes as $orden)
                                                    <a class="link-badge-info" target="_blank"
                                                        href="{{ asset($orden->fileorden->archivo) }}"><i
                                                            class="fa {{ getIconOrder($orden->fileorden->extension) }}"></i>
                                                        {{ $orden->num_orden }}</a><br>
                                                @empty
                                                    Sin ordenes
                                                @endforelse
                                            @endif
                                        </td>

                                        <td class="p-1 text-center  text-dark"><span
                                                class="badge {{ verificarStarus($solicitud->estado) }} text-capitalize">{{ $solicitud->estado }}
                                            </span>
                                        </td>
                                    @else
                                        @if (!$solicitud->trashed())
                                            <td class="p-1 text-center" width="25">
                                                <a class="btn btn-sm btn-warning text-dark" data-toggle="modal"
                                                    data-target="#createConvenio"
                                                    wire:click.prevent="editSolicitud('{{ $solicitud->tipo }}',{{ $solicitud->id }})">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @endif
                                    @endif
                                    <td class="p-1 text-center" width="25">
                                        <a class="btn btn-sm btn-success" target="_blank"
                                            href="{{ route('pdf-solicitud', ['solicitud' => $solicitud->id, 'tipo' => $solicitud->tipo]) }}">
                                            <i class="  fa fa-print"></i>
                                        </a>
                                    </td>
                                    <td class="p-1 text-center" width="25">
                                        <a class="btn btn-sm btn-primary"
                                            wire:click.prevent="showSolicitud({{ $solicitud->id }}, '{{ $solicitud->tipo }}')">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                    @if ($solicitud->trashed())
                                        <td colspan="2" class="text-center"><span
                                                class="badge badge-warning">ELIMINADO</span>
                                        </td>
                                    @else
                                        <td class="p-1 text-center" width="25">
                                            <a class="btn btn-sm btn-danger"
                                                wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar esta Solicitud?','eliminarSolicitud', {{ $solicitud->id }})">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    @endif

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
