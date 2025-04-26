@extends('layouts.auth')

@section('title', 'Đăng ký')
@section('content')
<div>
    <div class="mb-4">
        <h3 class="mb-1 text-center">Đăng ký</h3>
    </div>
    <div>
        <form action="{{ route('register.handle') }}" method="POST">
            @csrf
            <div class="form-container vertical">
                <div class="form-item vertical">
                    <label class="form-label mb-2">Tên người dùng</label>
                    <div>
                        <input class="input" type="text" name="username" autocomplete="off" placeholder="Nhập tên người dùng" value="{{old('username')}}">
                    </div>
                    @error('username')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-item vertical">
                    <label class="form-label mb-2">E-mail</label>
                    <div>
                        <input class="input" type="text" name="email" autocomplete="off" placeholder="Nhập e-mail" value="{{old('email')}}">
                    </div>
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-item vertical">
                    <label class="form-label mb-2">Mật khẩu</label>
                    <div>
                        <span class="input-wrapper">
                            <input class="input pr-8 password-input" type="password" name="password" autocomplete="off" placeholder="Nhập mật khẩu">
                            <div class="input-suffix-end toggle-password">
                                <img src="{{ asset('auth/eye-hide.svg') }}" alt="">
                            </div>
                        </span>
                    </div>
                    @error('password')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-item vertical">
                    <label class="form-label mb-2">Xác nhận mật khẩu</label>
                    <div>
                        <span class="input-wrapper">
                            <input class="input pr-8 password-input" type="password" name="password_confirmation" autocomplete="off" placeholder="Nhập lại mật khẩu">
                            <div class="input-suffix-end toggle-password">
                                <img src="{{ asset('auth/eye-hide.svg') }}" alt="">
                            </div>
                        </span>
                    </div>
                </div>
                <button class="btn btn-solid w-full" type="submit">Đăng ký</button>
                <div class="mt-4 text-center">
                    <span>Bạn đã có tài khoản?</span>
                    <a class="text-primary-600 hover:underline" href="{{ route('login') }}">Đăng nhập</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('custom-js')
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