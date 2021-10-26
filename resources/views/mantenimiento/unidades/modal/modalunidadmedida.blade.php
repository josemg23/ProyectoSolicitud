<div wire:ignore.self class="modal fade" id="createMedida" tabindex="-1" role="dialog" aria-labelledby="formModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Actualizar Unidad de Medida</h5>
                @else
                    <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Crear Unidad de Medida</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInput">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="text-center text-dark font-weight-bold">DATOS GENERALES</h3>
                <form class="">
                    <div class="form-group">
                        <label class="font-weight-bold text-dark" for="inputAddress">Ingrese la Unidad de Medida</label>
                        <input type="text" wire:model.defer="nombre"
                            class="form-control @error('nombre') is-invalid @enderror" placeholder="Unidad de Medida">
                        @error('nombre')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </form>
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
                    <button type="button" class="btn btn-warning" wire:click="updateMedida">Actualizar Unidad</button>
                @else
                    @if ($creatingMode) disabled @endif
                    <button type="button" class="btn btn-primary" @if ($creatingMode) disabled @endif wire:click="crearMedida">Crear Unidad</button>
                @endif
            </div>
        </div>
    </div>
</div>
