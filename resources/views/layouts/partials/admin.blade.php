@can('usuarios')
<li class="menu{{ Request::is('admin/usuarios') ? ' active' : '' }}">
    <a href="#usuarios" data-toggle="collapse" @if (Request::is('admin/usuarios')) aria-expanded="true" @elseif(Request::is('admin/mi-perfil')) aria-expanded="true" @else aria-expanded="false" @endif class="dropdown-toggle">
        <div class="">
            <i data-feather="users"></i>
            <span>Usuario</span>
        </div>
        <div>
            <i data-feather="chevron-right"></i>
        </div>
    </a>
    <ul class="collapse submenu list-unstyled{{ Request::is('admin/usuarios') ? ' recent-submenu mini-recent-submenu show' : '' }}" id="usuarios" data-parent="#accordionExample">
        <li class="{{ Request::is('admin/usuarios') ? 'active' : '' }}">
            <a href="{{ route('admin.usuario.index') }}"> Lista de Usuarios </a>
        </li>

    </ul>
</li>
@endcan
@can('mantenimiento')
<li class="menu{{ active('admin/convenios') }}{{ active('admin/productos') }}{{ active('admin/roles') }}{{ active('admin/proveedores') }}{{ active('admin/cuentas') }}{{ active('admin/unidades-medida') }}{{ active('admin/dependencias') }}{{ active('admin/departamentos') }}">
    <a href="#mantenimiento" data-toggle="collapse" @if (Request::is('admin/convenios') or Request::is('admin/roles') or Request::is('admin/productos') or Request::is('admin/proveedores') or Request::is('admin/cuentas') or Request::is('admin/unidades-medida') or Request::is('admin/dependencias') or Request::is('admin/departamentos')) aria-expanded="true" @else aria-expanded="false" @endif class="dropdown-toggle">
        <div class="">
            <i data-feather="edit"></i>
            <span> Mantenimiento </span>
        </div>
        <div>
            <i data-feather="chevron-right"></i>
        </div>
    </a>
    <ul class="collapse submenu list-unstyled{{ submenu('admin/roles') }}{{ submenu('admin/productos') }}{{ submenu('admin/convenios') }}{{ submenu('admin/proveedores') }}{{ submenu('admin/cuentas') }}{{ submenu('admin/unidades-medida') }}{{ submenu('admin/dependencias') }}{{ submenu('admin/departamentos') }}" id="mantenimiento" data-parent="#accordionExample">
        @can('convenios')
        <li class="{{ Request::is('admin/convenios') ? 'active' : '' }}">
            <a href="{{ route('admin.convenio.index') }}"> Lista de Convenios </a>
        </li>
        @endcan
        @can('proveedores')
        <li class="{{ Request::is('admin/proveedores') ? 'active' : '' }}">
            <a href="{{ route('admin.proveedor.index') }}"> Lista de Proveedores </a>
        </li>
        @endcan
        @can('productos')
        <li class="{{ Request::is('admin/productos') ? 'active' : '' }}">
            <a href="{{ route('admin.productos.index') }}"> Lista de Productos</a>
        </li>
        @endcan
        @can('cuentas')
        <li class="{{ Request::is('admin/cuentas') ? 'active' : '' }}">
            <a href="{{ route('admin.cuenta.index') }}"> Lista de Cuentas </a>
        </li>
        @endcan
        @can('unidades medidas')
        <li class="{{ Request::is('admin/unidades-medida') ? 'active' : '' }}">
            <a href="{{ route('admin.unidades-medida.index') }}"> Lista de Unidades </a>
        </li>
        @endcan
        @can('dependencias')
        <li class="{{ Request::is('admin/dependencias') ? 'active' : '' }}">
            <a href="{{ route('admin.dependencias.index') }}"> Lista de Dependencias</a>
        </li>
        @endcan
        @can('departamentos')
        <li class="{{ Request::is('admin/departamentos') ? 'active' : '' }}">
            <a href="{{ route('admin.departamentos.index') }}"> Lista de Departamentos</a>
        </li>
        @endcan
        @can('roles')
        <li class="{{ Request::is('admin/roles') ? 'active' : '' }}">
            <a href="{{ route('admin.roles.index') }}"> Lista de Roles</a>
        </li>
        @endcan

    </ul>
</li>
@endcan
