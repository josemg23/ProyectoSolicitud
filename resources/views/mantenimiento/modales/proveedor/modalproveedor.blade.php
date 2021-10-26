<!-- Vertically Center -->
<div wire:ignore.self class="modal fade" id="crearProveedor" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="crearProveedorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Actualizar Proveedor</h5>
                @else
                    <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Crear Proveedor</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1 class="text-center font-weight-bold text-danger">Datos de Nuevo Proveedor</h1>
                <div class="form-row">
                    <div class="form-group col-lg-6">
                        <label for="">RUT</label>
                        <input type="text" class="form-control" wire:model.defer="rut" placeholder="Agregar Rut">
                        @error('rut')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="">Razon Social</label>
                        <input type="text" class="form-control" wire:model.defer="nombre"
                            placeholder="Agregar Razon Social">
                        @error('nombre')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="">Giro</label>
                        <textarea name="" id="" cols="5" rows="3" class="form-control" wire:model.defer="giro"
                            placeholder="Agregar Giro"></textarea>
                        {{-- <input type="text" class="form-control" > --}}
                        @error('giro')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="">Dirección</label>
                        <textarea name="" id="" cols="5" rows="3" class="form-control" wire:model.defer="direccion"
                            placeholder="Agregar Dirección"></textarea>

                        {{-- <input type="text" class="form-control" wire:model.defer="direccion"> --}}
                        @error('direccion')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="">Email</label>
                        <input type="text" class="form-control" wire:model.defer="email" placeholder="Agregar Email">
                        @error('email')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div wire:ignore class="form-group col-lg-12">
                        <label for="">Tipos de Contratos</label>
                        <select name="" wire:model="tipo_contrato" id="select2-dropdown" multiple class="form-control">
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                        @error('tipo_contrato')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer br">
                @if ($editMode)
                    <button type="button" wire:target="updateProveedor" wire:loading.attr="disabled"
                        class="btn btn-warning" wire:click="$emit('updateTipos')">Actualizar Proveedor</button>

                @else
                    <button type="button" wire:target="editProveedor" wire:loading.attr="disabled"
                        class="btn btn-primary" wire:click="$emit('verificarTipos')">Crear Proveedor</button>
                @endif
            </div>
        </div>
    </div>
</div>
