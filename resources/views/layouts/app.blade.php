<!DOCTYPE html>
<html lang="es">

<head>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/master.js') }}" defer></script>

    <!-- Required meta tags-->
    <meta charset="UTF-8">
    {{-- <link rel="icon" type="image/png" href="{{ asset('images/icon/cropped-logo-black.png') }}"> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Team Acevedo">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Precalificacion</title>

    <!-- Fontfaces CSS-->
    <link href="{{ asset('css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="{{ asset('vendor/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="{{ asset('vendor/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet"
        media="all">
    <link href="{{ asset('vendor/wow/animate.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/slick/slick.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.2/locale/es.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />

    <link rel="stylesheet" type="text/css"
        href="{{ asset('https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css') }}">
    <script type="text/javascript" src="{{ asset('https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js') }}"
        defer></script>
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!-- Main CSS-->
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet" media="all">

</head>

<body class="animsition" style="background-color: #f4f4f4;">

    <div class="page-wrapper" style="background-color: #f4f4f4;">

        <style>
            html,
            body {
                min-height: 100%;
            }

            .page-wrapper {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            .app-sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                z-index: 1030;
                width: 250px;
                padding: 24px 14px;
                color: #fff;
                background: #162a50;
                box-shadow: 2px 0 8px rgba(0, 0, 0, .12);
            }

            .app-sidebar__brand {
                padding: 12px 14px 22px;
                font-size: 1.05rem;
                font-weight: 700;
            }

            .app-sidebar__link {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 6px;
                padding: 12px 14px;
                color: rgba(255, 255, 255, .78);
                border-radius: 4px;
                text-decoration: none;
            }

            .app-sidebar__link:hover,
            .app-sidebar__link.is-active {
                color: #fff;
                background: #24518f;
            }

            .app-sidebar__link i {
                width: 18px;
                text-align: center;
            }

            .app-main-content {
                margin-left: 250px;
                flex: 1;
                display: flex;
                flex-direction: column;
            }

            .app-content-body {
                flex: 1;
            }

            .app-footer {
                flex: 0 0 auto !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 12px !important;
                width: 100% !important;
                min-height: 72px !important;
                margin-top: auto !important;
                padding: 12px 16px !important;
                background: #1d3668 !important;
            }

            .app-footer__copyright {
                margin: 0 !important;
                padding: 0 !important;
                color: #fff !important;
                line-height: 1.4 !important;
                text-align: center;
            }

            .app-footer #iconos {
                display: flex !important;
                align-items: center !important;
                gap: 12px !important;
                line-height: 1 !important;
            }

            .app-footer #iconos a {
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                line-height: 1 !important;
            }

            .app-footer #iconos i {
                display: block !important;
                line-height: 1 !important;
            }

            @media (max-width: 600px) {
                .app-footer {
                    flex-direction: column !important;
                    gap: 8px !important;
                }
            }

            @media (max-width: 991.98px) {
                .app-sidebar {
                    position: static;
                    width: 100%;
                    padding: 10px 14px;
                }

                .app-sidebar__brand {
                    padding: 4px 14px 10px;
                }

                .app-sidebar__link {
                    display: inline-flex;
                    margin-right: 6px;
                }

                .app-main-content {
                    margin-left: 0;
                }
            }

            ventana. {
                background: #1d3668 !important;
            }
        </style>
        <!-- HEADER DESKTOP-->
        <header class="header-desktop3 d-none d-lg-block" style="background:#1d3668">
            <div class="section__content section__content--p35" style="background: #1d3668;">
                <div class="header3-wrap">
                    <div class="header__logo">
                        <a class="image" href="{{ url('/home')}}">
                            <img class="image" style=" width:90px ;" src="{{ asset('images/icon/logo.png') }}" />
                        </a>
                    </div>
                    <div class="header__navbar">
                        <ul class="list-unstyled">
                            <li class="nav-item">
                            <li class="has-sub text-white" style="padding-top: 35px;">
                                <header class="container-fluid bg-primary d-flex justify-content-center rounded">
                                    {{-- <p class="text-light mb-0 p-2 fs-6">Contactanos (631) 841-8105</p> --}}
                                </header>
                            </li>

                        </ul>
                    </div>

                    <div class="header__tool">
                        <div class="account-wrap">
                            <div class="account-item account-item--style2 clearfix js-item-menu">
                                <ul class="navbar-nav ms-auto">
                                    <!-- Authentication Links -->
                                    @guest
                                    @else
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }}
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            @guest

                                            @else
                                            @if (Route::has('login'))
                                            @if(@Auth::user()->hasRole('administrador'))

                                            <a class="dropdown-item" onclick="vistaregister()">Usuarios</a>
                                            <div class="dropdown-divider"></div>

                                            @endif
                                            @endif
                                            @endguest

                                            <a class="dropdown-item" onclick="vista_home()">Home</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                    @endguest
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- END HEADER DESKTOP-->

        <!-- HEADER MOBILE-->
        <nav class="navbar navbar-expand-dark navbar-dark  d-lg-none " style="background:#1d3668">
            <a class="image d-lg-none" href="{{ url('/')}}">
                <img class="image d-lg-none" style=" width:90px ;" src="{{ asset('images/icon/logo.png') }}" />
            </a> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mr-auto">

                    @guest
                    @else
                    @if (Route::has('login'))
                    @if(@Auth::user()->hasRole('administrador'))

                    <li class="nav-item d-lg-none ">
                        <a class="nav-link text-white" onclick="vistaregister()">Usuarios</a>
                    </li>
                    <li class="nav-item d-lg-none ">
                        <a class="nav-link text-white" onclick="vista_home()">Home</a>
                    </li>

                    @endif
                    @endif
                    @endguest

                    <li class="nav-item active">
                        <!-- Contenido del menú -->
                        <!-- Authentication Links -->
                        @guest
                        @else

                    <li class="nav-item dropdown d-lg-none">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
                    </li>
                </ul>
            </div>
        </nav>

        <aside class="app-sidebar" aria-label="Menú principal">
            <div class="app-sidebar__brand">Menú principal</div>
            <nav>
                <a class="app-sidebar__link {{ request()->routeIs('home') ? 'is-active' : '' }}"
                    href="{{ route('home') }}">
                    <i class="fas fa-th-large" aria-hidden="true"></i>
                    <span>Seminarios</span>
                </a>
                @auth
                    @if (Auth::user()->hasRole('administrador'))
                        <a class="app-sidebar__link {{ request()->routeIs('seminarios.mantenimiento') ? 'is-active' : '' }}"
                            href="{{ route('seminarios.mantenimiento') }}">
                            <i class="fas fa-tools" aria-hidden="true"></i>
                            <span>Mantenimiento de seminarios</span>
                        </a>
                    @endif
                @endauth
            </nav>
        </aside>

        <!-- PAGE CONTENT-->
        <div class="page-content--bgf7 app-main-content">

            <!-- END BREADCRUMB-->
            <div class="py-4 app-content-body"  style="background: #f4f5ff">
                @yield('content')

            </div>

            <!--========================================================== -->
            <!--FOOTER-->

        </div>

        <!--========================================================== -->

        <footer class="app-footer">
            <p class="app-footer__copyright fs-5">Copyright © {{ date('Y') }} Contigo Mortgage. All rights reserved</p>
            <div id="iconos">
                <a href="https://www.facebook.com/contigomortgage?mibextid=ZbWKwL"><i
                        class="bi bi-facebook"></i></a>
                <a href="https://instagram.com/contigomortgage1?igshid=MzNlNGNkZWQ4Mg=="><i
                        class="bi bi-instagram"></i></a>
                <a href="https://m.youtube.com/@contigomortgage/videos"><i class="bi bi-youtube"></i></a>
                <a href="https://wa.me/message/4EMGID7CSSBZE1"><i class="bi bi-whatsapp"></i></a>
            </div>
            {{-- <br><br><br> --}}
        </footer>

        <!-- Jquery JS-->
        <script src="{{ asset('vendor/jquery-3.2.1.min.js') }}"></script>
        <!-- Bootstrap JS-->
        <script src="{{ asset('vendor/bootstrap-4.1/popper.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap-4.1/bootstrap.min.js') }}"></script>
        <!-- Vendor JS       -->
        <script src="{{ asset('vendor/slick/slick.min.js') }}">
        </script>
        <script src="{{ asset('vendor/wow/wow.min.js') }}"></script>
        <script src="{{ asset('vendor/animsition/animsition.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap-progressbar/bootstrap-progressbar.min.js') }}">
        </script>
        <script src="{{ asset('vendor/counter-up/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('vendor/counter-up/jquery.counterup.min.js') }}">
        </script>
        <script src="{{ asset('vendor/circle-progress/circle-progress.min.js') }}"></script>
        <script src="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('vendor/chartjs/Chart.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/select2/select2.min.js') }}">
        </script>

        <script type="module">
            import {
        Fancybox
    } from "https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.esm.js";
    </script>

        <!-- Main JS-->
        <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>
<!-- end document-->