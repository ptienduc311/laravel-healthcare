<!DOCTYPE html>
<html lang="en" dir="ltr" class="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="img/favicon.ico">
    <title>@yield('title')</title>

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
                                <div class="card-body md:p-10">
                                    <div class="text-center">
                                        <div class="logo">
                                            <img class="mx-auto" src="img/logo/logo-light-streamline.png"
                                                alt="Elstar logo">
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

    {{-- <script src="{{ asset('auth/js/app.min.js') }}"></script> --}}

    @yield('custom-js')
</body>

</html>