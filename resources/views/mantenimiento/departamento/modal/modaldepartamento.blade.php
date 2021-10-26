<div wire:ignore.self class="modal fade" id="createDepartamento" tabindex="-1" role="dialog" aria-labelledby="formModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                @if ($editMode)
                <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Actualizar Departamento</h5>
                @else
                <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Crear Departamento</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="text-center text-dark font-weight-bold">DATOS GENERALES</h3>
                <form class="">
                    <div class="form-group">
                        <label class="font-weight-bold text-dark" for="inputAddress">Ingrese el Departamento</label>
                        <input type="text" wire:model.defer="nombre"
                            class="form-control @error('nombre') is-invalid @enderror" placeholder="Departamento">
                        @error('nombre')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Seleccione una Dependencia</label>
                        <select wire:model="dependencia_id"
                            class="form-control @error('dependencia_id') is-invalid @enderror">
                            <option value="" selected disabled="">Elija una Dependencia</option>
                            @foreach ($dependencias as $depe)
                            <option value="{{ $depe->id }}">{{ $depe->nombre }}</option>
                            @endforeach
                        </select>
                        @error('dependencia_id')
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
                    <span class="badge @if($estado == 'activo')
                    badge-success @else badge-danger 
                    @endif">{{ $estado }}</span>
                </div>
            </div>
            <div class="modal-footer br">
                @if ($editMode)
                <button type="button" class="btn btn-warning" wire:click="updateDepartamento">Actualizar
                    Departamento</button>
                @else
                @if ($creatingMode) disabled @endif
                <button type="button" class="btn btn-primary" @if($creatingMode) disabled @endif
                    wire:click="crearDepartamento">Crear Departamento</button>
                @endif
            </div>
        </div>
    </div>
</div>