@extends('layouts.admin')

@section('title', 'Sửa lịch khám bệnh')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Hồ sơ</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Trang chủ</a>
            </li>
            <li>
                <a>Hồ sơ</a>
            </li>
            <li class="active">
                <strong>Cập nhật hồ sơ</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('admin.profile_update') }}" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-4">
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}" name="email" disabled>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tên người dùng</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="{{ old('username', Auth::user()->name) }}" name="username">
                                @error('username')
                                    <p class="error">{{ $message }}</p>
                                @enderror    
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Mật khẩu</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control pe-5" value="" name="password">
                                <div class="toggle-password">
                                    <i class="fa fa-eye-slash"></i>
                                </div>
                                @error('password')
                                    <p class="error">{{ $message }}</p>
                                @enderror    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Xác nhận mật khẩu</label>
                            <div class="col-sm-4">
                                <input type="password" class="form-control pe-5" value="" name="password_confirmation">
                                <div class="toggle-password">
                                    <i class="fa fa-eye-slash"></i>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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