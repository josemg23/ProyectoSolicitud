<div>
    @include('mantenimiento.rechazado.modal.modal-rechazo')
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createRechazo"><i
            class="fas fa-file-archive"></i>
        Agregar Estado de Rechazo
    </button>

    <div class="card">
        <div class="card-body">
            <div class="row mb-4 justify-content-between">
                <div class="col-lg-4 form-inline">
                    Por Pagina: &nbsp;
                    <select wire:model="perPage" class="form-control form-control-sm">
                        <option>10</option>
                        <option>15</option>
                        <option>25</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Estados...">
                </div>
            </div>
            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('nombre')" role="button" href="#">
                                    Nombre
                                    @include('includes._sort-icon', ['field' => 'nombre'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('estado')" role="button" href="#">
                                    Estado
                                    @include('includes._sort-icon', ['field' => 'estado'])
                                </a></th>
                            <th class="px-4 py-2 text-center" colspan="2">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($estados->isNotEmpty())
                            @foreach ($estados as $estado)
                                <tr>
                                    <td class="p-1 text-center  text-dark">{{ $estado->nombre }}</td>
                                    <td class="p-1 text-center  text-dark">
                                        <span style="cursor: pointer;"
                                            wire:click.prevent="estadochange('{{ $estado->id }}')"
                                            class="badge {{ simpleStatus($estado->estado) }}">{{ $estado->estado }}</span>
                                    </td>
                                    <td class="p-1 text-center" width="25">
                                        <a class="btn btn-sm btn-warning text-dark" data-toggle="modal"
                                            data-target="#createRechazo"
                                            wire:click.prevent="editMotivo({{ $estado->id }})">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="p-1 text-center" width="25">
                                        <a class="btn btn-sm btn-danger text-dark"
                                            wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Registro?','eliminarMotivo', {{ $estado->id }})">
                                            <i class="fa fa-trash"></i>
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
                    {{ $estados->links() }}
                </div>
                <div class="col text-right text-muted">
                    Mostrar {{ $estados->firstItem() }} a {{ $estados->lastItem() }} de
                    {{ $estados->total() }} registros
                </div>
            </div>
        </div>
    </div>

</div>
