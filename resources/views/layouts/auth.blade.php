<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgriTech | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/assets/img/icon/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/assets/img/icon/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/assets/img/icon/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/assets/img/icon/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="/assets/img/icon/apple-touch-icon-60x60.png" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="/assets/img/icon/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="/assets/img/icon/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="/assets/img/icon/apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="/assets/img/icon/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="/assets/img/icon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="/assets/img/icon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/assets/img/icon/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="/assets/img/icon/favicon-128.png" sizes="128x128" />
    <meta name="application-name" content="&nbsp;" />
    <meta name="msapplication-TileColor" content="#FFFFFF" />
    <meta name="msapplication-TileImage" content="mstile-144x144.png" />
    <meta name="msapplication-square70x70logo" content="mstile-70x70.png" />
    <meta name="msapplication-square150x150logo" content="mstile-150x150.png" />
    <meta name="msapplication-wide310x150logo" content="mstile-310x150.png" />
    <meta name="msapplication-square310x310logo" content="mstile-310x310.png" />



    <style>
        body {
            background-color: #f8fafc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            display: flex;
            flex-direction: column;
            width: 90%;
            max-width: 1024px;
        }

        .left-panel {
            background-color: #f1f5f9;
            display: flex;
            /* align-items: center; */
            justify-content: center;
            padding: 2rem;
            width: 100%;
        }

        .right-panel {
            padding: 2rem;
            width: 100%;
        }

        .right-panel .form-control {
            margin-bottom: 1rem;
        }

        .right-panel .form-check {
            margin-bottom: 1rem;
        }

        .right-panel .btn {
            width: 100%;
        }

        @media (min-width: 768px) {
            .login-container {
                flex-direction: row;
            }

            .left-panel,
            .right-panel {
                width: 50%;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="left-panel">

            <img src="/assets/img/bg-loger.jpg" alt="Logo" class="img-fluid rounded">
        </div>
        <div class="right-panel">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
