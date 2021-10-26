@extends('layouts.nav')
@section('breadcrumb')
    <li class="___class_+?0___"><a href="{{ route('ordenes.index') }}"><i class="fas fa-shopping-bag"></i> Lista de Ordenes
            de
            Compra</a></li>
    <li class="active"><a><i class="fas fa-plus-circle"></i> Nueva Orden de Compra</a></li>
@endsection
@section('content')
@section('titulo', '| Lista de Ordenes de Compra')
<div>
    <h1 class="text-danger text-center font-weight-bold">Nueva Orden de Compra</h1>
    <br>
    <div id="orden">
        @include('ordenes.modales.modal_cuentas')
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div>
                        <div class="card-header">
                            <h2 class="font-weight-bold text-danger">Previsualizar XML</h2>
                        </div>
                        <div class="card-body">
                            <div v-if="tipo_compra !== 'compra-menor' && tipo_compra !== 'moneda'">
                                <div v-if="Object.keys(jsondata).length > 0">
                                    {{-- <pre style="height: 350px" v-html="JSON.stringify(jsondata, null, 2)"></pre>npn run <de></de> --}}
                                    <json-viewer :value="jsondata" boxed sort :expanded="true" theme="jv-dark">
                                    </json-viewer>
                                    {{-- <vue-json-pretty style="height: 200px" :virtual="true" :data="jsondata"
                                        :virtualLines="+20" :collapsed-on-click-brackets="true">
                                    </vue-json-pretty> --}}
                                </div>
                                <small v-else class="text-info font-weight-bold">*Seleccione archivo xml para
                                    pre-visualizar</small>
                            </div>
                            <small v-else class="text-warning font-weight-bold">*Seccion no disponible para este tipo de
                                compra</small>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="___class_+?16___">
                        <div class="card-header">
                            <h2 class="font-weight-bold text-danger">Agregar Orden de Compra</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="col-form-label mr-1 ">Solicitud Aprobada:</label>
                                    {{-- <select name="" id="" class="form-control">
                                        <option value="" disabled selected>Selecciona Una Solicitud</option>

                                        <option v-for="solicitud in solicitudes" :value="solicitud.id">
                                            @{{ solicitud . solicitud }}
                                        </option>
                                    </select> --}}
                                    <model-list-select :list="solicitudes" v-model="solicitud_id" class="form-control"
                                        option-value="id" option-text="solicitud" placeholder="Elije Una Solicitud"
                                        @input="solicitudSelected">
                                </div>
                                <div class="form-group col">
                                    <label class="col-form-label mr-1 ">Tipo de Compra:</label>
                                    <select name="" id="" class="form-control" disabled :value="tipo_compra"
                                        @change="checkTipo">
                                        <option value="" disabled selected>Tipo de Compra</option>
                                        <option value="licitacion">Licitación Publica</option>
                                        <option value="contrato">Contrato de Suministro</option>
                                        <option value="trato-directo">Trato Directo</option>
                                        <option value="compra-menor">Compra Menor 3UTM</option>
                                        <option value="convenio">Convenio Marco</option>
                                        <option value="moneda">Moneda Extranjera</option>
                                        <option value="compra-agil">Compra Ágil</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-4" v-if="tipo_compra == 'licitacion'">
                                    <label class="col-form-label mr-1 ">Monto de Adjudicación:</label>
                                    <money v-model="monto_adjudicacion" :disabled="!primera_orden" v-bind="money"
                                        class="form-control text-right">
                                    </money>
                                    {{-- <currency-input v-model="monto_adjudicacion" class="form-control text-right"
                                        :options="numeric" /> --}}
                                    {{-- <input type="number" class="form-control text-right" v-model="monto_adjudicacion"
                                        placeholder="Monto de Adjudicación"> --}}
                                </div>
                                <div class="form-group col-lg-4" v-if="tipo_compra == 'licitacion'">
                                    <label class="col-form-label mr-1 ">T. Ordenes:</label>
                                    <input type="text" :value="formtatNumber(montoAdj)" disabled
                                        class="form-control text-right">
                                </div>
                                <div class="form-group col-lg-4" v-if="tipo_compra == 'licitacion'">
                                    <label class="col-form-label mr-1 ">Multiples Ordenes:</label>
                                    <input type="checkbox" :disabled="!show_multiple" v-model="order_multiple">
                                </div>
                                <div class="form-group col-lg-12" v-if="tipo_compra == 'licitacion' && order_multiple">
                                    <div class="accordion" id="accordionExample">
                                        <div class="card">
                                            <div class="card-header" id="headingOne">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link btn-block text-left" type="button"
                                                        data-toggle="collapse" data-target="#collapseOne"
                                                        aria-expanded="false" aria-controls="collapseOne">
                                                        Ordenes de Compra
                                                    </button>
                                                </h2>
                                            </div>

                                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                                data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Orden C.</th>
                                                                <th>Proveedor</th>
                                                                <th>Monto</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="(orden, index) in solicitud.ordenes">
                                                                <td> @{{ orden . num_orden }}</td>
                                                                <td> @{{ orden . codigo_proveedor }}</td>
                                                                <td> @{{ formtatNumber(orden . valor_total) }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-row" v-if="tipo_compra !== ''">
                                <div class="form-group col-lg-4">
                                    <label class="col-form-label mr-1 ">Valor Total:</label>
                                    <money v-model="total" v-bind="money" :disabled="isDisabled"
                                        class="form-control text-right"></money>
                                    {{-- <currency-input class="form-control text-right" v-model="total" /> --}}
                                    {{-- <input type="number" v-model="total" class="form-control text-right" step="any"
                                        :disabled="isDisabled" placeholder="Valor Total"> --}}
                                </div>
                                <div class="form-group col-lg-8">
                                    <label class="col-form-label mr-1 ">Numero O.C:</label>
                                    <input type="text" class="form-control" :disabled="isDisabled"
                                        v-model="orden_compra" placeholder="Numero O.C">
                                </div>
                                <div v-if="tipo_compra == 'compra-menor' || tipo_compra == 'moneda'"
                                    class="form-group col-lg-12">
                                    <div class="form-row">
                                        <div class="form-group col-lg-12">
                                            <label class="col-form-label mr-1 ">Proveedores:</label>
                                            <model-list-select :list="proveedores" v-model="proveedor_id"
                                                class="form-control" option-value="id" option-text="proveedor"
                                                placeholder="Elije Un Proveedor">
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label class="col-form-label mr-1 ">Seleccione PDF:</label>
                                            <input type="file" v-on:change="getPdf" accept="application/pdf, image/png">
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="form-group col-lg-12">
                                    <div class="form-row">
                                        <div class="form-group col-lg-4">
                                            <input type="text" class="form-control" :disabled="isDisabled"
                                                v-model="rut" placeholder="Cod. Proveedor">
                                        </div>
                                        <div class="form-group col-lg-8">
                                            <input type="text" class="form-control" :disabled="isDisabled"
                                                v-model="proveedor" placeholder="Nombre Proveedor">
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label class="col-form-label mr-1 ">Captura Xml:</label>
                                            <input type="file" v-on:change="getXml" accept="text/xml">
                                            <p class="error-message text-danger font-weight-bold"
                                                v-if="errors.has('xml')">
                                                @{{ errors . get('xml') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="col-form-label mr-1 ">Documento Anexo:</label>
                                    <input type="file" accept="application/pdf" v-on:change="getAnexo">
                                </div>
                            </div>
                            <div class="form-row" v-if="tipo_compra !== ''">
                                <div class="form-group col-lg-2">
                                    <label class="col-form-label mr-1 ">Flete:</label>
                                    <input type="checkbox" v-model="flete" @change="total_flete = 0">
                                </div>
                                <div class="form-group col-lg-6" v-if="flete">
                                    {{-- <label class="col-form-label mr-1 ">Valor Del Flete:</label> --}}
                                    <money v-model="total_flete" v-bind="money" class="form-control text-right"></money>
                                </div>
                            </div>
                            <div class="form-row justify-content-around">

                                <div class="form-group col-lg-5" v-if="tipo_compra == 'licitacion'">
                                    <a href="" class="btn btn-info btn-block" :disabled="buttonDisable"
                                        @click.prevent="checkValue('finalizar')"><i class="fas fa-save"></i>
                                        Guardar y Finalizar</a>
                                </div>
                                <div class="form-group col-lg-3"
                                    v-if="tipo_compra == 'licitacion' && order_multiple || tipo_compra !== 'licitacion' && !order_multiple">
                                    <a href="" class="btn btn-block btn-success" :disabled="buttonDisable"
                                        @click.prevent="checkValue('guardar')"><i class="fas fa-save"></i>
                                        Guardar</a>
                                </div>
                            </div>
                            {{-- <div class="row justify-content-center">
                                <button class="btn btn-success" @click.prevent="checkValue()"><i
                                        class="fa fa-save"></i>
                                    GUARDAR</button>
                            </div> --}}
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
<script type="text/javascript">
    let solicitudes = @json($solicitudes);
    class Errors {
        constructor() {
            this.errors = {}
        }
        has(field) {
            return this.errors.hasOwnProperty(field);
        }
        get(field) {
            if (this.errors[field]) {
                return this.errors[field][0]
            }
        }
        record(errors) {
            this.errors = errors;
        }
        any() {
            return Object.keys(this.errors).length > 0;
        }
        anyfiles(query) {
            const asArray = Object.entries(this.errors);
            //const atLeast9Wins = asArray.filter(([key, value]) => key !== 'fecha_atencion' && key !== 'responsable_id' && key !== 'detalle_atencion' && key !== 'observacion' );
            const atLeast9Wins = asArray.filter(([key, value]) => key.toLowerCase().indexOf(query.toLowerCase()) > -
                1);
            const atLeast9WinsObject = Object.fromEntries(atLeast9Wins);

            return Object.keys(atLeast9WinsObject).length > 0;
        }
        archivos(query) {
            const asArray = Object.entries(this.errors);
            //const atLeast9Wins = asArray.filter(([key, value]) => key !== 'fecha_atencion' && key !== 'responsable_id' && key !== 'detalle_atencion' && key !== 'observacion' );
            const atLeast9Wins = asArray.filter(([key, value]) => key.toLowerCase().indexOf(query.toLowerCase()) > -
                1);
            const atLeast9WinsObject = Object.fromEntries(atLeast9Wins);
            return atLeast9WinsObject;
        }

    }
    const ordenes = new Vue({
        el: "#orden",
        name: "Ordenes de Compra",
        data: {
            jsondata: {},
            solicitudes: solicitudes,
            solicitud_id: '',
            flete: false,
            total_flete: 0,
            // tipo_compra: [],
            money: {
                decimal: ',',
                thousands: '.',
                prefix: '',
                suffix: ' CLP',
                precision: 2,
                masked: false
            },
            numeric: {
                locale: undefined,
                currency: 'EUR',
                currencyDisplay: 'hidden',
                valueRange: undefined,
                precision: 0,
                hideCurrencySymbolOnFocus: true,
                hideGroupingSeparatorOnFocus: true,
                hideNegligibleDecimalDigitsOnFocus: true,
                autoDecimalDigits: false,
                exportValueAsInteger: false,
                autoSign: true,
                useGrouping: false
            },
            total: 0,
            diferencia: 0,
            diferencia_monto: 0,
            monto_adjudicacion: 0,
            total_ordenes: 0,
            orden_compra: '',
            metodo: '',
            tipo_compra: '',
            proveedores: [],
            cuentas: [],
            proveedor_id: '',
            cuenta_id: '',
            rut: '',
            proveedor: '',
            solicitud: {
                ordenes: []
            },
            xml: null,
            documento: null,
            anexo: null,
            buttonDisable: false,
            buttonMultiple: false,
            isDisabled: true,
            primera_orden: false,
            show_multiple: false,
            order_multiple: false,
            errors: new Errors,

        },
        mounted() {
            this.getProveedores();
        },
        computed: {
            montoAdj() {

                return this.totalOrdenes
            },
            totalOrdenes() {
                let total = 0;
                let solicitud = this.solicitudes.filter(s => s.id == this.solicitud_id);
                if (solicitud.length == 1) {
                    solicitud[0].ordenes.forEach(orden => {
                        if (orden.total_recepcionado !== null && orden.recepcion == 'recepcionada') {
                            total += Number(orden.total_recepcionado);
                        } else {
                            total += Number(orden.valor_total);
                        }
                    });
                }
                return Number(total.toFixed(2)) + this.total;

            }
        },


        methods: {

            //subir imagen
            getXml(event) {
                this.xml = event.target.files[0];
                console.log(event)
                this.getJsonxml();
            },
            solicitudSelected() {
                let set = this;
                this.order_multiple = false;
                let solicitud = this.solicitudes.filter(s => s.id == this.solicitud_id);
                if (solicitud.length == 1) {
                    let aprobacion = solicitud[0].aprobaciones.filter(s => s.tipo == 'abastecimiento');
                    if (aprobacion.length == 1) {
                        this.tipo_compra = aprobacion[0].modalidad_compra;
                        this.checkTipo();
                    } else {
                        return iziToast.error({
                            title: 'Municipio',
                            message: 'Esta solicitud no tiene aprobacion de abastecimiento',
                            position: 'topRight'
                        });
                    }
                    if (aprobacion[0].modalidad_compra == 'licitacion') {
                        this.solicitud.ordenes = solicitud[0].ordenes;
                        if (solicitud[0].monto_adj == null) {
                            this.primera_orden = true;
                            this.show_multiple = true;

                            return iziToast.info({
                                title: 'Municipio',
                                message: 'Esta solicitud no tiene ordenes de compras generadas',
                                position: 'topRight'
                            });
                        } else {
                            this.primera_orden = false;
                            this.monto_adjudicacion = solicitud[0].monto_adj.monto;
                            console.log(solicitud[0].monto_adj.multiple)
                            this.order_multiple = solicitud[0].monto_adj.multiple ? true : false;
                        }
                        // let ordenes = solicitud[0].ordenes.length;
                    }
                } else {
                    this.tipo_compra = '';
                    this.order_multiple = false;
                    this.show_multiple = false;
                    this.flete = false;
                    this.total_flete = 0;
                }

            },
            getPdf(event) {
                this.documento = event.target.files[0];
            },
            getAnexo(event) {
                this.anexo = event.target.files[0];
            },
            checkTipo() {
                if (this.tipo_compra == 'compra-menor' || this.tipo_compra == 'moneda') {
                    // this.documento = null;
                    this.xml = null;
                    this.jsondata = {};
                    this.isDisabled = false;
                    this.total = '';
                    this.proveedor_id = '';
                    this.orden_compra = '';
                    this.rut = '';
                    this.proveedor = '';
                } else {
                    this.documento = null;
                    // this.xml = null;
                    // this.jsondata = {};
                    this.isDisabled = true;
                    // this.total = '';
                    this.proveedor_id = '';
                }

            },
            calculoProductos() {
                let total = 0;
                this.cuentas.forEach(cuenta => {
                    total += cuenta.monto;
                });
                this.diferencia = Number(total);
                // alert(new Intl.NumberFormat("de-DE").format(total))
            },
            formtatNumber(number) {
                return new Intl.NumberFormat("de-DE").format(number) + ' CLP'
            },
            validaciones(es) {

                let estado = false;
                if (this.tipo_compra === '') {
                    iziToast.error({
                        title: 'Municipio',
                        message: 'No has seleccionado el tipo de compra',
                        position: 'topRight'
                    });
                    estado = true;
                } else if (this.verificarTipo()) {
                    estado = true;
                }
                return estado;
            },

            verificarTipo() {
                let estado = false;
                if (this.tipo_compra == 'compra-menor' || this.tipo_compra == 'moneda') {
                    if (this.total == 0) {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No se ha cargado el total de la Orden de Compra',
                            position: 'topRight'
                        });
                        estado = true;
                    } else if (this.orden_compra == '') {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No se ha cargado el numero de la Orden de Compra',
                            position: 'topRight'
                        });
                        estado = true;
                    } else if (this.proveedor_id === '') {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No se has seleccionado el proveedor',
                            position: 'topRight'
                        });
                        estado = true;
                    } else if (this.documento == null || this.documento == undefined) {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No se has seleccionado el documento',
                            position: 'topRight'
                        });
                        estado = true;
                    }
                } else {
                    if (this.tipo_compra == 'licitacion') {
                        let solicitud = this.solicitudes.filter(s => s.id == this.solicitud_id);

                        if (this.monto_adjudicacion == 0 && this
                            .primera_orden) {
                            iziToast.error({
                                title: 'Municipio',
                                message: 'Debes agregar un Monto de Adjudicación',
                                position: 'topRight'
                            });
                            estado = true;
                        } else if (this.monto_adjudicacion !== this.montoAdj && this
                            .metodo == 'finalizar') {
                            iziToast.error({
                                title: 'Municipio',
                                message: 'Para finalizar el proceso, el monto de adjudicacion debe ser igual al total de las ordenes de compras',
                                position: 'topRight'
                            });
                            estado = true;
                        } else if (this.montoAdj > this.monto_adjudicacion && this
                            .metodo == 'guardar') {
                            iziToast.error({
                                title: 'Municipio',
                                message: 'El monto de esta orden compra supera el total del mondo adjudicado',
                                position: 'topRight'
                            });
                            estado = true;
                        } else if (this.montoAdj == this.monto_adjudicacion && this
                            .metodo == 'guardar') {
                            iziToast.info({
                                title: 'Municipio',
                                message: 'El monto de la orden es igual al monto de adjudicación, debes finalizar el proceso',
                                position: 'topRight'
                            });
                            estado = true;
                        }
                    }
                    if (this.xml == null || this.xml == undefined) {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No se ha cargado el XML de la Orden de Compra',
                            position: 'topRight'
                        });
                        estado = true;
                    } else if (this.total == 0) {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No se ha cargado el total de la Orden de Compra',
                            position: 'topRight'
                        });
                        estado = true;
                    }
                }
                return estado;
            },
            checkValue(estado) {
                this.metodo = estado;
                this.buttonDisable = true;
                if (this.validaciones(estado)) {
                    console.log('NO HAS PASADO VALIDACIONES');
                } else {
                    if (this.tipo_compra == 'licitacion' && this.metodo == 'guardar') {
                        let data = new FormData();
                        //SI SE CARGA UN XML
                        data.append('xml', this.xml);
                        data.append('rut', this.rut);
                        data.append('jsonxml', JSON.stringify(this.jsondata));
                        data.append('proveedor', this.proveedor);
                        data.append('anexo', this.anexo);
                        data.append('total', this.total);
                        // data.append('multiple', false);
                        // data.append('diferencia', false);
                        data.append('orden_compra', this.orden_compra);
                        data.append('tipo_compra', this.tipo_compra);
                        data.append('metodo', this.metodo);
                        if (this.primera_orden) {
                            data.append('monto_adjudicacion', this.monto_adjudicacion);
                            if (this.order_multiple) {
                                data.append('multiples_ordenes', this.order_multiple);
                            }
                        }
                        data.append('solicitud_id', this.solicitud_id);

                        if (this.primera_orden) {
                            let mss = this.order_multiple ?
                                'Multiples Ordenes de Compras' : 'Una Orden de Compra';
                            Swal.fire({
                                title: "Generar Orden de Compra!",
                                text: 'Has elegido cargar ' + mss,
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Si, Generar!',
                                cancelButtonText: 'Cancelar!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    this.storeOrden(data);
                                }
                            });
                        } else {
                            this.storeOrden(data);
                        }
                    } else if (this.tipo_compra == 'licitacion' && this.metodo == 'finalizar' || this
                        .tipo_compra !== 'licitacion' && this.metodo == 'guardar') {
                        let solicitud = this.solicitudes.filter(s => s.id == this.solicitud_id);
                        if (solicitud.length == 1) {
                            let total_solicitud = Number(solicitud[0].total.toFixed(2));
                            let total_orden = this.tipo_compra == 'licitacion' ? this.monto_adjudicacion :
                                Number(
                                    this.total.toFixed(2));
                            //SI EL TOTAL DE LA ORDEN DE COMPRA ES IGUAL AL TOTAL DE LA SOLICITUD
                            if (total_solicitud == total_orden) {
                                let data = new FormData();
                                if (this.tipo_compra == 'compra-menor' || this.tipo_compra == 'moneda') {
                                    //SI SE CARGA UN PDF
                                    data.append('pdf', this.documento);
                                    data.append('proveedor_id', this.proveedor_id);
                                } else {
                                    //SI SE CARGA UN XML
                                    data.append('xml', this.xml);
                                    data.append('rut', this.rut);
                                    data.append('jsonxml', JSON.stringify(this.jsondata));
                                    data.append('proveedor', this.proveedor);
                                }
                                data.append('anexo', this.anexo);
                                data.append('total', this.total);
                                // data.append('multiple', false);
                                // data.append('diferencia', false);
                                data.append('orden_compra', this.orden_compra);
                                data.append('tipo_compra', this.tipo_compra);
                                data.append('metodo', this.metodo);
                                data.append('solicitud_id', this.solicitud_id);
                                if (this.primera_orden) {
                                    data.append('monto_adjudicacion', this.monto_adjudicacion);
                                    if (this.order_multiple) {
                                        data.append('multiples_ordenes', this.order_multiple);
                                    }
                                }
                                if (this.primera_orden) {
                                    let mss = this.order_multiple ?
                                        'Multiples Ordenes de Compras' : 'Una Orden de Compra';
                                    Swal.fire({
                                        title: "Generar Orden de Compra!",
                                        text: 'Has elegido cargar ' + mss,
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Si, Generar!',
                                        cancelButtonText: 'Cancelar!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            this.storeOrden(data);
                                        }
                                    });
                                } else {
                                    this.storeOrden(data);
                                }
                            } else {
                                let operacion = total_orden > total_solicitud ? 'egreso' :
                                    'ingreso';
                                //SI EL TOTAL DE LA ORDEN DE COMPRA NO ES IGUAL AL TOTAL DE LA SOLICITUD
                                if (solicitud[0].aprobaciones[0].multiple == true) {
                                    //SI LA SOLICITUD TIENE APROBADA MULTIPLES CUENTAS.
                                    this.modalMultiple(solicitud[0].aprobaciones[0].id,
                                        total_solicitud,
                                        total_orden);
                                } else {
                                    //SI LA SOLICITUD TIENE APROBADA UNA CUENTA.
                                    this.cuenta_id = solicitud[0].aprobaciones[0].cuenta_id;
                                    let suma = total_orden - total_solicitud;
                                    console.log(suma)
                                    let msg = Number(this.total.toFixed(2)) > Number(solicitud[
                                                0].total
                                            .toFixed(
                                                2)) ?
                                        'El monto de la Orden de Compra es superior al monto de la solicitud. Se descontara la diferencia a la cuenta asociada' :
                                        'El monto de la Orden de Compra es inferior al monto de la solicitud. Se adicionara la diferencia a la cuenta asociada';

                                    this.sutmitAlert(msg, operacion);
                                }
                            }
                        } else {
                            //SI NO HAY SOLICITUD
                            iziToast.error({
                                title: 'Municipio',
                                message: 'No has seleccionado una solicitud',
                                position: 'topRight'
                            });
                        }
                    }

                }
            },
            putStore() {
                //GENERAR ORDEN DE COMPRA CON MULTIPLES CUENTAS
                this.buttonDisable = true;
                this.buttonMultiple = true;
                if (this.diferencia_monto !== this.diferencia) {
                    this.buttonDisable = false;
                    this.buttonMultiple = false;
                    return iziToast.error({
                        title: 'Municipio',
                        message: 'La diferencia de los montos no coinciden',
                        position: 'topRight'
                    });
                } else {
                    let solicitud = this.solicitudes.filter(s => s.id == this.solicitud_id);
                    let total_solicitud = Number(solicitud[0].total.toFixed(2));
                    let total_orden = Number(this.total.toFixed(2));
                    let operacion = total_orden > total_solicitud ? 'egreso' : 'ingreso';
                    let data = new FormData();
                    if (this.tipo_compra == 'compra-menor' || this.tipo_compra == 'moneda') {
                        data.append('pdf', this.documento);
                        data.append('proveedor_id', this.proveedor_id);
                    } else {
                        data.append('xml', this.xml);
                        data.append('rut', this.rut);
                        data.append('jsonxml', JSON.stringify(this.jsondata));
                        data.append('proveedor', this.proveedor);
                    }
                    data.append('anexo', this.anexo);
                    data.append('total', this.total);
                    data.append('multiple', true);
                    data.append('diferencia', true);
                    data.append('operacion', operacion);
                    data.append('orden_compra', this.orden_compra);
                    data.append('tipo_compra', this.tipo_compra);
                    data.append('diferencia_monto', this.diferencia_monto);
                    data.append('solicitud_id', this.solicitud_id);
                    data.append('metodo', this.metodo);
                    if (this.primera_orden) {
                        data.append('monto_adjudicacion', this.monto_adjudicacion);
                        if (this.order_multiple) {
                            data.append('multiples_ordenes', this.order_multiple);
                        }
                    }
                    data.append('cuentas', JSON.stringify(this.cuentas));
                    console.log('ALERTA')
                    this.storeOrden(data);

                }
            },
            storeOrden(data) {
                let url = '/ordenes/store';
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                axios.post(url, data, config)
                    .then(function(res) {
                        let link = res.data.ruta;
                        window.location = link;
                    })
                    .catch(function(error) {
                        this.buttonMultiple = false;
                        this.buttonDisable = false;
                        iziToast.error({
                            title: 'Municipio',
                            message: error.response.data.message,
                            position: 'topRight'
                        });
                    });
            },
            modalMultiple(id, total_solicitud, total_orden) {
                let set = this;
                let url = '/ordenes/' + id + '/cuentas';
                axios.get(url)
                    .then(function(res) {
                        set.cuentas = [];
                        console.log(res.data.cuentas);
                        res.data.cuentas.forEach(cuenta => {
                            let c = {
                                id: cuenta.id,
                                cuenta: cuenta.cuenta,
                                monto: ''
                            }
                            set.cuentas.push(c);
                        });
                        set.diferencia_monto = total_solicitud > total_orden ?
                            total_solicitud -
                            total_orden : total_orden - total_solicitud;
                        // set.cuentas = res.data.cuentas;
                        $("#modal_cuentas").modal('show');
                    })
                    .catch(function(error) {

                    });
            },
            precise_round(num, decimals) {
                var sign = num >= 0 ? 1 : -1;
                return (Math.round((num * Math.pow(10, decimals)) + (sign * 0.001)) / Math.pow(
                    10,
                    decimals));
            },
            getProveedores() {
                let set = this;
                let url = '/ordenes/proveedores';
                axios.get(url)
                    .then(function(res) {
                        set.proveedores = res.data.data;
                        console.log(set.proveedores);
                    })
                    .catch(function(error) {

                        set.buttonDisable = false;
                    });
            },
            sutmitAlert(msg, operacion) {
                Swal.fire({
                    title: "Generar Orden de Compra!",
                    text: msg,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Generar!',
                    cancelButtonText: 'Cancelar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let data = new FormData();
                        if (this.tipo_compra == 'compra-menor' || this.tipo_compra ==
                            'moneda') {
                            //SI SE CARGA UN PDF
                            data.append('pdf', this.documento);
                            data.append('proveedor_id', this.proveedor_id);
                        } else {
                            //SI SE CARGA UN XML
                            data.append('xml', this.xml);
                            data.append('rut', this.rut);
                            data.append('jsonxml', JSON.stringify(this.jsondata));
                            data.append('proveedor', this.proveedor);
                        }
                        data.append('anexo', this.anexo);
                        data.append('total', this.total);
                        // data.append('multiple', false);
                        data.append('diferencia', true);
                        data.append('operacion', operacion);
                        data.append('orden_compra', this.orden_compra);
                        data.append('tipo_compra', this.tipo_compra);
                        data.append('solicitud_id', this.solicitud_id);
                        data.append('cuenta_id', this.cuenta_id);
                        data.append('metodo', this.metodo);
                        if (this.primera_orden) {
                            data.append('monto_adjudicacion', this.monto_adjudicacion);
                        }
                        this.storeOrden(data);
                    }
                });
            },
            getJsonxml() {
                let set = this;
                let data = new FormData();
                data.append('xml', this.xml);
                let url = '/ordenes/xml-file';
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                this.buttonDisable = true;
                axios.post(url, data, config)
                    .then(function(res) {
                        set.jsondata = res.data
                        set.total = Number(set.jsondata.ListSummary.OrdersTotalAmount)
                            .toFixed(2);
                        set.orden_compra = set.jsondata.OrdersList.Order.OrderHeader
                            .OrderNumber
                            .BuyerOrderNumber;
                        set.rut = set.jsondata.OrdersList.Order.OrderHeader.OrderParty
                            .SellerParty
                            .PartyID
                            .Ident;
                        set.proveedor = set.jsondata.OrdersList.Order.OrderHeader.OrderParty
                            .SellerParty
                            .NameAddress.Name1;
                    })
                    .catch(function(error) {
                        if (error.response.status == 422) {
                            set.errors.record(error.response.data.errors);
                            set.jsondata = {};
                            set.buttonDisable = false;
                            set.total = 0;
                        } else if (error.response.status == 501) {
                            console.log(error.response.data)
                            iziToast.error({
                                title: 'Municipio',
                                message: error.response.data.msg,
                                position: 'topRight'
                            });
                            set.jsondata = {};
                            set.total = 0;
                            set.orden_compra = '';
                            set.rut = '';
                            set.proveedor = '';
                            set.buttonDisable = false;
                        }

                    });
            }
        }
    });
</script>
@endsection
