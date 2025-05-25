@extends('layouts.admin')

@section('title', 'Sửa lịch khám bệnh')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Thiết lập site</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">Trang chủ</a>
            </li>
            <li class="active">
                <a>Thiết lập site</a>
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
                    <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('admin.site_update') }}" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Số điện thoại</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ old('phone', $site?->phone) }}" name="phone">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Hotline</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ old('hotline', $site?->hotline) }}" name="hotline">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ old('email', $site?->email) }}" name="email">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Địa chỉ</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ old('address', $site?->address) }}" name="address">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Link Facebook</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ old('link_facebook', $site?->link_facebook) }}" name="link_facebook">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Link Zalo</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ old('link_zalo', $site?->link_zalo) }}" name="link_zalo">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Link Youtube</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="{{ old('link_youtube', $site?->link_youtube) }}" name="link_youtube">
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