@extends('layouts.nav')
@section('breadcrumb')
    <li class=""><a href="{{ route('admin.contrato-suministro.index') }}"><i class="fas fa-file-contract"></i>
            Contratos de Suministro</a></li>
    <li class="active">
        <a><i class="fas fa-plus-circle"></i> Crear Contrato Suministro</a>
    </li>
@endsection
@section('content')
@section('titulo', '| Contrato de Suministros')
<div id="">
    <h1 class="text-danger text-center font-weight-bold">Crear Contrato de Suministros</h1>
    <div id="contrato_suministro">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"></div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-lg-4">
                                <label class="text-dark" for="">Nombre Contrato</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-clipboard-list"></i>
                                        </div>
                                    </div>
                                    <input type="text" v-model="nombre" class="form-control"
                                        placeholder="Agrega Nombre Del Contrato">
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="text-dark" for="">Licitación</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-clipboard"></i>
                                        </div>
                                    </div>
                                    <input type="text" v-model="licitacion" class="form-control"
                                        placeholder="Agrega La Licitación">
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="text-dark" for="">Decreto De Adjudicación</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-clipboard"></i>
                                        </div>
                                    </div>
                                    <input type="text" v-model="decreto_adjudicacion" class="form-control"
                                        placeholder="Agrega el Decreto de Adjudicación">
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="text-dark" for="">Fecha Inicio</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="date" v-model="fecha_inicio" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="text-dark" for="">Fecha Termino</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="date" v-model="fecha_termino" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="text-dark" for="">Monto</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </div>
                                    </div>
                                    <input type="number" v-model="monto" class="form-control"
                                        placeholder="Agregar Monto">
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="text-dark" for="">Fecha Inicio Periodo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="date" v-model="fecha_inicio_periodo" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="text-dark" for="">Fecha Termino Periodo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="date" v-model="fecha_termino_periodo" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-lg-4">
                                <label class="text-dark" for="">Monto Periodo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </div>
                                    </div>
                                    <input type="number" v-model="monto_periodo" class="form-control"
                                        placeholder="Agregar Monto de Periodo">
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="text-dark" for="">Tipo de Contrato</label>
                                <model-list-select :list="tipos_contratos" v-model="tipo_contrato_id"
                                    class="form-control" option-value="id" option-text="nombre"
                                    placeholder="Elije Un Tipo de Contrato" @input="searchProveedor()">
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="text-dark" for="">Solicitud de Contrato</label>
                                <model-list-select :list="solicitudes" v-model="solicitud_contrato_id"
                                    class="form-control" option-value="id" option-text="adquisicion"
                                    placeholder="Elije Una Solicitud">
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="text-dark" for="">Proveedor</label>
                                <model-list-select :list="proveedores" v-model="proveedor_id" class="form-control"
                                    option-value="id" option-text="nombre" placeholder="Elije Un Proveedor"
                                    @input="searchProductos()">
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="text-dark" for="">Cuenta Contable</label>
                                <model-list-select :list="cuentas" v-model="cuenta_id" class="form-control"
                                    option-value="id" option-text="cuenta" placeholder="Elije Una Cuenta Contable">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-head p-2">
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-end">
                            <div class="col-lg-12">
                                <button class="btn btn-success mb-1" @click="newproduct()"><i
                                        class="fa fa-shopping-bag"></i>
                                    Agregar
                                    Producto</button>

                                <table class="table table-striped table-sm">
                                    <thead class="bg-dark">
                                        <tr>
                                            <td width="175">Unidad</td>
                                            <td>Producto</td>
                                            <td>Detalle</td>
                                            <td width="125">Valor Neto</td>
                                            <td width="50"></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(producto, index) in productos">

                                            <td>
                                                <select name="" class="form-control" v-model="producto.unidad_id"
                                                    disabled id="">
                                                    <option value="" selected disabled>Unidad</option>
                                                    <option v-for="(medida, index) in medidas" :value="medida.id">
                                                        @{{ medida . nombre }}
                                                    </option>
                                                </select>
                                            </td>
                                            <td>
                                                <model-list-select :list="items" v-model="producto.producto_id"
                                                    class="form-control" option-value="id" option-text="nombre"
                                                    placeholder="Elije Un Producto" @input="selectProduct(index)">
                                            </td>
                                            <td><input type="text" v-model="producto.detalle" disabled
                                                    class="form-control form-control-sm"></td>
                                            <td><input type="number" min="0" v-model="producto.neto" disabled
                                                    class="form-control form-control-sm">
                                            </td>

                                            <td><button class="btn btn-danger" @click.prevent="eliminarProducto(index)">
                                                    <i class="fa fa-trash"></i></button>
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
        <div class="row justify-content-lg-around">
            <div class="col-lg-2">
                <button class="btn btn-success btn-sm" :disabled="buttonDisable"
                    @click.prevent="validaciones('en proceso')">GRABAR Y
                    ENVIAR</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    let proveedores = @json($proveedores);
    let medidas = @json($medidas);
    let solicitudes = @json($solicitudes);
    let tipos = @json($tipos);
    let cuentas = @json($cuentas);
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
    const contrato_suministro = new Vue({
        el: "#contrato_suministro",
        name: "Contrarto Suministro",
        data: {
            nombre: '',
            licitacion: '',
            decreto_adjudicacion: '',
            fecha_inicio: '',
            fecha_termino: '',
            monto: '',
            fecha_inicio_periodo: '',
            fecha_termino_periodo: '',
            monto_periodo: '',
            tipo_contrato_id: '',
            tipos_contratos: tipos,
            solicitud_contrato_id: '',
            solicitudes: solicitudes,
            proveedor_id: '',
            proveedores: proveedores,
            medidas: medidas,
            cuentas: cuentas,
            cuenta_id: '',
            productos: [],
            items: [],
            errors: new Errors,
            buttonDisable: false
        },
        mounted() {
            this.newproduct();
        },
        methods: {
            newproduct() {
                let producto = {
                    cantidad: 1,
                    unidad_id: '',
                    producto_id: '',
                    detalle: '',
                    neto: 0
                }
                this.productos.push(producto);
            },
            searchProductos() {
                let id = this.proveedor_id;
                let tipo_contrato_id = this.tipo_contrato_id;
                let url = 'productos';
                axios.post(url, {
                    id: id,
                    tipo_contrato_id: tipo_contrato_id,
                }).then(response => {
                    this.items = response.data.data;
                    this.productos = []
                    this.newproduct();
                    console.log(response.data);
                }).catch(function(error) {

                });
            },
            searchProveedor() {
                let id = this.tipo_contrato_id;
                let url = 'proveedores';
                axios.post(url, {
                    id: id
                }).then(response => {
                    this.proveedor_id = '';
                    this.items = [];
                    this.productos = []
                    this.newproduct();
                    console.log(response.data);
                    this.proveedores = response.data.data;
                }).catch(function(error) {

                });
            },
            //VALIDACIONES ANTES DE ENVIAR
            validaciones() {
                if (this.licitacion === '') {
                    iziToast.error({
                        title: 'Municipio',
                        message: 'No has agregado la Licitación',
                        position: 'topRight'
                    });
                } else if (this.nombre === '') {
                    iziToast.error({
                        title: 'Municipio',
                        message: 'No has agregado el Nombre del Contrato',
                        position: 'topRight'
                    });
                } else if (this.decreto_adjudicacion === '') {
                    iziToast.error({
                        title: 'Municipio',
                        message: 'No has agregado el Decreto de Adjudicación',
                        position: 'topRight'
                    });
                } else if (this.fecha_inicio === '') {
                    iziToast.error({
                        title: 'Municipio',
                        message: 'No has agregado la fecha de inicio',
                        position: 'topRight'
                    });
                } else if (this.fecha_termino === '') {
                    iziToast.error({
                        title: 'Municipio',
                        message: 'No has agregado la fecha de termino',
                        position: 'topRight'
                    });
                } else if (this.monto === '') {
                    iziToast.error({
                        title: 'Municipio',
                        message: 'No has agregado el monto',
                        position: 'topRight'
                    });
                } else if (this.fecha_inicio_periodo === '') {
                    iziToast.error({
                        title: 'Municipio',
                        message: 'No has agregado la fecha de inicio del periodo',
                        position: 'topRight'
                    });
                } else if (this.fecha_inicio_periodo !== this.fecha_inicio) {
                    iziToast.error({
                        title: 'Municipio',
                        message: 'La fecha de Inicio e Inicio del Periodo no coinciden',
                        position: 'topRight'
                    });
                } else if (this.fecha_termino_periodo === '') {
                    iziToast.error({
                        title: 'Municipio',
                        message: 'No has agregado la fecha de inicio del periodo',
                        position: 'topRight'
                    });
                } else if (this.fecha_termino_periodo > this.fecha_termino) {
                    iziToast.error({
                        title: 'Municipio',
                        message: 'La Fecha de Termino de Periodo no puede ser mayor a la Fecha de Termino',
                        position: 'topRight'
                    });
                } else if (this.monto_periodo === '') {
                    iziToast.error({
                        title: 'Municipio',
                        message: 'No has agregado el monto del periodo',
                        position: 'topRight'
                    });
                } else if (Number(this.monto_periodo) > Number(this.monto)) {
                    iziToast.error({
                        title: 'Municipio',
                        message: 'El monto del periodo no puede ser mayor al monto',
                        position: 'topRight'
                    });
                } else if (this.tipo_contrato_id == '') {
                    iziToast.error({
                        title: 'Municipio',
                        message: 'No has seleccionado el Tipo de Contrato',
                        position: 'topRight'
                    });
                } else if (this.solicitud_contrato_id == '') {
                    iziToast.error({
                        title: 'Municipio',
                        message: 'No has seleccionado la Solicitud',
                        position: 'topRight'
                    });
                } else if (this.producto_id == '') {
                    iziToast.error({
                        title: 'Municipio',
                        message: 'No has seleccionado el Proveedor',
                        position: 'topRight'
                    });
                }
                // else if (this.cuenta_id == '') {
                //     iziToast.error({
                //         title: 'Municipio',
                //         message: 'No has seleccionado la Cuenta Contable',
                //         position: 'topRight'
                //     });
                // }
                // else if (this.verificarTotalCuenta()) {
                //     iziToast.error({
                //         title: 'Municipio',
                //         message: 'El monto del periodo supera el saldo actual de la Cuenta Contable',
                //         position: 'topRight'
                //     });
                // }
                else if (this.verificarProductos()) {
                    iziToast.error({
                        title: 'Municipio',
                        message: 'No has seleccionado ningun Producto',
                        position: 'topRight'
                    });
                } else {
                    let datos = this.createData();
                    return this.storeControlador(datos);
                    console.log(datos);
                }
            },
            createData() {
                let set = this;
                let url = 'store';
                let data = {
                    nombre: set.nombre,
                    licitacion: set.licitacion,
                    decreto_adjudicacion: set.decreto_adjudicacion,
                    fecha_inicio: set.fecha_inicio,
                    fecha_termino: set.fecha_termino,
                    monto: set.monto,
                    fecha_inicio_periodo: set.fecha_inicio_periodo,
                    fecha_termino_periodo: set.fecha_termino_periodo,
                    monto_periodo: set.monto_periodo,
                    monto_disponible: set.monto - set.monto_periodo,
                    tipo_contrato_id: set.tipo_contrato_id,
                    solicitud_id: set.solicitud_contrato_id,
                    proveedor_id: set.proveedor_id,
                    cuenta_id: set.cuenta_id,
                    productos: set.productos,
                }
                let datos = {
                    url: url,
                    data: data
                };
                return datos;
            },
            storeControlador(data) {
                let set = this;
                axios.post(data.url, data.data)
                    .then(function(res) {
                        console.log(res.data);
                        this.buttonDisable = true;
                        let link = '{{ route('admin.contrato-suministro.index') }}';
                        window.location = link;
                    })
                    .catch(function(error) {
                        if (error.response.status === 422) {
                            set.errors.record(error.response.data.errors);
                        }
                        set.buttonDisable = false;
                    });
            },
            verificarProductos() {
                if (this.productos.length == 0) {
                    return true;
                }
                estado = false;
                this.productos.forEach(producto => {
                    if (producto.producto_id == '') {
                        estado = true;
                        return
                    }
                });
                if (estado) {
                    return true;
                } else {
                    return estado;
                }
            },
            verificarTotalCuenta() {
                let cuenta = this.cuentas.filter(cuenta => cuenta.id == this.cuenta_id);
                if (cuenta.length == 1) {
                    return this.monto_periodo > cuenta[0].saldo_a ? true : false;
                }
                return false;
            },
            selectProduct(index) {

                if (this.validarProducto(this.productos[index].producto_id)) {
                    this.productos[index].producto_id = '';
                    this.productos[index].unidad_id = '';
                    this.productos[index].detalle = '';
                    return iziToast.error({
                        title: 'Municipio',
                        message: 'Este Producto ya esta registrado',
                        position: 'topRight'
                    });
                }
                let prod = this.items.filter(producto => producto.id == this.productos[index].producto_id);
                console.log(prod[0]);
                if (prod.length == 1) {
                    this.productos[index].unidad_id = prod[0].medida_id;
                    this.productos[index].detalle = prod[0].detalle;
                    this.productos[index].neto = prod[0].valor;
                }
            },
            validarProducto(id) {
                let prod = this.productos.filter(producto => producto.producto_id == id);
                return prod.length == 2 ? true : false;
            },
            eliminarProducto(index) {
                this.productos.splice(index, 1);
            },
        }
    });
</script>
@endsection
