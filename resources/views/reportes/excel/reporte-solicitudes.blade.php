<div class="container">
    <h3 style="text-align: center"><strong>REPORTE DE SOLICITUDES</strong></h3>
    <table class="table table-striped">
        <tr>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="30">TIPO</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="15">DEPENDENCIA</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="15">DTO/UNIDAD</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="25">ADQUISICIÓN</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="25">TOTAL COSTO</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="25">ORDEN C.</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="25">USUARIO</th>
            <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Estado</th>
        </tr>
        <tbody>
            @foreach ($solicitudes as $s)
              <tr>
                    <td>{{ $s['tipo'] }} </td>
                    <td>{{ $s['dependencia'] }}</td>
                    <td>{{ $s['departamento'] }}</td>
                    <td>{{ $s['adquisicion'] }}</td>
                    <td>{{ $s['total'] }}</td>
                    <td> Orden Compra</td>
                    <td>{{ $s['nombre'] }}</td>
                    <td class="text-center">
                        {{ $s['estado'] }}
            </td>
            @endforeach
            <tr>
        </tbody>

    </table>
</div>
