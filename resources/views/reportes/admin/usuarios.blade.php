<div class="container">
    <h3 style="text-align: center"><strong>REPORTE DE USUARIOS</strong></h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="30">Nombres</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="15">Usuario</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="25">Correo</th>
                <th style="vertical-align: middle; background-color: #D44C4C" class="px-4 py-2 text-center" width="15">
                    Rol</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Estado</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col" width="15">Ultimo Acceso</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $element)
                <tr>
                    <td>{{ $element['nombres'] }} </td>
                    <td>{{ $element['username'] }}</td>
                    <td>{{ $element['email'] }}</td>
                    <td class="p-1 text-center">
                        @if ($element->hasRole('cliente'))
                            <div>Cliente</div>
                        @elseif ($element->hasRole('chofer'))
                            <div>Chofer</div>
                        @elseif ($element->hasRole('motorizado'))
                            <div>Motorizado</div>
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $element['estado'] }}
                    </td>
                    <td>
                        @isset($element['access_at'])
                            {{ Carbon\Carbon::parse($element['access_at'])->diffForHumans() }}
                        @else
                            Sin Ingreso
                        @endisset
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
