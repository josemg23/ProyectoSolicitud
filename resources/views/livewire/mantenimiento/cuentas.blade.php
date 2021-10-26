<div>
    @include('mantenimiento.cuenta.modal.modalcuenta')
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createCuenta"><i
            class="fas fa-list"></i>
        Crear Nueva Cuenta
    </button>

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body p-0">
                    <div class="row p-2">
                        <div class="col-lg-3 col-sm-12 mt-2">
                            <input wire:model.debounce.300ms="search" type="text" class="form-control p-2"
                                placeholder="Buscar Cuentas...">
                        </div>
                        <div class="col-lg-2 col-sm-12 mt-2">
                            <select wire:model="orderBy" class="custom-select " id="grid-state">
                                <option value="id">ID</option>
                                <option value="nombre">Cuenta</option>

                            </select>

                        </div>
                        <div class="col-lg-2 col-sm-12 mt-2">
                            <select wire:model="orderAsc" class="custom-select " id="grid-state">
                                <option value="1">Ascendente</option>
                                <option value="0">Descenente</option>
                            </select>

                        </div>
                        <div class="col-lg-2 col-sm-12 mt-2">
                            <select wire:model="perPage" class="custom-select " id="grid-state">
                                <option>10</option>
                                <option>25</option>
                                <option>50</option>
                                <option>100</option>
                            </select>

                        </div>


                    </div>
                    <div class="table-responsive">

                        <table class="table table-striped">
                            <thead class="">
                                <tr class="">
                                    <th class="px-4 py-2 text-center ">Cuenta</th>
                                    <th class="px-4 py-2 text-center ">Descripcion</th>
                                    <th class="px-4 py-2 text-center ">Saldo Inicial</th>
                                    <th class="px-4 py-2 text-center ">Saldo Actual</th>
                                    <th class="px-4 py-2 text-center ">Estado</th>
                                    <th class="px-4 py-2 text-center " colspan="3">Accion</th>
                                </tr>
                            </thead>
                            <tbody class="text-center text-dark">
                                @if ($cuentas->isNotEmpty())
                                    @foreach ($cuentas as $c)
                                        <tr>
                                            <td class="p-1 text-center  text-dark">{{ $c->nombre }}</td>
                                            <td class="p-1 text-center  text-dark">{{ $c->descripcion }}</td>
                                            <td class="p-1 text-center  text-dark">
                                                {{ number_format($c->saldo_i, 2, ',', '.') }}</td>
                                            <td class="p-1 text-center  text-dark">
                                                {{ number_format($c->saldo_a, 2, ',', '.') }}</td>

                                            <td class="p-1 text-center  text-dark">
                                                <span style="cursor: pointer;"
                                                    wire:click.prevent="estadochange('{{ $c->id }}')"
                                                    class="badge {{ simpleStatus($c->estado) }}">{{ $c->estado }}</span>

                                            </td>
                                            <td class="p-1 text-center" width="25"><a
                                                    href="{{ route('admin.cuenta.show', $c->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a></td>
                                            <td class="p-1 text-center" width="25">
                                                <a class="btn btn-sm btn-warning text-dark" data-toggle="modal"
                                                    data-target="#createCuenta"
                                                    wire:click.prevent="editCuenta({{ $c->id }})">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                            <td class="p-1 text-center" width="25">
                                                <a class="btn btn-sm btn-danger text-dark"
                                                    wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Usuario?','eliminarCuenta', {{ $c->id }})">
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
                                                <strong>{{ $page }}</strong> al mostrar
                                                <strong>{{ $perPage }} </strong> por pagina
                                            </p>
                                        </td>
                                    </tr>

                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row justify-content-center">
                    {!! $cuentas->links() !!}

                </div>
            </div>
        </div>
    </div>
</div>
