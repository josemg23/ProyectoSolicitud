<!-- Vertically Center -->
<div class="modal fade" id="modal_cuentas" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="modal_cuentasLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Cuentas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h1 class="text-center font-weight-bold text-danger">Asignacion de diferencia</h1>
                <small class="text-danger small">Deberas asignar la diferencia para poder hacer la reduccion a adicion
                    en las respectivas
                    cuentas</small>
                <div class="form-row">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th width="400" style="font-size: 10px">Cuenta</th>
                                <th width="150" style="font-size: 10px">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(cuenta, index) in cuentas">
                                <td style=" font-size: 10px">
                                    <input type="text" v-model="cuenta.cuenta" class="form-control form-control-sm"
                                        disabled>
                                </td>
                                <td style=" font-size: 10px">
                                    <money v-model="cuenta.monto" v-bind="money" class="form-control text-right"
                                        @input="calculoProductos()"></money>
                                    {{-- <input type="number" v-model="cuenta.monto"
                                        class="form-control form-control-sm text-right"> --}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-lg-between align-content-end">
                    <div class="col-lg-5">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold text-primary pr-3">Monto de Direrencia:
                                    </td>
                                    <td><span class="badge badge-danger">
                                            @{{ formtatNumber(diferencia_monto) }}
                                        </span>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-4 ">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold text-primary pr-3">Total Monto:
                                    </td>
                                    <td><span class="badge badge-danger">
                                            @{{ formtatNumber(diferencia) }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer br">
                <button type="button" class="btn btn-primary" @click.prevent="putStore()"
                    :disabled="buttonMultiple">Guardar Orden de
                    Compra</button>
            </div>
        </div>
    </div>
</div>
