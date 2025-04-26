@extends('layouts.auth')

@section('title', 'Đặt lại mật khẩu')
@section('content')
<div>
    <div class="mb-4 text-center">
        <h3 class="mb-1">Đặt lại mật khẩu</h3>
        <p>Hãy đặt mật khẩu mới an toàn!</p>
    </div>
    <div>
        <form action="{{route('update.pass', $reset_token)}}" method="POST">
            @csrf
            <div class="form-container vertical">
                <div class="form-item vertical">
                    <label class="form-label mb-2">Mật khẩu</label>
                    <div>
                        <span class="input-wrapper">
                            <input class="input pr-8 password-input" type="password" name="password" autocomplete="off" placeholder="Nhập mật khẩu mới">
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
                <button class="btn btn-solid w-full" type="submit">Xác nhận</button>
                <div class="mt-4 text-center">
                    <span>Quay lại</span>
                    <a class="text-primary-600 hover:underline" href="{{route('login')}}">Đăng nhập</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection