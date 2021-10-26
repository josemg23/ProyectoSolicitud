<!-- Vertically Center -->
<div wire:ignore.self class="modal fade" id="modalAdjudicacion" data-backdrop="static" data-keyboard="false"
    tabindex="-1" aria-labelledby="modalAdjudicacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content ">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Editar Monto de Adjudicación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    wire:click="resetModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-lg-6">
                        <label for="">Monto Actual</label>
                        <input type="text" class="form-control text-right"
                            value="{{ number_format($monto_actual, 2, ',', '.') }}" disabled>
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="">Nuevo Monto</label>
                        <input type="number" class="form-control text-right" wire:model.defer="monto_nuevo">
                        @error('monto_nuevo')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- <div class="form-group col-lg-12">
                        <label for="">Motivo del Cambio</label>
                        <textarea name="" id="" class="form-control" rows="5" wire:model.defer="motivo"></textarea>
                        @error('motivo')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div> --}}
                </div>
            </div>
            <div class="modal-footer br">
                <button class="btn btn-danger" wire:target="actualizarMonto" wire:loading.attr="disabled"
                    wire:click.prevent="actualizarMonto">Actualizar
                    Monto</button>
            </div>
        </div>
    </div>
</div>
