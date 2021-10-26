@section('content')
@section('titulo', '| Aprobacion Convenio')
<div id="convenio">
    <h1 class="text-danger text-center font-weight-bold">Aprobación - Convenio</h1>
    <br>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="padding-10">
                    <div class="card-header">
                        <h4 class="font-weight-bold text-danger">Información de Solicitud</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless table-sm">
                                <tbody>
                                    <tr>
                                        <td width="170" class="font-weight-bold">Numero Solicitud:</td>
                                        <td class="text-left">{{ $solicitud->id }}</td>
                                    </tr>
                                    <tr>
                                        <td width="170" class="font-weight-bold">Tipo:</td>
                                        <td class="text-left text-uppercase">{{ $solicitud->convenio->tipo_c }}</td>
                                    </tr>
                                    <tr>
                                        <td width="170" class="font-weight-bold">Fecha Solicitud:</td>
                                        <td class="text-left">{{ $solicitud->fecha_creacion }}</td>
                                    </tr>
                                    <tr>
                                        <td width="170" class="font-weight-bold">Dependencia:</td>
                                        <td class="text-left">{{ $solicitud->dependencia->nombre }}</td>
                                    </tr>
                                    <tr>
                                        <td width="170" class="font-weight-bold">Departamento:</td>
                                        <td class="text-left">{{ $solicitud->departamento->nombre }}</td>
                                    </tr>
                                    <tr>
                                        <td width="170" class="font-weight-bold">Nombre Adquisición:</td>
                                        <td class="text-left">{{ $solicitud->adquisicion }}</td>
                                    </tr>
                                    <tr>
                                        <td width="170" class="font-weight-bold">Desc./Destino::</td>
                                        <td class="text-left">{{ $solicitud->adquisicion }}</td>
                                    </tr>
                                    <tr>
                                        <td width="170" class="font-weight-bold">Usuario:</td>
                                        <td class="text-left">{{ $solicitud->solicitante->nombres }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="___class_+?26___">
                            <h4 class="text-center text-info">Productos/Servicios</h4>
                            <div class="table-responsive" style="height: 100%; overflow-y: scroll; ">
                                <table class="table table-sm">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="font-size: 10px" class="text-center">Cantidad</th>

                                            <th style="font-size: 10px" class="text-center">Producto</th>
                                            <th style="font-size: 10px" class="text-center">Detalle</th>
                                            <th style="font-size: 10px" class="text-center">Valor Neto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($solicitud->convenio->tipo_c == 'contrato')
                                            @foreach ($solicitud->convenio->products as $producto)
                                                <tr>
                                                    <td style="font-size: 10px" class="text-center">
                                                        {{ $producto->pivot->cantidad }}
                                                    </td>
                                                    <td style="font-size: 10px" class="text-capitalize text-center">
                                                        {{ $producto->nombre }}
                                                    </td>
                                                    <td style="font-size: 10px" class="text-center">
                                                        {{ $producto->detalle }}</td>

                                                    <td style="font-size: 10px" class="text-center text-capitalize">
                                                        {{ number_format($producto->pivot->neto, 2, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @foreach (json_decode($solicitud->convenio->productos) as $producto)
                                                <tr>
                                                    <td style="font-size: 10px" class="text-center">
                                                        {{ $producto->cantidad }}
                                                    </td>
                                                    <td style="font-size: 10px" class="text-capitalize text-center">
                                                        {{ $producto->producto }}
                                                    </td>
                                                    <td style="font-size: 10px" class="text-center">
                                                        {{ $producto->detalle }}</td>

                                                    <td style="font-size: 10px" class="text-center text-capitalize">
                                                        {{ number_format($producto->total, 2, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>

                            </div>
                            <div class="row justify-content-end mt-2">
                                <div class="col-lg-4">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td class="font-weight-bold text-primary pr-3">Total Costo: </td>
                                                <td><span class="badge badge-danger">
                                                        {{ number_format($solicitud->total, 2, ',', '.') }}</span>

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
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="___class_+?49___">
                    <div class="card-header">
                        <h4 class="font-weight-bold text-danger">Evaluación</h4>
                    </div>
                    <div class="card-body">
                        <form>
                            <fieldset class="form-group">
                                <div class="row">
                                    <legend class="col-form-label col-sm-2 pt-0">Estado</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" v-model="estado"
                                                @change="changeEstado" value="aprobado" name="gridRadios"
                                                id="gridRadios1" checked>
                                            <label class="form-check-label" for="gridRadios1">
                                                Aprobado
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gridRadios"
                                                @change="changeEstado" v-model="estado" value="rechazado"
                                                id="gridRadios2">
                                            <label class="form-check-label" for="gridRadios2">
                                                Rechazado
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-row">
                                <div class="form-group col-lg-12" v-if="estado == 'aprobado'">
                                    <label class="col-form-label">Observación</label>
                                    <textarea name="" class="form-control" v-model="observacion" cols="5"
                                        rows="5"></textarea>
                                </div>
                                <div class="form-group col-lg-12" v-else>
                                    <label class="col-form-label">Tipo de Rechazo</label>
                                    <select name="" id="" class="form-control text-capitalize" v-model="rechazo_id">
                                        <option value="" selected disabled>Selecciona un Tipo de Rechazo</option>
                                        <option class="text-capitalize" v-for="(motivo, index) in estados"
                                            :value="motivo.id">@{{ motivo . nombre }}
                                        </option>
                                    </select>
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
    let solicitud = @json($solicitud);
    let estados = @json($estados);

    const convenio = new Vue({
        name: "convenio",
        el: "#convenio",
        data: {
            estado: 'aprobado',
            solicitud: solicitud,
            estados: estados,
            rechazo_id: '',
            observacion: '',
            disabled: false,
            buttonDisable: false,
        },
        methods: {
            changeEstado() {
                this.observacion = '';
                this.rechazo_id = '';
            },
            storeAprobacion() {
                if (this.rechazo_id === '' && this.estado == 'rechazado') {
                    return iziToast.error({
                        title: 'Municipio',
                        message: 'No has seleccionado un tipo de rechazo',
                        position: 'topRight'
                    });
                }
                let set = this;
                let data = {
                    solicitud_id: solicitud.id,
                    observacion: this.observacion,
                    rechazo_id: this.rechazo_id,
                    estado: this.estado,
                };
                let url = '/evaluacion/convenios/' + solicitud.id + '/aprobacion/direccion';
                axios.post(url, data)
                    .then(function(res) {
                        console.log(res.data)
                        this.buttonDisable = true;
                        let link = '{{ route('evaluacion.convenio.index') }}';
                        window.location = link;
                    })
                    .catch(function(error) {
                        set.buttonDisable = false;
                    });
            },
        }
    });
</script>
@endsection
