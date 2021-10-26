@can($menu->can)
    <li class="menu{{ activeAll($menu->submenu) }}">
        <a href="#{{ $menu->url }}" data-toggle="collapse" aria-expanded="{{ expanded($menu->submenu) }}"" class="

            dropdown-toggle">
            <div class="___class_+?2___">
                <i data-feather="{{ $menu->icon }}"></i>
                <span>{{ $menu->name }} </span>
            </div>
            <div>
                <i data-feather="chevron-right"></i>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled{{ submenu($menu->submenu) }}" id="{{ $menu->url }}"
            data-parent="#accordionExample">
            @foreach ($menu->submenu as $submenu)
                @if ($submenu->can)
                    @can($submenu->can)
                        <li class="{{ active($submenu->url) }}">
                            <a href="{{ route($submenu->route) }}"> {{ $submenu->name }} </a>
                        </li>
                    @endcan
                @else
                    <li class="{{ active($submenu->url) }}">
                        <a href="{{ route($submenu->route) }}"> {{ $submenu->name }} </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </li>
@endcan
