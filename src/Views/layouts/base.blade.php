<!DOCTYPE html>
<html lang="{{ LOCALE }}">

<head>
    {{-- META TAGS --}}
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="author" content="{{ AUTHOR }}">
    <meta name="{{ XSRF_KEY }}" content="{{ $_SESSION[XSRF_KEY] }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:url" content="@yield('url')">
    <meta property="og:image" content="@yield('image')">
    <meta property="og:description" content="@yield('description')">
    <meta property="business:contact_data:street_address" content="{{ STREET_ADDRESS }}">
    <meta property="business:contact_data:country_name" content="{{ COUNTRY }}">
    {{-- END META TAGS --}}

    {{-- LINK TAGS --}}
    <link rel="shortcut icon" href="{{ Dir::assets('img/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ Dir::assets('img/logo.png') }}">
    <link rel="stylesheet" href="{{ Dir::assets('libs/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ Dir::assets('libs/bootstrap-icons/font/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ Dir::assets('css/style.css') }}">
    {{-- END LINK TAGS --}}

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
    <div id="base-layout">
        <div id="alert-container"></div>
        @yield('base-content')
    </div>
    {{-- END LAYOUT --}}

    {{-- LIB SCRIPTS --}}
    <script src="{{ Dir::assets('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ Dir::assets('libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ Dir::assets('js/main.js') }}"></script>
    {{-- END LIB SCRIPTS --}}

    {{-- MODULE SCRIPTS --}}
    <script src="{{ Dir::assets('js/modules/alert.module.js') }}"></script>
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
