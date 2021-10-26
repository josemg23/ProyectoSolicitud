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

                <div class="col-lg-3">
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Recepción...">
                </div>
            </div>
            <div class="row table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th style="vertical-align: middle" width="150" class="px-4 py-2 text-center "><a
                                    class="text-primary" wire:click.prevent="sortBy('solicituds.id')" role="button"
                                    href="#">
                                    Num. Solicitud </a> @include('includes._sort-icon', ['field' => 'solicituds.id'])
                            </th>
                            <th style="vertical-align: middle" width="150" class="px-4 py-2 text-center "><a
                                    class="text-primary" wire:click.prevent="sortBy('users.nombres')" role="button"
                                    href="#">
                                    Solicitante
                                </a> @include('includes._sort-icon', ['field' => 'users.nombres'])</th>
                            <th style="vertical-align: middle" width="180" class="px-4 py-2 text-center"><a
                                    class="text-primary" wire:click.prevent="sortBy('recepcions.num_documento')"
                                    role="button" href="#">
                                    Numero Documento
                                </a>@include('includes._sort-icon', ['field' => 'recepcions.num_documento'])</th>
                            <th style="vertical-align: middle" width="180" class="px-4 py-2 text-center"><a
                                    class="text-primary" wire:click.prevent="sortBy('recepcions.documento')"
                                    role="button" href="#">
                                    Tipo Documento
                                </a>@include('includes._sort-icon', ['field' => 'recepcions.documento'])</th>
                            <th style="vertical-align: middle" width="180" class="px-4 py-2 text-center "><a
                                    class="text-primary" wire:click.prevent="sortBy('recepcions.tipo')" role="button"
                                    href="#">
                                    Tipo Recepción
                                </a>@include('includes._sort-icon', ['field' => 'recepcions.tipo'])</th>
                            <th style="vertical-align: middle" width="150" class="px-4 py-2 text-center "><a
                                    class="text-primary" wire:click.prevent="sortBy('recepcions.monto_total')"
                                    role="button" href="#">
                                    Monto Recepción
                                </a> @include('includes._sort-icon', ['field' => 'recepcions.monto_total'])</th>
                            <th width="50">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($recepciones->isNotEmpty())
                            @foreach ($recepciones as $recepcion)
                                <tr>
                                    <td style="font-size: 12px" class="p-1 text-center  text-dark text-capitalize">
                                        {{ $recepcion->id }}</td>
                                    <td style="font-size: 12px" class="p-1  text-dark text-center">
                                        {{ $recepcion->user_solicitante }}
                                    </td>

                                    <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                        @isset($recepcion->document)
                                            <a class="link-badge-info" target="_blank"
                                                href="{{ asset($recepcion->document->archivo) }}"><i
                                                    class="fa {{ getIconOrder($recepcion->document->extension) }}"></i>
                                                {{ $recepcion->num_documento }}</a>
                                        @endisset

                                    </td>
                                    <td style="font-size: 12px" class="p-1  text-dark text-center text-capitalize">
                                        {{ $recepcion->documento }}
                                    </td>
                                    <td style="font-size: 12px" class="p-1 text-center text-dark text-capitalize">
                                        <span class="badge {{ ramdomBadge() }}">
                                            {{ $recepcion->tipo }}</span>

                                    </td>
                                    <td style="font-size: 12px" class="p-1 text-center  text-dark">
                                        <span class="badge {{ ramdomBadge() }}">
                                            {{ number_format($recepcion->monto_total, 2, ',', '.') }}</span>
                                    </td>
                                    <td class="p-1 text-center" width="25">
                                        <a class="btn btn-sm btn-warning text-dark" @if ($recepcion->aprobacion == 'finanzas')
                                            href="{{ route('recepciones.aprobaciones.finanzas.create', $recepcion->id) }}"
                                        @else
                                            href="{{ route('recepciones.aprobaciones.abastecimiento.create', $recepcion->id) }}"
                            @endif>
                            <i class="fa fa-edit"></i>
                            </a>
                            {{-- <button
                                            wire:click.prevent="aprobarRecepcion('{{ $recepcion->id }}',{{ $recepcion->aprobacion }})">
                                            <i class="fa fa-edit"></i>
                                        </button> --}}
                            </td>
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
                    {{ $recepciones->links() }}
                </div>
                <div class="col text-right text-muted">
                    Mostrar {{ $recepciones->firstItem() }} a {{ $recepciones->lastItem() }} de
                    {{ $recepciones->total() }} registros
                </div>
            </div>
        </div>
    </div>

</div>
