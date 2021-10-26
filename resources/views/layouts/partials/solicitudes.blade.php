@can('solicitudes')
    <li class="menu{{ active('solicitudes/insumos-y-servicios') }}">
        <a href="#solicitudes" data-toggle="collapse" @if (Request::is('solicitudes/insumos-y-servicios')) aria-expanded="true" @elseif(Request::is('admin/mi-perfil')) aria-expanded="true" @else aria-expanded="false" @endif class="dropdown-toggle">
            <div class="">
                <i data-feather="clipboard"></i>
                <span>Solicitudes</span>
            </div>
            <div>
                <i data-feather="chevron-right"></i>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled{{ submenu('solicitudes/insumos-y-servicios') }}" id="solicitudes"
            data-parent="#accordionExample">
            <li class="{{ active('solicitudes/insumos-y-servicios') }}">
                <a href="{{ route('solicitudes.insumos.index') }}"> Insumos y Servicios </a>
            </li>
            <li class="{{ Request::is('admin/usuarios') ? 'active' : '' }}">
                <a href="{{ route('solicitudes.convenios.index') }}"> Convenios </a>
            </li>
            <li class="{{ Request::is('admin/usuarios') ? 'active' : '' }}">
                <a href="{{ route('solicitudes.mantenimiento.index') }}"> Mantenimiento </a>
            </li>
            <li class="{{ Request::is('admin/usuarios') ? 'active' : '' }}">
                <a href="{{ route('solicitudes.mis-solicitudes') }}"> Mis Solicitudes </a>
            </li>
            <li class="{{ Request::is('admin/usuarios') ? 'active' : '' }}">
                <a href="{{ route('solicitudes.mis-borradores') }}"> Mis Borradores</a>
            </li>

        </ul>
    </li>
@endcan
