<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    {{-- ngrok --}}
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/components/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/components/swiper/css/swiper-bundle.min.css') }}">
    <!-- Toastr style -->
    <link href="{{ asset('assets/css/plugins/toastr.min.css') }}" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="{{ asset('assets/css/plugins/sweetalert.css') }}" rel="stylesheet">
    <!-- Date Picker -->
    <link href="{{ asset('assets/css/plugins/datepicker3.css') }}" rel="stylesheet">
    <!-- Ladda style -->
    <link href="{{ asset('assets/css/plugins/ladda-themeless.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/global.css ') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css ') }}">
    @yield('custom-css')
</head>

<body>
    <div id="wrapper">
        <!-- header -->
        @include('inc_themes.header')
        <!-- end header -->
        <!-- content -->

        @yield('content')

        <div id="overlay"></div>
        <button id="backToTop" class="back-to-top">
            <i class="fa-solid fa-angle-up"></i>
        </button>
        <!-- end content -->
        <!-- footer -->
        @include('inc_themes.footer')
        <!-- end footer -->
    </div>

    <script src="{{asset('assets/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/components/swiper/js/swiper-bundle.min.js')}}"></script>
    <!-- Toastr script -->
    <script src="{{asset('assets/js/plugins/toastr.min.js') }}"></script>
    <!-- Sweet alert -->
    <script src="{{asset('assets/js/plugins/sweetalert.min.js') }}"></script>
    <!-- Date picker -->
    <script src="{{asset('assets/js/plugins/bootstrap-datepicker.js') }}"></script>
    <!-- Ladda -->
    <script src="{{asset('assets/js/plugins/spin.min.js') }}"></script>
    <script src="{{asset('assets/js/plugins/ladda.min.js') }}"></script>
    <script src="{{asset('assets/js/plugins/ladda.jquery.min.js') }}"></script>
    <script src="{{asset('assets/js/index.js')}}"></script>
    @yield('custom-js')
</body>

</html>