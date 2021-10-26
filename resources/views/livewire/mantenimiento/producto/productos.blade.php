<div>
    @include('mantenimiento.producto.modales.productosmodal')
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#crearProducto"><i
            class="fas fa-shopping-bag"></i>
        Agregar Nuevo producto
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
                    <input wire:model="search" class="form-control" type="text" placeholder="Buscar Producto...">
                </div>
            </div>
            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('products.nombre')" role="button" href="#">
                                    Producto
                                    @include('includes._sort-icon', ['field' => 'products.nombre'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('products.detalle')" role="button" href="#">
                                    Detalle
                                    @include('includes._sort-icon', ['field' => 'products.detalle'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('products.valor')" role="button" href="#">
                                    Valor Unitario
                                    @include('includes._sort-icon', ['field' => 'products.valor'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('proveedors.nombre')" role="button" href="#">
                                    Proveedor
                                    @include('includes._sort-icon', ['field' => 'proveedors.nombre'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('medidas.nombre')" role="button" href="#">
                                    Unidad
                                    @include('includes._sort-icon', ['field' => 'medidas.nombre'])
                                </a></th>
                            <th class="px-4 py-2 text-center "><a class="text-primary"
                                    wire:click.prevent="sortBy('tipo_contratos.nombre')" role="button" href="#">
                                    Tipo Contrato
                                    @include('includes._sort-icon', ['field' => 'tipo_contratos.nombre'])
                                </a></th>
                            <th class="px-4 py-2 text-center" colspan="2">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($productos->isNotEmpty())
                            @foreach ($productos as $producto)
                                <tr>
                                    <td class="p-1 text-center  text-dark">{{ $producto->nombre }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $producto->detalle }}</td>
                                    <td class="p-1 text-center  text-dark">
                                        {{ number_format($producto->valor, 2, ',', '.') }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $producto->proveedor }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $producto->unidad }}</td>
                                    <td class="p-1 text-center  text-dark">{{ $producto->tipo_contrato }}</td>
                                    <td class="p-1 text-center" width="25">
                                        <a class="btn btn-sm btn-warning text-dark" data-toggle="modal"
                                            data-target="#crearProducto"
                                            wire:click.prevent="editProducto({{ $producto->id }})">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="p-1 text-center" width="25">
                                        <a class="btn btn-sm btn-danger text-dark"
                                            wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Producto?','eliminarProducto', {{ $producto->id }})">
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
                    {{ $productos->links() }}
                </div>
                <div class="col text-right text-muted">
                    Mostrar {{ $productos->firstItem() }} a {{ $productos->lastItem() }} de
                    {{ $productos->total() }} registros
                </div>
            </div>
        </div>
    </div>

</div>
@push('scripts')

    {{-- <script>
        $(document).ready(function() {
            $('#select2-dropdown').select2({
                dropdownParent: $("#crearProducto"),
            });
            $('#tipos-dropdown').select2({
                dropdownParent: $("#crearProducto"),
            });
            $('#select2-dropdown').on('change', function(e) {
                var data = $('#select2-dropdown').select2("val");
                @this.emit('cargartipos', data);
                // @this.set('proveedor_id', data);
            });
            $('#tipos-dropdown').on('change', function(e) {
                var data = $('#tipos-dropdown').select2("val");
                // @this.emit('tipo_pro', data);
                @this.set('tipo_contrato_id', data);
            });
        });
    </script> --}}
    <script>
        const producto = new Vue({
            el: "#producto",
            name: "Producto",
            data: {
                proveedores: [],
                proveedor_id: '',
                tipos_contratos: [],
                tipo_contrato_id: '',
            },
            methods: {
                searchTipos() {
                    producto.tipos_contratos = [];
                    producto.tipo_contrato_id = '';
                    @this.emit('cargartipos', this.proveedor_id);

                    // @this.set('tipo_contrato_id', this.tipo_contrato_id);

                },
                setTipo() {
                    @this.set('tipo_contrato_id', this.tipo_contrato_id);


                }
            }
        });
        Livewire.on('reset', function() {
            producto.proveedor_id = '';
            producto.tipos_contratos = [];
            producto.tipo_contrato_id = '';

        });
        Livewire.on('edit', function(data) {
            producto.proveedor_id = data.proveedor_id;
            // producto.tipos_contratos = [];
            producto.tipo_contrato_id = data.tipo_contrato_id;
        });
        Livewire.on('setTipo', function(data) {
            producto.tipos_contratos = data.tipos;
        });
        Livewire.on('setProveedores', function(data) {
            producto.proveedores = data.proveedores;
        });
        setTimeout(() => {
            Livewire.emit('cargarProveedores');

        }, 300);
    </script>

@endpush
