@extends('layouts.nav')
@section('breadcrumb')
    <li class="active"><a><i class="fas fa-clipboard"></i> Solicitudes </a></li>
    <li class="active"><a><i class="fas fa-file-contract"></i> Insumos y Servicios</a>
    </li>
@endsection
@section('titulo', '| Solicitud de Insumos y Servicios')

@section('content')
    <div class="">
        <h1 class=" text-center font-weight-bold text-danger">Insumos y Servicios</h1>
        <div id="insumos_contratos">
            <div class="form-row mb-1">
                <div class="col-2">
                    <label class="text-dark">Elegir el tipo de Solicitud</label>
                </div>
                <div class="col-2">
                    <select name="" id="" v-model="tipo_in" class="custom-select" @change="elegirTipo()">
                        <option value="" selected disabled>Seleccionar</option>
                        <option value="insumos">Insumos Y Servicios</option>
                        <option value="exenta">Exenta</option>
                        <option value="contrato">Contrato Suministro</option>
                    </select>
                </div>
            </div>
            <!-- tipo de solicitud con calculo de iva -->
            <div v-if="uno.active">
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

                                        <model-list-select :list="dependencias" v-model="dependencia_id"
                                            class="form-control" option-value="id" option-text="nombre"
                                            placeholder="Elije Una Dependencia" @input="searchDepartamento">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="text-dark" for="">Departamento</label>

                                        <model-list-select :list="departamentos" v-model="departamento_id"
                                            class="form-control" option-value="id" option-text="nombre"
                                            placeholder="Elije Un Departamento">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="text-dark" for="">Nombre adquisicion:</label>
                                        <input type="text" v-model="adquisicion" placeholder="Maximo 100 Caracteres"
                                            class="form-control">

                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="text-dark" for="">Proveedor (Opcional):</label>
                                        <model-list-select :list="proveedores" v-model="id_proveedor" class="form-control"
                                            option-value="id" option-text="proveedor" placeholder="Elije Un Proveedor">

                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label class="text-dark" for="">Descripción/Destino:</label>
                                        <input type="text" v-model="descripcion" placeholder="Maximo 100 Caracteres"
                                            class="form-control">

                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label class="text-dark" for="">Cotización:</label>
                                        <input type="file" v-on:change="getImage">
                                        <p class="error-message text-danger font-weight-bold"
                                            v-if="errors.has('cotizacion')">
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
                                                    <td width="75">Cantidad</td>
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
                                                            class="form-control form-control-sm"
                                                            @input="totalProducto(index)"> --}}
                                                    </td>
                                                    <td>
                                                        <select name="" class="form-control" v-model="producto.unidad_id"
                                                            id="">
                                                            <option value="" selected disabled>Unidad</option>
                                                            <option v-for="(medida, index) in medidas" :value="medida.id">
                                                                @{{ medida . nombre }}
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" v-model="producto.producto"
                                                            class="form-control form-control-sm">
                                                    </td>
                                                    <td><input type="text" v-model="producto.detalle"
                                                            class="form-control form-control-sm"></td>
                                                    <td>
                                                        <currency-input v-model="producto.neto"
                                                            class="form-control text-right" :options="money"
                                                            @input="totalProducto(index)" />
                                                        {{-- <input type="number" min="0" v-model="producto.neto"
                                                            class="form-control form-control-sm text-right"
                                                            @input="totalProducto(index)"> --}}
                                                    </td>
                                                    <td>
                                                        {{-- <money :value="producto.total" disabled v-bind="money"
                                                            class="form-control text-right">
                                                        </money> --}}
                                                        <currency-input :value="producto.total" disabled
                                                            class="form-control text-right" :options="money" />
                                                        {{-- <input type="number" min="0" disabled :value="producto.total"
                                                            class="form-control form-control-sm text-right"> --}}
                                                    </td>
                                                    <td><button class="btn btn-danger"
                                                            @click.prevent="eliminarProducto(index)"> <i
                                                                class="fa fa-trash"></i></button>
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
            <!-- end uno  -->
            <!-- tipo de solicitud sin calculo de iva -->
            <div v-else-if="dos.active">
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

                                        <model-list-select :list="dependencias" v-model="dependencia_id"
                                            class="form-control" option-value="id" option-text="nombre"
                                            placeholder="Elije Una Dependencia" @input="searchDepartamento">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="text-dark" for="">Departamento</label>

                                        <model-list-select :list="departamentos" v-model="departamento_id"
                                            class="form-control" option-value="id" option-text="nombre"
                                            placeholder="Elije Un Departamento">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="text-dark" for="">Nombre adquisicion:</label>
                                        <input type="text" v-model="adquisicion" placeholder="Macimo 100 Cracteres"
                                            class="form-control">

                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="text-dark" for="">Proveedor (Opcional):</label>
                                        <model-list-select :list="proveedores" v-model="id_proveedor"
                                            class="form-control" option-value="id" option-text="proveedor"
                                            placeholder="Elije Un Proveedor">

                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label class="text-dark" for="">Descripción/Destino:</label>
                                        <input type="text" v-model="descripcion" placeholder="Maximo 100 Caracteres"
                                            class="form-control">

                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label class="text-dark" for="">Cotización:</label>
                                        <input type="file" v-on:change="getImage">
                                        <p class="error-message text-danger font-weight-bold"
                                            v-if="errors.has('cotizacion')">
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
                                                    <td width="75">Cantidad</td>
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
                                                            class="form-control form-control-sm"
                                                            @input="totalProducto(index)"> --}}
                                                    </td>
                                                    <td>
                                                        <select name="" class="form-control" v-model="producto.unidad_id"
                                                            id="">
                                                            <option value="" selected disabled>Unidad</option>
                                                            <option v-for="(medida, index) in medidas" :value="medida.id">
                                                                @{{ medida . nombre }}
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td><input type="text" v-model="producto.producto"
                                                            class="form-control form-control-sm">
                                                    </td>
                                                    <td><input type="text" v-model="producto.detalle"
                                                            class="form-control form-control-sm"></td>
                                                    <td>
                                                        <currency-input v-model="producto.neto"
                                                            class="form-control text-right" :options="money"
                                                            @input="totalProducto(index)" />
                                                        {{-- <input type="number" min="0" v-model="producto.neto"
                                                            class="form-control form-control-sm"
                                                            @input="totalProducto(index)"> --}}
                                                    </td>
                                                    <td>
                                                        <currency-input :value="producto.total" disabled
                                                            class="form-control text-right" :options="money" />
                                                        {{-- <input type="number" min="0" disabled :value="producto.total"
                                                            class="form-control form-control-sm"> --}}
                                                    </td>
                                                    <td><button class="btn btn-danger"
                                                            @click.prevent="eliminarProducto(index)"> <i
                                                                class="fa fa-trash"></i></button>
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
                                                    {{-- <tr>
                                                        <td class="text-dark font-weight-bold">IVA</td>
                                                        <td class="text-right">
                                                            @{{ iva | currency('CLP', 2, currency) }}

                                                            @{{ numberFormat(iva) }}
                                                        </td>
                                                    </tr> --}}
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
            <!--tipo de solicitud libre  -->
            <div v-if="tres.active">
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

                                        <model-list-select :list="dependencias" v-model="dependencia_id"
                                            class="form-control" option-value="id" option-text="nombre"
                                            placeholder="Elije Una Dependencia" @input="searchDepartamento">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label class="text-dark" for="">Departamento</label>

                                        <model-list-select :list="departamentos" v-model="departamento_id"
                                            class="form-control" option-value="id" option-text="nombre"
                                            placeholder="Elije Un Departamento">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label class="text-dark" for="">Contrato Suministro</label>

                                        <model-list-select :list="contratos" v-model="contrato_id" class="form-control"
                                            option-value="id" option-text="nombre" placeholder="Elije Un Contrato"
                                            @input="getProveedores()">
                                    </div>

                                    <div class="form-group col-lg-4">
                                        <label class="text-dark" for="">Tipo de Contrato:</label>
                                        <input type="text" disabled v-model="tipo_contrato" class="form-control">

                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label class="text-dark" for="">Proveedor</label>
                                        <input type="text" disabled v-model="proveedor" class="form-control">

                                        {{-- <model-list-select :list="proveedores" v-model="proveedor_id" class="form-control"
                                            option-value="id" option-text="nombre" placeholder="Elije Un Proveedor"
                                            @input="getProductos()"> --}}
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label class="text-dark" for="">Nombre adquisicion:</label>
                                        <input type="text" v-model="adquisicion" placeholder="Maximo 100 Caracteres"
                                            class="form-control">

                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label class="text-dark" for="">Descripción/Destino:</label>
                                        <input type="text" v-model="descripcion" placeholder="Maximo 100 Caracteres"
                                            class="form-control">

                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label class="text-dark" for="">Cotización:</label>
                                        <input type="file" v-on:change="getImage">
                                        <p class="error-message text-danger font-weight-bold"
                                            v-if="errors.has('cotizacion')">
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
                                                    <td width="75">Cantidad</td>
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
                                                        {{-- <input type="tel" min="1" v-model="producto.cantidad"
                                                            class="form-control form-control-sm"
                                                            @input="totalProducto(index)"> --}}
                                                    </td>
                                                    <td><input type="text" v-model="producto.medida"
                                                            class="form-control form-control-sm" disabled>
                                                    </td>
                                                    <td>
                                                        <model-list-select :list="items" v-model="producto.producto"
                                                            class="form-control" option-value="id" option-text="nombre"
                                                            placeholder="Elije Un Producto"
                                                            @input="filerProduct(index, producto.producto)">
                                                    </td>
                                                    <td><input type="text" v-model="producto.detalle" disabled
                                                            class="form-control form-control-sm"></td>
                                                    <td>
                                                        <currency-input v-model="producto.neto" disabled
                                                            class="form-control text-right" :options="money"
                                                            @input="totalProducto(index)" />
                                                        {{-- <input type="number" min="0" v-model="producto.neto" disbled
                                                                    class="form-control form-control-sm"
                                                                    @input="totalProducto(index)"> --}}
                                                    </td>
                                                    <td>
                                                        <currency-input :value="producto.total" disabled
                                                            class="form-control text-right" :options="money" />
                                                        {{-- <input type="number" min="0" disabled :value="producto.total"
                                                                    class="form-control form-control-sm"> --}}
                                                    </td>

                                                    <td><button class="btn btn-danger"
                                                            @click.prevent="eliminarProducto(index)">
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
                const atLeast9Wins = asArray.filter(([key, value]) => key.toLowerCase().indexOf(query.toLowerCase()) > -
                    1);
                const atLeast9WinsObject = Object.fromEntries(atLeast9Wins);

                return Object.keys(atLeast9WinsObject).length > 0;
            }
            archivos(query) {
                const asArray = Object.entries(this.errors);
                const atLeast9Wins = asArray.filter(([key, value]) => key.toLowerCase().indexOf(query.toLowerCase()) > -
                    1);
                const atLeast9WinsObject = Object.fromEntries(atLeast9Wins);
                return atLeast9WinsObject;
            }

        }
        let conteo = @json($conteo);
        let dependencias = @json($dependencias);
        let medidas = @json($medidas);
        let fecha = @json(Carbon\Carbon::now()->isoFormat('YYYY-MM-DD'));

        const insumos_contratos = new Vue({
            el: "#insumos_contratos",
            name: "Insumos y Servicios",
            data: {
                fecha: fecha,
                solicitud: 'Automatico',
                adquisicion: '',
                descripcion: '',
                dependencia_id: '',
                departamento_id: '',
                tipo_contrato: '',
                tipo_contrato_id: '',
                proveedor: '',
                proveedor_id: '',
                id_proveedor: '',
                proveedores: [],
                contrato_id: '',
                productos: [],
                items: [],
                departamentos: [],
                contratos: [],
                medidas: medidas,
                dependencias: dependencias,
                total_neto: 0,
                cotizacion: null,
                buttonDisable: false,
                editMode: false,
                solicitud_id: '',
                iva: 0,
                total: 0,
                errors: new Errors,
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
                producto: {
                    cantidad: 1,
                    unidad_id: '',
                    producto: '',
                    detalle: '',
                    neto: 0,
                    total: 0,
                },
                tipo_in: '',
                uno: {
                    active: false,
                },
                dos: {
                    active: false,
                },
                tres: {
                    active: false,
                },
            },

            mounted() {
                this.newproduct();
            },
            methods: {
                //subir imagen
                getImage(event) {
                    this.cotizacion = event.target.files[0];
                },
                filerProduct(index, id) {
                    let consulta = this.productos.filter(x => x.producto == id);
                    console.log(consulta)
                    if (consulta.length == 2) {
                        this.productos[index].producto = '';
                        return alert('Ya has seleccionado este producto');
                    }
                    let product = this.items.filter(x => x.id == id);
                    console.log(id)
                    if (product.length > 0) {
                        this.productos[index].medida = product[0].medida.nombre;
                        this.productos[index].neto = product[0].valor;
                        this.productos[index].detalle = product[0].detalle;
                    } else {
                        this.productos[index].medida = '';
                        this.productos[index].detalle = '';
                        this.productos[index].neto = '';
                    }
                    this.totalProducto(index)
                },

                //agregar nuevo producto
                newproduct() {
                    let producto = {
                        cantidad: 1,
                        unidad_id: '',
                        producto: '',
                        detalle: '',
                        neto: 0,
                        total: 0,
                    }
                    this.productos.push(producto);
                    this.sumatorias();
                },
                obtenerProveedores() {
                    let url = 'obtener-proveedores-insumos';
                    axios.post(url).then(response => {
                        this.proveedores = response.data.data;
                        // iziToast.success({
                        //     title: 'Municipio',
                        //     message: response.data.message,
                        //     position: 'topRight'
                        // });
                        console.log(response.data);
                    }).catch(function(error) {

                    });
                },


                //calculo del total de cada producto con iva
                totalProducto(index) {
                    let cantidad = this.productos[index].cantidad;
                    let neto = this.productos[index].neto;
                    let calculo = Number(cantidad * neto);
                    this.productos[index].total = Number(calculo.toFixed(2));
                    this.sumatorias();
                },

                eliminarProducto(index) {
                    this.productos.splice(index, 1);
                    this.sumatorias();
                },
                //busqueda de los departamentos relacionados al producto
                searchDepartamento() {
                    let id = this.dependencia_id;
                    let url = 'obtener-departamentos-insumos';

                    axios.post(url, {
                        id: id
                    }).then(response => {
                        this.departamentos = response.data;
                        console.log(response.data);
                    }).catch(function(error) {

                    });
                },

                //calculo del iva con total neto
                sumatorias() {
                    let total_neto = this.calculoProductos();
                    this.total_neto = total_neto;
                    this.iva = 0;
                    if (this.tipo_in !== 'exenta') {
                        this.iva = total_neto * 0.19;
                    }
                    this.total = this.total_neto + this.iva;
                    console.log(this.total)
                },
                //calcilo de la suma de todos los productos

                calculoProductos() {
                    let total = 0;
                    this.productos.forEach(producto => {
                        total += Number(producto.total);
                    });
                    return total;
                },

                //validaciones antes de enviar
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
                    } else if (this.verificarProd()) {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'La Unidad en los productos es requerida',
                            position: 'topRight'
                        });
                    } else if (this.verificarTipo()) {
                        // iziToast.error({
                        //     title: 'Municipio',
                        //     message: 'La Unidad en los productos es requerida',
                        //     position: 'topRight'
                        // });
                    } else {
                        let datos = this.crearData(estado);
                        return this.storeInsumos1(datos);
                        console.log(datos);
                    }
                },
                verificarTipo() {
                    if (this.tipo_in == 'contrato') {
                        if (this.contrato_id === '') {
                            iziToast.error({
                                title: 'Municipio',
                                message: 'No has seleccionado el contrato',
                                position: 'topRight'
                            });
                            return true
                        } else if (this.proveedor_id == '') {
                            iziToast.error({
                                title: 'Municipio',
                                message: 'No has seleccionado el Proveedor',
                                position: 'topRight'
                            });
                            return true

                        } else if (this.producContrato()) {
                            iziToast.error({
                                title: 'Municipio',
                                message: 'No has seleccionado Productos',
                                position: 'topRight'
                            });
                            return true

                        } else if (this.verificarContrato()) {
                            return true;
                        }
                    } else {
                        return false;
                    }

                },
                verificarContrato() {
                    let contrato = this.contratos.filter(contrato => contrato.id == this.contrato_id);
                    if (this.fecha > contrato[0].fecha_actual) {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'La fecha del Contrato de Suministro es inferior a la fecha actual',
                            position: 'topRight'
                        });
                        return true

                    } else if (this.total > contrato[0].monto_actual) {
                        iziToast.error({
                            title: 'Municipio',
                            message: 'El monto del Contrato de Suministro es inferior al total de la solicitud ',
                            position: 'topRight'
                        });
                        return true

                    } else {
                        return false;
                    }

                },

                // verificacion de los productos
                verificarProd() {
                    if (this.tipo_in == 'contrato') {
                        return false;
                    }
                    let conteo = this.productos.filter(producto => producto.unidad_id === '');
                    return conteo.length > 0 ? true : false;
                },
                producContrato() {

                    let conteo = this.productos.filter(producto => producto.producto === '');
                    return conteo.length > 0 ? true : false;
                },

                //  CREACION DEL FORMATO DE CAMPOS
                crearData(estado) {
                    let set = this;
                    let url = 'insumos-y-servicios';
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
                    data.append('departamento_id', set.departamento_id);
                    data.append('productos', JSON.stringify(this.productos));
                    data.append('total_neto', set.total_neto);
                    data.append('iva', set.iva);
                    data.append('tipo_in', set.tipo_in);
                    data.append('id_proveedor', set.id_proveedor);
                    if (set.tipo_in == 'contrato') {
                        data.append('tipo_contrato_id', set.tipo_contrato_id);
                        data.append('proveedor_id', set.proveedor_id);
                        data.append('contrato_id', set.contrato_id);
                    }
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

                editSolicitud(solicitud) {
                    // this.buttonDisable = false;
                    this.tipo_in = solicitud.insumo.tipo_in;
                    this.elegirTipo();
                    this.adquisicion = solicitud.adquisicion == null ? '' : solicitud.adquisicion;
                    this.descripcion = solicitud.descripcion == null ? '' : solicitud.descripcion;
                    this.id_proveedor = solicitud.proveedor_id == null ? '' : solicitud.proveedor_id;
                    this.dependencia_id = solicitud.dependencia_id;
                    this.searchDepartamento();
                    this.departamento_id = solicitud.departamento_id;
                    if (this.tipo_in == 'contrato') {
                        // this.getContratos();
                        this.contrato_id = solicitud.insumo.contrato_id;
                        this.proveedor_id = solicitud.insumo.proveedor_id;
                        setTimeout(() => {
                            this.getProveedores();
                            // this.getProductos();
                            setTimeout(() => {
                                this.productos = this.convertProduct(solicitud.insumo.products);
                                this.sumatorias();
                                this.buttonDisable = false;
                            }, 1000);
                        }, 1000);
                    } else {
                        this.productos = JSON.parse(solicitud.insumo.productos);
                    }
                    this.sumatorias();
                    this.editMode = true;
                    this.solicitud_id = solicitud.id;

                },
                convertProduct(productos) {
                    let products = [];

                    productos.forEach(producto => {
                        let pro = {
                            cantidad: producto.pivot.cantidad,
                            medida: producto.medida.nombre,
                            producto: producto.id,
                            detalle: producto.detalle,
                            neto: producto.valor,
                            total: producto.pivot.neto,
                        }
                        products.push(pro);
                    });
                    return products
                },

                storeInsumos1(data) {
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
                            // console.log(error.response.data.msg);
                            iziToast.error({
                                title: 'Municipio',
                                message: error.response.data.msg,
                                position: 'topRight'
                            });
                            set.buttonDisable = false;
                        });
                },

                //seleccionar tipo de insumo

                elegirTipo() {
                    let tipo = this.tipo_in;
                    if (tipo == 'insumos') {
                        this.uno.active = true;
                        this.dos.active = false;
                        this.tres.active = false;
                        this.clearContrato();
                    } else if (tipo == 'exenta') {
                        this.uno.active = false;
                        this.dos.active = true;
                        this.tres.active = false;
                        this.clearContrato();
                    } else if (tipo == 'contrato') {
                        this.id_proveedor = '';
                        this.getContratos(); //CARGAR LOS TODO RELACIONADO A CONTRATOS DE SUMINISTROS
                        this.uno.active = false;
                        this.dos.active = false;
                        this.tres.active = true
                    }
                    this.sumatorias();

                },
                clearContrato() {
                    this.clearProduct();
                    this.contrato_id = '';
                    this.proveedor_id = '';
                    this.obtenerProveedores();
                    this.tipo_contrato = '';
                    this.tipo_contrato_id = '';
                    this.proveedor = '';
                    this.proveedor_id = '';

                },
                //OBTENER TODOS LOS CONTRATOS DE SUMINISTROS
                getContratos() {
                    this.clearProduct(); //LIMPIAR Y CARGAR UN PRODUCTO NUEVO
                    let url = 'obtener-contratos-suministros-insumos';
                    axios.get(url).then(response => {
                        this.contratos = response.data.data;
                        iziToast.success({
                            title: 'Municipio',
                            message: response.data.message,
                            position: 'topRight'
                        });
                        console.log(response.data);
                    }).catch(function(error) {

                    });
                },
                //LIMPIAR Y CARGAR UN PRODUCTO NUEVO
                clearProduct() {
                    this.productos = [];
                    this.newproduct();
                },
                //OBTENER LA LISTA DE LOS PROVEEDORES
                getProveedores() {
                    let cont = this.contratos.filter(contrato => contrato.id == this.contrato_id);
                    if (cont.length == 1) {
                        this.tipo_contrato = cont[0].tipo.nombre;
                        this.tipo_contrato_id = cont[0].tipo.id;

                        this.proveedor = cont[0].proveedor.proveedor;
                        this.proveedor_id = cont[0].proveedor.id;

                        this.items = cont[0].productos;
                        this.productos = [];
                        this.newproduct();
                        // let url = 'obtener-proveedores-insumos';
                        // axios.post(url, {
                        //     id: cont[0].tipo.id
                        // }).then(response => {
                        //     this.proveedores = response.data.data;
                        //     iziToast.success({
                        //         title: 'Municipio',
                        //         message: response.data.message,
                        //         position: 'topRight'
                        //     });
                        //     console.log(response.data);
                        // }).catch(function(error) {

                        // });
                    }

                },
                //OBTENER LOS PRODUCTOS DE UN PROVEEDOR EN ESPECIFICO
                getProductos() {
                    let id = this.proveedor_id;
                    let url = 'obtener-productos-insumos';
                    axios.post(url, {
                        id: id
                    }).then(response => {
                        this.productos = [];
                        this.newproduct();
                        this.items = response.data.data;
                        iziToast.success({
                            title: 'Municipio',
                            message: response.data.message,
                            position: 'topRight'
                        });

                    }).catch(function(error) {

                    });
                }
            },
        });

        @if (Request::has('solicitud'))
            console.log(@json($solicitud))
            insumos_contratos.editSolicitud(@json($solicitud))
        @endif
    </script>
@endsection
