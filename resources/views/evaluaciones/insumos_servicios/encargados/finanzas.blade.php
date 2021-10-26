@section('content')
@section('titulo', '| Aprobacion Insumos y Servicios')
<div id="insumo">
    <h1 class="text-danger text-center font-weight-bold">Aprobación - Insumos y Servicios</h1>
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
                                        <td class="text-left text-uppercase">{{ $solicitud->insumo->tipo_in }}</td>
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
                                    @if ($solicitud->insumo->tipo_in == 'contrato')
                                        <tr>
                                            <td width="170" class="font-weight-bold">Contrato de Suministro:</td>
                                            <td class="text-left">{{ $solicitud->insumo->contrato->nombre }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="___class_+?28___">
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
                                        @if ($solicitud->insumo->tipo_in == 'contrato')
                                            @foreach ($solicitud->insumo->products as $producto)
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
                                            @foreach (json_decode($solicitud->insumo->productos) as $producto)
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
                <div class="___class_+?51___">
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
                                                id="gridRadios2" value="option2">
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
                                        <option value="" selected disabled>Selecciona un Tipo</option>
                                        <option class="text-capitalize" v-for="(motivo, index) in estados"
                                            :value="motivo.id">@{{ motivo . nombre }}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-12" v-if="!disabled">
                                    <label class="col-form-label">Varias cuentas</label>
                                    <input type="checkbox" v-model=isMultiple>

                                </div>
                                <div class="form-group col-lg-12" v-if="isMultiple">
                                    <label class="col-form-label">Cuentas</label>
                                    <div class="___class_+?77___">
                                        <table class="table table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th style="font-size: 10px">Cuenta</th>
                                                    <th style="font-size: 10px">Monto</th>
                                                    <th style="font-size: 10px"></th>
                                                </tr>
                                            </thead>
                                            <tbody v-for="(cuenta, index) in items">
                                                <tr>
                                                    <td style=" font-size: 10px">
                                                        <model-list-select :list="cuentas" v-model="cuenta.id"
                                                            class="form-control" :is-disabled="disabled"
                                                            option-value="id" option-text="cuenta"
                                                            placeholder="Elije Una Cuenta"
                                                            @input="filerCuenta(index, cuenta.id)">
                                                    </td>
                                                    <td style=" font-size: 10px">
                                                        <input type="number" v-model="cuenta.monto"
                                                            class="form-control form-control-sm text-right"
                                                            @input="calculoProductos()">
                                                    </td>
                                                    <td><button class="btn btn-danger"
                                                            @click.prevent="eliminarCuenta(index)">
                                                            <i class="fa fa-trash"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="row justify-content-lg-between">
                                            <div class="col-lg-2">
                                                <button class="btn btn-success mb-1 btn-sm "
                                                    @click.prevent="newproduct()"><i
                                                        class="fa fa-plus-circle"></i></button>
                                            </div>
                                            <div class="col-lg-4">
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td class="font-weight-bold text-primary pr-3">Total Monto:
                                                            </td>
                                                            <td><span class="badge badge-danger">
                                                                    @{{ total }}
                                                                </span>

                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {{-- <button class="btn btn-sm btn-success">Agregar Cuenta</button> --}}

                                    </div>
                                    {{-- <multi-list-select :list="cuentas" option-value="id" option-text="cuenta"
                                            :selected-items="items" placeholder="Elije Una Cuenta" :is-disabled="disabled"
                                            @select="onSelect">
                                        </multi-list-select> --}}
                                    {{-- <select name="cuenta_id" class="form-control select2"
                                                :disabled="estado == 'rechazado'">
                                                <option value="" selected disabled>-- SELECCIONE UNA CUENTA --</option>
                                                @foreach ($cuentas as $cuenta)
                                                    <option value="{{ $cuenta->id }}">{{ $cuenta->cuenta }} | Saldo:
                                                        {{ number_format($cuenta->saldo_a, 2, ',', '.') }}
                                                    </option>

                                                @endforeach
                                            </select> --}}
                                </div>
                                <div class="form-group col-lg-12" v-else>
                                    <label class="col-form-label">Cuenta</label>

                                    <model-list-select :list="cuentas" v-model="cuenta_id" class="form-control"
                                        :is-disabled="disabled" option-value="id" option-text="cuenta"
                                        placeholder="Elije Una Cuenta">
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
    let cuentas = @json($cuentas);
    let solicitud = @json($solicitud);
    let estados = @json($estados);
    const insumo = new Vue({
        name: "Insumo",
        el: "#insumo",
        data: {
            estado: 'aprobado',
            filtros: cuentas,
            cuentas: cuentas,
            solicitud: solicitud,
            rechazo_id: '',
            estados: estados,
            cuenta_id: '',
            total: 0,
            observacion: '',
            isMultiple: false,
            items: [],
            disabled: false,
            buttonDisable: false,
            lastSelectItem: {}
        },
        computed: {
            // getIds() {
            //     let ids = []
            //     this.items.forEach(cuenta => {
            //         ids.push(cuenta.id);
            //     });
            //     return ids;
            // },
            // getFilterCuenta: function() {
            //     let ids = this.getIds;
            //     // const cuentas = this.cuentas.reduce((obj, item) => (obj[item.id] = true, obj), {});
            //     const results = this.cuentas.filter(({
            //         id: id1
            //     }) => !ids.some(
            //         id2 => id2 === id1));
            //     // const result = this.cuentas.filter(el.id => !datos2.includes(el.id));
            //     // var result = this.cuentas.filter(el.id => !ids.includes(el.id));
            //     return results;
            // }
        },
        methods: {
            newproduct() {
                if (this.items.length == 3) {
                    return iziToast.error({
                        title: 'Municipio',
                        message: 'Solo puedes agregar un maximo de 3 cuentas',
                        position: 'topRight'
                    });
                } else {
                    let cuenta = {
                        id: '',
                        monto: ''
                    }
                    this.items.push(cuenta);
                }
            },
            // filerCuenta(index, id) {
            //     let ids = []
            //     this.items.forEach(cuenta => {
            //         ids.push(cuenta.id);
            //     });
            //     const results = this.cuentas.filter(({
            //         id: id1
            //     }) => !ids.some(
            //         id2 => id2 === id1));
            //     this.filtros = results;
            // },
            filerCuenta(index, id) {
                let consulta = this.items.filter(x => x.id == id);
                // console.log(consulta)
                if (consulta.length == 2) {
                    this.items[index].id = '';
                    return iziToast.error({
                        title: 'Municipio',
                        message: 'Esta cuenta ya se encuentra agregada',
                        position: 'topRight'
                    });
                }
                this.calculoProductos()
            },
            eliminarCuenta(index) {
                this.items.splice(index, 1);
                this.calculoProductos();
            },
            calculoProductos() {
                let total = 0;
                this.items.forEach(cuenta => {
                    total += Number(cuenta.monto);
                });
                this.total = total.toFixed(2);
            },
            changeEstado() {
                if (this.estado == 'rechazado') {
                    this.cuenta_id = '';
                    this.disabled = true;
                    this.isMultiple = false;
                    this.items = [];
                    this.total = 0;
                    this.observacion = '';
                    this.rechazo_id = '';
                } else {
                    this.disabled = false;
                    this.observacion = '';
                    this.rechazo_id = '';
                }
            },
            validaciones() {
                if (this.estado == 'aprobado') {
                    if (this.isMultiple) {
                        let conteo = this.items.filter(cuenta => cuenta.monto === '' || cuenta.id === '');
                        if (conteo.length >= 1) {
                            return iziToast.error({
                                title: 'Municipio',
                                message: 'No puedes dejar campos vacios al agregar cuentas',
                                position: 'topRight'
                            });
                        } else if (this.items.length <= 1) {
                            return iziToast.error({
                                title: 'Municipio',
                                message: 'Has habilitado la opcion de varias cuentas, debes seleccionar mas de una',
                                position: 'topRight'
                            });
                        }
                        //  else if (this.verificarMontos()) {

                        // }
                        else if (Number(this.total) !== this.solicitud.total) {
                            console.log(Number(this.total));
                            return iziToast.error({
                                title: 'Municipio',
                                message: 'El total asignado no coincide con el total de la solicitud',
                                position: 'topRight'
                            });
                        } else {
                            let data = {
                                solicitud_id: this.solicitud.id,
                                estado: this.estado,
                                total: this.total,
                                observacion: this.observacion,
                                multiple: true,
                                cuentas: this.items
                            }
                            this.storeAprobacion(data);
                        }

                    } else {
                        let cuenta = this.cuentas.filter(x => x.id == this.cuenta_id);
                        if (cuenta.length > 0) {
                            if (this.solicitud.total > cuenta[0].saldo_a) {
                                Swal.fire({
                                    title: 'El total de la solicitud es mayor al saldo actual de la cuenta',
                                    text: "¿Seguro que deseas aprobar esta solicitud?",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'Si, Aprobar!',
                                    cancelButtonText: 'Cancelar!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        let data = {
                                            solicitud_id: this.solicitud.id,
                                            estado: this.estado,
                                            observacion: this.observacion,
                                            multiple: false,
                                            cuenta_id: this.cuenta_id
                                        }
                                        this.storeAprobacion(data);
                                    }
                                });
                                // iziToast.error({
                                //     title: 'Municipio',
                                //     message: 'El total de la solicitud no puede ser mayor al saldo actual de la cuenta',
                                //     position: 'topRight'
                                // });
                            } else {
                                let data = {
                                    solicitud_id: this.solicitud.id,
                                    estado: this.estado,
                                    observacion: this.observacion,
                                    multiple: false,
                                    cuenta_id: this.cuenta_id
                                }
                                this.storeAprobacion(data);
                            }
                        } else {
                            iziToast.error({
                                title: 'Municipio',
                                message: 'No has seleccionado la cuenta',
                                position: 'topRight'
                            });
                        }
                    }

                } else {
                    if (this.rechazo_id === '') {
                        return iziToast.error({
                            title: 'Municipio',
                            message: 'No has seleccionado un tipo de rechazo',
                            position: 'topRight'
                        });
                    } else {
                        let data = {
                            solicitud_id: this.solicitud.id,
                            estado: this.estado,
                            multiple: false,
                            observacion: this.observacion,
                            rechazo_id: this.rechazo_id,

                        }
                        this.storeAprobacion(data);
                    }
                }

            },
            verificarMontos() {
                let estado = false;
                this.items.forEach(cuenta => {
                    let c = this.cuentas.filter(x => x.id == cuenta.id);
                    if (c.length == 1) {
                        let monto = Number(cuenta.monto);
                        if (monto > c[0].saldo_a) {
                            console.log(c)
                            iziToast.error({
                                title: 'Municipio',
                                message: 'El monto asignado para la cuenta ' + c[0]
                                    .nombre +
                                    ' es superior a su saldo actual',
                                position: 'topRight'
                            });
                            estado = true;
                        }
                    }
                });
                console.log(estado)

                return estado
            },
            onSelect(items, lastSelectItem) {
                this.items = items
                this.lastSelectItem = lastSelectItem;
                console.log(this.items);
                if (this.items.length > 3) {
                    let cuentas = this.items.filter(x => x.id !== this.lastSelectItem.id);
                    // let item = JSON.parse(JSON.stringify(cuentas));
                    this.items = cuentas
                    return iziToast.error({
                        title: 'Municipio',
                        message: 'Solo puedes agregar un maximo de 3 cuentas',
                        position: 'topRight'
                    });
                }
            },
            storeAprobacion(data) {
                let set = this;
                let url = '/evaluacion/insumos-y-servicios/' + solicitud.id + '/aprobacion/finanzas';
                axios.post(url, data)
                    .then(function(res) {
                        console.log(res.data)
                        this.buttonDisable = true;
                        let link = '{{ route('evaluacion.insumo.index') }}';
                        window.location = link;

                    })
                    .catch(function(error) {
                        if (error.response.status == 422) {
                            // set.errors.record(error.response.data.errors);
                        }
                        set.buttonDisable = false;
                    });
            },
        }
    });
</script>
@endsection
