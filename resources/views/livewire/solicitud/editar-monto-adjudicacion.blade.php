<div>
    @include('solicitudes.modal.montoadjudicacion')
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
                                    N Solicitud°
                                    @include('includes._sort-icon', ['field' => 'solicituds.id'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('solicituds.tipo')" role="button" href="#">
                                    Tipo Solicitud
                                    @include('includes._sort-icon', ['field' => 'solicituds.tipo'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('monto_adjudicacions.monto')" role="button" href="#">
                                    Monto Adjudicación
                                    @include('includes._sort-icon', ['field' => 'monto_adjudicacions.monto'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('monto_adjudicacions.multiple')" role="button" href="#">
                                    Multiples Ordenes
                                    @include('includes._sort-icon', ['field' => 'monto_adjudicacions.multiple'])
                                </a></th>
                            <th class="px-4 py-2 text-center" colspan="4">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($montos->isNotEmpty())
                            @foreach ($montos as $monto)
                                <tr>
                                    <td class="p-1 text-center  text-dark text-capitalize">{{ $monto->id_solicitud }}
                                    </td>
                                    <td class="p-1 text-center  text-dark text-capitalize">
                                        {{ $monto->tipo_solicitud }}</td>
                                    <td class="p-1 text-center  text-dark">
                                        {{ number_format($monto->monto, 2, ',', '.') }}</td>
                                    <td class="p-1 text-center text-dark text-capitalize">
                                        <span class="badge badge-info"> {{ $monto->multiple ? 'SI' : 'NO' }}</span>
                                    </td>
                                    <td class="p-1 text-center" width="25">
                                        <a data-toggle="modal" data-target="#modalAdjudicacion"
                                            wire:click.prevent="editarMonto({{ $monto->id }})"
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
                    {{ $montos->links() }}
                </div>
                <div class="col text-right text-muted">
                    Mostrar {{ $montos->firstItem() }} a {{ $montos->lastItem() }} de
                    {{ $montos->total() }} registros
                </div>
            </div>
        </div>
    </div>

</div>
