<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}" />

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/admin.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pages/error/style-400.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- Styles -->
    <style>
        /* body {
            margin: 0px;
            font-family: 'Nunito', sans-serif;
            background-image: linear-gradient(-225deg, #121315 0%, #1C2231 51%, #05010F 100%);
        } */

        .animated {
            animation-duration: 2.5s;
            animation-fill-mode: both;
            animation-iteration-count: infinite;


        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-30px);
            }

            60% {
                transform: translateY(-15px);
            }
        }

        .bounce {
            animation-name: bounce;
        }

    </style>
</head>

<body class="error404 text-center">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 mr-auto mt-5 text-md-left text-center">
                <a href="{{ route('index') }}" class="ml-md-5">
                    <img alt="image-404" src="{{ asset('img/logo.png') }}" class="theme-logo">
                </a>
            </div>
        </div>
    </div>
    {{-- <div class="error-message">
        <div class="error-mesagge__container">
            <h1 class="animated bounce"> @yield('code')</h1>
            <p>@yield('message')</p>
        </div>
    </div> --}}
    <div class="container-fluid error-content">
        <div class="">
            <h1 class="error-number animated bounce">@yield('code')</h1>
            <p class="mini-text">Ooops!</p>
            <p class="error-text mb-4 mt-1">@yield('message')</p>
            <a href="{{ route('index') }}" class="btn btn-primary mt-5"><i class="fa fa-arrow-left"></i> Volver al
                Inicio</a>

            {{-- <a href="index.html" class="btn btn-primary mt-5">Go Back</a> --}}
        </div>
    </div>
    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->
</body>

</html>
