@extends('layouts.auth')

@section('title', 'Đăng nhập')
@section('content')
<div>
    <div class="mb-4 text-center">
        <h3 class="mb-1">Chào mừng bạn quay trở lại!</h3>
        <p>Vui lòng nhập thông tin để đăng nhập!</p>
    </div>
    <div>
        <form action="{{ route('login.handle') }}" method="POST">
            @csrf
            <div class="form-container vertical">
                <div class="form-item vertical">
                    <label class="form-label mb-2">E-mail</label>
                    <div>
                        <input class="input" type="text" name="email" autocomplete="off" placeholder="E-mail" value="{{old('email')}}">
                    </div>
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-item vertical">
                    <label class="form-label mb-2">Mật khẩu</label>
                    <div>
                        <span class="input-wrapper">
                            <input class="input pr-8 password-input" type="password" name="password" autocomplete="off" placeholder="Mật khẩu">
                            <div class="input-suffix-end toggle-password">
                                <img src="{{ asset('auth/eye-hide.svg') }}" alt="">
                            </div>
                        </span>
                    </div>
                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-between mb-6">
                    <label class="checkbox-label mb-0">
                        <input class="checkbox" type="checkbox" name="remember" value="true">
                        <span class="ltr:ml-2 rtl:mr-2">Ghi nhớ đăng nhập</span>
                    </label>
                    <a class="text-primary-600 hover:underline" href="{{ route('reset.pass') }}">Quên mật khẩu?</a>
                </div>
                <button class="btn btn-solid w-full" type="submit">Đăng nhập</button>
                <div class="mt-4 text-center">
                    <span>Bạn chưa có tài khoản?</span>
                    <a class="text-primary-600 hover:underline" href="{{ route('register') }}">Đăng ký</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('custom-js')
    @if (session('error'))
        <script>
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "progressBar": true,
                "preventDuplicates": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "10000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            toastr.error("{{session('error')}}", "Tài khoản chưa được xác nhận")
        </script>
    @endif

    @if (session('success'))
        <script>
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "progressBar": true,
                "preventDuplicates": false,
                "positionClass": "toast-top-right",
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "10000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            toastr.success("{{session('success')}}")
        </script>
    @endif

    @if (session('blocked'))
        <script>
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "progressBar": false,
                "preventDuplicates": false,
                "positionClass": "toast-top-center",
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "10000",
                "timeOut": "60000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            toastr.error("Vui lòng liên hệ với quản trị viên", "{{session('blocked')}}")
        </script>
    @endif

    @if (session('no-access'))
        <script>
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "progressBar": false,
                "preventDuplicates": false,
                "positionClass": "toast-top-center",
                "onclick": null,
                "showDuration": "400",
                "hideDuration": "10000",
                "timeOut": "60000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }

            toastr.error("{{session('no-access')}}")
        </script>
    @endif
@endsection