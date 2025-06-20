<!DOCTYPE html>
<html data-bs-theme="light" lang="es-ES" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="keywords" content="">


    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- ===============================================-->
    <!-- Favicons-->
    <!-- ===============================================-->
    <link rel="shortcut icon" type="image/x-icon" href="/image/default.svg">

    <meta name="msapplication-TileImage" content="/image/default.svg">
    <meta name="theme-color" content="#ffffff">
    {!! Html::script('/falcon/public/assets/js/config.js') !!}
    {!! Html::script('/falcon/public/vendors/simplebar/simplebar.min.js') !!}


    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:300,400,500,600,700,800,900&amp;display=swap"
        rel="stylesheet">
    {!! Html::style('/falcon/public/vendors/simplebar/simplebar.min.css') !!}
    {!! Html::style('/falcon/public/assets/css/theme-rtl.css', ['id' => 'style-rtl']) !!}
    {!! Html::style('/falcon/public/assets/css/theme.css', ['id' => 'style-default']) !!}
    {!! Html::style('/falcon/public/assets/css/user-rtl.css', ['id' => 'user-style-rtl']) !!}
    {!! Html::style('/falcon/public/assets/css/user.css', ['id' => 'user-style-default']) !!}

    <script>
        var isRTL = JSON.parse(localStorage.getItem('isRTL'));
        if (isRTL) {
            var linkDefault = document.getElementById('style-default');
            var userLinkDefault = document.getElementById('user-style-default');
            linkDefault.setAttribute('disabled', true);
            userLinkDefault.setAttribute('disabled', true);
            document.querySelector('html').setAttribute('dir', 'rtl');
        } else {
            var linkRTL = document.getElementById('style-rtl');
            var userLinkRTL = document.getElementById('user-style-rtl');
            linkRTL.setAttribute('disabled', true);
            userLinkRTL.setAttribute('disabled', true);
        }
    </script>
</head>


