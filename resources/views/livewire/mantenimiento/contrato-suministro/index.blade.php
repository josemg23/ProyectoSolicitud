<div>
    <a href="{{ route('admin.contrato-suministro.create') }}" class="btn btn-primary mb-2"><i
            class="fas fa-file-archive"></i>
        Crear Nuevo Contrato
    </a>
    {{-- <button type="button" class="btn btn-outline-success mb-2" wire:click.prevent="generaExcel()">
	<i class="fa fa-file-excel"></i> Generar Reporte
	</button> --}}
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

                <div class="col-lg-2">
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Contrato...">
                </div>
            </div>
            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('licitacion')" role="button" href="#">
                                    Licitacion
                                    @include('includes._sort-icon', ['field' => 'licitacion'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('decreto_adjudicacion')" role="button" href="#">
                                    Decreto de Adjudicacion
                                    @include('includes._sort-icon', ['field' => 'decreto_adjudicacion'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('fecha_inicio')" role="button" href="#">
                                    Fecha Inicio
                                    @include('includes._sort-icon', ['field' => 'fecha_inicio'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('fecha_termino')" role="button" href="#">
                                    Fecha Final
                                    @include('includes._sort-icon', ['field' => 'fecha_termino'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('monto')" role="button" href="#">
                                    Monto
                                    @include('includes._sort-icon', ['field' => 'monto'])
                                </a></th>
                            <th class="px-4 py-2 text-center" colspan="2">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($contratos->isNotEmpty())
                            @foreach ($contratos as $contrato)
                                <tr>
                                    <td class="p-1 text-center  text-dark">{{ $contrato->licitacion }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $contrato->decreto_adjudicacion }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $contrato->fecha_inicio }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $contrato->fecha_termino }}</td>
                                    <td class="p-1 text-center  text-dark">
                                        {{ number_format($contrato->monto, 2, ',', '.') }}
                                    </td>
                                    <td class="p-1 text-center" width="25">
                                        <a class="btn btn-sm btn-primary"
                                            href="{{ route('admin.contrato-suministro.show', $contrato->id) }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                    <td class="p-1 text-center" width="25">
                                        <a class="btn btn-sm btn-danger text-dark"
                                            wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Contrato de Suministro?','eliminarConvenio', {{ $contrato->id }})">
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
                    {{ $contratos->links() }}
                </div>
                <div class="col text-right text-muted">
                    Mostrar {{ $contratos->firstItem() }} a {{ $contratos->lastItem() }} de
                    {{ $contratos->total() }} registros
                </div>
            </div>
        </div>
    </div>

</div>
