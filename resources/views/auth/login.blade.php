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
                            <input class="input pr-8" type="password" name="password" autocomplete="off" placeholder="Mật khẩu" value="">
                            <div class="input-suffix-end">
                                <span class="cursor-pointer text-xl">
                                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </span>
                    </div>
                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-between mb-6">
                    <label class="checkbox-label mb-0">
                        <input class="checkbox" type="checkbox" name="remember" value="true" checked>
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
@endsection