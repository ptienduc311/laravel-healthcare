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
                            <input class="input pr-8" type="password" name="password" autocomplete="off" placeholder="Nhập mật khẩu mới">
                            <div class="input-suffix-end">
                                <span class="cursor-pointer text-xl">
                                    <svgstroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                    </svgstroke=>
                                </span>
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
                            <input class="input pr-8" type="password" name="password_confirmation" autocomplete="off" placeholder="Nhập lại mật khẩu">
                            <div class="input-suffix-end">
                                <span class="cursor-pointer text-xl">
                                    <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                                    </svg>
                                </span>
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