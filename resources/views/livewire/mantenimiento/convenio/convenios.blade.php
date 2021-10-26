<div>
    @include('mantenimiento.modales.convenio.modalconvenio')
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createConvenio"><i
            class="fas fa-file-archive"></i>
        Crear Nuevo Convenio
    </button>
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
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Convenio...">
                </div>
            </div>
            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('convenios.nombre')" role="button" href="#">
                                    Nombre
                                    @include('includes._sort-icon', ['field' => 'convenios.nombre'])
                                </a></th>
                            <th class="px-4 py-2 text-center text-primary">
                                Encargados
                            </th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('convenios.presupuesto')" role="button" href="#">
                                    Presupuesto
                                    @include('includes._sort-icon', ['field' => 'convenios.presupuesto'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('convenios.saldo')" role="button" href="#">
                                    Saldo
                                    @include('includes._sort-icon', ['field' => 'convenios.saldo'])
                                </a></th>
                            <th class="px-4 py-2 text-center" colspan="2">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($convenios->isNotEmpty())
                            @foreach ($convenios as $convenio)
                                <tr>
                                    <td class="p-1 text-center  text-dark">{{ $convenio->nombre }}</td>
                                    <td class="p-1 text-center  text-dark">
                                        @foreach ($convenio->encargados as $encargado)
                                            <span class="badge badge-success"> {{ $encargado->nombres }} </span>
                                        @endforeach
                                    </td>
                                    <td class="p-1 text-center  text-dark">
                                        {{ number_format($convenio->presupuesto, 2, ',', '.') }}

                                    </td>
                                    <td class="p-1 text-center  text-dark">
                                        {{ number_format($convenio->saldo, 2, ',', '.') }}</td>
                                    <td class="p-1 text-center" width="25">
                                        <a class="btn btn-sm btn-warning text-dark" data-toggle="modal"
                                            data-target="#createConvenio"
                                            wire:click.prevent="editConvenio({{ $convenio->id }})">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="p-1 text-center" width="25">
                                        <a class="btn btn-sm btn-danger text-dark"
                                            wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Convenio?','eliminarConvenio', {{ $convenio->id }})">
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
                    {{ $convenios->links() }}
                </div>
                <div class="col text-right text-muted">
                    Mostrar {{ $convenios->firstItem() }} a {{ $convenios->lastItem() }} de
                    {{ $convenios->total() }} registros
                </div>
            </div>
        </div>
    </div>

</div>
@push('scripts')

    <script>
        document.addEventListener('livewire:load', function() {
            $('#select2-dropdown').select2({
                dropdownParent: $("#createConvenio"),
                placeholder: "Selecciona Encargados",
            });

        });
        Livewire.on('reset', function() {
            $('#select2-dropdown').val(null).trigger('change');
        });
        Livewire.on('verificarEncargados', function() {
            // if ($('#select2-dropdown').select2('val').length == 0) {
            //     alert('nohas seleccionado encargados')
            // } else {
            console.log($('#select2-dropdown').select2('val'));
            @this.emit('crearConvenio', $('#select2-dropdown').select2('val'));
            // }
        });
        Livewire.on('actualizarEncargados', function() {
            console.log($('#select2-dropdown').select2('val'));
            @this.emit('updateConvenio', $('#select2-dropdown').select2('val'));
        });

        Livewire.on('edit', function(data) {
            $('#select2-dropdown').val(data.encargados).trigger('change');
        });
    </script>

@endpush
