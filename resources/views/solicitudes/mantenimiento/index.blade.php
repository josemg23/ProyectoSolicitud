@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-clipboard"></i> Solicitudes </a></li>
    <li class="active"><a><i class="fas fa-file-contract"></i> Mantenimiento</a>
    </li>
@endsection
@section('titulo', '| Solicitud de Mantenimiento')

@section('content')
    <div class="">
        <h1 class=" text-center font-weight-bold text-danger">Solicitud de Mantenimiento</h1>
        <div id="sm">
            <div class="row">
                <div class="col lg 12">
                    <div class="card">
                        <div class="card-header"></div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-lg-6">
                                    <label class="text-dark" for="">Fecha Solicitud</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="date" v-model="fecha" disabled="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="text-dark" for="">Numero Solicitud</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-clipboard"></i>
                                            </div>
                                        </div>
                                        <input type="text" v-model="solicitud" disabled="" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="text-dark" for="">Dependencia</label>

                                    <model-list-select :list="dependencias" v-model="dependencia_id" class="form-control"
                                        option-value="id" option-text="nombre" placeholder="Elije Una Dependencia"
                                        @input="searchDepartamento">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="text-dark" for="">Departamento</label>

                                    <model-list-select :list="departamentos" v-model="departamento_id"
                                        class="form-control" option-value="id" option-text="nombre"
                                        placeholder="Elije Un Departamento">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="text-dark" for="">Nombre adquisicion:</label>
                                    <input type="text" v-model="adquisicion" class="form-control"
                                        placeholder="Maximo 100 Caracteres">

                                </div>
                                <div class="form-group col-lg-6">
                                    <label class="text-dark" for="">Proveedor</label>

                                    <model-list-select :list="proveedores" v-model="proveedor_id" class="form-control"
                                        option-value="id" option-text="proveedor" placeholder="Elije Un Proveedor"
                                        @input="searchProductos">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label class="text-dark" for="">Descripción/Destino:</label>
                                    <input type="text" v-model="descripcion" class="form-control"
                                        placeholder="Maximo 100 Caracteres">

                                </div>

                                <div class="form-group col-lg-12">
                                    <label class="text-dark" for="">Cotización:</label>
                                    <input type="file" v-on:change="getImage">
                                    <p class="error-message text-danger font-weight-bold" v-if="errors.has('cotizacion')">
                                        @{{ errors . get('cotizacion') }}</p>
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
                                                <td width="50">Cantidad</td>
                                                <td width="175">Unidad</td>
                                                <td>Producto</td>
                                                <td>Detalle</td>
                                                <td width="125">Valor Neto</td>
                                                <td width="125">Total</td>
                                                <td width="50"></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(producto, index) in productos">
                                                <td>
                                                    <currency-input v-model="producto.cantidad"
                                                        class="form-control text-right" :options="numeric"
                                                        @input="totalProducto(index)" />
                                                    {{-- <input type="number" min="1" v-model="producto.cantidad"
                                                        class="form-control form-control-sm" @input="totalProducto(index)"> --}}
                                                </td>
                                                <td><input type="text" v-model="producto.medida"
                                                        class="form-control form-control-sm" disabled>
                                                </td>
                                                <td>
                                                    <model-list-select :list="products" v-model="producto.producto_id"
                                                        class="form-control" option-value="id" option-text="nombre"
                                                        placeholder="Elije Un Producto"
                                                        @input="filerProduct(index, producto.producto_id)">
                                                </td>
                                                <td><input type="text" v-model="producto.detalle" disabled
                                                        class="form-control form-control-sm"></td>
                                                <td>
                                                    <currency-input v-model="producto.valor" disabled
                                                        class="form-control text-right" :options="money"
                                                        @input="totalProducto(index)" />
                                                    {{-- <input type="number" min="0" v-model="producto.valor"
                                                        class="form-control form-control-sm" disabled
                                                        @input="totalProducto(index)"> --}}
                                                </td>
                                                <td>
                                                    <currency-input :value="producto.total" disabled
                                                        class="form-control text-right" :options="money" />
                                                    {{-- <input type="number" min="0" disabled :value="producto.total"
                                                        class="form-control form-control-sm"> --}}
                                                </td>
                                                <td><button class="btn btn-danger" @click.prevent="eliminarProducto(index)">
                                                        <i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-6 align-content-end">
                                    <div>
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <td class="text-dark font-weight-bold">PRODUCTOS</td>
                                                    <td class="text-right">@{{ productos . length }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-dark font-weight-bold">TOTAL NETO</td>
                                                    <td class="text-right">
                                                        @{{ total_neto | currency('CLP', 2, currency) }}

                                                        {{-- @{{ numberFormat(total_neto) }} --}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-dark font-weight-bold">IVA</td>
                                                    <td class="text-right">
                                                        @{{ iva | currency('CLP', 2, currency) }}

                                                        {{-- @{{ numberFormat(iva) }} --}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-dark font-weight-bold">TOTAL</td>
                                                    <td class="text-right">
                                                        @{{ total | currency('CLP', 2, currency) }}

                                                        {{-- @{{ numberFormat(total) }} --}}
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

            <div class="row justify-content-lg-around">
                <div class="col-lg-2">
                    <button class="btn btn-success btn-sm" :disabled="buttonDisable"
                        @click.prevent="validaciones('en proceso')">GRABAR Y
                        ENVIAR</button>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-danger btn-sm" :disabled="buttonDisable"
                        @click.prevent="validaciones('borrador')">GUARDAR
                        BORRADOR</button>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script type="text/javascript">
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


        let conteo = @json($conteo);
        let dependencias = @json($dependencias);
        let fecha = @json(Carbon\Carbon::now()->isoFormat('YYYY-MM-DD'));
        let proveedores = @json($proveedores);

        const sm = new Vue({
            el: "#sm",
            name: "Solicitud de Mantenimiento",
            data: {
                fecha: fecha,
                solicitud: 'Automatico',
                dependencias: dependencias,
                proveedores: proveedores,
                adquisicion: '',
                descripcion: '',
                dependencia_id: '',
                departamento_id: '',
                proveedor_id: '',
                products: [], //lista de producto de los proveedores
                productos: [],
                departamentos: [],
                total_neto: 0,
                cotizacion: null,
                buttonDisable: false,
                editMode: false,
                solicitud_id: '',
                iva: 0,
                total: 0,
                currency: {
                    decimalSeparator: ',',
                    thousandsSeparator: '.',
                    symbolOnLeft: false,
                    spaceBetweenAmountAndSymbol: true
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
                money: {
                    locale: undefined,
                    currency: 'USD',
                    currencyDisplay: 'hidden',
                    valueRange: undefined,
                    precision: 2,
                    hideCurrencySymbolOnFocus: false,
                    hideGroupingSeparatorOnFocus: false,
                    hideNegligibleDecimalDigitsOnFocus: false,
                    autoDecimalDigits: false,
                    exportValueAsInteger: false,
                    autoSign: false,
                    useGrouping: true
                },
                errors: new Errors,
                producto: {
                    cantidad: 1,
                    producto_id: '',
                    total: 0,
                    detalle: '',
                    valor: '',
                    medida: '',
                },

            },
            mounted() {
                this.newproduct();


            },

            methods: {
                //CARGA DE LA IMAGEN
                getImage(event) {
                    this.cotizacion = event.target.files[0];
                },

                //filtro para añadir los valores del producto en la tabla filtrados
                filerProduct(index, id) {
                    let consulta = this.productos.filter(x => x.producto_id == id);
                    console.log(consulta)
                    if (consulta.length == 2) {
                        this.productos[index].producto_id = '';
                        return alert('Ya has seleccionado este producto');
                    }
                    let product = this.products.filter(x => x.id == id);
                    console.log(id)
                    if (product.length > 0) {
                        this.productos[index].medida = product[0].medida.nombre;
                        this.productos[index].valor = product[0].valor;
                        this.productos[index].detalle = product[0].detalle;
                    } else {
                        this.productos[index].medida = '';
                        this.productos[index].detalle = '';
                        this.productos[index].valor = '';
                    }
                    this.totalProducto(index)



                },
                // AGREGAR NUEVO PRODUCTO A LA TABLA
                newproduct() {
                    let producto = {
                        cantidad: 1,
                        producto_id: '',
                        total: 0,
                        detalle: '',
                        valor: 0,
                        medida: ''
                    }
                    this.productos.push(producto);
                    this.sumatorias();

                },
                //ELIMINAR PRODUCTOS
                eliminarProducto(index) {
                    this.productos.splice(index, 1);
                    this.sumatorias();

                },
                totalProducto(index) {
                    let cantidad = this.productos[index].cantidad;
                    let valor = (this.productos[index].valor);
                    let calculo = Number(cantidad * valor);
                    this.productos[index].total = Number(calculo.toFixed(2))
                    this.sumatorias();
                },

                // BUSCAR LOS DEPARTAMENTOS RELACIONADOS AL PRODUCTO
                searchDepartamento() {
                    let id = this.dependencia_id;
                    let url = 'obtener-departamentos';
                    axios.post(url, {
                        id: id
                    }).then(response => {
                        this.departamentos = response.data;
                        console.log(response.data);
                    }).catch(function(error) {

                    });
                },
                //BUSCAR LOS PRODUCTOS DE LOS PROVEEDORES
                searchProductos() {
                    let id = this.proveedor_id;
                    let url = 'obtener-productos';
                    axios.post(url, {
                        id: id
                    }).then(response => {
                        this.productos = [];
                        this.newproduct();
                        this.products = response.data;

                    }).catch(function(error) {

                    });
                },

                sumatorias() {
                    let total_neto = this.calculoProductos();
                    this.total_neto = total_neto;
                    this.iva = total_neto * 0.19;
                    this.total = this.total_neto + this.iva;
                    // console.log(total_neto);
                },

                //SACAR EL TOTAL FINAL DE LA SUMA DE TODOS LOS PRODUCTOS
                calculoProductos() {
                    let total = 0;
                    this.productos.forEach(producto => {
                        total += Number(producto.total);
                    });
                    return total;
                },

                //VALIDACION
                validaciones(estado) {
                    if (this.dependencia_id === '') {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No has seleccionado la Dependencia',
                            position: 'topRight'
                        });
                    } else if (this.departamento_id === '') {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No has seleccionado el Departamento',
                            position: 'topRight'
                        });
                    } else if (this.proveedor_id === '') {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No has seleccionado el Proveedor',
                            position: 'topRight'
                        });
                    } else if (this.verificarProd()) {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'No ha Seleccionado ningun Producto',
                            position: 'topRight'
                        });
                    } else {
                        let datos = this.crearData(estado);
                        return this.Store(datos);
                        console.log(datos);
                    }
                },

                // verificacion de los productos
                verificarProd() {
                    let conteo = this.productos.filter(producto => producto.producto_id === '');
                    return conteo.length > 0 ? true : false;
                },

                //  CREACION DEL FORMATO DE CAMPOS
                crearData(estado) {
                    let set = this;
                    let url = 'mantenimiento';
                    const config = {
                        headers: {
                            'content-type': 'multipart/form-data'
                        }
                    }
                    let data = new FormData();
                    data.append('dependencia_id', this.dependencia_id);
                    if (this.cotizacion !== null) {
                        data.append('cotizacion', this.cotizacion);
                    }
                    data.append('adquisicion', set.adquisicion);
                    data.append('descripcion', set.descripcion);
                    data.append('proveedor_id', set.proveedor_id);
                    data.append('departamento_id', set.departamento_id);
                    data.append('productos', JSON.stringify(this.productos));
                    data.append('total_neto', set.total_neto);
                    data.append('iva', set.iva);
                    data.append('tipo', set.tipo);
                    data.append('total', set.total);
                    data.append('estado', estado);
                    if (set.editMode) {
                        data.append('edit', 'si');

                    } else {
                        data.append('edit', 'no')
                    }
                    data.append('solicitud_id', set.solicitud_id);
                    let datos = {
                        url: url,
                        config: config,
                        data: data
                    };
                    return datos;


                },

                editSolicitud(solicitud, productos) {
                    this.proveedor_id = solicitud.mantenimiento.proveedor_id == null ? '' : solicitud.mantenimiento
                        .proveedor_id;
                    this.products = productos
                    this.editMode = true;
                    this.solicitud_id = solicitud.id;
                    this.adquisicion = solicitud.adquisicion == null ? '' : solicitud.adquisicion;
                    this.descripcion = solicitud.descripcion == null ? '' : solicitud.descripcion;
                    this.dependencia_id = solicitud.dependencia_id;
                    this.searchDepartamento();
                    this.departamento_id = solicitud.departamento_id;
                    this.cargarProducts(solicitud.mantenimiento.productos);

                },
                Store(data) {
                    //store del que tiene iva
                    let set = this;
                    axios.post(data.url, data.data, data.config)
                        .then(function(res) {
                            this.buttonDisable = true;
                            let link = '{{ route('admin.index') }}';
                            window.location = link;
                        })
                        .catch(function(error) {
                            if (error.response.status == 422) {
                                set.errors.record(error.response.data.errors);
                            }
                            set.buttonDisable = false;
                        });

                },


                cargarProducts(prod) {
                    this.productos = [];
                    prod.forEach(product => {
                        let item = {
                            producto_id: product.id,
                            detalle: product.detalle,
                            medida: product.medida.nombre,
                            cantidad: product.pivot.cantidad,
                            valor: product.valor,
                            total: product.pivot.neto,
                        };

                        this.productos.push(item);

                    });
                    this.sumatorias();
                },



            }, // end methods


        });

        @if (Request::has('solicitud'))
            sm.editSolicitud(@json($solicitud), @json($product))
        @endif
    </script>
@endsection
