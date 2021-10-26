<div>
    @role('ejecutivo-compras')
    <a href="{{ route('decretos.create') }}" class="btn btn-primary mb-2"><i class="fas fa-plus-circle"></i>
        Decreto de Adjudicación
    </a>
    @endrole
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
                <div class="col-lg-3">
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Decreto...">
                </div>
            </div>
            <div class="row table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th style="vertical-align: middle" width="125" class="px-4 py-2 text-center "><a
                                    class="text-primary" wire:click.prevent="sortBy('decretos.id')" role="button"
                                    href="#">
                                    Num. @include('includes._sort-icon', ['field' => 'decretos.id'])</a> </th>

                            <th style="vertical-align: middle" width="350" class="px-4 py-2 text-center "><a
                                    class="text-primary" wire:click.prevent="sortBy('solicituds.adquisicion')"
                                    role="button" href="#">
                                    Adquisición @include('includes._sort-icon', ['field' => 'solicituds.adquisicion'])
                                </a> </th>

                            <th style="vertical-align: middle" width="180" class="px-4 py-2 text-center"><a
                                    class="text-primary" wire:click.prevent="sortBy('decretos.num_orden')" role="button"
                                    href="#">
                                    Numero Decreto @include('includes._sort-icon', ['field' => 'decretos.num_orden'])
                                </a></th>
                            <th style="vertical-align: middle" width="150" class="px-4 py-2 text-center"><a
                                    class="text-primary" wire:click.prevent="sortBy('decretos.created_at')"
                                    role="button" href="#">
                                    Fecha Registro @include('includes._sort-icon', ['field' => 'decretos.created_at'])
                                </a></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($decretos->isNotEmpty())
                            @foreach ($decretos as $decreto)
                                <tr>
                                    <td style="font-size: 12px" class="p-1 text-center  text-dark text-capitalize">
                                        {{ $decreto->id }}</td>
                                    <td style="font-size: 12px" class="p-1  text-dark">
                                        <strong> {{ $decreto->adquisicion }}</strong><br>
                                        - {{ $decreto->descripcion }}
                                    </td>
                                    <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                        <a class="link-badge-info" target="_blank"
                                            href="{{ asset($decreto->documento->archivo) }}"><i
                                                class="fa {{ getIconOrder($decreto->documento->extension) }}"></i>
                                            {{ $decreto->num_decreto }}</a>
                                    </td>
                                    <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                        {{ $decreto->created_at }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td style="font-size: 12px" colspan="10">
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
                    {{ $decretos->links() }}
                </div>
                <div class="col text-right text-muted">
                    Mostrar {{ $decretos->firstItem() }} a {{ $decretos->lastItem() }} de
                    {{ $decretos->total() }} registros
                </div>
            </div>
        </div>
    </div>

</div>
