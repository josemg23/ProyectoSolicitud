@extends('layouts.nav')
@section('titulo', '| Recepción De Solicitudes')
@section('breadcrumb')
    <li class=""><a href=" {{ route('recepciones.index') }}"><i class="fas fa-boxes"></i>
        Solicitudes Con Recepciones</a></li>
    <li class="active"><a><i class="fas fa-plus-circle"></i>
            Generar Recepción</a></li>
@endsection
@section('content')
    <div id="contrato">
        @include('recepciones.modales.modalDiferencia')
        <h1 class="text-danger text-center font-weight-bold">Recepción De Ordenes de Compras</h1>
        <br>
        <div class="row">
            <div class="col-lg-7">
                <div class="card">
                    <div class="">
                        <div class=" card-header">
                        <h4 class="font-weight-bold text-danger">Recepción</h4>
                    </div>
                    <div class="card-body">
                        <form>
                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-3 pt-0">Recepción:</legend>
                                    <div class="col-sm-9">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" v-model="estado"
                                                :disabled="disabledCheck" value="completa" name="gridRadios"
                                                @change="estadoChange()" id="gridRadios1" checked>
                                            <label class="form-check-label" for="gridRadios1">
                                                Recepcion Completa
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gridRadios" v-model="estado"
                                                @change="estadoChange()" value="parcial" id="gridRadios2">
                                            <label class="form-check-label" for="gridRadios2">
                                                Recepcion Parcial
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <model-list-select :list="solicitudes" v-model="solicitud_id" class="form-control"
                                        :is-disabled="disabled" option-value="id" option-text="solicitud"
                                        placeholder="Elije Una Solicitud" @input="getSolicitud()">
                                </div>
                                <div class="form-group col-lg-12">
                                    <model-list-select :list="ordenes" v-model="orden_id" class="form-control"
                                        :is-disabled="disabled" option-value="id" option-text="num_orden"
                                        placeholder="Elije Una Orden de Compra" @input="getOrden()">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label class="col-form-label">Tipo de Documento</label>
                                    <select v-model="tipo_documento" id="" class="form-control">
                                        <option value="" selected disabled>Seleccione un Tipo</option>
                                        <option value="factura">Factura</option>
                                        <option value="guia-despacho">Guia de Despacho</option>
                                        <option value="otro">Otro</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label class="col-form-label">N° Documento</label>
                                    <input type="text" v-model="n_documento" class="form-control"
                                        placeholder="N° Documento">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label class="col-form-label">Monto de Documento</label>
                                    <money v-model="monto_documento" v-bind="money" class="form-control text-right"
                                        @input="estadoChange()">
                                    </money>
                                    {{-- <input type="number" v-model="monto_documento" class="form-control"
                                        placeholder="Monto Documento"> --}}
                                </div>
                                <div class="form-group col-lg-8">
                                    <label class="col-form-label">Documento</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile"
                                            v-on:change="getDocumento" accept="application/pdf, image/png">
                                        <label class="custom-file-label" for="customFile">Cargar Documento</label>
                                    </div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label class="col-form-label">Total de Recepción</label>
                                    <money v-model="monto_recepcion" v-bind="money" class="form-control text-right">
                                    </money>
                                    {{-- <input type="number" v-model="monto_recepcion" class="form-control"
                                        placeholder="Total Recepción"> --}}
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="col-form-label">Detalle</label>
                                    <textarea name="" class="form-control" v-model="observacion" cols="5"
                                        rows="5"></textarea>
                                </div>
                            </div>
                            <div class="form-row justify-content-around">
                                <div class="form-group col-lg-5" v-if="estado == 'parcial' && orden.total_recepcion > 0">
                                    <a href="" class="btn btn-info btn-block" :disabled="buttonDisable"
                                        @click.prevent="storeRecepcion('finalizar')"><i class="fas fa-save"></i>
                                        Guardar y Finalizar Proceso</a>
                                </div>
                                <div class="form-group col-lg-5" v-if="estado == 'parcial' && sum_recepcion < orden.total">
                                    <button class="btn btn-danger btn-block"
                                        :disabled="sum_recepcion == orden.total || buttonDisable"
                                        @click.prevent="storeRecepcion('cancelar')"><i class="fas fa-save"></i>
                                        Guardar y Cancelar Proceso</button>
                                </div>
                                <div class="form-group col-lg-3"
                                    v-if="estado == 'parcial' && sum_recepcion < orden.total || estado == 'completa'">
                                    <a href="" class="btn btn-block btn-success" :disabled="buttonDisable"
                                        @click.prevent="storeRecepcion('guardar')"><i class="fas fa-save"></i>
                                        Guardar</a>
                                </div>
                            </div>
                            <div v-if="estado == 'parcial'">
                                <small>
                                    <strong> Guardar: </strong> Le permitira generar nuevas recepciones, siempre y
                                    cuando sea de tipo
                                    parcial. Si la recepcion es completa, finalizara el proceso automaticamente.
                                </small> <br>
                                <small>
                                    <strong> Guardar y Finalizar Proceso:</strong> Le permitira finalizar el proceso con
                                    la recepción
                                    parcial actual.
                                </small> <br>
                                <small>
                                    <strong> Guardar y Cancelar Proceso:</strong> Le permitira cancelar el proceso con
                                    la recepción
                                    parcial actual. Con esto no podra agregar mas recepciones.
                                </small>
                            </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="padding-20 rounded-pills-icon">
                    <ul class="nav nav-pills mb-4 mt-3  justify-content-center" id="myTab" role="tablist">
                        <li class="nav-item ml-2 mr-2">
                            <a class="nav-link active text-center" id="solicitud-tab" data-toggle="pill" href="#solicitud"
                                role="tab" aria-controls="solicitud" aria-selected="true"> <i
                                    class="fas fa-file-prescription"></i><br>Solicitud</a>
                        </li>
                        <li class="nav-item ml-2 mr-2">
                            <a class="nav-link text-center" id="orden-tab" data-toggle="pill" href="#orden" role="tab"
                                aria-controls="orden" aria-selected="true"><i class="fas fa-file-invoice"></i><br>Orden</a>
                        </li>
                        <li class="nav-item ml-2 mr-2" v-if="orden.recepciones.length >= 1">
                            <a class="nav-link text-center" id="recpcion-tab" data-toggle="pill" href="#recpcion" role="tab"
                                aria-controls="recpcion" aria-selected="false"><i class="fas fa-boxes"></i>
                                <br> Recepciones</a>
                        </li>
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                        <div class="tab-pane fade show active" id="solicitud" role="tabpanel"
                            aria-labelledby="solicitud-tab">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="col-form-label">Tipo de Compra</label>
                                    <select name="" id="" class="form-control text-capitalize" disabled
                                        v-model="solicitud.tipo_compra">
                                        <option value="" selected disabled>Tipo de Compra
                                        </option>
                                        <option value="licitacion">Licitación Publica</option>
                                        <option value="contrato">Contrato de Suministro</option>
                                        <option value="trato-directo">Trato Directo</option>
                                        <option value="compra-menor">Compra Menor 3UTM</option>
                                        <option value="convenio">Convenio Marco</option>
                                        <option value="moneda">Moneda Extranjera</option>
                                        <option value="compra-agil">Compra Ágil</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="col-form-label">Total O. de Compra</label>
                                    <money :value="solicitud.total" v-bind="money" disabled class="form-control text-right">
                                    </money>
                                    <small>Suma de todas las ordenes de compra</small>
                                    {{-- <input type="text" :value="solicitud.total" placeholder="Total  Orden" disabled
                                        class="form-control"> --}}
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="col-form-label">Total Recepcionado(General)</label>
                                    <money :value="solicitud.total_recepcion" v-bind="money" disabled
                                        class="form-control text-right"></money>
                                    <small>Recepcion de todas las Ordenes de Compra</small>

                                    {{-- <input type="text" :value="solicitud.total_recepcion" placeholder="Total  Orden"
                                        disabled class="form-control"> --}}
                                </div>
                                <div class="form-group col-lg-4" v-if="solicitud.tipo_compra == 'licitacion'">
                                    <label class="col-form-label mr-1 ">Multiples Ordenes:</label>
                                    <input type="checkbox" disabled v-model="solicitud.multiples_ordenes">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="orden" role="tabpanel" aria-labelledby="orden-tab">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="col-form-label">Num Orden:</label>
                                    <input type="text" :value="orden.orden" placeholder="N° Orden" disabled
                                        class="form-control">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="col-form-label">Proveedor</label>
                                    <input type="text" :value="orden.proveedor" placeholder="Proveedor" disabled
                                        class="form-control">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="col-form-label">Total O. de Compra</label>
                                    <money :value="orden.total" v-bind="money" disabled class="form-control text-right">
                                    </money>
                                    <small>Total de Orden de Compra actual</small>

                                    {{-- <input type="text" :value="solicitud.total" placeholder="Total  Orden" disabled
                                        class="form-control"> --}}
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="col-form-label">Total Recepcionado(Actual)</label>
                                    <money :value="orden.total_recepcion" v-bind="money" disabled
                                        class="form-control text-right"></money>
                                    <small>Total de recepciones de Orden Actual</small>

                                    {{-- <input type="text" :value="solicitud.total_recepcion" placeholder="Total  Orden"
                                        disabled class="form-control"> --}}
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade p-1" id="recpcion" role="tabpanel" aria-labelledby="recpcion-tab"
                            v-if="orden.recepciones.length >= 1">
                            <h2 class="text-center text-danger">Recepciones</h2>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Documento</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(recepcion, index) in orden.recepciones">
                                        <td> @{{ recepcion . num_documento }}</td>
                                        <td> @{{ formtatNumber(recepcion . monto_total) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
    <script>
        $(document).ready(function() {
            bsCustomFileInput.init()
        });
        let solicitudes = @json($solicitudes);
        const contrato = new Vue({
            name: "contrato",
            el: "#contrato",
            data: {
                estado: 'completa',
                solicitudes: solicitudes,
                observacion: '',
                n_documento: '',
                documento: null,
                ordenes: [],
                orden_id: '',
                monto_documento: '',
                monto_recepcion: '',
                tipo_documento: '',
                solicitud_id: '',
                mode: '',
                money: {
                    decimal: ',',
                    thousands: '.',
                    prefix: '',
                    suffix: ' CLP',
                    precision: 2,
                    masked: false
                },
                diferencia: {
                    total: 0,
                    tipo: '',
                    detalle: ''
                },
                solicitud: {
                    total: 0,
                    tipo_compra: '',
                    recepciones: [],
                    ordenes: [],
                    total_recepcion: 0,
                    monto_adjudicacion: 0,
                    multiples_ordenes: false
                },
                licitacion: {
                    estado_cancelado: '',
                    monto_adjudicacion: 0
                },
                orden: {
                    orden: '',
                    proveedor: '',
                    total: 0,
                    recepciones: [],
                    total_recepcion: 0,
                    last_orden: false
                },
                disabled: false,
                buttonDisable: false,
                disabledCheck: false,
            },
            computed: {
                sum_recepcion() {
                    return this.orden.total_recepcion + this.monto_recepcion;
                },
                all_recepcion() {
                    return this.solicitud.total_recepcion + this.monto_recepcion;
                },
                new_monto_adj() {
                    return this.solicitud.monto_adjudicacion - (this.orden.total - this.monto_recepcion);
                }
            },
            methods: {
                getDocumento(event) {
                    this.documento = event.target.files[0];
                },
                estadoChange() {
                    if (this.estado == 'completa' && this.solicitud.tipo_compra == 'licitacion' && !this
                        .solicitud.multiples_ordenes) {
                        console.log('estado Change');
                        this.orden.last_orden = true;
                    } else if (this.estado == 'completa' && this.solicitud.tipo_compra == 'licitacion' &&
                        this.all_recepcion == this.solicitud.monto_adjudicacion) {
                        console.log('estado Change');
                        this.orden.last_orden = true;
                    } else if (this.estado == 'parcial' && this.solicitud.tipo_compra == 'licitacion' && this
                        .mode == 'finalizar' && !this
                        .solicitud.multiples_ordenes) {
                        console.log('estado Change');
                        this.orden.last_orden = true;
                    } else if (this.estado == 'parcial' && this.solicitud.tipo_compra == 'licitacion' && this
                        .mode == 'cancelar' && !this
                        .solicitud.multiples_ordenes && this.licitacion.estado_cancelado == 'actualizar') {
                        console.log('estado Change');
                        this.orden.last_orden = true;
                    } else {
                        this.orden.last_orden = false;
                    }
                },
                changeParcial() {
                    if (this.licitacion.estado_cancelado == 'actualizar') {
                        this.licitacion.monto_adjudicacion = this.solicitud.monto_adjudicacion;
                    } else if (this.licitacion.estado_cancelado == 'cancelar') {
                        this.licitacion.monto_adjudicacion = 0;
                    }
                    this.estadoChange();
                },
                getSolicitud() {
                    let solicitud = this.solicitudes.filter(s => s.id == this.solicitud_id);
                    this.orden_id = '';
                    this.getOrden();
                    if (solicitud.length == 1) {
                        this.ordenes = solicitud[0].ordenes;
                        // this.solicitud.total = this.withSum(solicitud[0].ordenes, 'valor_total');
                        if (solicitud[0].modalidad_compra == 'licitacion') {
                            this.solicitud.monto_adjudicacion = solicitud[0].monto_adj.monto;
                            this.solicitud.multiples_ordenes = solicitud[0].monto_adj.multiple ? true :
                                false;
                        }
                        this.solicitud.total = solicitud[0].total_ordenes == null ? 0 : solicitud[0]
                            .total_ordenes;
                        this.solicitud.ordenes = solicitud[0].ordenes;
                        this.solicitud.tipo_compra = solicitud[0].modalidad_compra;
                        this.solicitud.total_recepcion = solicitud[0].total_recepciones == null ? 0 :
                            solicitud[0]
                            .total_recepciones;
                        this.estadoChange();

                    } else {
                        this.solicitud.ordenes = [];
                        this.solicitud.tipo_compra = '';
                        this.solicitud.total = 0;
                        this.solicitud.recepciones = [];
                        this.solicitud.total_recepcion = 0;
                        this.solicitud.multiples_ordenes = false;
                        this.solicitud.monto_adjudicacion = 0;
                        this.disabledCheck = false;
                        this.orden_id = '';
                        this.ordenes = [];
                    }
                },
                getOrden() {
                    let orden = this.solicitud.ordenes.filter(s => s.id == this.orden_id);
                    if (orden.length == 1) {
                        this.orden.orden = orden[0].num_orden;
                        this.orden.total = orden[0].valor_total;
                        this.orden.recepciones = orden[0].recepciones;
                        this.orden.total_recepcion = this.withSum(orden[0].recepciones, 'monto_total');
                        this.orden.proveedor = orden[0].proveedor ? orden[0].proveedor
                            .nombre : orden[0].nom_proveedor;
                        if (orden[0].recepciones.length >= 1) {
                            this.estado = 'parcial';
                            this.disabledCheck = true;
                        } else {
                            this.disabledCheck = false;

                        }
                        if (this.estado == 'completa') {
                            this.monto_documento = orden[0].valor_total;
                            this.monto_recepcion = orden[0].valor_total;
                        } else {
                            this.monto_documento = 0;
                            this.monto_recepcion = 0;
                        }
                        $("#orden-tab").tab('show');

                    } else {
                        this.orden_id = '';
                        this.ordenes = [];
                        this.estado = 'completa';
                        this.disabledCheck = false;
                        this.orden.orden = '';
                        this.orden.total = 0;
                        this.orden.proveedor = '';
                    }

                },
                withSum(datas, column) {
                    let total = 0;
                    datas.forEach(data => {
                        total += Number(data[column]);
                    });
                    return Number(total.toFixed(2));
                },
                formtatNumber(number) {
                    return new Intl.NumberFormat("de-DE").format(number) + ' CLP'
                },
                storeRecepcion(mode) {
                    this.buttonDisable = true;
                    this.mode = mode;
                    if (this.validacionNormales()) {
                        this.buttonDisable = false;
                        console.log('ERROR DE VALIDACIONES')
                    } else {
                        if (this.solicitud.tipo_compra == 'licitacion') {
                            this.procesoLicitacion();
                        } else {
                            this.procesoNormal();
                        }
                    }
                },
                //COMIENZO PROCESO NORMAL
                validacionNormales() {
                    let estado = false;
                    if (this.solicitud_id === '') {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No has seleccionado la solicitud',
                            position: 'topRight'
                        });
                        estado = true;
                    } else if (this.tipo_documento === '') {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No has seleccionado el tipo de Documento',
                            position: 'topRight'
                        });
                        estado = true;
                    } else if (this.n_documento === '') {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No has seleccionado el N° de Documento',
                            position: 'topRight'
                        });
                        estado = true;
                    } else if (this.monto_documento === '') {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No has agregado el Monto del Documento',
                            position: 'topRight'
                        });
                        estado = true;
                    } else if (this.documento == null || this.documento == undefined) {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No has cargado el documento',
                            position: 'topRight'
                        });
                        estado = true;
                    } else if (this.monto_recepcion === '') {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No has agregado el Total de la Recepción',
                            position: 'topRight'
                        });
                        estado = true;
                    } else if (this.monto_recepcion !== this.monto_documento) {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'El monto del documento y la recepción no coincide',
                            position: 'topRight'
                        });
                        estado = true;
                    } else if (this.monto_recepcion > this.orden.total) {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'El monto de recepción no puede ser mayor al monto de la orden de compra',
                            position: 'topRight'
                        });
                        estado = true;
                    } else if (this.estado == 'parcial' && (this.monto_recepcion + this.solicitud
                            .total_recepcion) >
                        this.solicitud.total && this.mode != 'finalizar' && this.solicitud.tipo_compra !==
                        'licitacion') {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'En recepciones parciales, el monto de la solicitud no puede ser mayor al de la recepción',
                            position: 'topRight'
                        });
                        estado = true;
                    } else if (this.estado == 'parcial' && (this.monto_recepcion + this.solicitud
                            .total_recepcion) ==
                        this.solicitud.total && this.mode != 'finalizar' && this.solicitud.tipo_compra !==
                        'licitacion') {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'El monto de la recepcion es igual al monto de la orden de compra, debes seleccionar recepción de tipo completa',
                            position: 'topRight'
                        });
                        estado = true;
                    }
                    return estado;
                },
                procesoNormal() {
                    if (this.estado == 'completa') {
                        this.recepcionCompleta();
                    } else {
                        if (this.mode == 'finalizar') {
                            this.recepcionCompleta();
                        } else if (this.mode == 'cancelar') {
                            this.recepcionCancelar();
                        } else {
                            if (this.monto_recepcion == this.orden.total) {
                                return iziToast.error({
                                    title: 'Municipio',
                                    message: 'El monto de la recepción es igual al total de la orden de compra, selecciona recepción completa',
                                    position: 'topRight'
                                });
                            } else {
                                this.recepcionSinDiferencia();

                            }
                        }
                    }
                },
                recepcionCompleta() {
                    let monto_orden = Number(this.solicitud.total.toFixed(2));
                    let monto_recepcion = this.solicitud.total_recepcion + Number(this.monto_recepcion
                        .toFixed(2));
                    if (monto_orden == monto_recepcion) {
                        console.log('PRIMER IF');
                        this.recepcionSinDiferencia();
                    } else if (monto_orden < monto_recepcion || monto_orden > monto_recepcion) {
                        console.log('SEGUNDO IF');
                        let diferencia = monto_recepcion > monto_orden ? monto_recepcion - monto_orden :
                            monto_orden - monto_recepcion;
                        let tipo = monto_recepcion > monto_orden ? 'egreso' : 'ingreso';
                        this.recepcionDiferencia(diferencia, tipo);

                    }
                },
                recepcionCancelar() {
                    let data = new FormData();
                    data.append('solicitud_id', this.solicitud_id);
                    data.append('documento', this.documento);
                    data.append('tipo', this.estado);
                    data.append('mode', this.mode);
                    data.append('n_documento', this.n_documento);
                    data.append('monto_documento', this.monto_documento);
                    data.append('monto_recepcion', this.monto_recepcion);
                    data.append('tipo_documento', this.tipo_documento);
                    data.append('observacion', this.observacion);
                    data.append('estado', 'pendiente');
                    data.append('aprobacion', 'abastecimiento');
                    this.sendRecepcion(data);
                },
                recepcionSinDiferencia() {
                    Swal.fire({
                        title: "Realizar Recepción?",
                        text: 'Esta accion no se puede revertir!!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Realizar!',
                        cancelButtonText: 'Cancelar!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let data = new FormData();
                            data.append('solicitud_id', this.solicitud_id);
                            data.append('documento', this.documento);
                            data.append('tipo', this.estado);
                            data.append('mode', this.mode);

                            data.append('n_documento', this.n_documento);
                            data.append('monto_documento', this.monto_documento);
                            data.append('monto_recepcion', this.monto_recepcion);
                            data.append('tipo_documento', this.tipo_documento);
                            data.append('observacion', this.observacion);
                            data.append('estado', 'aprobada');
                            this.sendRecepcion(data);
                        } else {
                            this.resetVariablesDiferencia();
                        }
                    });
                },
                recepcionDiferencia(diferencia, tipo) {
                    this.diferencia.total = diferencia;
                    console.log(diferencia)
                    this.diferencia.tipo = tipo;
                    if (diferencia < 1000) {
                        $("#modalRecepcionDiferencia").modal(
                            'show'); //Abrir Modal para asignar las diferencias, menor a 1000
                        console.log('PRIMER IF DIFERENCIA');
                    } else if (diferencia > 1000 && diferencia < 1000000) {
                        console.log('SEGUNDO IF DIFERENCIA');
                        this.recepcionConAprobacion(diferencia, tipo); //Diferencia mayor a 1000 y menor a un millon
                    } else {
                        //Diferencia superior a un millon
                        return iziToast.error({
                            title: 'Municipio',
                            message: 'La difernecia es superior a 1000000, por lo que no es posible realizar esta recepción',
                            position: 'topRight'
                        });
                    }
                },
                recepcionConAprobacion(diferencia, tipo) {
                    Swal.fire({
                        title: "Realizar Recepción!",
                        text: 'La Diferencia de la Recepción es superior a 1000, por lo que pasara a un proceso de Aprobacion',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Realizar!',
                        cancelButtonText: 'Cancelar!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let data = new FormData();
                            data.append('solicitud_id', this.solicitud_id);
                            data.append('documento', this.documento);
                            data.append('tipo', this.estado);
                            data.append('mode', this.mode);

                            data.append('n_documento', this.n_documento);
                            data.append('monto_documento', this.monto_documento);
                            data.append('monto_recepcion', this.monto_recepcion);
                            data.append('tipo_documento', this.tipo_documento);
                            data.append('observacion', this.observacion);

                            data.append('diferencia', this.diferencia.total);
                            data.append('aprobacion', 'finanzas');
                            data.append('estado', 'pendiente');
                            data.append('detalle_diferencia', this.diferencia.detalle);
                            data.append('tipo_diferencia', this.diferencia.tipo);
                            this.sendRecepcion(data);
                        } else {
                            this.resetVariablesDiferencia();
                        }
                    });
                },
                resetVariablesDiferencia() {
                    this.buttonDisable = false;
                    this.diferencia.detalle = '';
                    this.diferencia.tipo = '';
                    this.diferencia.total = '';
                },
                //COMIENZO LICITACION PUBLICA
                procesoLicitacion() {
                    if (this.estado == 'completa') {
                        if (this.orden.total !== this.monto_recepcion) {
                            this.buttonDisable = false;
                            return iziToast.error({
                                title: 'Municipio',
                                message: 'El Total de la orden de Compra y el monto de la Recepción no coincide',
                                position: 'topRight'
                            });
                        } else {
                            $("#modalLicitacion").modal('show');
                        }
                    } else if (this.estado == 'parcial') {
                        if (this.monto_recepcion >= this.orden.total) {
                            this.buttonDisable = false;
                            return iziToast.info({
                                title: 'Municipio',
                                message: 'El total de la recepcion es mayor o igual al total de la orden, selecciona recepción completa',
                                position: 'topRight'
                            });
                        } else {
                            $("#modalLicitacion").modal('show');
                        }
                    }
                },
                storeLicitacion() {
                    if (this.validacionPostLicitacion()) {
                        this.buttonDisable = false;
                        return console.log('HAY ERRORES');
                    }
                    Swal.fire({
                        title: "Realizar Recepción!",
                        text: 'Seguro que deseas realizar esta acción?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Realizar!',
                        cancelButtonText: 'Cancelar!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let data = new FormData();
                            data.append('solicitud_id', this.solicitud_id);
                            data.append('orden_id', this.orden_id);
                            data.append('documento', this.documento);
                            data.append('tipo', this.estado);
                            data.append('mode', this.mode);

                            data.append('n_documento', this.n_documento);
                            data.append('monto_documento', this.monto_documento);
                            data.append('monto_recepcion', this.monto_recepcion);
                            data.append('tipo_documento', this.tipo_documento);
                            data.append('observacion', this.observacion);
                            data.append('tipo_compra', this.solicitud.tipo_compra);
                            //LICITACION
                            if (this.mode == 'cancelar' && this.licitacion.estado_cancelado ==
                                'actualizar') {
                                data.append('estado_cancelado', this.licitacion.estado_cancelado);
                                data.append('monto_adjudicacion', this.licitacion
                                    .monto_adjudicacion);
                            } else if (this.mode == 'cancelar' && this.licitacion
                                .estado_cancelado ==
                                'nueva_orden') {
                                data.append('nueva_orden', 1);
                                data.append('estado_cancelado', this.licitacion.estado_cancelado);
                            }
                            if (this.orden.last_orden) {
                                data.append('las_orden', 1);
                            }
                            this.sendRecepcion(data);
                        } else {
                            this.resetVariables();
                        }
                    });
                },
                validacionPostLicitacion() {
                    let estado = false;
                    if (this.mode == 'cancelar' && this.licitacion.estado_cancelado == 'actualizar' && this
                        .solicitud.monto_adjudicacion == this.licitacion.monto_adjudicacion) {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No has actualizado el monto de adjudicación',
                            position: 'topRight'
                        });
                        return true;
                    } else if (this.mode == 'finalizar' && this.sum_recepcion !== this.orden.total) {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'Para finalizar el proceso, la suma de todas las recepciones deben coincidir con el total de la orden de compra',
                            position: 'topRight'
                        });
                        return true;
                    } else if (this.mode == 'cancelar' && this.licitacion.estado_cancelado == '') {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'Para cancelar la orden de compra, debes seleccionar una opción',
                            position: 'topRight'
                        });
                        return true;
                    } else if (this.mode == 'guardar' && this.sum_recepcion > this.orden.total) {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'La suma de las recepciones supera el total de la Orden de Compra',
                            position: 'topRight'
                        });
                        return true;
                    } else if (this.orden.last_orden &&
                        this.mode == 'cancelar' && this.licitacion.estado_cancelado ==
                        'actualizar' && this.all_recepcion !== this.licitacion.monto_adjudicacion) {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No puedes cerrar este proceso, porque la suma de todas las recepciones no coincide con el monto de adjudicación',
                            position: 'topRight'
                        });
                        return true;
                    } else if (
                        this.mode == 'cancelar' && this.licitacion.estado_cancelado ==
                        'actualizar' && this.new_monto_adj !== this.licitacion.monto_adjudicacion) {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'El nuevo monto de adjudicación no cuadra con el total de recepción actual',
                            position: 'topRight'
                        });
                        return true;
                    } else if (this.orden.last_orden && this.all_recepcion !== this.solicitud
                        .monto_adjudicacion && this.mode ==
                        'finalizar') {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No puedes cerrar este proceso, porque la suma de todas las recepciones no coincide con el monto de adjudicación',
                            position: 'topRight'
                        });
                        return true;
                    } else if (this.orden.last_orden && this.all_recepcion !== this.solicitud
                        .monto_adjudicacion && this.estado == 'completa') {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No puedes cerrar este proceso, porque la suma de todas las recepciones no coincide con el monto de adjudicación',
                            position: 'topRight'
                        });
                        return true;
                    } else if (this.orden.last_orden && this.all_recepcion !== this.solicitud
                        .monto_adjudicacion && this.estado == 'completa') {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No puedes cerrar este proceso, porque la suma de todas las recepciones no coincide con el monto de adjudicación',
                            position: 'topRight'
                        });
                        return true;
                    } else {
                        return false;
                    }
                },
                resetLicitacion() {
                    this.buttonDisable = false;
                },
                sendRecepcion(data) {
                    let set = this;
                    set.buttonDisable = true;
                    let url = '/recepciones/' + this.orden_id + '/store';
                    const config = {
                        headers: {
                            'content-type': 'multipart/form-data'
                        }
                    }
                    axios.post(url, data, config)
                        .then(function(res) {
                            console.log(res.data);
                            let link = '{{ route('recepciones.index') }}';
                            window.location = link;
                        })
                        .catch(function(error) {
                            set.buttonDisable = false;
                            if (error.response.status == 501) {
                                console.log(error.response.data);
                                iziToast.error({
                                    title: 'Municipio',
                                    message: error.response.data.msg,
                                    position: 'topRight'
                                });
                            }
                        });
                }
            }
        });
    </script>
@endsection
