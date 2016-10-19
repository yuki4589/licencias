<nav id="sidebar">
    <!-- Sidebar Scroll Container -->
    <div id="sidebar-scroll">
        <!-- Sidebar Content -->
        <!-- Adding .sidebar-mini-hide to an element will hide it when the sidebar is in mini mode -->
        <div class="sidebar-content">
            <!-- Side Header -->
            <div class="side-header side-content" style="background-color: rgba(255, 255, 255, 0.5);">
                <!-- Layout API, functionality initialized in App() -> uiLayoutApi() -->
                <button class="btn btn-link text-gray pull-right hidden-md hidden-lg" type="button" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times"></i>
                </button>
                <!-- Themes functionality initialized in App() -> uiHandleTheme() -->

                <a class="text-white" href="{{ route('home') }}">
                    <img src="{{ asset(env('LOGO')) }}" class="responsive-img" style="width: 100%; height: 100px">
                </a>
            </div>
            <!-- END Side Header -->

            <!-- Side Content -->
            <div class="side-content">
                <ul class="nav-main">
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" ><i class="fa fa-book"></i><span class="sidebar-mini-hide">Licencias</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('license.index') }}"><i class="si si-book-open"></i>Licencias</a>
                            </li>
                            <li>
                                <a href="{{ route('titularitychange.index') }}"><i class="si si-user"></i>Cambios de titularidad</a>
                            </li>
                            <li>
                                <a href="{{ route('mapa') }}"><i class="fa fa-map-marker"></i>Mapa</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-bell"></i><span class="sidebar-mini-hide">Alertas</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('alert.index') }}"><i class="si si-list"></i>Listado de alertas</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-bar-chart"></i><span class="sidebar-mini-hide">Estad&iacute;sticas</span></a>
                    </li>

                @if(Auth::user()->is(1))
                    <li>
                        <a  href="{{ route('titular.index') }}"><i class="fa fa-users"></i><span class="sidebar-mini-hide">Titulares</span></a>
                    </li>
                    <li>
                        <a href="{{ route('person.index') }}"><i class="fa fa-user-md"></i><span class="sidebar-mini-hide">Personas de visita</span></a>
                    </li>
                    <li>
                        <a href="{{ route('loan.index') }}"><i class="fa fa-exchange"></i><span class="sidebar-mini-hide">Prestamos</span></a>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" ><i class="glyphicon glyphicon-screenshot"></i><span class="sidebar-mini-hide">Reparos</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('license.index') }}"><i class="glyphicon glyphicon-screenshot"></i>Reparos</a>
                            </li>
                            <li>
                                <a href="{{ route('titularitychange.index') }}"><i class="glyphicon glyphicon-alert"></i>Notificaciones de reparos</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('denunciation.index') }}"><i class="fa fa-balance-scale"></i><span class="sidebar-mini-hide">Denuncias</span></a>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" ><i class="si si-settings"></i><span class="sidebar-mini-hide">Configuracion</span></a>
                        <ul>
                            <li>
                                <a href="{{ route('licensetype.index') }}">Tipos de licencias</a>
                            </li>
                            <li>
                                <a href="{{ route('licensestage.index') }}">Pasos de Licencia</a>
                            </li>
                            <li>
                                <a href="{{ route('licensecurrentstage.index') }}">Etapas de licencias</a>
                            </li>
                            <li>
                                <a href="{{ route('licensetypestage.index') }}">Asignacion de pasos</a>
                            </li>
                            <li>
                                <a href="{{ route('licensestatus.index') }}">Estados de licencias</a>
                            </li>
                            <li>
                                <a href="{{ route('street.index') }}">Direcciones</a>
                            </li>
                            <li>
                                <a href="{{ route('activity.index') }}">Actividades</a>
                            </li>
                            <li>
                                <a href="{{ route('archive.index') }}">Archivadores</a>
                            </li>
                            <li>
                                <a href="{{ route('personposition.index') }}">Posiciones</a>
                            </li>
                            <li>
                                <a href="{{ route('file.index') }}">Documentos</a>
                            </li>
                            <li>
                                <a href="{{ route('timelimit.index') }}">Tiempos de limites de entrega</a>
                            </li>
                        </ul>
                    </li>

                @endif
                </ul>
            </div>
            <!-- END Side Content -->
        </div>
        <!-- Sidebar Content -->
    </div>
    <!-- END Sidebar Scroll Container -->
</nav>
<!-- END Sidebar -->