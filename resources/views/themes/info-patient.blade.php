@extends('layouts.app')

@section('title', 'Đội ngũ chuyên gia')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/css/listdoctor.css ') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/doctor.css ') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/findbook.css ') }}">
@stop

@section('content')
<div id="main-content">
    <div class="header-category" style="background-image: url(https://medlatec.vn/med/images/breadcrumb4.jpg);">
        <div class="container">
            <h1>Tài khoản</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/">Trang chủ</a>
                </li>
                <li class="active">Thông tin tài khoản</li>
            </ol>
        </div>
    </div>
    <div class="container">
        <div class="booking-search-wrapper py-5">
            <h2 class="text-center mb-4 text-primary">Thông tin bệnh nhân</h2>
            <form action="{{ route('patient.update') }}" method="POST" class="booking-search-form mx-auto">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Họ tên <span class="claim">*</span></label>
                        <input type="text" name="name" id="name" class="form-control mb-3" placeholder="Nhập họ tên" value="{{ old('name', $patient->name) }}">
                        @error('name')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email <span class="claim">*</span></label>
                        <input type="text" name="email" id="email" class="form-control mb-3" placeholder="Nhập email" value="{{ old('email', $patient->email) }}" readonly>
                        @error('email')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" id="phone" class="form-control mb-3" placeholder="Nhập số điện thoại" value="{{ old('phone', $patient->phone) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="birth" class="form-label">Ngày sinh</label>
                        <input type="text" name="birth" id="birth" class="form-control mb-3" 
                        value="{{ old('birth', $patient->birth) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="gender" class="form-label">Giới tính</label>
                        <select name="gender" id="gender" class="form-control mb-3">
                            <option value="">Chọn giới tính</option>
                            <option value="1" {{ $patient->gender == 1 ? 'selected' : '' }}>Nam</option>
                            <option value="2" {{ $patient->gender == 2 ? 'selected' : '' }}>Nữ</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="province" class="form-label">Tỉnh/Thành phố</label>
                        <div class="control filter-province">
                            <div class="select-btn form-control">
                                <span style="color: 4f4f4f;opacity: 0.5;font-weight: 600;"></span>
                                <i class="fa-solid fa-angle-down"></i>
                            </div>
                            <div class="options-content">
                                <div class="search">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                    <input type="text" placeholder="Search" class="search-input">
                                </div>
                                <ul class="options" id="province">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="district" class="form-label">Quận/Huyện</label>
                        <select name="district" id="district" class="form-control mb-3">
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="ward" class="form-label">Xã/Phường</label>
                        <select name="ward" id="ward" class="form-control mb-3">
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" name="address" id="address" class="form-control mb-3" placeholder="Nhập địa chỉ" value="{{ old('address', $patient->address) }}">
                    </div>
                    <input type="hidden" name="province_id" id="province-id" value="{{ $patient->province_id }}">
                    <input type="hidden" name="district_id" id="district-id" value="{{ $patient->district_id }}">
                    <input type="hidden" name="ward_id" id="ward-id" value="{{ $patient->ward_id }}">
                    <div class="d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </form>
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

    @if (session('warning'))
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

        toastr.warning("{{session('warning')}}")
    </script>
@endif
<script>
    $('#birth').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true
    });
</script>
@endsection