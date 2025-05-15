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
                <div class="book-note">Quý khách hàng vui lòng điền thông tin để đặt lịch thăm khám cùng bác sĩ</div>
                <div class="bookings">
                    <form action="/api-save-book" method="post" id="form-book">
                        @csrf
                        <div class="form">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Họ và tên <sup>*</sup></label>
                                    <div class="control">
                                        <input type="text" name="name" class="form-control" id="patientName" placeholder="Nhập họ và tên">
                                        <div class="error" id="patientName-error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Số điện thoại <sup>*</sup></label>
                                    <div class="control">
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Nhập số điện thoại">
                                        <div class="error" id="phone-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Ngày sinh <sup>*</sup></label>
                                    <div class="control">
                                        <input type="date" name="birth" class="form-control" id="patientBirthDate">
                                        <div class="error" id="patientBirthDate-error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Email <sup>*</sup></label>
                                    <div class="control">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Nhập email">
                                        <div class="error" id="email-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Giới tính <sup>*</sup></label>
                                    <div class="control">
                                        <select name="gender" class="form-control" id="patientSex">
                                            <option>Chọn giới tính</option>
                                            <option value="male">Nam</option>
                                            <option value="female">Nữ</option>
                                        </select>
                                        <div class="error" id="patientSex-error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Tỉnh/Thành phố <sup>*</sup></label>
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
                                        <div class="error" id="province-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Quận/Huyện <sup>*</sup></label>
                                    <div class="control">
                                        <select class="form-control" id="district">
                                        </select>
                                        <div class="error" id="district-error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Phường/Xã <sup>*</sup></label>
                                    <div class="control">
                                        <select class="form-control" id="ward">
                                        </select>
                                        <div class="error" id="ward-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Địa chỉ <sup>*</sup></label>
                                    <div class="control">
                                        <input type="text" name="address" id="address" class="form-control" placeholder="Nhập địa chỉ">
                                        <div class="error" id="address-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Chuyên khoa</label>
                                    <div class="control">
                                        <select name="specialty_id" id="specialty-id" class="form-control">
                                            <option value="">---- Chọn chuyên khoa ----</option>
                                            @foreach ($specialties as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="error" id="specialty-id-error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Bác sĩ</label>
                                    <div class="control group-doctor">
                                        <div class="form-control show-name-doctor disabled">Chọn bác sĩ</div>
                                        <div class="show-list-doctor">
                                            <div data-doctor-id="1" class="item-doctor">
                                                <img src="{{ asset('assets/images/female-doctor.jpg')}}" title="Ảnh bác sĩ" class="avatar">
                                                <div class="name">Bác sĩ abc</div>
                                            </div>
                                        </div>
                                        <div class="error" id="doctor-id-error"></div>
                                        <input type="hidden" name="doctor_id" id="doctor-id" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Ngày khám <sup>*</sup></label>
                                    <div class="control">
                                        <input type="date" name="appointmentDate" id="appointmentDate" class="form-control">
                                        <div class="error" id="appointmentDate-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Chọn giờ <sup>*</sup></label>
                                    <div class="control list-times" id="time-slot-list">
                                        <div class="error-message">Vui lòng chọn ngày để xem giờ khám.</div>
                                    </div>
                            <div class="error" id="time-error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Nội dung yêu cầu <sup>*</sup></label>
                                    <div class="control">
                                        <textarea name="reason" id="reasonNote" class="form-control" placeholder="Tôi cảm thấy..."></textarea>
                                        <div class="error" id="reasonNote-error"></div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="province_id" id="province-id">
                            <input type="hidden" name="district_id" id="district-id">
                            <input type="hidden" name="ward_id" id="ward-id">
                            <button type="submit" class="btn-book btn btn-primary">Đặt lịch</button>
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

            toastr.success("{{session('success')}}", "Đặt lịch hẹn thành công")
        </script>
    @endif
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

            toastr.error("{{session('error')}}")
        </script>
    @endif
    <script>
        $(document).ready(function () {
            const specialtySelect = $('#specialty-id');
            const doctorList = $('.show-list-doctor');
            const showNameDoctor = $('.show-name-doctor');
            const doctorIdInput = $('#doctor-id');
            const groupDoctor = $('.group-doctor');

            let doctorsData = [];

            showNameDoctor.on('click', function () {
                if (!$(this).hasClass('disabled') && doctorsData.length > 0) {
                    doctorList.toggle();
                }
            });

            // Chọn một chuyên khoa
            specialtySelect.on('change', function () {
                const specialtyId = $(this).val();

                doctorsData = [];
                doctorIdInput.val('');
                doctorList.empty().hide();
                showNameDoctor.addClass('disabled').text('Chọn bác sĩ');

                if (!specialtyId) return;

                $.ajax({
                    url: '/api-get-doctors',
                    type: 'GET',
                    data: { specialty_id: specialtyId },
                    success: function (response) {
                        if (response.status == 'success' && response.doctors.length > 0) {
                            doctorsData = response.doctors;

                            response.doctors.forEach(function (doctor) {
                                const doctorItem = `
                                    <div class="item-doctor" data-doctor-id="${doctor.id}" data-doctor-name="${doctor.name}">
                                        <img src="${doctor.avatar_url}" title="Ảnh bác sĩ" class="avatar">
                                        <div class="name">${doctor.name}</div>
                                    </div>`;
                                doctorList.append(doctorItem);
                            });
                            showNameDoctor.removeClass('disabled').text('Chọn bác sĩ');
                        } else {
                            showNameDoctor.addClass('disabled').html(`<p class="error">Không có bác sĩ</p>`);
                            toastr.options = {
                                "closeButton": false,
                                "debug": false,
                                "progressBar": true,
                                "preventDuplicates": false,
                                "positionClass": "toast-top-right",
                                "onclick": null,
                                "showDuration": "400",
                                "hideDuration": "10000",
                                "timeOut": "3000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            };
                            toastr.warning(response.message, "Không có bác sĩ");
                        }
                    },
                    error: function () {
                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "progressBar": true,
                            "preventDuplicates": false,
                            "positionClass": "toast-top-right",
                            "onclick": null,
                            "showDuration": "400",
                            "hideDuration": "10000",
                            "timeOut": "3000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };
                        toastr.warning("Đã xảy ra lỗi khi tải bác sĩ.");
                    }
                });
            });

            // Khi click chọn một bác sĩ
            groupDoctor.on('click', '.item-doctor', function () {
                doctorList.find('.item-doctor').removeClass('selected');
                $(this).addClass("selected");
                
                const doctorId = $(this).data('doctor-id');
                const doctorName = $(this).data('doctor-name');
                doctorIdInput.val(doctorId);
                showNameDoctor.text(doctorName);
                doctorList.hide();
            });

            // Nhấn lại chuyên khoa khác → reset toàn bộ
            specialtySelect.on('change', function () {
                doctorIdInput.val('');
                doctorList.empty().hide();
                showNameDoctor.addClass('disabled').text('Chọn bác sĩ');
            });

            $(document).on('click', function (e) {
                const target = $(e.target);
                const isInsideDoctorGroup = target.closest('.group-doctor').length > 0;

                if (!isInsideDoctorGroup) {
                    doctorList.hide();
                }
            });

        });
    </script>
@endsection