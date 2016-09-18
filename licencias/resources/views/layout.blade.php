<!DOCTYPE html>
<html lang="es">
<head>
    <title>CityBoard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/smoothness/jquery-ui-1.10.4.custom.min.css') }}">
    @yield('scripts_at_head')
    <style>
        .sidebar-nav {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .sidebar-nav li {
            line-height: 40px;
        }

        .sidebar-nav li a {
            display: block;
            color: #999;
            background: #EEE;
        }

        .sidebar-nav li a:hover {
            color: #333;
            background: rgba(255, 255, 255, 0.8);
        }

        a, a:hover {
            text-decoration: none;
        }

        .navbar {
            margin-bottom: 0;
            border-radius: 0;
            border: 0;
        }

        .lightgray {
            background: #EEE;
        }

        .white {
            background: #FFF;
        }

        .gray {
            background: gray;
        }

        .search-box {
            margin-top: 8px;
            margin-bottom: 8px;
        }

        .primary-navbar {
            background: black;
            color: white;
        }

        .home-notification {
            text-align: center;
            border-radius: 10px;
            height: 130px;
            margin-top: 10px;
        }
        .inline {
            display: inline-block;
        }

        .panel-default {
            margin-top: 8px;
        }
        .current-stage {
            font-weight: bold;
            border: 1px solid darkred;
        }

        .other-stage {
            font-weight: normal;
        }

        .bg-primary {
            color: #fff; }

        .bg-primary {
            background-color: #337ab7; }

        a.bg-primary:hover,
        a.bg-primary:focus {
            background-color: #286090; }

        .bg-success {
            background-color: #dff0d8; }

        a.bg-success:hover,
        a.bg-success:focus {
            background-color: #c1e2b3; }

        .bg-info {
            background-color: #d9edf7; }

        a.bg-info:hover,
        a.bg-info:focus {
            background-color: #afd9ee; }

        .bg-warning {
            background-color: #fcf8e3; }

        a.bg-warning:hover,
        a.bg-warning:focus {
            background-color: #f7ecb5; }

        .bg-danger {
            background-color: #f2dede; }

        a.bg-danger:hover,
        a.bg-danger:focus {
            background-color: #e4b9b9; }
    </style>
</head>
<body>
<nav class="navbar navbar-default primary-navbar">
    <div class="container">
        <div class="row">
            <div class="col-md-2 text-left">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ route('home') }}" style="color:white;">CityBoard</a>
                </div>
            </div>
            <div class="col-md-6">
            </div>
            <div class="col-md-6 text-right">
                @if(Auth::check())
                    <a href="{{ route('logout') }}" class="btn btn-warning" style="margin-top:5px">Salir</a>
                @endif
            </div>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row lightgray">
        @if(Auth::check())
        <div class="col-md-2">
            <!--
            <ul class="sidebar-nav">
                <li>
                    <a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Inicio</a>
                </li>

                <li>
                    <a href="{{ route('license.index') }}"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Listado Licencias</a>
                </li>

                <li>
                    <a href="{{ route('titularitychange.index') }}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Cambios de titularidad</a>
                </li>

                <li>
                    <a href="{{ route('license.index') }}"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Buscador</a>
                </li>
            </ul>
            -->

            @yield('sidebar')
        </div>
        @endif
        @if(Auth::check())
            <div class="col-md-10 white">
        @else
            <div class="col-md-12 white">
        @endif
            @if(Auth::check())
                <div class="row">
                    <nav class="navbar navbar-default">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="{{ route('license.create') }}"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Nueva
                                    Licencia</a>
                            </li>

                            <li>
                                <a href="#"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    Alertas</a>
                            </li>

                            <li>
                                <a href="#"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span> Estadísticas</a>
                            </li>

                            <li>
                                <a href="{{ route('license.index') }}"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> Listado Licencias</a>
                            </li>

                            <li>
                                <a href="{{ route('titularitychange.index') }}"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Cambios de titularidad</a>
                            </li>

                            <!--<li>
                                <a href="{{ route('license.index') }}"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Buscador</a>
                            </li>-->

                        </ul>
                    </nav>
                </div>
            @endif

            @yield('content')

        </div>
    </div>
</div>

@yield('scripts_at_body')
</body>

</html>
