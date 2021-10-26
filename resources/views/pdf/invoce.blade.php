<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Reporte de calificaciones</title>

    {{-- <link href="{{ env('APP_URL') }}/css/pdf.css" rel="stylesheet"> --}}
    <style type="text/css">
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 3cm 0cm 2cm;
        }

        @page {
            margin: 0cm 1cm;

        }

        header {
            position: fixed;
            left: 0px;
            top: 0px;
            bottom: 0;
            right: 0px;
            height: 100px;
            margin: 0;
            text-align: center;

            /* position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            text-align: center;
            line-height: 30px; */
        }

        header h4 {
            margin: 0;
        }

        header h5 {
            margin: 0;
        }

        .table-header {
            width: 100%;
            border: none;
            border-collapse: collapse;
            border-spacing: 0;

        }

        footer {
            /* position: fixed;
            left: 0px;
            bottom: -150px;
            right: 0px;
            height: 40px;
            text-align: center; */
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            /* background-color: #F93855; */
            /* color: white; */
            text-align: center;
            /* line-height: 35px; */

        }

        footer .page:after {
            content: counter(page);
        }

        footer table {
            width: 100%;
        }

        footer p {
            text-align: right;
        }

        footer .izq {
            text-align: left;
        }

        .td-fecha {
            text-align: right;
            /* font-size: 10px; */
        }

        .font-size-10 {
            font-size: 10px;
        }

        .font-size-15 {
            /* font-size: 11px; */

        }

        .text-left {
            text-align: left;
        }

        .marco {
            background-color: rgba(0, 0, 0, 0.247);
            border-radius: 20px 0px 20px 0px;
            border: solid 2px black;
            margin-top: 0;
            padding: 5px;
            font-size: 11px;

        }

        #watermark {
            position: fixed;
            opacity: 0.10;

            /**
                    Establece una posición en la página para tu imagen
                    Esto debería centrarlo verticalmente
                **/
            bottom: 5cm;
            left: -1.35cm;

            /** Cambiar las dimensiones de la imagen **/
            width: 21cm;
            height: 19.7cm;

            /** Tu marca de agua debe estar detrás de cada contenido **/
            /* z-index: -1000; */
        }

        #logo {
            position: absolute;

            /* bottom: 0cm;
            left: 0cm; */

            /** Cambiar las dimensiones de la imagen **/
            width: 3cm;
            height: 2.7cm;

            /** Tu marca de agua debe estar detrás de cada contenido **/
            z-index: -1000;
        }

        #content {
            position: absolute;
            bottom: 10px;
            /* height: 40px; */
            /* margin-top: 40px; */
        }

        .table-lef {
            width: 50%;
            text-align: rigth;
            border: none;
            /* border-collapse: collapse; */
            border-spacing: 0;
        }

        .table-confi {
            border-spacing: 25;
            border-collapse: separate;
            padding: 5px;
        }

        .table-confi .config-td {

            padding: 5px;
        }

    </style>

