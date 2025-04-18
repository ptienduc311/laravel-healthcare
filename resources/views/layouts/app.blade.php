<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css">

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="{{ asset('assets/components/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/components/swiper/css/swiper-bundle.min.css') }}">
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
        <!-- end content -->
        <!-- footer -->
        @include('inc_themes.footer')
        <!-- end footer -->
    </div>

    <script src="{{asset('assets/components/swiper/js/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/index.js')}}"></script>
    @yield('custom-js')
</body>

</html>