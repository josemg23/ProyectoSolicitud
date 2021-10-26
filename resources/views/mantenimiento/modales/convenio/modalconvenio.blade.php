<!-- Vertically Center -->
<div wire:ignore.self class="modal fade" id="createConvenio" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="createConvenioLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl " role="document">
        <div class="modal-content ">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Actualizar Convenio</h5>
                @else
                    <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Crear Convenio</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1 class="text-center font-weight-bold text-danger">Datos de Nuevo Convenio</h1>
                <div class="form-row">
                    <div class="form-group col-lg-12">

                        @error('encarg')
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                {{ $message }}

                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            {{-- <div class="alert alert-primary" role="alert">
                            </div> --}}

                        @enderror

                    </div>
                    <div class="form-group col-lg-6">
                        <label for="">Nombre del Covenio</label>
                        <input type="text" class="form-control" wire:model.defer="nombre"
                            placeholder="Nombre del Convenio">
                        @error('nombre')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div wire:ignore class="form-group col-lg-6">
                        <label for="select2-dropdown">Encargados</label>
                        <select class="form-control" id="select2-dropdown" multiple="multiple">
                            @foreach ($encargados as $encargado)
                                <option value="{{ $encargado->id }}">{{ $encargado->nombres }}</option>
                            @endforeach
                        </select>
                        @error('encargado_id')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="">Nota</label>
                        <input type="text" class="form-control" wire:model.defer="nota" placeholder="Nota del Convenio">
                        @error('nota')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <h2 class="text-center font-weight-bold text-danger">CUENTAS</h2>
                <div class="form-row">
                    <div class="form-group col-lg-8">
                        <select name="" id="" class="form-control" wire:model.defer="cuenta_id">
                            <option value="" selected disabled>Selecciona Cuenta</option>
                            @foreach ($cuentas as $cuenta)
                                <option value="{{ $cuenta->id }}">{{ $cuenta->descripcion }}</option>

                            @endforeach
                        </select>
                        @error('cuenta_id')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-3">
                        <button wire:click="agregarCuenta()" wire:target="agregarCuenta,
                        actualizarEncargados,
                        eliminarCuenta,
                        agregarCuenta
                        editConvenio,
                        updateConvenio,
                        verificarEncargados" wire:loading.attr="disabled"
                            class="btn btn-block btn-secondary">Agregar</button>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-lg-12">
                        <h3 class="text-center font-weight-bold text-danger">Cuentas Seleccionadas</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-center ">Cuenta</th>
                                    <th class="px-4 py-2 text-center ">Descripción</th>
                                    <th class="px-4 py-2 text-center ">Monto</th>
                                    <th class="px-4 py-2 text-center ">Accion</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($seleccion as $key => $item)
                                    <tr>
                                        <td class="p-1 text-center  text-dark">{{ $item['nombre'] }}</td>
                                        <td class="p-1 text-center  text-dark">{{ $item['descripcion'] }}</td>
                                        <td class="p-1 text-center  text-dark">
                                            {{ number_format($item['saldo_a'], 2, ',', '.') }}
                                        </td>
                                        <td class="p-1 text-center  text-dark"><button class="btn btn-danger"
                                                wire:target="agregarCuenta,
                                            actualizarEncargados,
                                            eliminarCuenta,
                                            agregarCuenta
                                            editConvenio,
                                            updateConvenio,
                                            verificarEncargados" wire:loading.attr="disabled"
                                                wire:click="eliminarCuenta({{ $key }}, {{ $item['id'] }})"><i
                                                    class="fa fa-trash"></i></button></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10">
                                            <p class="text-center"> No has agregado cuentas </p>
                                        </td>
                                    </tr>
                                @endforelse


                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-lg-6">
                        <label for="">Presupuesto</label>
                        <input type="text" class="form-control" disabled
                            value="{{ number_format($presupuesto, 2, ',', '.') }}">
                    </div>
                    {{-- <div class="form-group col-lg-6">
                <label for="">Saldo</label>
                <input type="text" class="form-control" disabled wire:model.defer="saldo">
            </div> --}}
                </div>
            </div>
            <div class="modal-footer br">
                @if ($editMode)
                    <button type="button" class="btn btn-warning" wire:target="agregarCuenta,
                        actualizarEncargados,
                        eliminarCuenta,
                        agregarCuenta
                        editConvenio,
                        updateConvenio,
                        verificarEncargados" wire:loading.attr="disabled"
                        wire:click="$emit('actualizarEncargados')">Actualizar
                        Convenio</button>
                @else
                    <button type="button" class="btn btn-primary" wire:target="agregarCuenta,
                        actualizarEncargados,
                        eliminarCuenta,
                        agregarCuenta
                        editConvenio,
                        updateConvenio,
                        verificarEncargados" wire:loading.attr="disabled"
                        wire:click="$emit('verificarEncargados')">Crear
                        Convenio</button>
                @endif
            </div>
        </div>
    </div>
</div>
