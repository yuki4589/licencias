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
                        </ul>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-bell"></i><span class="sidebar-mini-hide">Alertas</span></a>
                    </li>
                    <li>
                        <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-bar-chart"></i><span class="sidebar-mini-hide">Estad&iacute;sticas</span></a>
                    </li>
                </ul>
            </div>
            <!-- END Side Content -->
        </div>
        <!-- Sidebar Content -->
    </div>
    <!-- END Sidebar Scroll Container -->
</nav>
<!-- END Sidebar -->