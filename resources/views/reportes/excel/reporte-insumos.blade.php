<div class="container">
    <h3 style="text-align: center"><strong>REPORTE DE INSUMOS</strong></h3>
    <table class="table table-striped">
        <tr>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="30">TIPO</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="30">DEPENDENCIA</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="40">DTO/UNIDAD</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="30">TOTAL COSTO</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="25">USUARIO</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="25">ORDEN C.</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="25">TIPO INSUMOS</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col">ESTADO</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="25">PROVEEDOR</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="25">CONTRATO</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="25">TIPO CONTRATO</th>
        </tr>
        <tbody>
            @foreach ($solicitudes as $s)
              <tr>
                    <td>{{ $s['tipo'] }} </td>
                    <td>{{ $s['dependencia'] }}</td>
                    <td>{{ $s['departamento'] }}</td>
                    <td>{{ $s['total'] }}</td>
                    <td>{{ $s['nombre'] }}</td>
                    <td> </td>
                    <td>{{ $s['tipo_in'] }}</td>
                    <td class="text-center">
                        {{ $s['estado'] }}
            </td>
            <td>{{ $s['proveedor'] }}</td>
            <td>{{ $s['licitacion'] }}</td>
            <td>{{ $s['tipo_contrato'] }}</td>
            @endforeach
            <tr>
        </tbody>

    </table>
</div>