<body>

    <div id="watermark">
        <img src="{{ env('APP_URL') }}/img/logo muni.png" height="100%" width="100%" />
    </div>
    <header>
        <table class="table-header">
            <tr>
                <td>
                    <div id="logo">
                        <img src="{{ env('APP_URL') }}/img/logo muni.png" height="100%" width="100%" />
                    </div>
                </td>
                <td class="td-fecha font-size-10">
                    <p>
                        Fecha Imp: {{ fechaFormat($solicitud->created_at) }}
                    </p>
                </td>
            </tr>
        </table>
        <h4>SOLICITUD DE ADQUISICIÓN</h4>
        <h4>DSM MUNICIPALIDAD DE LAUTARO</h4>
        <h5>{{ $solicitud->tipo }}</h5>
        <table class="table-header">
            <tr>
                <td class="td-fecha font-size-15" style="margin: 0px">
                    <div style="margin: 0px">
                        <h5>Fecha: {{ fechaFormat(today()) }}</h5>
                        <h5> N°: 1</h5>
                    </div>
                </td>
            </tr>
        </table>
    </header>
    <footer>
        <table>
            <tr>
                <td>
                    <p class="page">
                        Página
                    </p>
                </td>
            </tr>
        </table>
    </footer>
    <div class="marco">
        <table class="table-header">
            {{-- <thead>

            </thead> --}}
            <tbody>
                <tr>
                    <td width="130"><strong> Dependencia:</strong></td>
                    <td>{{ $solicitud->dependencia->nombre }}</td>
                    <td width="70"><strong> Dpto/ Unidad:</strong></td>
                    <td>{{ $solicitud->departamento->nombre }}</td>
                </tr>
                <tr>
                    <td width="130"><strong> Nombre de Adquisicion:</strong></td>
                    <td>A{{ $solicitud->adquisicion }}</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td width="130"><strong>Descripcion/Destino:</strong> </td>
                    <td colspan="3">{{ $solicitud->descripcion }}</td>
                </tr>
                <tr>
                    <td width="130"><strong> Proveedor:</strong></td>
                    <td>GARCES CASANELLI LIMITADA</td>
                    <td width="50" align="left"><strong>RUT:</strong> </td>
                    <td>76.415.442-8
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <h5>Detalle de productos y/o servicios:</h5>
    <table class="table-header">
        <thead style="background-color: rgb(72, 182, 226); ">
            <tr>
                <th>Linea</th>
                <th>Cantidad</th>
                <th>Unidad</th>
                <th>Producto/Servicio</th>
                <th>Detalle</th>
                <th>Uni/Neto</th>
                <th>Total/Neto</th>
            </tr>
        </thead>
        <tbody style="
            font-size: 9px;
        ">
            @if ($solicitud->tipo = 'insumo')
                @isset($solicitud->insumo->products)
                    @forelse ($solicitud->insumo->products as $key => $producto)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $producto->pivot->cantidad }}</td>
                            <td>{{ $producto->medida->nombre }}</td>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->detalle }}</td>
                            <td>{{ number_format($producto->valor, 2) }}</td>
                            <td>{{ number_format($producto->pivot->neto, 2) }}</td>
                        </tr>
                    @empty
                    @endforelse
                @endisset
            @endif




        </tbody>
    </table>
    <div id="content">
        <div>
            <table border="1" class="table-lef">
                <tbody>
                    <tr>
                        <td>TOTAL NETO</td>
                        <td>{{ $solicitud->total_neto }}</td>
                    </tr>
                    <tr>
                        <td>IVA</td>
                        <td>{{ $solicitud->iva }}</td>
                    </tr>
                    <tr>
                        <td>TOTAL COSTO ESTIMADO</td>
                        <td>{{ $solicitud->total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="margin-bottom: 5px">
            <table width="100%">
                <thead>
                    <tr>
                        <th width="50%" style="background-color: cyan; text-align: left">Condiciones de Entrega:</th>
                        <th width="50%" style="background-color: cyan; text-align: left">Modalidad de Compra:</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="10" style="border: solid 1px black; vertical-align:top">

                        </td>
                        <td rowspan="10" style="border: solid 1px black; vertical-align:top">
                            Criterio de Adjudicación:

                        </td>
                    </tr>
                </tbody>


            </table>

            <br />
        </div>
        <div style="margin-bottom: 5px">
            <table width="100%">
                <thead>
                    <tr>
                        <th width="50%" style="background-color: cyan; text-align: left">Motivo de rechazo y/o
                            Observacion:</th>
                        <th width="50%" style="background-color: cyan; text-align: left">Datos de Contacto del
                            Solicitante:</th>
                    </tr>
                </thead>
                <tbody>
                    <tr valing=middle>
                        <td rowspan="10" rowspan="10" style="border: solid 1px black; vertical-align:top">

                        </td>
                        <td rowspan="10" style="border: solid 1px black; vertical-align:top">


                        </td>
                    </tr>
                </tbody>


            </table>

            <br />
        </div>
        <div>
            <table class="table-header">
                {{-- <thead>

                </thead> --}}
                <tbody>
                    <tr>
                        <td width="130"><strong> Dependencia:</strong></td>
                        <td>CASA RURAL</td>
                        <td width="70"><strong> Dpto/ Unidad:</strong></td>
                        <td>JEFE SALUD RURAL</td>
                    </tr>
                    <tr>
                        <td width="130"><strong> Nombre de Adquisicion:</strong></td>
                        <td>ADQUISICION PILAS EQUIPOS MEDICOS</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="margin-bottom: 5px">
            <table width="100%">
                <thead>
                    <tr>
                        <th width="50%" style="background-color: cyan; text-align: center">ORDEN DE COMPRA</th>
                        <th width="50%" style="background-color: cyan; text-align: center">Uso Exclusivo Unidad De
                            Finanzas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr valing=middle>
                        <td rowspan="10" rowspan="10" style="border: solid 1px black; vertical-align:top">

                        </td>
                        <td rowspan="10" style=" vertical-align:top">
                            <table width="100%" style="border-spacing: 0">
                                <thead style="background-color: red">
                                    <tr>
                                        <td>Linea</td>
                                        <td>Cuenta</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>TOTAL NETO</td>
                                        <td>900</td>
                                    </tr>
                                    <tr>
                                        <td>IVA</td>
                                        <td>900</td>
                                    </tr>
                                    <tr>
                                        <td>TOTAL COSTO ESTIMADO</td>
                                        <td>950</td>
                                    </tr>
                                </tbody>
                            </table>

                        </td>
                    </tr>
                </tbody>


            </table>

            <br />
        </div>

    </div>
</body>

</html>
