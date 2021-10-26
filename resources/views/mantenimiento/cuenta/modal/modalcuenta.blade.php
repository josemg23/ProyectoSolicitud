<div wire:ignore.self class="modal fade" id="createCuenta" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="createCuentaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg " role="document">
        <div class="modal-content ">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Actualizar Cuenta</h5>
                @else
                    <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Crear Cuenta</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInput">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="text-center text-dark font-weight-bold">DATOS GENERALES</h3>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="font-weight-bold text-dark" for="inputAddress">Ingrese la Cuenta</label>
                        <input type="text" wire:model.defer="nombre"
                            class="form-control @error('nombre') is-invalid @enderror" placeholder="Cuenta">
                        @error('nombre')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">

                        <label class="font-weight-bold text-dark" for="inputEmail4">Descripción</label>
                        <input type="text" wire:model.defer="descripcion"
                            class="form-control @error('descripcion') is-invalid @enderror" placeholder="Descripción">
                        @error('descripcion')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>


                    <div class="form-group col-md-6">
                        <label class="font-weight-bold text-dark" for="inputAddress">Saldo Inicial</label>
                        <input type="number" wire:model.defer="saldo_i"
                            class="form-control @error('saldo_i') is-invalid @enderror" placeholder="Saldo Inicial">
                        @error('saldo_i')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="font-weight-bold text-dark" for="inputAddress">Saldo Actual</label>
                        <input type="number" wire:model.defer="saldo_a"
                            class="form-control @error('saldo_a') is-invalid @enderror" placeholder="Saldo Actual">
                        @error('saldo_a')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="selectgroup selectgroup-pills">
                    <span class="font-weight-bold text-dark"> Estado:</span>
                    <label class="selectgroup-item">
                        <input type="radio" wire:model="estado" name="estado" value="activo" class="selectgroup-input">
                        <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-toggle-on"></i></span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" wire:model="estado" name="estado" value="inactivo"
                            class="selectgroup-input">
                        <span class="selectgroup-button selectgroup-button-icon"><i
                                class="fas fa-toggle-off"></i></span>
                    </label>
                    <span class="badge @if ($estado=='activo' ) badge-success @else badge-danger @endif">{{ $estado }}</span>
                </div>
            </div>

            <div class="modal-footer br">
                @if ($editMode)
                    <button type="button" class="btn btn-warning" wire:click="updateCuenta">Actualizar Cuenta</button>
                @else
                    @if ($creatingMode) disabled @endif
                    <button type="button" class="btn btn-primary" @if ($creatingMode) disabled @endif wire:click="crearCuenta">Crear Cuenta</button>
                @endif
            </div>
        </div>
    </div>
</div>
