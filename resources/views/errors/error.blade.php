<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Error</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <style>
    body {
        margin: 0px;
        font-family: 'Nunito', sans-serif;
        background-image: linear-gradient(-225deg, #121315 0%, #1C2231 51%, #05010F 100%);
    }

    h1 {
        margin: 0px;
        font-size: 100px;
    }

    .error-message {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: calc(100vh - 100px);
        width: 100%;
    }

    .error-mesagge__container {
        text-align: center;
        color: white;
    }

    p {

        font-size: 18px;
    }

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

    .footer {
        display: flex;
        align-items: center;
        min-height: 100px;
        width: 100%;
    }
    </style>
</head>

<body>
    <div class="error-message">
        <div class="error-mesagge__container">
            <h1 class="animated bounce"> UPPPS!</h1>
            <p>No tienes un curso asignado todavia, ponte en contacto con tu tutor</p>
        </div>
    </div>
    <footer class="footer">

    </footer>
</body>

</html>