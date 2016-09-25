<!DOCTYPE html>
<html lang="es">
<head>
    <title>CityBoard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/smoothness/jquery-ui-1.10.4.custom.min.css') }}">
    --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('css/oneui.css') }}">


    @yield('scripts_at_head')
</head>
<body class="bg-image" style="background-image: url('{{ asset('img/photos/photo17@2x.jpg') }}');">
    <div class="container-fluid">
        <div class="row lightgray">
             @yield('content')
        </div>
    </div>

    <!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/core/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/core/jquery.scrollLock.min.js') }}"></script>
    <script src="{{ asset('js/core/jquery.appear.min.js') }}"></script>
    <script src="{{ asset('js/core/jquery.countTo.min.js') }}"></script>
    <script src="{{ asset('js/core/jquery.placeholder.min.js') }}"></script>
    <script src="{{ asset('js/core/js.cookie.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{ asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

    <script src="{{ asset('js/pages/base_pages_login.js') }}"></script>

@yield('scripts_at_body')
</body>

</html>
