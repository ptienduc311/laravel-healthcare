@extends('layouts.auth')

@section('title', 'Quên mật khẩu')
@section('content')
<div>
    <div class="mb-4 text-center">
        <h3 class="mb-1">Quên mật khẩu</h3>
        <p>Vui lòng nhập địa chỉ email của bạn để nhận mã xác minh</p>
    </div>
    <div>
        <form action="{{route('reset.send_code')}}" method="POST">
            @csrf
            <div class="form-container vertical">
                <div class="form-item vertical">
                    <input class="input" type="text" name="email" autocomplete="off" placeholder="Nhập e-mail của bạn" value="{{old('email')}}">
                    @error('email')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>
                <button class="btn btn-solid w-full" type="submit">Xác nhận</button>
                <div class="mt-4 text-center">
                    <span>Quay lại </span>
                    <a class="text-primary-600 hover:underline" href="{{route('login')}}">Đăng nhập</a>
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

            toastr.error("{{session('error')}}", "Yêu cầu khôi phục không hợp lệ")
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