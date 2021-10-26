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
                    @role('director|administracion-gestion')

                    <button wire:target="selectionAll, cambioSelectos, aprobarSeleccion" wire:loading.attr="disabled"
                        class="ml-2 btn btn-outline-success" wire:click.prevent="aprobarSeleccion">Aprobar
                        Selección</button>
                    @endrole

                </div>

                <div class="col-lg-2">
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Solicitud...">
                </div>
            </div>
            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            @role('director|administracion-gestion')
                            <th class="px-4 py-2 text-center ">
                                <input type="checkbox" class="custom-checkbox" wire:change="cambioSelectos"
                                    wire:target="selectionAll, cambioSelectos, aprobarSeleccion"
                                    wire:loading.attr="disabled" wire:model="selectioncompleta">
                            </th>
                            @endrole
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('solicituds.fecha_creacion')" role="button" href="#">
                                    Fecha
                                    @include('includes._sort-icon', ['field' => 'solicituds.fecha_creacion'])
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
                                    wire:click.prevent="sortBy('solicituds.descripcion')" role="button" href="#">
                                    Descripción
                                    @include('includes._sort-icon', ['field' => 'solicituds.descripcion'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('solicituds.total')" role="button" href="#">
                                    Total Costo
                                    @include('includes._sort-icon', ['field' => 'solicituds.total'])
                                </a></th>
                            <th class="px-4 py-2 text-center ">
                                <a class="text-primary" wire:click.prevent="sortBy('users.nombres')" role="button"
                                    href="#">
                                    Usuario
                                    @include('includes._sort-icon', ['field' => 'users.nombres'])
                                </a>
                            </th>
                            <th class="px-4 py-2 text-center text-primary">
                                Dpto Aprobado
                            </th>

                            @if (!Auth::user()->hasRole('super-admin'))

                                <th class="px-4 py-2 text-center">Accion</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if ($solicitudes->isNotEmpty())
                            @foreach ($solicitudes as $solicitud)
                                <tr>
                                    @role('director|administracion-gestion')
                                    <td class="p-1 text-center  text-dark">
                                        <input type="checkbox" class="custom-radio"
                                            value="{{ intval($solicitud->id) }}" wire:model.defer="selecionados"
                                            wire:target="selectionAll, cambioSelectos, aprobarSeleccion"
                                            wire:loading.attr="disabled">
                                    </td>
                                    @endrole
                                    <td class="p-1 text-center  text-dark text-capitalize">
                                        {{ $solicitud->fecha_creacion }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $solicitud->departamento }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $solicitud->adquisicion }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $solicitud->descripcion }}</td>
                                    <td class="p-1 text-center  text-dark">
                                        {{ number_format($solicitud->total, 2, ',', '.') }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $solicitud->creador_solicitud }}</td>
                                    <td class="p-1 text-left  text-dark">
                                        @foreach ($solicitud->aprobaciones as $aprobacion)
                                            <span
                                                class="badge {{ ramdomBadge() }} text-capitalize mb-1">{{ $aprobacion->encargado->roles[0]->description }}
                                                -
                                                {{ changeDateFormate($aprobacion->created_at, 'Y/m/d') }}</span><br>

                                        @endforeach
                                    </td>

                                    @if (!Auth::user()->hasRole('super-admin'))
                                        <td class="p-1 text-center" width="25">
                                            <button class="btn btn-sm btn-warning text-dark" data-toggle="modal"
                                                data-target="#createConvenio"
                                                wire:target="selectionAll, cambioSelectos, aprobarSeleccion"
                                                wire:loading.attr="disabled"
                                                wire:click.prevent="aprobarSolicitud('{{ $solicitud->tipo }}',{{ $solicitud->id }})">
                                                <i class="fa fa-edit"></i>
                                            </button>
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
