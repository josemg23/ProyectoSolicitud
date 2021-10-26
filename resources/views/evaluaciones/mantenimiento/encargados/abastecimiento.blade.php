@section('content')
@section('titulo', '| Aprobacion Mantenimiento')
<div id="mantenimiento">
    <h1 class="text-danger text-center font-weight-bold">Aprobación - Mantenimiento</h1>
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
                        <div>
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
                                        @foreach (json_decode($solicitud->mantenimiento->productos) as $producto)
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
            <div class="___class_+?49___" v-if="tipo_compra == 'licitacion'">
                <div class="card">
                    <div class="padding-10">
                        <div class="card-header">
                            <h4 class="font-weight-bold text-danger">Criterios de Adjudicación</h4>
                        </div>
                        <div class="card-body">
                            {{-- <label class="col-form-label">Criterios de Adjudicación</label> --}}
                            <div class="form-row">
                                <div class="col-lg-8">
                                    <model-list-select :list="getFilterCriterio" v-model="criterio.criterio_id"
                                        class="form-control" :is-disabled="disabled" option-value="id"
                                        option-text="nombre" placeholder="Elije Un Criterio">
                                </div>
                                <div class="col-lg-2">
                                    <currency-input v-model="criterio.porcentaje" class="form-control text-right"
                                        :options="numeric" />
                                </div>
                                <div class="col-lg-2">
                                    <button class="btn btn-block btn-success"
                                        @click.prevent="newCriterio()">Agregar</button>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th width="65%">Criterio</th>
                                            <th>Porcentaje</th>
                                            <th>Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(criterio, index) in criterio.registros">
                                            <td>@{{ criterio . nombre }}</td>
                                            <td class="text-center">
                                                <currency-input v-model="criterio.porcentaje"
                                                    class="form-control text-right" :options="numeric"
                                                    @input="changePorcentaje(index)" />
                                            </td>
                                            <td><button class="btn btn-sm btn-danger"
                                                    @click.prevent="deleteCriterio(index)"><i
                                                        class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="float-right">
                                    <p><strong class="text-danger">Porcentaje Total:</strong>
                                        @{{ criterio . porcentaje_total }} % </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="___class_+?43___">
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
                                            <input class="form-check-input" @change="changeEstado" type="radio"
                                                v-model="estado" value="aprobado" name="gridRadios" id="gridRadios1"
                                                checked>
                                            <label class="form-check-label" for="gridRadios1">
                                                Aprobado
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" @change="changeEstado" type="radio"
                                                name="gridRadios" v-model="estado" value="rechazado" id="gridRadios2">
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
                                <div class="form-group col-lg-12">
                                    <label class="col-form-label">Tipo de Compra</label>
                                    <select name="" id="" class="form-control text-capitalize" :disabled="disabled"
                                        @change="getTipoCompra" v-model="tipo_compra">
                                        <option value="" selected disabled>Selecciona un Tipo de Compra
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
                            </div>
                            <div class="form-row">
                                <h6 class="text-center font-weight-bold text-danger">Ejecutivo de Compra</h6>
                                {{-- <div class="form-group col-lg-12">
                                    <label class="col-form-label">Departamento</label>
                                    <model-list-select :list="departamentos" v-model="departamento_id"
                                        class="form-control" :is-disabled="disabled" option-value="id"
                                        option-text="nombre" placeholder="Elije Un Departamento"
                                        @input="getEjecutivos()">
                                </div> --}}
                                <div class="form-group col-lg-12">
                                    <label class="col-form-label">Ejecutivo de Compras</label>
                                    <model-list-select :list="ejecutivos" v-model="ejecutivo_id" class="form-control"
                                        :is-disabled="disabled" option-value="id" option-text="nombres"
                                        placeholder="Elije Un Ejecutivo de Compras">
                                </div>
                            </div>
                            <div class="text-center">
                                <a href="" class="btn btn-danger" :disabled="buttonDisable"
                                    @click.prevent="validaciones()"><i class="fas fa-save"></i>
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

    const mantenimiento = new Vue({
        name: "mantenimiento",
        el: "#mantenimiento",
        data: {
            estado: 'aprobado',
            solicitud: solicitud,
            estados: estados,
            rechazo_id: '',
            observacion: '',
            departamento_id: '',
            ejecutivo_id: '',
            departamentos: [],
            criterio: {
                registros: [],
                porcentaje: 1,
                criterio_id: '',
                porcentaje_total: 0,
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
                useGrouping: false,
                valueRange: {
                    min: 1,
                    max: 100
                },
            },
            tipo_compra: '',
            criterios: [],
            ejecutivos: [],
            disabled: false,
            buttonDisable: false,
        },
        computed: {
            getIds() {
                let ids = []
                this.criterio.registros.forEach(criterio => {
                    ids.push(criterio.id);
                });
                return ids;
            },
            getFilterCriterio: function() {
                let ids = this.getIds;
                // const cuentas = this.cuentas.reduce((obj, item) => (obj[item.id] = true, obj), {});
                const results = this.criterios.filter(({
                    id: id1
                }) => !ids.some(
                    id2 => id2 === id1));
                // const result = this.cuentas.filter(el.id => !datos2.includes(el.id));
                // var result = this.cuentas.filter(el.id => !ids.includes(el.id));
                return results;
            }
        },
        mounted() {
            this.getEjecutivos();
        },
        methods: {
            changeEstado() {
                if (this.estado == 'rechazado') {
                    this.disabled = true;
                    this.departamento_id = '';
                    this.ejecutivo_id = '';
                    this.observacion = '';
                    this.rechazo_id = '';
                } else {
                    this.disabled = false;
                    this.observacion = '';
                    this.rechazo_id = '';
                }
            },
            getEjecutivos() {
                let set = this;
                // let data = {
                //     departamento_id: set.departamento_id,
                // };
                let url = '/evaluacion/ejecutivos';
                axios.get(url)
                    .then(function(res) {
                        console.log(res.data);
                        set.ejecutivos = res.data.data;
                    })
                    .catch(function(error) {
                        set.buttonDisable = false;
                    });
            },
            getDepartamentos() {
                let set = this;
                let url = '/evaluacion/departamentos';
                axios.get(url)
                    .then(function(res) {
                        set.departamentos = res.data.departamentos;
                        console.log(set.departamentos);
                    })
                    .catch(function(error) {
                        set.buttonDisable = false;
                    });
            },
            getTipoCompra() {
                if (this.tipo_compra == 'licitacion') {
                    let set = this;
                    let url = '/evaluacion/criterios';
                    axios.get(url)
                        .then(function(res) {
                            console.log(res.data);
                            set.criterios = res.data.data;
                        })
                        .catch(function(error) {
                            set.buttonDisable = false;
                        });
                }
                this.resetCriterios();
            },
            resetCriterios() {
                this.criterio.porcentaje = 1;
                this.criterio.criterio_id = '';
                this.criterio.registros = [];
                this.criterio.porcentaje_total = 0;
                // this.sumatorias();
            },
            newCriterio() {
                if (this.criterio.criterio_id === '') {
                    return iziToast.error({
                        title: 'Municipio',
                        message: 'No has seleccionado un criterio',
                        position: 'topRight'
                    });
                } else if (this.criterio.porcentaje > 100) {
                    return iziToast.error({
                        title: 'Municipio',
                        message: 'el procentaje del criterio no puede ser mayor a 100',
                        position: 'topRight'
                    });
                } else if (this.calculoPorcentaje(this.criterio.porcentaje) > 100) {
                    return iziToast.error({
                        title: 'Municipio',
                        message: 'El procentaje final no puede ser mayor a 100',
                        position: 'topRight'
                    });
                } else if ((this.criterio.registros.length + 1) == 10) {
                    return iziToast.error({
                        title: 'Municipio',
                        message: 'No puedes agregar mas de 10 criterios',
                        position: 'topRight'
                    });
                } else {
                    let data = this.criterios.filter(x => x.id == this.criterio.criterio_id);
                    if (data.length == 1) {
                        let criterio = {
                            nombre: data[0].nombre,
                            porcentaje: this.criterio.porcentaje,
                            id: data[0].id
                        };
                        this.criterio.registros.push(criterio);
                        this.criterio.porcentaje = 1;
                        this.criterio.criterio_id = '';
                        this.sumatorias();

                    }
                }
            },
            calculoPorcentaje(porcentaje) {
                let total = porcentaje;
                this.criterio.registros.forEach(criterio => {
                    total += Number(criterio.porcentaje);
                });
                console.log(total);
                return total;
            },
            changePorcentaje(index) {
                let data = this.criterio.registros[index];
                let total = 0;
                this.criterio.registros.forEach(criterio => {
                    total += Number(criterio.porcentaje);
                });
                if (total > 100) {

                    data.porcentaje = 1;
                    iziToast.error({
                        title: 'Municipio',
                        message: 'El porcentaje no puede ser mayor a 100',
                        position: 'topRight'
                    });
                }
                this.sumatorias();

            },
            deleteCriterio(index) {
                this.criterio.registros.splice(index, 1);
                this.sumatorias();
            },
            sumatorias() {
                let total = 0;
                this.criterio.registros.forEach(criterio => {
                    total += Number(criterio.porcentaje);
                });
                // console.log(total);
                this.criterio.porcentaje_total = total;
            },
            validaciones() {
                if (this.estado == 'aprobado') {
                    if (this.ejecutivo_id === '') {
                        return iziToast.error({
                            title: 'Municipio',
                            message: 'No has seleccionado un ejecutivo de compras',
                            position: 'topRight'
                        });
                    } else if (this.tipo_compra === '') {
                        return iziToast.error({
                            title: 'Municipio',
                            message: 'No has seleccionado el Tipo de Compra',
                            position: 'topRight'
                        });
                    } else if (this.tipo_compra == 'licitacion' && this.criterio.porcentaje_total !== 100) {
                        return iziToast.error({
                            title: 'Municipio',
                            message: 'El porcentaje total de los criterios debe ser igual a 100',
                            position: 'topRight'
                        });
                    } else {
                        let data = {
                            solicitud_id: solicitud.id,
                            observacion: this.observacion,
                            estado: this.estado,
                            ejecutivo_id: this.ejecutivo_id,
                            tipo_compra: this.tipo_compra,
                        };
                        if (this.tipo_compra == 'licitacion') {
                            data.criterios = this.criterio.registros;
                        }
                        this.storeAprobacion(data);

                    }
                } else {
                    if (this.rechazo_id === '' && this.estado == 'rechazado') {
                        return iziToast.error({
                            title: 'Municipio',
                            message: 'No has seleccionado un tipo de rechazo',
                            position: 'topRight'
                        });
                    }
                    let data = {
                        solicitud_id: solicitud.id,
                        observacion: this.observacion,
                        estado: this.estado,
                        rechazo_id: this.rechazo_id,
                        ejecutivo_id: '',
                    };
                    this.storeAprobacion(data);
                }
            },
            storeAprobacion(data) {
                let set = this;
                set.buttonDisable = true;
                let url = '/evaluacion/mantenimientos/' + solicitud.id +
                    '/aprobacion/abastecimiento';
                axios.post(url, data)
                    .then(function(res) {
                        console.log(res.data)
                        let link = '{{ route('evaluacion.mantenimiento.index') }}';
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
