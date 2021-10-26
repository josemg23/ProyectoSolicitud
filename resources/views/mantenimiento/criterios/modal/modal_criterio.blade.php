<div wire:ignore.self class="modal fade" id="createCriterio" tabindex="-1" role="dialog" aria-labelledby="formModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="exampleModalCenterTitle">
                    {{ $editMode ? 'Actualizar Criterio de Adjudicación' : 'Crear Criterio de Adjudicación' }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    wire:click="resetInput">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="text-center text-dark font-weight-bold">DATOS GENERALES</h3>
                <form class="___class_+?8___">
                    <div class="form-group">
                        <label class="font-weight-bold text-dark" for="inputAddress">Ingrese el Criterio de
                            Adjudicación</label>
                        <input type="text" wire:model.defer="nombre"
                            class="form-control @error('nombre') is-invalid @enderror"
                            placeholder="Criterio de Adjudicación">
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
                    <span class="badge @if ($estado == 'activo') badge-success @else badge-danger @endif">{{ $estado }}</span>
                </div>
            </div>
            <div class="modal-footer br">
                @if ($editMode)
                    <button type="button" class="btn btn-warning"
                        wire:target="updateCriterio, createCriterio, editCriterio" wire:loading.attr="disabled"
                        wire:click="updateCriterio">Actualizar Estado</button>
                @else
                    <button type="button" class="btn btn-primary"
                        wire:target="updateCriterio, createCriterio, editCriterio" wire:loading.attr="disabled"
                        wire:click="createCriterio">Crear Estado</button>
                @endif
            </div>
        </div>
    </div>
</div>
