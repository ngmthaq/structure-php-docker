<!DOCTYPE html>
<html lang="{{ LOCALE }}">

<head>
    {{-- META TAGS --}}
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- END META TAGS --}}

    @stack('meta')

    {{-- LINK TAGS --}}
    <link rel="shortcut icon" href="{{ Dir::assets('img/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ Dir::assets('img/logo.png') }}">
    <link rel="stylesheet" href="{{ Dir::assets('libs/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ Dir::assets('libs/bootstrap-icons/font/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ Dir::assets('css/style.css') }}">
    {{-- END LINK TAGS --}}

    @stack('link')

    <title>@yield('title')</title>

    {{-- ALERT CONTAINER CSS --}}
    <style>
        #alert-container {
            position: fixed;
            top: 8px;
            right: 8px;
            width: 400px;
        }
    </style>
    {{-- END ALERT CONTAINER CSS --}}

    @stack('css')

</head>

<body>
    {{-- LAYOUT --}}
    <div id="layout">
        <div id="alert-container"></div>
        @yield('base-content')
    </div>
    {{-- END LAYOUT --}}

    {{-- LIB SCRIPTS --}}
    <script src="{{ Dir::assets('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ Dir::assets('libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    {{-- END LIB SCRIPTS --}}

    @stack('js_libs')

    @stack('js_modules')

    {{-- MODULE SCRIPTS --}}
    <script src="{{ Dir::assets('js/modules/alert.module.js') }}"></script>
    <script src="{{ Dir::assets('js/main.js') }}"></script>
    {{-- END MODULE SCRIPTS --}}

    {{-- ALERT SCRIPT --}}
    @if (isset($flash_messages['alert_error']))
        <script>
            showAlert("{{ $flash_messages['alert_error'] }}", "danger");
        </script>
    @endif

    @if (isset($flash_messages['alert_success']))
        <script>
            showAlert("{{ $flash_messages['alert_success'] }}", "success");
        </script>
    @endif

    @if (isset($flash_messages['alert_normal']))
        <script>
            showAlert("{{ $flash_messages['alert_normal'] }}", "primary");
        </script>
    @endif
    {{-- END ALERT SCRIPT --}}

    @stack('js')
</body>

</html>
