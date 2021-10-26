<!-- Vertically Center -->
<div class="modal fade" id="modalRecepcionDiferencia" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modalRecepcionDiferenciaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Diferencia en Recepción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    @click.prevent="resetVariables()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <small class="text-danger">Hay una diferencia de <strong>@{{ diferencia . total }} CLP</strong>, por
                    lo que debes detallar el motivo.</small>
                <div class="form-row">
                    <div class="form-group col-lg-6">
                        <label for="">Diferencia:</label>
                        <input disabled :value="diferencia.total" class="form-control">
                    </div>
                    <div class="form-group col-lg-6">
                        <label for="">Tipo:</label>
                        <input disabled :value="diferencia.tipo" class="form-control">
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="">Motivo:</label>
                        <textarea name="" id="" cols="5" rows="5" v-model="diferencia.detalle"
                            class="form-control"></textarea>
                        <small>Detalla aqui el motivo de la diferencia.</small>
                    </div>
                </div>

            </div>
            <div class="modal-footer br">
                <button type="button" class="btn btn-primary" @click.prevent="storeDiferencia()">Generar
                    Recepción</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalLicitacion" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modalLicitacionLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Proceso Licitación Publica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    @click.prevent="resetLicitacion()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div v-if="estado=='completa'">
                    <h5 class="text-center text-danger">Recepción Completa</h5>
                    <div class="form-row">
                        <div class="form-group col-lg-6" v-if="!orden.last_orden">
                            <label for="">Recepciones Totales</label>
                            <money :value="sum_recepcion" v-bind="money" disabled class="form-control text-right">
                            </money>
                            <small>Suma de esta orden de compra</small>
                        </div>
                        <div class="form-group col-lg-6" v-else>
                            <label for="">Recepciones Totales</label>
                            <money :value="all_recepcion" v-bind="money" disabled class="form-control text-right">
                            </money>
                            <small>Suma de la recepción en todas las ordenes</small>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="">Monto de Adjudicación</label>
                            <money :value="solicitud.monto_adjudicacion" v-bind="money" disabled
                                class="form-control text-right">
                            </money>
                            <small>Monto de Adjudicación de la solicitud</small>
                        </div>
                        <div class="form-group col-lg-12">
                            <div class="n-chk">
                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-success">
                                    <input type="checkbox" v-model="orden.last_orden"
                                        :disabled="estado == 'completa' && !solicitud.multiples_ordenes || all_recepcion == solicitud.monto_adjudicacion"
                                        class="new-control-input">
                                    <span class="new-control-indicator"></span> Ultima Orden a Recepcionar
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
                <div v-else>
                    <h5 class="text-center text-danger">Recepción Parcial</h5>
                    <div class="form-row">
                        <div class="form-group col-lg-6" v-if="mode == 'guardar'">
                            <label for="">Total Recepcionado</label>
                            <money :value="sum_recepcion" v-bind="money" disabled class="form-control text-right">
                            </money>
                            <small>Suma de recepciones en Orden Actual</small>
                        </div>
                        <div class="form-group col-lg-6" v-else-if=" mode == 'finalizar' || mode == 'cancelar'">
                            <label for="">Total Recepcionado</label>
                            <money :value="all_recepcion" v-bind="money" disabled class="form-control text-right">
                            </money>
                            <small>Suma de recepciones de la Solicitud</small>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="">Monto de Adjudicación</label>
                            <money :value="solicitud.monto_adjudicacion" v-bind="money" disabled
                                class="form-control text-right">
                            </money>
                            <small>Monto de Adjudicación de la solicitud</small>
                        </div>
                        <div class="form-group col-lg-12">
                            <div class="form-row justify-content-center">
                                {{-- <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-light active">
                                    <input type="radio" v-model="mode" value="finalizar" id="finalizar"> Finalizar
                                </label>
                                <label class="btn btn-light">
                                    <input type="radio" v-model="mode" value="guardar" id="guardar"> Guardar
                                </label>
                                <label class="btn btn-light">
                                    <input type="radio" v-model="mode" value="cancelar" id="cancelar"> CANCELAR
                                </label>
                            </div> --}}
                                <div class="form-group col-lg-6" v-if="orden.total_recepcion > 0">
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-classic-primary"
                                            style="font-size: 12px;">
                                            <input type="radio" v-model="mode" value="finalizar"
                                                class="new-control-input" @change="changeParcial()"
                                                name="custom-radio-2">
                                            <span class="new-control-indicator"></span> Guardar y Finalizar Proceso
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-6" v-if="sum_recepcion < orden.total">
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-classic-danger"
                                            style="font-size: 12px;">
                                            <input type="radio" v-model="mode" value="cancelar"
                                                class="new-control-input" :disabled="sum_recepcion == orden.total"
                                                @change="changeParcial()" name="custom-radio-2">
                                            <span class="new-control-indicator"></span>Guardar y Cancelar Proceso
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-3" v-if="sum_recepcion < orden.total">
                                    <div class="n-chk">
                                        <label class="new-control new-radio radio-classic-primary"
                                            style="font-size: 12px;">
                                            <input type="radio" v-model="mode" value="guardar" class="new-control-input"
                                                name="custom-radio-2">
                                            <span class="new-control-indicator"></span> Guardar
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-lg-12" v-if="mode == 'cancelar'">
                            <h6 class="text-center text-danger">Selecciona una opción</h6>
                            <small>Eligue si quieres agregar una nueva Orden de Compra para completar el Monto de
                                Adjudicación, o cambiar el valor de dicho monto</small>
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-warning">
                                    <input type="radio" v-model="licitacion.estado_cancelado" value="nueva_orden"
                                        @change="changeParcial()"
                                        class="
                                        new-control-input"
                                        name="estado_cancelado">
                                    <span class="new-control-indicator"></span>Agregar Nueva Orden de Compra
                                </label>

                            </div>
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-info">
                                    <input type="radio" v-model="licitacion.estado_cancelado" value="actualizar"
                                        @change="changeParcial()" class="new-control-input" name="estado_cancelado">
                                    <span class="new-control-indicator"></span>Actualizar Monto de Adjudicación
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-lg-12"
                            v-if="mode == 'cancelar' && licitacion.estado_cancelado == 'actualizar'">
                            <label for="">Actualiza Monto de Adjudicación</label>
                            <money v-model="licitacion.monto_adjudicacion" v-bind="money"
                                class="form-control text-right">
                            </money>
                        </div>
                        <div class="form-group col-lg-12"
                            v-if="mode == 'finalizar' || mode == 'cancelar'  && licitacion.estado_cancelado == 'actualizar'">
                            <h6 class="text-center text-danger">Finalizar Proceso Completo</h6>

                            <div class="n-chk">
                                <label class="new-control new-checkbox new-checkbox-rounded checkbox-success"
                                    style="font-size: 12px;">
                                    <input type="checkbox" v-model="orden.last_orden" class="new-control-input"
                                        :disabled="estado == 'parcial' && !solicitud.multiples_ordenes && mode == 'finalizar' || estado == 'parcial' && !solicitud.multiples_ordenes && mode == 'cancelar'">
                                    <span class="new-control-indicator"></span> Ultima Orden a Recepcionar
                                </label>
                            </div>
                        </div>
                    </div>
                    <div v-if="estado == 'parcial'" class="mt-5">
                        <div class="alert alert-success" role="alert" v-if="mode == 'guardar'">
                            Le permitira generar nuevas recepciones, siempre y
                            cuando sea de tipo
                            parcial. Si la recepcion es completa, finalizara el proceso automaticamente.
                        </div>
                        <div class="alert alert-primary" role="alert" v-if="mode == 'finalizar'">
                            Le permitira finalizar el proceso con
                            la recepción
                            parcial actual.
                        </div>
                        <div class="alert alert-danger" role="alert" v-if="mode == 'cancelar'">
                            Le permitira cancelar el proceso con
                            la recepción
                            parcial actual. Con esto no podra agregar mas recepciones a esta orden de compra.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer br">
                <button type="button" class="btn btn-primary" @click.prevent="storeLicitacion()">Generar
                    Recepción</button>
            </div>
        </div>
    </div>
</div>
