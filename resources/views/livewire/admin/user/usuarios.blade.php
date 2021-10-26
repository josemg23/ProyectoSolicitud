<div>
    @include('admin.modales.users.modaluser')
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createUser"><i
            class="fa fa-user-plus"></i>
        Crear Nuevo Usuario
    </button>
    {{-- <button type="button" class="btn btn-outline-success mb-2" wire:click.prevent="generaExcel()">
	<i class="fa fa-file-excel"></i> Generar Reporte
	</button> --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body p-1">
                    <div class="row p-2">
                        <div class="col-lg-3 col-sm-12 mt-2">
                            <input wire:model.debounce.300ms="search" type="text" class="form-control p-2"
                                placeholder="Buscar Usuarios...">
                        </div>
                        <div class="col-lg-2 col-sm-12 mt-2">
                            <select wire:model="orderBy" class="custom-select " id="grid-state">
                                <option value="id">ID</option>
                                <option value="nombres">Nombre</option>
                                <option value="email">Correo</option>
                            </select>

                        </div>
                        <div class="col-lg-2 col-sm-12 mt-2">
                            <select wire:model="orderAsc" class="custom-select " id="grid-state">
                                <option value="1">Ascendente</option>
                                <option value="0">Descenente</option>
                            </select>

                        </div>
                        <div class="col-lg-3 col-sm-12 mt-2">
                            <select wire:model="findrole" class="custom-select " id="grid-state">
                                <option value="">Roles</option>
                                @foreach ($roles as $r)
                                    <option value="{{ $r->name }}">{{ $r->description }}</option>
                                @endforeach
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
                                    <th class="px-4 py-2 text-center ">Nombres</th>
                                    <th class="px-4 py-2 text-center ">Usuario</th>
                                    <th class="px-4 py-2 text-center ">Correo</th>
                                    <th class="px-4 py-2 text-center ">Rol</th>
                                    <th class="px-4 py-2 text-center ">Estado</th>
                                    <th class="px-4 py-2 text-center ">Ultimo Acceso</th>
                                    <th class="px-4 py-2 text-center " colspan="2">Accion</th>
                                </tr>
                            </thead>
                            <tbody class="text-center text-dark">
                                @if ($data->isNotEmpty())
                                    @foreach ($data as $user)
                                        <tr>
                                            <td class="p-1 text-center  text-dark">{{ $user->nombres }}</td>
                                            <td class="p-1 text-center  text-dark">{{ $user->username }}</td>
                                            <td class="p-1 text-center  text-dark">{{ $user->email }}</td>
                                            <td class="p-1 text-center  text-dark">
                                                <span
                                                    class="text-capitalize badge {{ ramdomBadge() }}">{{ $user->roles[0]->description }}</span>
                                            </td>
                                            <td class="p-1 text-center  text-dark">
                                                <span style="cursor: pointer;"
                                                    wire:click.prevent="estadochange('{{ $user->id }}')"
                                                    class="badge {{ simpleStatus($user->estado) }}">{{ $user->estado }}</span>
                                            </td>
                                            <td>
                                                @isset($user->access_at)
                                                    {{ Carbon\Carbon::parse($user->access_at)->diffForHumans() }}
                                                @else
                                                    Sin Ingreso
                                                @endisset
                                            </td>
                                            <td class="p-1 text-center" width="25">
                                                <a class="btn btn-sm btn-warning text-dark" data-toggle="modal"
                                                    data-target="#createUser"
                                                    wire:click.prevent="editUser({{ $user->id }})">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                            <td class="p-1 text-center" width="25">
                                                <a class="btn btn-sm btn-danger text-dark"
                                                    wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Usuario?','eliminarUser', {{ $user->id }})">
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
                    {!! $data->links() !!}

                </div>
            </div>
        </div>
    </div>
</div>
