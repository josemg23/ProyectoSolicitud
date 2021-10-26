<!-- Vertically Center -->
<div wire:ignore.self class="modal fade" id="createUser" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="createUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl " role="document">
        <div class="modal-content ">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Actualizar Usuario</h5>
                @else
                    <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Crear Usuario</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInput">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="text-center text-dark font-weight-bold">DATOS GENERALES</h3>
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label class="font-weight-bold text-dark" for="inputAddress">Nombres</label>
                        <input type="text" wire:model.defer="reNombres"
                            class="form-control @error('reNombres') is-invalid @enderror"
                            placeholder="Nombres y Apellidos">
                        @error('reNombres')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label class="font-weight-bold text-dark" for="inputEmail4">Usuario</label>
                        <input type="text" wire:model.defer="reUsuario"
                            class="form-control @error('reUsuario') is-invalid @enderror" placeholder="Usuario">
                        @error('reUsuario')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label class="font-weight-bold text-dark" for="inputPassword4">Correo</label>
                        <input type="email" wire:model.defer="reEmail"
                            class="form-control @error('reEmail') is-invalid @enderror"
                            placeholder="Correo Electronico">
                        @error('reEmail')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Selecciona un Rol</label>
                        <select wire:model="rol" class="form-control @error('rol') is-invalid @enderror">
                            <option value="" selected disabled="">Elige un Rol</option>
                            @foreach ($roles as $ro)
                                <option class="text-capitalize" value="{{ $ro->name }}">{{ $ro->description }}
                                </option>
                            @endforeach
                        </select>
                        @error('rol')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-md-12">
                        <label for="inputEmail3" class=" text-dark font-weight-bold">Selecciona un Departamento</label>
                        <select wire:model="departamento_id"
                            class="form-control @error('departamento_id') is-invalid @enderror">
                            <option value="" selected disabled="">Elige un Departamento</option>
                            @foreach ($departamentos as $departamento)
                                <option value="{{ $departamento->id }}">{{ $departamento->dependencia->nombre }} /
                                    {{ $departamento->nombre }}</option>
                            @endforeach
                        </select>
                        @error('departamento_id')
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
                    <button type="button" class="btn btn-warning" wire:click="updateUser">Actualizar Usuario</button>
                @else
                    @if ($creatingMode) disabled @endif
                    <button type="button" class="btn btn-primary" @if ($creatingMode) disabled @endif wire:click="crearUsuario">Crear Usuario</button>
                @endif
            </div>
        </div>
    </div>
</div>
