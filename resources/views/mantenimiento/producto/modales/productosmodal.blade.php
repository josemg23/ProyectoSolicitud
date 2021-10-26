<!-- Vertically Center -->
<div wire:ignore.self class="modal fade" id="crearProducto" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="crearProductoLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Actualizar Producto</h5>
                @else
                    <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Crear Producto</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1 class="text-center font-weight-bold text-danger">Datos de Nuevo Producto</h1>
                @if ($errors->any())

                    @error('proveedor_id')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                    @enderror
                    @error('tipo_contrato_id')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                    @enderror


                @endif
                <div wire:ignore class="form-row" id="producto">
                    <div class="form-group col-lg-12">
                        <label for="">Proveedor</label>
                        <model-list-select :list="proveedores" v-model="proveedor_id" class="form-control"
                            option-value="id" option-text="nombre" placeholder="Elije Un Proveedor"
                            @input="searchTipos">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="">Tipos Contrato</label>
                        <model-list-select :list="tipos_contratos" v-model="tipo_contrato_id" class="form-control"
                            option-value="id" option-text="nombre" placeholder="Elije un Tipo de Contrato"
                            @input="setTipo">
                    </div>
                </div>
                <div class="form-row">

                    <div class="form-group col-lg-12">
                        <label for="">Producto</label>
                        <input type="text" class="form-control" wire:model.defer="nombre">
                        @error('nombre')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="">Detalle</label>
                        <textarea name="" id="" cols="5" rows="3" class="form-control"
                            wire:model.defer="detalle"></textarea>
                        @error('detalle')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="">Valor Unitario</label>
                        <input type="number" class="form-control" wire:model.defer="valor">
                        @error('valor')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group col-lg-12">
                        <label for="">Unidad</label>
                        <select wire:model.defer="unidad_id" class="form-control">
                            <option value="" selected disabled>-- Seleccione Unidad -- </option>
                            @foreach ($unidades as $unidad)
                                <option value="{{ $unidad->id }}">{{ $unidad->nombre }}</option>
                            @endforeach
                        </select>
                        @error('unidad_id')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    @error('proveedor_id')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                    @enderror

                </div>
            </div>
            <div class="modal-footer br">
                @if ($editMode)
                    <button type="button" wire:target="updateProducto" wire:loading.attr="disabled"
                        class="btn btn-warning" wire:click="updateProducto">Actualizar Producto</button>

                @else
                    <button type="button" wire:target="editProducto" wire:loading.attr="disabled"
                        class="btn btn-primary" wire:click="storeProducto">Crear Producto</button>
                @endif
            </div>
        </div>
    </div>
</div>
