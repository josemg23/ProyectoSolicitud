<!-- Vertically Center -->
<div wire:ignore.self class="modal fade" id="modalPermisos" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modalPermisosLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Administración de Permisos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1 class="text-center font-weight-bold text-danger">Administrar Permisos</h1>
                <div class="form-inline">
                    <label class="my-1 mr-2" for="inlineFormCustomSelectPref">ROL SELECCIONADO</label>

                    <select class="form-control" id="" wire:model="role" wire:change="obtenerPermisos()">
                        @foreach ($allRoles as $unique)
                            <option value="{{ $unique->name }}">{{ $unique->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <h4 class="text-center text-danger">Asignados</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 ">Permiso</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permisos as $per)
                                    <tr>
                                        <td>{{ $per->description }}</td>
                                        <td width="25" class="text-left"><button
                                                wire:target="quitarPermiso, obtenerPermisos, asignarPermiso"
                                                wire:loading.attr="disabled"
                                                wire:click.prevent="quitarPermiso('{{ $per->name }}')"
                                                class="btn btn-danger">Quitar</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-6">
                        <h4 class="text-center text-danger">Disponibles</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Permiso</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($libres as $libre)
                                    <tr>
                                        <td>{{ $libre->description }}</td>
                                        <td width="25" class="text-left"><button
                                                wire:target="quitarPermiso, obtenerPermisos, asignarPermiso"
                                                wire:loading.attr="disabled"
                                                wire:click.prevent="asignarPermiso('{{ $libre->name }}')"
                                                class="btn btn-success">Asignar</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer br">

            </div>
        </div>
    </div>
</div>
