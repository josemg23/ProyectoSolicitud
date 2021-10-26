@extends('layouts.nav')
@section('titulo', '| Aprobación de Recepción')
@section('breadcrumb')
    <li class=""><a href=" {{ route('recepciones.aprobaciones.finanzas') }}"><i class="fas fa-shopping-bag"></i>
        Recepciones Pendientes de Aprobación</a></li>
    <li class="active"><a><i class="fas fa-shopping-bag"></i> Finanzas</a></li>
    <li class="active"><a><i class="fas fa-edit"></i> Recepcion # {{ $recepcion->id }}</a></li>
@endsection
@section('content')
    <div id="finanzas">
        <h1 class="text-danger text-center font-weight-bold">Aprobación - Finanzas</h1>
        <br>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="padding-10">
                        {{-- <div class="card-header">
                            <h4 class="font-weight-bold text-danger">Información de Recepción</h4>
                        </div> --}}
                        <div class="card-body">
                            <h4 class="font-weight-bold text-danger">Información</h4>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="recepcion-tab" data-toggle="tab" href="#recepcion"
                                        role="tab" aria-controls="recepcion" aria-selected="false">Recepción</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link " id="solicitud-tab" data-toggle="tab" href="#solicitud"
                                        role="tab" aria-controls="solicitud" aria-selected="true">Orden</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link " id="diferencia-tab" data-toggle="tab" href="#diferencia"
                                        role="tab" aria-controls="diferencia" aria-selected="true">Diferencia</a>
                                </li>

                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade show active p-1" id="recepcion" role="tabpanel"
                                    aria-labelledby="recepcion-tab">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-sm">
                                            <tbody>
                                                <tr>
                                                    <td width="170" class="font-weight-bold">Numero Recepción:</td>
                                                    <td class="text-left">{{ $recepcion->id }}</td>
                                                </tr>

                                                <tr>
                                                    <td width="170" class="font-weight-bold">Fecha Recepción:</td>
                                                    <td class="text-left">{{ $recepcion->created_at }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="170" class="font-weight-bold">Tipo de Recepción:</td>
                                                    <td class="text-left text-capitalize">{{ $recepcion->tipo }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="170" class="font-weight-bold">N° Documento:</td>
                                                    <td class="text-left">{{ $recepcion->num_documento }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="170" class="font-weight-bold">Tipo de Documento:</td>
                                                    <td class="text-left text-capitalize">{{ $recepcion->documento }}</td>
                                                </tr>
                                                <tr>
                                                    <td width="170" class="font-weight-bold">Monto Recepción:</td>
                                                    <td class="text-left text-capitalize">
                                                        {{ number_format($recepcion->monto_total, 2, ',', '.') }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade p-1" id="solicitud" role="tabpanel"
                                    aria-labelledby="solicitud-tab">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-sm">
                                            <tbody>
                                                <tr>
                                                    <td width="170" class="font-weight-bold">Numero Solicitud:</td>
                                                    <td class="text-left">{{ $recepcion->orden->solicitud->id }}</td>
                                                </tr>

                                                <tr>
                                                    <td width="170" class="font-weight-bold">Orden de Compra:</td>
                                                    <td class="text-left">
                                                        {{ $recepcion->orden->num_orden }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td width="170" class="font-weight-bold">Monto Orden de Compra:</td>
                                                    <td class="text-left text-capitalize">
                                                        {{ number_format($recepcion->orden->valor_total, 2, ',', '.') }}
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade p-1" id="diferencia" role="tabpanel"
                                    aria-labelledby="diferencia-tab">
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <label for="">Diferencia:</label>
                                            <input type="text" class="form-control text-right" disabled
                                                value="{{ number_format($recepcion->diferencia, 2, ',', '.') }}">
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="">Tipo De Diferencia:</label>
                                            <input type="text" class="form-control text-capitalize" disabled
                                                value="{{ $recepcion->tipo_diferencia }}">
                                        </div>
                                        {{-- <div class="form-group col-lg-12">
                                            <label for="">Detalle:</label>
                                            <textarea class="form-control text-capitalize"
                                                disabled>{{ $recepcion->detalle }}
                                                                                                                                                                                                </textarea>
                                        </div> --}}
                                    </div>
                                </div>



                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="">
                        <div class=" card-header">
                        <h4 class="font-weight-bold text-danger">Evaluación</h4>
                    </div>
                    <div class="card-body">
                        <form>
                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-2 pt-0">Estado</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" v-model="estado" value="aprobada"
                                                name="gridRadios" id="gridRadios1" value="option1" checked>
                                            <label class="form-check-label" for="gridRadios1">
                                                Aprobada
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gridRadios" v-model="estado"
                                                value="rechazada" id="gridRadios2" value="option2">
                                            <label class="form-check-label" for="gridRadios2">
                                                Rechazada
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-row">
                                <div class="form-group col-lg-12">
                                    <label class="col-form-label">Observación</label>
                                    <textarea name="" class="form-control" v-model="observacion" cols="5"
                                        rows="5"></textarea>
                                </div>
                            </div>
                            <div class="text-center">
                                <a href="" class="btn btn-danger" :disabled="buttonDisable"
                                    @click.prevent="storeAprobacion()"><i class="fas fa-save"></i>
                                    Guardar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection
@section('js')
    <script>
        let recepcion = @json($recepcion);
        const finanzas = new Vue({
            name: "Finanzas",
            el: "#finanzas",
            data: {
                estado: 'aprobada',
                recepcion: recepcion,
                observacion: '',
                disabled: false,
                buttonDisable: false,
            },
            methods: {
                storeAprobacion() {
                    this.buttonDisable = true;
                    let set = this;
                    let data = {
                        recepcion_id: recepcion.id,
                        observacion: this.observacion,
                        estado: this.estado,
                    };
                    let url = '/recepciones/aprobaciones/finanzas/' + recepcion.id;
                    axios.post(url, data)
                        .then(function(res) {
                            console.log(res.data);
                            let link = '{{ route('recepciones.aprobaciones.finanzas') }}';
                            window.location = link;
                        })
                        .catch(function(error) {
                            if (error.response.status == 501) {
                                console.log(error.response.data);
                                iziToast.error({
                                    title: 'Municipio',
                                    message: error.response.data.msg,
                                    position: 'topRight'
                                });
                            }
                            set.buttonDisable = false;
                        });
                },
            }
        });
    </script>
@endsection
