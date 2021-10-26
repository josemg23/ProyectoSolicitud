<div>
    @include('mantenimiento.modales.proveedor.modalproveedor')
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#crearProveedor"><i
            class="fas fa-file-archive"></i>
        Agregar Nuevo Proveedor
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

                <div class="col-lg-3">
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Proveedor...">
                </div>
            </div>
            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('rut')" role="button" href="#">
                                    RUT
                                    @include('includes._sort-icon', ['field' => 'rut'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('nombre')" role="button" href="#">
                                    Proveedor
                                    @include('includes._sort-icon', ['field' => 'nombre'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('giro')" role="button" href="#">
                                    Giro
                                    @include('includes._sort-icon', ['field' => 'giro'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('direccion')" role="button" href="#">
                                    Dirección
                                    @include('includes._sort-icon', ['field' => 'direccion'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('email')" role="button" href="#">
                                    Email
                                    @include('includes._sort-icon', ['field' => 'email'])
                                </a></th>
                            <th class="px-4 py-2 text-center" colspan="2">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($proveedores->isNotEmpty())
                            @foreach ($proveedores as $proveedor)
                                <tr>
                                    <td class="p-1 text-center  text-dark">{{ $proveedor->rut }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $proveedor->nombre }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $proveedor->giro }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $proveedor->direccion }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $proveedor->email }}</td>
                                    <td class="p-1 text-center" width="25">
                                        <a class="btn btn-sm btn-warning text-dark" data-toggle="modal"
                                            data-target="#crearProveedor"
                                            wire:click.prevent="editProveedor({{ $proveedor->id }})">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="p-1 text-center" width="25">
                                        <a class="btn btn-sm btn-danger text-dark"
                                            wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Proveedor?','eliminarProveedor', {{ $proveedor->id }})">
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
                    {{ $proveedores->links() }}
                </div>
                <div class="col text-right text-muted">
                    Mostrar {{ $proveedores->firstItem() }} a {{ $proveedores->lastItem() }} de
                    {{ $proveedores->total() }} registros
                </div>
            </div>
        </div>
    </div>

</div>
@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            $('#select2-dropdown').select2({
                dropdownParent: $("#crearProveedor"),
                placeholder: "Tipos de Contratos",
            });
        });
        Livewire.on('reset', function() {
            $('#select2-dropdown').val(null).trigger('change');
        });
        Livewire.on('verificarTipos', function() {
            // if ($('#select2-dropdown').select2('val').length == 0) {
            //     alert('nohas seleccionado encargados')
            // } else {
            console.log($('#select2-dropdown').select2('val'));
            @this.emit('storeProveedor', $('#select2-dropdown').select2('val'));
            // }
        });
        Livewire.on('updateTipos', function() {
            console.log($('#select2-dropdown').select2('val'));
            @this.emit('updateProveedor', $('#select2-dropdown').select2('val'));
        });

        Livewire.on('edit', function(data) {
            $('#select2-dropdown').val(data.tipos).trigger('change');
        });
    </script>
@endpush