<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <script>
                var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                if (isFluid) {
                    var container = document.querySelector('[data-layout]');
                    container.classList.remove('container');
                    container.classList.add('container-fluid');
                }
            </script>
            <nav class="navbar navbar-light navbar-vertical navbar-expand-xl">
                <script>
                    var navbarStyle = localStorage.getItem("navbarStyle");
                    if (navbarStyle && navbarStyle !== 'transparent') {
                        document.querySelector('.navbar-vertical').classList.add(`navbar-${navbarStyle}`);
                    }
                </script>
                <div class="d-flex align-items-center">
                    <div class="toggle-icon-wrapper">

                        <button class="btn navbar-toggler-humburger-icon navbar-vertical-toggle"
                            data-bs-toggle="tooltip" data-bs-placement="left" title="Toggle Navigation"><span
                                class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>

                    </div><a class="navbar-brand" href="{{ url('/') }}">
                        <div class="d-flex align-items-center py-3">
                            <h2><span style="color: #D25252;">Red</span>Civica</h2>
                        </div>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
                    <div class="navbar-vertical-content scrollbar">
                        <ul class="navbar-nav flex-column mb-3" id="navbarVerticalNav">
                            <li class="nav-item">
                                <!-- label-->
                                <div class="user-profile-card mb-4 d-none d-lg-block ">
                                    <div class="d-flex align-items-center ">
                                        <!-- Información del usuario -->
                                        <div class="flex-grow-1 col-auto navbar-vertical-label">
                                            <h6 class="mb-0 fw-semi-bold text-800">
                                                {{ $saludo }} {{ Auth::user()->name }}
                                                <span class="verified-badge ms-1" data-bs-toggle="tooltip"
                                                    title="Usuario verificado">
                                                    <i class="fas fa-check-circle text-success fs--2"></i>
                                                </span>
                                            </h6>
                                            <p class="mb-0 text-600 fs--1">
                                                {{ Auth::user()->email }}
                                                @if (Auth::user()->created_at)
                                                    <span class="d-block mt-0 fs--2 text-400">
                                                        {{-- Formatear la fecha de creación del usuario --}}
                                                        Miembro desde
                                                        {{ Auth::user()->created_at->translatedFormat('F Y') }}
                                                    </span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- label-->
                                <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
                                    <div class="col-auto navbar-vertical-label">Menu
                                    </div>
                                    <div class="col ps-0">
                                        <hr class="mb-0 navbar-vertical-divider" />
                                    </div>
                                </div>

                                <!-- parent pages--><a
                                    class="nav-link {{ Request::segment(1) === 'home' ? 'active' : '' }}"
                                    href="{{ url('/') }}" role="button">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                class="fas fa-home"></span></span><span
                                            class="nav-link-text ps-1">Home</span>
                                    </div>
                                </a>
                                @hasrole('admin')
                                    <!-- parent pages--><a
                                        class="nav-link {{ Request::segment(1) === 'campañas' ? 'active' : '' }}"
                                        href="{{ route('campañas.index') }}" role="button">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-bullhorn"></span></span><span
                                                class="nav-link-text ps-1">Campañas</span>
                                        </div>
                                    </a>
                                @endhasrole
                                <!-- parent pages--><a
                                    class="nav-link {{ Request::segment(1) === 'referencias' ? 'active' : '' }}"
                                    href="{{ route('referencias.index') }}" role="button">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                class="fas fa-link"></span></span><span
                                            class="nav-link-text ps-1">Referencias</span>
                                    </div>
                                </a>
                                <!-- parent pages--><a
                                    class="nav-link {{ Request::segment(1) === 'red' ? 'active' : '' }}"
                                    href="{{ route('red.index') }}" role="button">
                                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                class="fas fa-network-wired"></span></span><span
                                            class="nav-link-text ps-1">Red</span>
                                    </div>
                                </a>
                                @hasrole('admin')
                                    <!-- parent pages--><a
                                        class="nav-link {{ Request::segment(1) === 'analitica' ? 'active' : '' }}"
                                        href="{{ route('analitica.index') }}" role="button">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-chart-bar"></span></span><span
                                                class="nav-link-text ps-1">Analítica </span>
                                        </div>
                                    </a>
                                    <a class="nav-link {{ Request::segment(1) === 'users' ? 'active' : '' }}"
                                        href="{{ route('users.index') }}" role="button">
                                        <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                                    class="fas fa-user"></span></span><span
                                                class="nav-link-text ps-1">Usuarios </span>
                                        </div>
                                    </a>
                                @endhasrole
                            </li>
                        </ul>
                        <div class="settings my-3">
                            <div class="card shadow-none">
                                <div class="card-body alert mb-0" role="alert">
                                    <div class="btn-close-/falcon-container">
                                        <button class="btn btn-link btn-close-/falcon p-0" aria-label="Close"
                                            data-bs-dismiss="alert"></button>
                                    </div>
                                    <div class="text-center"><img
                                            src="/falcon/public/assets/img/icons/spot-illustrations/navbar-vertical.png"
                                            alt="" width="80" />
                                        <p class="fs-11 mt-2">Invita a personas a tu red
                                        <div class="d-grid"><a class="btn btn-sm btn-primary" href="#"
                                                target="_blank"><i class="fas fa-user-plus"></i> Invitar</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="content">
                <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">

                    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button"
                        data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse"
                        aria-controls="navbarVerticalCollapse" aria-expanded="false"
                        aria-label="Toggle Navigation"><span class="navbar-toggle-icon"><span
                                class="toggle-line"></span></span></button>
                    <a class="navbar-brand me-1 me-sm-3" href="{{ url('/') }}">
                        <div class="d-flex align-items-center">
                            <h2><span style="color: red !important;"
                                    class="font-sans-serif text-primary">Red</span>Civica</h2>
                        </div>
                    </a>
                    <ul class="navbar-nav align-items-center d-none d-lg-block">
                        <li class="nav-item">
                            <div class="search-box">
                                <form class="position-relative" data-bs-toggle="search" data-bs-display="static">
                                    <input class="form-control search-input fuzzy-search" type="search"
                                        placeholder="Buscar..." aria-label="Search" />
                                    <span class="fas fa-search search-box-icon"></span>

                                </form>
                                <div class="btn-close-/falcon-container position-absolute end-0 top-50 translate-middle shadow-none"
                                    data-bs-dismiss="search">
                                    <button class="btn btn-link btn-close-/falcon p-0" aria-label="Close"></button>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
                        <li class="nav-item ps-2 pe-0">
                            <div class="dropdown theme-control-dropdown"><a
                                    class="nav-link d-flex align-items-center dropdown-toggle fa-icon-wait fs-9 pe-1 py-0"
                                    href="#" role="button" id="themeSwitchDropdown" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false"><span class="fas fa-sun fs-7"
                                        data-fa-transform="shrink-2"
                                        data-theme-dropdown-toggle-icon="light"></span><span class="fas fa-moon fs-7"
                                        data-fa-transform="shrink-3"
                                        data-theme-dropdown-toggle-icon="dark"></span><span class="fas fa-adjust fs-7"
                                        data-fa-transform="shrink-2"
                                        data-theme-dropdown-toggle-icon="auto"></span></a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-caret border py-0 mt-3"
                                    aria-labelledby="themeSwitchDropdown">
                                    <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                        <button class="dropdown-item d-flex align-items-center gap-2" type="button"
                                            value="light" data-theme-control="theme"><span
                                                class="fas fa-sun"></span>Light<span
                                                class="fas fa-check dropdown-check-icon ms-auto text-600"></span></button>
                                        <button class="dropdown-item d-flex align-items-center gap-2" type="button"
                                            value="dark" data-theme-control="theme"><span class="fas fa-moon"
                                                data-fa-transform=""></span>Dark<span
                                                class="fas fa-check dropdown-check-icon ms-auto text-600"></span></button>
                                        <button class="dropdown-item d-flex align-items-center gap-2" type="button"
                                            value="auto" data-theme-control="theme"><span class="fas fa-adjust"
                                                data-fa-transform=""></span>Auto<span
                                                class="fas fa-check dropdown-check-icon ms-auto text-600"></span></button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            {{-- las notificaciones se activan y desactivan con las clases notification-indicator y notification-indicator-primary --}}
                            <a class="nav-link {{ $hayNotificacionesNoLeidas ? 'notification-indicator notification-indicator-primary' : '' }} px-0 fa-icon-wait"
                                id="navbarDropdownNotification" role="button" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"
                                data-hide-on-body-scroll="data-hide-on-body-scroll"><span class="fas fa-bell"
                                    data-fa-transform="shrink-6" style="font-size: 33px;"></span></a>
                            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end dropdown-menu-card dropdown-menu-notification dropdown-caret-bg"
                                aria-labelledby="navbarDropdownNotification">
                                <div class="card card-notification shadow-none">
                                    <div class="card-header">
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-auto">
                                                <h6 class="card-header-title mb-0">Notificaciones</h6>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{ route('actividades.leer') }}"> <span
                                                        class="fas fa-eye"></span> </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="scrollbar-overlay" style="max-height:19rem">
                                        <div class="list-group list-group-flush fw-normal fs-10">
                                            <div class="list-group-title border-bottom">Actividad de referencia
                                                reciente</div>
                                            @forelse($notificacionesRecientes as $actividad)
                                                <div class="list-group-item">

                                                    <a class="notification notification-flush notification-unread"
                                                        href="#!">
                                                        <div class="notification-avatar m-3">
                                                            <div
                                                                class="avatar avatar-md bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center">
                                                                <i class="{{ $actividad->icono }} fs-4"></i>
                                                            </div>
                                                        </div>

                                                        <div class="notification-body">
                                                            <p class="mb-1">{{ $actividad->titulo }} <br>
                                                                @if (!$actividad->afectado)
                                                                    {{ $actividad->actor->name }}
                                                                    {{ $actividad->accion }}
                                                                @else
                                                                    <strong>{{ $actividad->afectado->name }}</strong>
                                                                    {{ $actividad->accion }}
                                                                    {{ $actividad->actor->name }}
                                                                @endif
                                                            </p>
                                                            <span class="notification-time"><span class="me-2"
                                                                    role="img" aria-label="Emoji">✨</span>
                                                                {{ $actividad->created_at->diffForHumans() }}</span>

                                                        </div>
                                                    </a>
                                                </div>
                                            @empty
                                                <div class="text-center p-3">
                                                    <small class="text-muted">Sin actividad reciente</small>
                                                </div>
                                            @endforelse

                                        </div>
                                    </div>
                                    <div class="card-footer text-center border-top"><a class="card-link d-block"
                                            href="{{ route('actividades.index') }}">Mostrar más</a></div>
                                </div>
                            </div>


                        </li>{{-- 
                        <li class="nav-item dropdown px-1">
                            <a class="nav-link fa-icon-wait nine-dots p-1" id="navbarDropdownMenu" role="button"
                                data-hide-on-body-scroll="data-hide-on-body-scroll" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="43"
                                    viewBox="0 0 16 16" fill="none">
                                    <circle cx="2" cy="2" r="2" fill="#6C6E71"></circle>
                                    <circle cx="2" cy="8" r="2" fill="#6C6E71"></circle>
                                    <circle cx="2" cy="14" r="2" fill="#6C6E71"></circle>
                                    <circle cx="8" cy="8" r="2" fill="#6C6E71"></circle>
                                    <circle cx="8" cy="14" r="2" fill="#6C6E71"></circle>
                                    <circle cx="14" cy="8" r="2" fill="#6C6E71"></circle>
                                    <circle cx="14" cy="14" r="2" fill="#6C6E71"></circle>
                                    <circle cx="8" cy="2" r="2" fill="#6C6E71"></circle>
                                    <circle cx="14" cy="2" r="2" fill="#6C6E71"></circle>
                                </svg></a>
                            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end dropdown-menu-card dropdown-caret-bg"
                                aria-labelledby="navbarDropdownMenu">
                                <div class="card shadow-none">
                                    <div class="scrollbar-overlay nine-dots-dropdown">
                                        <div class="card-body px-3">
                                            <div class="row text-center gx-0 gy-0">
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="pages/user/profile.html" target="_blank">
                                                        <div class="avatar avatar-2xl"> <img class="rounded-circle"
                                                                src="/falcon/public/assets/img/team/3.jpg"
                                                                alt="" /></div>
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11">Account
                                                        </p>
                                                    </a></div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="https://themewagon.com/" target="_blank"><img
                                                            class="rounded"
                                                            src="/falcon/public/assets/img/nav-icons/themewagon.png"
                                                            alt="" width="40" height="40" />
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                                            Themewagon</p>
                                                    </a></div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="https://mailbluster.com/" target="_blank"><img
                                                            class="rounded"
                                                            src="/falcon/public/assets/img/nav-icons/mailbluster.png"
                                                            alt="" width="40" height="40" />
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                                            Mailbluster</p>
                                                    </a></div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="#!" target="_blank"><img class="rounded"
                                                            src="/falcon/public/assets/img/nav-icons/google.png"
                                                            alt="" width="40" height="40" />
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                                            Google</p>
                                                    </a></div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="#!" target="_blank"><img class="rounded"
                                                            src="/falcon/public/assets/img/nav-icons/spotify.png"
                                                            alt="" width="40" height="40" />
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                                            Spotify</p>
                                                    </a></div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="#!" target="_blank"><img class="rounded"
                                                            src="/falcon/public/assets/img/nav-icons/steam.png"
                                                            alt="" width="40" height="40" />
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                                            Steam</p>
                                                    </a></div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="#!" target="_blank"><img class="rounded"
                                                            src="/falcon/public/assets/img/nav-icons/github-light.png"
                                                            alt="" width="40" height="40" />
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                                            Github</p>
                                                    </a></div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="#!" target="_blank"><img class="rounded"
                                                            src="/falcon/public/assets/img/nav-icons/discord.png"
                                                            alt="" width="40" height="40" />
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                                            Discord</p>
                                                    </a></div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="#!" target="_blank"><img class="rounded"
                                                            src="/falcon/public/assets/img/nav-icons/xbox.png"
                                                            alt="" width="40" height="40" />
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                                            xbox</p>
                                                    </a></div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="#!" target="_blank"><img class="rounded"
                                                            src="/falcon/public/assets/img/nav-icons/trello.png"
                                                            alt="" width="40" height="40" />
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                                            Kanban</p>
                                                    </a></div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="#!" target="_blank"><img class="rounded"
                                                            src="/falcon/public/assets/img/nav-icons/hp.png"
                                                            alt="" width="40" height="40" />
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">Hp
                                                        </p>
                                                    </a></div>
                                                <div class="col-12">
                                                    <hr class="my-3 mx-n3 bg-200" />
                                                </div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="#!" target="_blank"><img class="rounded"
                                                            src="/falcon/public/assets/img/nav-icons/linkedin.png"
                                                            alt="" width="40" height="40" />
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                                            Linkedin</p>
                                                    </a></div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="#!" target="_blank"><img class="rounded"
                                                            src="/falcon/public/assets/img/nav-icons/twitter.png"
                                                            alt="" width="40" height="40" />
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                                            Twitter</p>
                                                    </a></div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="#!" target="_blank"><img class="rounded"
                                                            src="/falcon/public/assets/img/nav-icons/facebook.png"
                                                            alt="" width="40" height="40" />
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                                            Facebook</p>
                                                    </a></div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="#!" target="_blank"><img class="rounded"
                                                            src="/falcon/public/assets/img/nav-icons/instagram.png"
                                                            alt="" width="40" height="40" />
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                                            Instagram</p>
                                                    </a></div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="#!" target="_blank"><img class="rounded"
                                                            src="/falcon/public/assets/img/nav-icons/pinterest.png"
                                                            alt="" width="40" height="40" />
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                                            Pinterest</p>
                                                    </a></div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="#!" target="_blank"><img class="rounded"
                                                            src="/falcon/public/assets/img/nav-icons/slack.png"
                                                            alt="" width="40" height="40" />
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                                            Slack</p>
                                                    </a></div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="#!" target="_blank"><img class="rounded"
                                                            src="/falcon/public/assets/img/nav-icons/deviantart.png"
                                                            alt="" width="40" height="40" />
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11 pt-1">
                                                            Deviantart</p>
                                                    </a></div>
                                                <div class="col-4"><a
                                                        class="d-block hover-bg-200 px-2 py-3 rounded-3 text-center text-decoration-none"
                                                        href="app/events/event-detail.html" target="_blank">
                                                        <div class="avatar avatar-2xl">
                                                            <div
                                                                class="avatar-name rounded-circle bg-primary-subtle text-primary">
                                                                <span class="fs-7">E</span>
                                                            </div>
                                                        </div>
                                                        <p class="mb-0 fw-medium text-800 text-truncate fs-11">Events
                                                        </p>
                                                    </a></div>
                                                <div class="col-12"><a class="btn btn-outline-primary btn-sm mt-4"
                                                        href="#!">Show more</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </li> --}}
                        <li class="nav-item dropdown"><a class="nav-link pe-0 ps-2" id="navbarDropdownUser"
                                role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="avatar avatar-xl">
                                    <img class="rounded-circle" src="{{ asset('image/' . $business->logo) }}"
                                        alt="" />

                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0"
                                aria-labelledby="navbarDropdownUser">
                                <div class="bg-white dark__bg-1000 rounded-2 py-2">
                                    <a class="dropdown-item fw-bold text-warning"
                                        href="{{ route('business.index') }}"><span
                                            class="fas fa-crown me-1"></span><span>{{ $business->name }}</span></a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="">Tu perfil</a>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="">Ajustes</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        ata-original-title="Logout"
                                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">Salir</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </li>
                    </ul>
                </nav>

                <div class="row g-3 mb-3">
                    @yield('content')
                </div>

                <footer class="footer">
                    <div class="row g-0 justify-content-between fs-10 mt-4 mb-3">
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600">Copyright <span class="d-none d-sm-inline-block">| </span><br
                                    class="d-sm-none" /> 2025 &copy;
                                <a href="https://www.afdeveloper.com/">AF</a>
                            </p>
                        </div>
                        <div class="col-12 col-sm-auto text-center">
                            <p class="mb-0 text-600">v1.0.0</p>
                        </div>
                    </div>
                </footer>
            </div>

            {{-- Modal futuro --}}

        </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->



    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->

    {!! Html::script('melody/vendors/js/vendor.bundle.base.js') !!}
    {!! Html::script('melody/vendors/js/vendor.bundle.addons.js') !!}
    {!! Html::script('/falcon/public/vendors/popper/popper.min.js') !!}
    {!! Html::script('/falcon/public/vendors/bootstrap/bootstrap.min.js') !!}
    {!! Html::script('/falcon/public/vendors/anchorjs/anchor.min.js') !!}
    {!! Html::script('/falcon/public/vendors/is/is.min.js') !!}
    {!! Html::script('/falcon/public/vendors/fontawesome/all.min.js') !!}
    {!! Html::script('/falcon/public/vendors/lodash/lodash.min.js') !!}
    {!! Html::script('/falcon/public/vendors/list.js/list.min.js') !!}
    {!! Html::script('/falcon/public/assets/js/theme.js') !!}
    @yield('scripts')

</body>

</html>
