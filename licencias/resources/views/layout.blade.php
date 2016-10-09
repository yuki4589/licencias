<!DOCTYPE html>
<html lang="es">
<head>
    <title>CityBoard @yield('pageTitle')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset(env('FAVICO')) }}">
    <link rel="apple-touch-icon" href="{{ asset(env('FAVICO')) }}">
    <link rel="image_src" type="image/png" href="{{ asset(env('FAVICO')) }}" />

    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">

    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/slick/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/slick/slick-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/css/oneui.css') }}">
    <link rel="stylesheet" id="css-theme" href="{{ asset('assets/css/themes/flat.min.css') }}">

    <link rel="stylesheet" href="{{ asset('plugin/bootstrap-calendar-master/css/calendar.css') }}">


    <!-- angular advanced searchbox includes -->
    <link rel="stylesheet" href="{{ asset('bower_components/angular-advanced-searchbox/dist/angular-advanced-searchbox.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css') }}">

    <style>
        [ng-cloak]
        {
            display: none !important;
        }
    </style>
    @yield('scripts_at_head')

</head>
<body>
    <!-- Page Container -->
    <!--
        Available Classes:

        'enable-cookies'             Remembers active color theme between pages (when set through color theme list)

        'sidebar-l'                  Left Sidebar and right Side Overlay
        'sidebar-r'                  Right Sidebar and left Side Overlay
        'sidebar-mini'               Mini hoverable Sidebar (> 991px)
        'sidebar-o'                  Visible Sidebar by default (> 991px)
        'sidebar-o-xs'               Visible Sidebar by default (< 992px)

        'side-overlay-hover'         Hoverable Side Overlay (> 991px)
        'side-overlay-o'             Visible Side Overlay by default (> 991px)

        'side-scroll'                Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (> 991px)

        'header-navbar-fixed'        Enables fixed header
    -->
    <div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed">

        @include('generals.menu.menu')
        @include('generals.menu.authMenu')
        <!-- Main Container -->
        <main id="main-container">
            @if(View::hasSection('title'))
                <div class="content bg-gray-lighter">
                    <h1 class="page-heading push">
                        @yield('title')
                    </h1>
                </div>
            @endif

            <div class="content content-boxed">
                @yield('content')
            </div>
        </main>
        <!-- END Main Container -->
    </div>

    <!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
    <script src="//code.jquery.com/jquery-2.2.3.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bower_components/angular-animate/angular-animate.min.js') }}"></script>
    <script src="https://rawgit.com/angular-ui/bootstrap/gh-pages/ui-bootstrap-tpls-1.3.2.min.js"></script>
    <script src="{{ asset('bower_components/angular-advanced-searchbox/dist/angular-advanced-searchbox-tpls.js') }}"></script>
    <script src="{{ asset('bower_components/angularUtils-pagination/dirPagination.js') }}"></script>

    <script src="{{ asset('assets/js/core/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/jquery.scrollLock.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/jquery.countTo.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/jquery.placeholder.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/js.cookie.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <!-- Page Plugins -->

    <script src="{{ asset('assets/js/plugins/slick/slick.min.js') }}"></script>

    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/base_tables_datatables.js') }}"></script>

    <script src="{{ asset('plugin/bootstrap-calendar-master/components/underscore/underscore-min.js') }}"></script>
    <script src="{{ asset('plugin/bootstrap-calendar-master/js/calendar.js') }}"></script>
    <script src="{{ asset('plugin/bootstrap-calendar-master/js/language/es-ES.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-datetimepicker/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-datetimepicker/locale/es.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>

    <!-- Page JS Code -->
    <script>
        jQuery(function () {
            // Init page helpers (Slick Slider plugin)
            App.initHelpers('slick');
        });
    </script>


    <script src="{{ asset('js/angular-route.js') }}"></script>
    <script src="{{ asset('js/ng-file-upload-shim.min.js') }}"></script>
    <script src="{{ asset('js/ng-file-upload.min.js') }}"></script>
    <script src="{{ asset('js/sortable.js') }}"></script>

    @yield('scripts_at_body')
</body>

</html>
