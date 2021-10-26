@extends('layouts.nav')
@section('breadcrumb')
    <li class=""><a href="{{ route('ordenes.index') }}"><i class="fas fa-shopping-bag"></i> Lista de Decretos de
            Adjudicación</a></li>
    <li class="active"><a><i class="fas fa-plus-circle"></i> Nuevo Decreto de Adjudicación</a></li>
@endsection
@section('content')
@section('titulo', '| Decreto de Adjudicación')
<div>
    <h1 class="text-danger text-center font-weight-bold">Nuevo Decreto de Adjudicación</h1>
    <br>
    <div id="orden">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="">
                        <div class="card-header">
                            <h2 class="font-weight-bold text-danger">Agregar Decreto de Adjudicación</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="col-form-label mr-1 ">Solicitud Aprobada:</label>
                                    <model-list-select :list="solicitudes" v-model="solicitud_id" class="form-control"
                                        option-value="id" option-text="solicitud" placeholder="Elije Una Solicitud">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="col-form-label mr-1 ">N° Decreto:</label>
                                    <input type="text" class="form-control" placeholder="N° Decreto"
                                        v-model="num_decreto">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="col-form-label mr-1 ">Seleccione Decreto:</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="customFile"
                                            v-on:change="getPdf" accept="application/pdf, image/png">
                                        <label class="custom-file-label" for="customFile">Cargar Documento</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <button class="btn btn-success" @click.prevent="validaciones()"><i
                                        class="fa fa-save"></i>
                                    GUARDAR</button>
                            </div>
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
<script type="text/javascript">
    $(document).ready(function() {
        bsCustomFileInput.init()
    });
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
            solicitudes: solicitudes,
            solicitud_id: '',
            num_decreto: '',
            documento: null,
            buttonDisable: false,
            isDisabled: true,
            errors: new Errors,
        },
        mounted() {},
        methods: {
            getPdf(event) {
                this.documento = event.target.files[0];
            },
            validaciones() {
                if (this.num_decreto === '') {
                    return iziToast.error({
                        title: 'Municipio',
                        message: 'No has agregado el numero de Decreto',
                        position: 'topRight'
                    });
                } else if (this.documento == null || this.documento == undefined) {
                    return iziToast.error({
                        title: 'Municipio',
                        message: 'No has cargado el Decreto de Adjudicación',
                        position: 'topRight'
                    });
                } else {
                    let data = new FormData();
                    data.append('solicitud_id', this.solicitud_id);
                    data.append('num_decreto', this.num_decreto);
                    data.append('documento', this.documento);
                    this.storeOrden(data);
                }
            },
            storeOrden(data) {
                let url = '/decretos/store';
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
                        this.buttonDisable = false;
                        iziToast.error({
                            title: 'Municipio',
                            message: error.response.data.message,
                            position: 'topRight'
                        });
                    });
            }
        }
    });
</script>
@endsection
