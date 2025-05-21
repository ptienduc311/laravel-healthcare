<!DOCTYPE html>
<html lang="en" dir="ltr" class="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>@yield('title')</title>
    
    {{-- ngrok --}}
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <link href="{{ asset('auth/css/font-awesome.css') }}" rel="stylesheet">
    <!-- Toastr style -->
    <link href="{{ asset('auth/css/plugins/toastr.min.css') }}" rel="stylesheet">

    <!-- Core CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/custom.css') }}">
</head>

<body>
    <!-- App Start-->
    <div id="root">
        <!-- App Layout-->
        <div class="app-layout-blank flex flex-auto flex-col h-[100vh]">
            <main class="h-full">
                <div class="page-container relative h-full flex flex-auto flex-col">
                    <div class="h-full">
                        <div class="container mx-auto flex flex-col flex-auto items-center justify-center min-w-0 h-full">
                            <div class="card min-w-[320px] md:min-w-[450px] card-shadow" role="presentation">
                                <div class="card-body md:p-10 pos-relative">
                                    <a class="back-home" href="{{ route('home') }}" title="Quay lại trang chủ">
                                        <i class="fa fa-home"></i>
                                    </a>
                                    <div class="text-center logo">
                                        <div class="logo-img">
                                            <img class="mx-auto avatar-img" src="{{ asset('assets/images/logo-big.png') }}" alt="HealthCare logo">
                                        </div>
                                    </div>
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Toastr -->
    <script src="{{ asset('auth/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('auth/js/plugins/toastr.min.js') }}"></script>

    <script>
        const eyeShow = "{{ asset('auth/eye-show.svg') }}";
        const eyeHide = "{{ asset('auth/eye-hide.svg') }}";
    </script>
    
    <script src="{{ asset('auth/js/app.js') }}"></script>

    @yield('custom-js')
</body>

</html>