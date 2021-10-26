<div>
    @role('ejecutivo-compras')
    <a href="{{ route('ordenes.create') }}" class="btn btn-primary mb-2"><i class="fas fa-plus-circle"></i>
        Orden de Compra
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
                    <input wire:model="search" class="form-control" type="text"
                        placeholder="Buscar Orden de Compra...">
                </div>
            </div>
            <div class="row table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th style="vertical-align: middle" width="125" class="px-4 py-2 text-center "><a
                                    class="text-primary" wire:click.prevent="sortBy('orden_compras.id')" role="button"
                                    href="#">
                                    Num. </a> @include('includes._sort-icon', ['field' => 'orden_compras.id'])</th>

                            <th style="vertical-align: middle" width="350" class="px-4 py-2 text-center "><a
                                    class="text-primary" wire:click.prevent="sortBy('solicituds.adquisicion')"
                                    role="button" href="#">
                                    Adquisición
                                </a> @include('includes._sort-icon', ['field' => 'solicituds.adquisicion'])</th>
                            <th style="vertical-align: middle" width="180" class="px-4 py-2 text-center "><a
                                    class="text-primary" wire:click.prevent="sortBy('proveedors.nombre')"
                                    role="button" href="#">
                                    Proveedor
                                </a>@include('includes._sort-icon', ['field' => 'proveedors.nombre'])</th>
                            <th style="vertical-align: middle" width="180" class="px-4 py-2 text-center"><a
                                    class="text-primary" wire:click.prevent="sortBy('orden_compras.num_orden')"
                                    role="button" href="#">
                                    Numero Orden
                                </a>@include('includes._sort-icon', ['field' => 'orden_compras.num_orden'])</th>
                            <th style="vertical-align: middle" width="150" class="px-4 py-2 text-center "><a
                                    class="text-primary" wire:click.prevent="sortBy('orden_compras.valor_total')"
                                    role="button" href="#">
                                    Valor Total
                                </a> @include('includes._sort-icon', ['field' => 'orden_compras.valor_total'])</th>
                            <th style="vertical-align: middle" width="150" class="px-4 py-2 text-center"><a
                                    class="text-primary" wire:click.prevent="sortBy('orden_compras.tipo_compra')"
                                    role="button" href="#">
                                    Tipo Compra
                                </a> @include('includes._sort-icon', ['field' => 'orden_compras.tipo_compra'])</th>
                            <th style="vertical-align: middle" width="180" class="px-4 py-2 text-center "><a
                                    class="text-primary">
                                    Documento Anexo
                                </a></th>
                            <th style="vertical-align: middle" width="150" class="px-4 py-2 text-center"><a
                                    class="text-primary" wire:click.prevent="sortBy('orden_compras.created_at')"
                                    role="button" href="#">
                                    Fecha Registro
                                </a>@include('includes._sort-icon', ['field' => 'orden_compras.created_at'])</th>
                            <th class="text-center" style="vertical-align: middle" colspan="2">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($ordenes->isNotEmpty())
                            @foreach ($ordenes as $orden)
                                <tr>
                                    <td style="font-size: 12px" class="p-1 text-center  text-dark text-capitalize">
                                        {{ $orden->id }}</td>
                                    <td style="font-size: 12px" class="p-1  text-dark">
                                        <strong> {{ $orden->adquisicion }}</strong><br>
                                        - {{ $orden->descripcion }}
                                    </td>
                                    <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                        @if ($orden->tipo_compra == 'compra-menor' || $orden->tipo_compra == 'moneda')
                                            {{ $orden->proveedo }}
                                        @else
                                            {{ $orden->nom_proveedor }}
                                        @endif
                                    </td>
                                    <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                        <a class="link-badge-info" target="_blank"
                                            href="{{ asset($orden->fileorden->archivo) }}"><i
                                                class="fa {{ getIconOrder($orden->fileorden->extension) }}"></i>
                                            {{ $orden->num_orden }}</a>
                                    </td>
                                    <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                        <span class="badge {{ ramdomBadge() }}">
                                            {{ number_format($orden->valor_total, 2, ',', '.') }}</span>

                                    </td>

                                    <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                        {{ $orden->tipo_compra }}</td>
                                    <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                        @isset($orden->documento)
                                            <a class="link-badge-info" target="_blank"
                                                href="{{ asset($orden->documento->archivo) }}"><i
                                                    class="fa {{ getIconOrder($orden->documento->extension) }}"></i>
                                                Documento Anexo</a>
                                        @endisset
                                    </td>
                                    <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                        {{ $orden->created_at }}</td>
                                    @if ($orden->recepcion == 'cancelada' || $orden->recepcion == 'eliminada')
                                        <td colspan="2" class="text-center">
                                            <span
                                                class="badge {{ verificarStarus($orden->recepcion) }}">{{ $orden->recepcion }}</span>
                                        </td>
                                    @else
                                        <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                            <button
                                                wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas cancelar esta Orden de Compra?','cancelarOrden', {{ $orden->id }})"
                                                wire:target="cancelarOrden,eliminarOrden" wire:loading.attr="disabled"
                                                type="button" class="btn btn-info btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="Cancelar Orden De Compra"><i
                                                    class="fas fa-times-circle"></i></button>
                                        </td>
                                        <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                            <button
                                                wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar esta esta Orden de Compra?','eliminarOrden', {{ $orden->id }})"
                                                wire:target="cancelarOrden,eliminarOrden" wire:loading.attr="disabled"
                                                type="button" class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="Eliminar Orden De Compra"><i
                                                    class="fas fa-trash"></i></button>
                                        </td>
                                    @endif

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
                    {{ $ordenes->links() }}
                </div>
                <div class="col text-right text-muted">
                    Mostrar {{ $ordenes->firstItem() }} a {{ $ordenes->lastItem() }} de
                    {{ $ordenes->total() }} registros
                </div>
            </div>
        </div>
    </div>

</div>
