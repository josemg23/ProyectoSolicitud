<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>DSM @yield('titulo')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    {{-- <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet"> --}}
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap+Condensed&display=swap" rel="stylesheet"> --}}

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sansita&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/admin.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/fonts.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/elements/miscellaneous.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('css/custom-styles.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('assets/css/elements/breadcrumb.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/components/tabs-accordian/custom-tabs.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    {{-- <link href="{{ asset('assets/css/apps/notes.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('plugins/font-icons/fontawesome/css/regular.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/font-icons/fontawesome/css/fontawesome.css') }}"> --}}
    @livewireStyles
    {{-- <link rel="stylesheet" href="{{ asset('plugins/izitoast/css/iziToast.min.css') }}"> --}}
    {{-- <link rel="stylesheet" href="/path/to/select2.css"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/select2.min.css') }}">
    <style>

    </style>


    @yield('css')
    <!-- END PAGE LEVEL STYLES -->
</head>

<body class="sidebar-noneoverflow" style="font-family: 'Sansita', sans-serif;">
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->
    <!--  BEGIN NAVBAR  -->
    <div class="header-container fixed-top">
        <header class="header navbar navbar-expand-sm">

            <ul class="navbar-nav theme-brand flex-row  text-center">
                <li class="nav-item theme-text">
                    <img src="{{ asset('img/logo.png') }}" class="navbar-logo" alt="logo" width="90">
                    {{-- <a href="{{ route('admin.index') }}" class="nav-link">Open<br>Express </a> --}}
                </li>
                <li class="nav-item toggle-sidebar">
                    <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom"><i
                            data-feather="list"></i></a>
                </li>
            </ul>

            <ul class="navbar-item flex-row navbar-dropdown search-ul">

                <li class="nav-item dropdown user-profile-dropdown  order-lg-0 order-1">
                    <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="settings"></i>
                    </a>
                    <div class="dropdown-menu position-absolute animated fadeInUp"
                        aria-labelledby="userProfileDropdown">
                        <div class="user-profile-section">
                            <div class="media mx-auto">
                                @if (Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}" class="img-fluid mr-2" alt="avatar">
                                @else
                                    <img alt="image" src="{{ Avatar::create(Auth::user()->nombres)->setChars(2) }}">
                                @endif

                                <div class="media-body">
                                    <h5>{{ Auth::user()->nombres }}</h5>
                                    <p class="text-capitalize">{{ getRole() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-item">
                            <a href="{{ route('admin.perfil.me') }}">
                                <i data-feather="user"></i> <span>Mi Perfil</span>
                            </a>
                        </div>
                        <div class="dropdown-item">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i data-feather="log-out"></i> <span>Cerrar Sesión</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </header>
    </div>
    <!--  END NAVBAR  -->
    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>
        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">
                <div class="profile-info">
                    <figure class="user-cover-image"></figure>
                    <div class="user-info">
                        @if (Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="avatar">
                        @else
                            <img alt="image" src="{{ Avatar::create(Auth::user()->nombres)->setChars(2) }}">
                        @endif
                        <h6 class="___class_+?29___">{{ Auth::user()->nombres }}</h6>
                        <p class="text-capitalize">{{ getRole() }}</p>
                    </div>
                </div>
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">
                    <li class="menu{{ Request::is('admin') ? ' active' : '' }}">
                        <a href="#inicio" data-toggle="collapse"
                            aria-expanded="{{ Request::is('admin') ? 'true' : 'false' }}" class="dropdown-toggle">
                            <div class="___class_+?35___">
                                <i data-feather="home"></i>
                                <span>Inicio</span>
                            </div>
                            <div>
                                <i data-feather="chevron-right"></i>
                            </div>
                        </a>
                        <ul class="collapse submenu  list-unstyled{{ Request::is('admin') ? ' recent-submenu mini-recent-submenu show' : '' }}"
                            id="inicio" data-parent="#accordionExample">
                            <li class="{{ Request::is('admin') ? 'active' : '' }}">
                                <a href="{{ route('admin.index') }}"> Inicio </a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu menu-heading">
                        <div class="heading"><i data-feather="minus"></i><span>ADMINISTRACIÓN</span></div>
                    </li>
                    @foreach ($menuData[0]->menu as $menu)
                        @include('layouts.partials.menuHorizontal', ['menu' => $menu])
                    @endforeach
                    {{-- @include('layouts.partials.solicitudes') --}}
                    {{-- @include('layouts.partials.admin') --}}
                </ul>

            </nav>
        </div>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            {{-- <div class="row justify-content-center pb-3">
                <div class="col-9 d-flex justify-content-lg-center">
                    <div class="span">
                        <div class="nombre">
                            <div class="UF"></div>
                            <div class="leftgris">UF</div>
                            <div class="valor">@{{ uf | currency('CLP', 2, currency) }}</div>
                            <div class="indicador ve"><i class="fas fa-money-bill-alt"></i></div>
                        </div>
                    </div>

                    <div class="span">
                        <div class="nombre">
                            <div class="UTM"></div>
                            <div class="leftgris">UTM</div>
                            <div class="valor">@{{ utm | currency('CLP', 2, currency) }}</div>
                            <div class="indicador ve"><i class="fas fa-money-bill-alt"></i></div>
                        </div>
                    </div>

                    <div class="span">
                        <div class="nombre">
                            <div class="IPSA"></div>
                            <div class="leftgris">IPC</div>
                            <div class="valor">@{{ ipc | currency('%', 2, currency) }}</div>
                            <div class="indicador ve"><i class="fas fa-signal"></i></div>
                        </div>
                    </div>

                    <div class="span">
                        <div class="nombre">
                            <div class="USD"></div>
                            <div class="leftgris">USD</div>
                            <div class="valor">@{{ usd | currency('CLP', 2, currency) }}</div>
                            <div class="indicador ve"><i class="fas fa-money-bill-alt"></i></div>
                        </div>
                    </div>
                    <div class="span">
                        <div class="nombre">
                            <div class="EURO"></div>
                            <div class="leftgris">EURO</div>
                            <div class="valor">@{{ euro | currency('CLP', 2, currency) }}</div>
                            <div class="indicador ve"><i class="fas fa-money-bill-alt"></i></div>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- <div id="indicadores" class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-2 col-10 m-1" style="font-size: 11px">
                        <div class="row">
                            <div class="bg-danger text-center p-1 col-2">UF</div>
                            <div class="text-center bg-primary p-1 col-8">@{{ uf | currency('CLP', 2, currency) }}
                            </div>
                            <div class="bg-danger text-center p-1 col-2"><i class="fas fa-money-bill-alt"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-10 m-1" style="font-size: 11px">
                        <div class="row">
                            <div class="bg-danger text-center p-1 col-2">UTM</div>
                            <div class="text-center bg-primary p-1 col-8">@{{ utm | currency('CLP', 2, currency) }}
                            </div>
                            <div class="bg-danger text-center p-1 col-2"><i class="fas fa-money-bill-alt"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-10 m-1" style="font-size: 11px">
                        <div class="row">
                            <div class="bg-danger text-center p-1 col-2">USD</div>
                            <div class="text-center bg-primary p-1 col-8">@{{ usd | currency('CLP', 2, currency) }}
                            </div>
                            <div class="bg-danger text-center p-1 col-2"><i class="fas fa-money-bill-alt"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-10 m-1" style="font-size: 11px">
                        <div class="row">
                            <div class="bg-danger text-center p-1 col-2">EURO</div>
                            <div class="text-center bg-primary p-1 col-8">@{{ euro | currency('CLP', 2, currency) }}
                            </div>
                            <div class="bg-danger text-center p-1 col-2"><i class="fas fa-money-bill-alt"></i></div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="layout-px-spacing">
                <nav aria-label="breadcrumb-one" class="breadcrumb-four">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i
                                    class="fas fa-tachometer-alt"></i> Inicio</a></li>
                        @yield('breadcrumb')
                    </ol>
                </nav>

                @yield('content')

            </div>
            <div class="footer-wrapper">
                <div class="footer-section f-section-1">
                    <p class="___class_+?78___">Copyright © 2021 <a target="_blank"
                            href="mailto:thony918@outlook.com">TonyStore</a>,
                        Todos los derechos reservados.</p>
                </div>

            </div>
        </div>
        <div class="settingSidebar">
            <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
            </a>
            <div class="settingSidebar-body ps-container ps-theme-default">
                <div class="fade show active">
                    <div class="setting-panel-header">Panel de Monedas
                    </div>
                    <div class="p-15 border-bottom">
                        <h6 class="font-medium m-b-10">Panel de Monedas</h6>
                        <div class="selectgroup layout-color">
                            <div id="indicadores" class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-12 col-10 m-1" style="font-size: 11px">
                                        <div class="row">
                                            <div class="bg-danger text-center p-1 col-2">UF</div>
                                            <div class="text-center bg-primary p-1 col-8">
                                                @{{ uf | currency('CLP', 2, currency) }}
                                            </div>
                                            <div class="bg-danger text-center p-1 col-2"><i
                                                    class="fas fa-money-bill-alt"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-10 m-1" style="font-size: 11px">
                                        <div class="row">
                                            <div class="bg-danger text-center p-1 col-2">UTM</div>
                                            <div class="text-center bg-primary p-1 col-8">
                                                @{{ utm | currency('CLP', 2, currency) }}
                                            </div>
                                            <div class="bg-danger text-center p-1 col-2"><i
                                                    class="fas fa-money-bill-alt"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-10 m-1" style="font-size: 11px">
                                        <div class="row">
                                            <div class="bg-danger text-center p-1 col-2">USD</div>
                                            <div class="text-center bg-primary p-1 col-8">
                                                @{{ usd | currency('CLP', 2, currency) }}
                                            </div>
                                            <div class="bg-danger text-center p-1 col-2"><i
                                                    class="fas fa-money-bill-alt"></i></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-10 m-1" style="font-size: 11px">
                                        <div class="row">
                                            <div class="bg-danger text-center p-1 col-2">EURO</div>
                                            <div class="text-center bg-primary p-1 col-8">
                                                @{{ euro | currency('CLP', 2, currency) }}
                                            </div>
                                            <div class="bg-danger text-center p-1 col-2"><i
                                                    class="fas fa-money-bill-alt"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  END CONTENT AREA  -->
    {{-- </div> --}}
    <!-- END MAIN CONTAINER -->
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    {{-- <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script> --}}
    {{-- <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('adm/js/app.j') }}s"></script> --}}
    @livewireScripts

    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            App.init();
        });
        @if (Session::has('message'))
            iziToast.error({
            title: 'Leones de Oro',
            message: '{{ Session::get('message') }}',
            position: 'topRight'
            });
        @endif
        feather.replace();
        $(".settingPanelToggle").on("click", function() {
                $(".settingSidebar").toggleClass("showSettingPanel");
            }),
            $(".page-wrapper").on("click", function() {
                $(".settingSidebar").removeClass("showSettingPanel");
            });

        // close right sidebar when click outside
        var mouse_is_inside = false;
        $(".settingSidebar").hover(
            function() {
                mouse_is_inside = true;
            },
            function() {
                mouse_is_inside = false;
            }
        );

        $("body").mouseup(function() {
            if (!mouse_is_inside) $(".settingSidebar").removeClass("showSettingPanel");
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            App.init();
        });
    </script>
    <script src="{{ asset('adm/js/custom.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="{{ asset('assets/js/ie11fix/fn.fix-padStart.js') }}"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script src="{{ asset('plugins/font-icons/feather/feather.min.js') }}"></script>
    <script type="text/javascript">
        feather.replace();
    </script> --}}
    {{-- <script type="text/javascript" src="{{ asset('plugins/izitoast/js/iziToast.min.js') }}"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/eventos.js') }}"></script> --}}
    <script src="{{ asset('plugins/select2/select2.min.js') }}"></script>
    @yield('js')
    @stack('scripts')
</body>

</html>
