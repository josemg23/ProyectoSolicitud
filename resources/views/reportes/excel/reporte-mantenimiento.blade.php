<div class="container">
    <h3 style="text-align: center"><strong>REPORTE DE MANTENIMIENTOS</strong></h3>
    <table class="table table-striped">
        <tr>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="30">TIPO</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="40">DEPENDENCIA</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="40">DTO/UNIDAD</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="30">ADQUISICIÓN</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="30">TOTAL COSTO</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="25">USUARIO</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="25">ORDEN C.</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col">ESTADO</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="25">PROVEEDOR</th>

        </tr>
        <tbody>
            @foreach ($solicitudes as $s)
              <tr>
                    <td>{{ $s['tipo'] }} </td>
                    <td>{{ $s['dependencia'] }}</td>
                    <td>{{ $s['departamento'] }}</td>
                    <td>{{ $s['adquisicion'] }}</td>
                    <td>{{ $s['total'] }}</td>
                    <td>{{ $s['nombre'] }}</td>
                    <td> </td>               
                    <td class="text-center">
                        {{ $s['estado'] }}
                    </td>
            <td>{{ $s['proveedor'] }}</td>
            @endforeach
            <tr>
        </tbody>

    </table>
</div>