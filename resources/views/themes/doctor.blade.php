@extends('layouts.app')

@section('title', $doctor->name) {{-- Truyền biến --}}
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('assets/css/listdoctor.css ') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/doctor.css ') }}">
@stop

@section('content')
<div id="main-content">
    <div class="header-category" style="background-image: url(https://medlatec.vn/med/images/breadcrumb4.jpg);">
        <div class="container">
            <h1>Đội ngũ chuyên gia</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/">Trang chủ</a>
                </li>
                <li>
                    <a href="/doi-ngu-chuyen-gia">Đội ngũ chuyên gia</a>
                </li>
                <li class="active">{{ $doctor->name }}</li>
            </ol>
        </div>
    </div>
    <div class="container-1200">
        <div class="doctor-single">
            <div class="doctor-single-info row">
                <div class="col-md-4">
                    <div class="avatar">
                        <img src="{{ $doctor->avatar_url }}" alt="Ảnh {{$doctor->name}}">
                    </div>
                </div>
                <div class="doctor-single-detail col-md-8">
                    <div class="detail-top">
                        <div class="doctor-name">{{$doctor->name}}</div>
                        <div class="doctor-review"><span style="color: #1D93E3;">Đánh giá:</span> <i class="fa-solid fa-star" style="color: #FFD43B;"></i>5/5</div>
                    </div>
                    <div class="detail-end">
                        @if ($doctor->specialty && $doctor->specialty->status == 1)
                            <div class="doctor-special"><strong style="color: #1D93E3;">Chuyên khoa:</strong> {{ $doctor->specialty->name }}</div>
                        @endif
                        @if ($doctor->academic_title)
                            <div class="doctor-level"><strong style="color: #1D93E3;">Học hàm:</strong> {{ $academicTitles[$doctor->academic_title] }}</div>
                        @endif
                        @if ($doctor->degree)
                            <div class="doctor-level"><strong style="color: #1D93E3;">Học vị:</strong> {{ $degrees[$doctor->degree] }}</div>
                        @endif
                        @if ($doctor->experience)
                            <div class="doctor-level"><strong style="color: #1D93E3;">Số năm kinh nghiệm:</strong> {{ $doctor->experience }}</div>
                        @endif
                        {{-- <div class="doctor-price"><i class="fa-solid fa-hand-holding-dollar" style="color: #1D93E3;"></i> 500.000đ</div> --}}
                    </div>
                </div>
            </div>
            <div class="make-appointment" id="book-doctor">
                <div class="book-title">Đặt lịch khám cùng chuyên gia</div>
                <div class="book-note">Quý khách hàng vui lòng điền thông tin để đặt lịch thăm khám cùng <span style="color: #1D93E3;">{{ $doctor->name }}</span></div>
                <div class="bookings">
                    <form action="/api-save-book" method="post" id="form-book" data-require-specialty="0">
                        @csrf
                        <div class="form">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Họ và tên <span class="claim">*</span></label>
                                    <div class="control">
                                        <input type="text" name="name" class="form-control" id="patientName" placeholder="Nhập họ và tên">
                                        <div class="error" id="patientName-error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Số điện thoại <span class="claim">*</span></label>
                                    <div class="control">
                                        <input type="text" name="phone" id="phone" class="form-control" placeholder="Nhập số điện thoại">
                                        <div class="error" id="phone-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Ngày sinh <span class="claim">*</span></label>
                                    <div class="control">
                                        <input type="text" name="birth" class="form-control" id="patientBirthDate">
                                        <div class="error" id="patientBirthDate-error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Email <span class="claim">*</span></label>
                                    <div class="control">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Nhập email">
                                        <div class="error" id="email-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Giới tính <span class="claim">*</span></label>
                                    <div class="control">
                                        <select name="gender" class="form-control" id="patientSex">
                                            <option>Chọn giới tính</option>
                                            <option value="1">Nam</option>
                                            <option value="2">Nữ</option>
                                        </select>
                                        <div class="error" id="patientSex-error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Tỉnh/Thành phố <span class="claim">*</span></label>
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
                                    <label>Quận/Huyện <span class="claim">*</span></label>
                                    <div class="control">
                                        <select class="form-control" id="district">
                                        </select>
                                        <div class="error" id="district-error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12 form-group">
                                    <label>Phường/Xã <span class="claim">*</span></label>
                                    <div class="control">
                                        <select class="form-control" id="ward">
                                        </select>
                                        <div class="error" id="ward-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Địa chỉ <span class="claim">*</span></label>
                                    <div class="control">
                                        <input type="text" name="address" id="address" class="form-control" placeholder="Nhập địa chỉ">
                                        <div class="error" id="address-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Chuyên khoa</label>
                                    <div class="control">
                                        <input type="text" name="special" id="special" class="form-control" value="{{ $doctor->specialty?->name }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Ngày khám <span class="claim">*</span></label>
                                    <div class="control">
                                        <input type="date" name="appointmentDate" id="appointmentDate" class="form-control">
                                        <div class="error" id="appointmentDate-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Chọn giờ <span class="claim">*</span></label>
                                    <div class="control list-times" id="time-slot-list">
                                        <div class="error-message">Vui lòng chọn ngày để xem giờ khám.</div>
                                    </div>
                            <div class="error" id="time-error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 form-group">
                                    <label>Nội dung yêu cầu <span class="claim">*</span></label>
                                    <div class="control">
                                        <textarea name="reason" id="reasonNote" class="form-control" placeholder="Tôi cảm thấy..."></textarea>
                                        <div class="error" id="reasonNote-error"></div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="doctor_id" id="doctor-id" value="{{ $doctor->id }}">
                            <input type="hidden" name="specialty_id" id="specialty-id" value="{{ $doctor->specialty?->id }}">
                            <input type="hidden" name="province_id" id="province-id">
                            <input type="hidden" name="district_id" id="district-id">
                            <input type="hidden" name="ward_id" id="ward-id">
                            <button type="submit" class="btn-book btn btn-primary ladda-button">Đặt lịch hẹn</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="doctor-single-content">
                <div class="row">
                    <div class="col-lg-8">
                        @if ($doctor->introduce)
                            <div class="card-left introduce">
                                <div class="top-title">Giới thiệu</div>
                                <div class="main-content">
                                    {{-- hiển thị html: Purifier --}}
                                    {!! $doctor->introduce !!}
                                </div>  
                            </div>
                        @endif
                        @if ($doctor->doctor_training->isNotEmpty())
                            <div class="card-left train">
                                <div class="top-title">Quá trình đào tạo</div>
                                <div class="main-content">
                                    <ul style="list-style-type:circle; list-style-position: inside;">
                                        @foreach ($doctor->doctor_training as $item)
                                            <li>{{ $item->time_training ? $item->time_training . ": " : ''}}{{ $item->content_training }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-4">
                        @if ($doctor->doctor_works->isNotEmpty())
                            <div class="card-right workplace">
                                <div class="top-title">Nơi công tác</div>
                                <div class="main-content">
                                    <ul style="list-style-type:circle; list-style-position: inside;">
                                        @foreach ($doctor->doctor_works as $item)
                                            <li>{{ $item->time_work ? $item->time_work . ": " : ''}}{{ $item->content_work }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        @if ($doctor->doctor_prizes->isNotEmpty())
                            <div class="card-right prize">
                                <div class="top-title">Giải thưởng và ghi nhận</div>
                                <div class="main-content">
                                    <ul style="list-style-type:circle; list-style-position: inside;">
                                        @foreach ($doctor->doctor_prizes as $item)
                                            <li>{{ $item->content_prize }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
    @if (session('success') && session('patient_info'))
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
            const patient = @json(session('patient_info'));
            localStorage.setItem('patientInfo', JSON.stringify(patient));
            
            const btn = document.querySelector('.ladda-button');
            if (btn) {
                const ladda = Ladda.create(btn);
                ladda.stop();
                btn.querySelector('.ladda-label').textContent = 'Đặt lịch hẹn';
            }
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
            $('#patientBirthDate').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true
            });
            //Lấy dữ liệu bệnh nhân
            const savedPatient = localStorage.getItem('patientInfo');

            const loggedInPatient = {!! auth()->check() && auth()->user()->roles->contains('slug_role', 'benh-nhan')
                ? json_encode([
                    'name' => auth()->user()->name,
                    'phone' => auth()->user()->phone,
                    'birth' => auth()->user()->birth,
                    'email' => auth()->user()->email,
                    'gender' => auth()->user()->gender,
                    'address' => auth()->user()->address,
                    'province_id' => auth()->user()->province_id,
                    'district_id' => auth()->user()->district_id,
                    'ward_id' => auth()->user()->ward_id,
                ])
                : 'null'
            !!};

            const data = loggedInPatient ?? (savedPatient ? JSON.parse(savedPatient) : null);

            if (data) {
                $('input[name="name"]').val(data.name || '');
                $('input[name="phone"]').val(data.phone || '');
                $('input[name="birth"]').val(data.birth || '');
                $('input[name="email"]').val(data.email || '');
                $('input[name="address"]').val(data.address || '');
                $('input[name="province_id"]').val(data.province_id || '');
                $('input[name="district_id"]').val(data.district_id || '');
                $('input[name="ward_id"]').val(data.ward_id || '');

                if (typeof data.gender !== 'undefined') {
                    $('#patientSex').val(data.gender);
                }
                if (data.province_id) {
                    $('#province-id').val(data.province_id).trigger('change');
                    $('.filter-province .select-btn span').text($('#province option[value="' + data.province_id + '"]').text());
                }
                if (data.district_id) {
                    $('#district-id').val(data.district_id);
                }
                if (data.ward_id) {
                    $('#ward-id').val(data.ward_id);
                }
            }
            //End
        });
    </script>
@endsection