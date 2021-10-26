<div wire:ignore.self class="modal fade" id="crearTipo" tabindex="-1" role="dialog" aria-labelledby="formModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Actualizar Tipo de Contrato</h5>
                @else
                    <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Crear Tipo de Contrato</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="text-center text-dark font-weight-bold">DATOS GENERALES</h3>
                <form class="">
                    <div class="form-group">
                        <label class="font-weight-bold text-dark" for="inputAddress">Ingresa el Nombre</label>
                        <input type="text" wire:model.defer="nombre"
                            class="form-control @error('nombre') is-invalid @enderror" placeholder="Nombre">
                        @error('nombre')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-dark" for="inputAddress">Ingrese la Descripcion</label>
                        <input type="text" wire:model.defer="descripcion"
                            class="form-control @error('descripcion') is-invalid @enderror" placeholder="Descripcion">
                        @error('descripcion')
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
                    <button type="button" class="btn btn-warning" wire:click="updateTipo">Actualizar Tipo</button>
                @else
                    <button type="button" class="btn btn-primary" wire:click="crearTipo">Crear Tipo</button>
                @endif
            </div>
        </div>
    </div>
</div>
