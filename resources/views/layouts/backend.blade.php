<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="/assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Bear Cyber Hunt">
    <title>AgriTech | @yield('title')</title>

    <link rel="stylesheet" href="/assets/css/css@3.css">

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">

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
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            /* fill: currentColor; */
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="/assets/css/dashboard.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    @if (Request::is('dashboard/peta-interaktif'))
        <link href="https://unpkg.com/maplibre-gl@3.2.1/dist/maplibre-gl.css" rel="stylesheet" />
        <style>
            #map {
                height: 500px;
                width: 100%;
            }
        </style>
    @endif

    @if (Request::is('dashboard/ndvi-map'))
        <!-- Add these in your <head> or before the map div -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>


        <!-- Plugin leaflet-easyPrint -->
        <script src="https://cdn.jsdelivr.net/npm/leaflet-easyprint@2.1.9/dist/bundle.min.js"></script>


        <style>
            #ndvi-map {
                height: 500px;
                width: 100%;
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endif
</head>

<body>
    @include('partials.backend.colorMode')

    <header class="navbar sticky-top flex-md-nowrap p-0 shadow" data-bs-theme="dark">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 bg-body-tertiary" href="/">
            <i class="fas fa-leaf text-secondary" style="font-size: 1rem;"></i>
            AgriTech
        </a>

        <ul class="navbar-nav flex-row d-md-none">
            <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <svg class="bi">
                        <use xlink:href="#list" />
                    </svg>
                </button>
            </li>
        </ul>

    </header>

    <div class="container-fluid">
        <div class="row">
            @include('partials.backend.sidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('title')</h1>
                    @if (Request::is('dashboard/ndvi-map'))
                        <div>
                            <button class="btn btn-outline-secondary me-2" id="export-map"><i
                                    class="fas fa-file-export"></i>
                                Export</button>

                            <button class="btn btn-primary" onclick="location.reload();">
                                <i class="fas fa-sync-alt"></i> Update
                            </button>

                        </div>
                    @endif
                </div>


                @yield('content')
            </main>
        </div>
    </div>


    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/dashboard.js"></script>
</body>

</html>
