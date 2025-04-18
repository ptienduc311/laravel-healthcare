@extends('layouts.app')

@section('title', 'Đặt lịch khám')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/css/listdoctor.css ') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/doctor.css ') }}">
@stop

@section('content')
<div id="main-content">
    <div class="header-category" style="background-image: url(https://medlatec.vn/med/images/breadcrumb4.jpg);">
        <div class="container">
            <h1>Đặt lịch khám</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/">Trang chủ</a>
                </li>
                <li class="active">Đặt lịch khám</li>
            </ol>
        </div>
    </div>
    <div class="container-1200">
        <div class="doctor-single">
            <div class="make-appointment">
                <div class="book-title">Đặt lịch khám cùng chuyên gia</div>
                <div class="book-note">Quý khách hàng vui lòng điền thông tin để đặt lịch thăm khám cùng <span style="color: #1D93E3;">PGS.TS.BSCC Nguyễn Quốc Dũng</span></div>
                <div class="bookings">
                    <form action="" method="post">
                        <div class="form">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Họ và tên <sup>*</sup></label>
                                    <div class="control">
                                        <input type="text" name="patientName" class="form-control" id="patientName" placeholder="Nhập họ và tên">
                                        <div class="error" style="display: none;" id="patientName-error">Họ và tên không được để trống</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Số điện thoại <sup>*</sup></label>
                                    <div class="control">
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Nhập số điện thoại">
                                        <div class="error" style="display: none;" id="phone-error">Số điện thoại không được để trống</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Ngày sinh <sup>*</sup></label>
                                    <div class="control">
                                        <input type="date" name="patientBirthDate" class="form-control" id="patientBirthDate">
                                        <div class="error" style="display: none;" id="patientBirthDate-error">Ngày sinh không hợp lệ</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Email <sup>*</sup></label>
                                    <div class="control">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Nhập email">
                                        <div class="error" style="display: none;" id="email-error">Email không được để trống</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Giới tính <sup>*</sup></label>
                                    <div class="control">
                                        <select name="patientSex" class="form-control" id="patientSex">
                                            <option>Chọn giới tính</option>
                                            <option value="male">Nam</option>
                                            <option value="female">Nữ</option>
                                        </select>
                                        <div class="error" style="display: none;" id="patientBirthDate-error">Giới tính không được để trống</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Tỉnh/Thành phố <sup>*</sup></label>
                                    <div class="control filter-province">
                                        <div class="select-btn form-control">
                                            <span style="color: 4f4f4f;opacity: 0.5;font-weight: 600;">Chọn Tỉnh/Thành phố</span>
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
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Quận/Huyện <sup>*</sup></label>
                                    <div class="control">
                                        <select name="district" class="form-control" id="district">
                                        </select>
                                        <div class="error" style="display: none;" id="district-error">Quận/Huyện không được để trống</div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Phường/Xã <sup>*</sup></label>
                                    <div class="control">
                                        <select name="ward" class="form-control" id="ward">
                                        </select>
                                        <div class="error" style="display: none;" id="ward-error">Phường/Xã không được để trống</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Địa chỉ <sup>*</sup></label>
                                    <div class="control">
                                        <input type="text" name="address" id="address" class="form-control" placeholder="Nhập địa chỉ">
                                        <div class="error" style="display: none;" id="email-error">Địa chỉ không được để trống</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Chuyên khoa <sup>*</sup></label>
                                    <div class="control">
                                        <input type="text" name="special" id="special" class="form-control" value="Chuẩn đoán hình ảnh">
                                        <div class="error" style="display: none;" id="special-error">Quận/Huyện không được để trống</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Ngày khám <sup>*</sup></label>
                                    <div class="control">
                                        <input type="date" name="appointmentDate" id="appointmentDate" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Ngày khám <sup>*</sup></label>
                                    <div class="control">
                                        <input type="date" name="appointmentDate" id="appointmentDate" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Chọn giờ <sup>*</sup></label>
                                    <div class="control swiper swiperTimeMeet">
                                        <div class="swiper-wrapper">
                                        </div>
                                        <div class="swiper-button-prev">
                                            <i class="fa-solid fa-angle-left"></i>
                                        </div>
                                        <div class="swiper-button-next">
                                            <i class="fa-solid fa-angle-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Nội dung yêu cầu <sup>*</sup></label>
                                    <div class="control">
                                        <textarea name="reasonNote" id="reasonNote" class="form-control" placeholder="Tôi cảm thấy..."></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn-book btn btn-primary">Đặt lịch</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection