@extends('layouts.admin')

@section('title', 'Thêm lịch khám bệnh')
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Bác sĩ</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{ route('admin.dashboard') }}">Trang chủ</a>
                </li>
                <li>
                    <a>Bác sĩ</a>
                </li>
                <li class="active">
                    <strong>Thêm lịch khám bệnh</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        @if ($isAdmin && !isset($doctor))
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins" id="ibox1">
                        <div class="ibox-title">
                            <h5>Tìm kiếm bác sĩ</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="sk-spinner sk-spinner-circle">
                                <div class="sk-circle1 sk-circle"></div>
                                <div class="sk-circle2 sk-circle"></div>
                                <div class="sk-circle3 sk-circle"></div>
                                <div class="sk-circle4 sk-circle"></div>
                                <div class="sk-circle5 sk-circle"></div>
                                <div class="sk-circle6 sk-circle"></div>
                                <div class="sk-circle7 sk-circle"></div>
                                <div class="sk-circle8 sk-circle"></div>
                                <div class="sk-circle9 sk-circle"></div>
                                <div class="sk-circle10 sk-circle"></div>
                                <div class="sk-circle11 sk-circle"></div>
                                <div class="sk-circle12 sk-circle"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-7 b-r">
                                    <div class="row">
                                        <div class="col-sm-3 m-b-xs">
                                            <select name="specialty_id" class="input-sm form-control" id="specialty-id">
                                                <option value="">Chọn chuyên khoa</option>
                                                @foreach ($specialties as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-7 m-b-xs">
                                            <input type="text" name="name" placeholder="Nhập tên bác sĩ" class="input-sm form-control" id="doctor-name">
                                        </div>
                                        <div class="col-sm-2">
                                            <button class="input-sm btn btn-sm btn-primary btn-search-doctor"><strong>Tìm kiếm</strong></button>
                                        </div>
                                    </div>
                                    <div class="img-search">
                                        <img src="{{ asset('admin/img/search.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <h4>Danh sách bác sĩ</h4>
                                    <div class="list-doctor"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins show-loading-bottom">
                    <div class="ibox-title">
                        <h5>Bác sĩ <span id="selected-doctor-name">{{ $doctor->name ?? '[Chưa chọn]' }}</span></h5>
                    </div>
                    <div class="ibox-content">
                        <div class="sk-spinner sk-spinner-cube-grid">
                            <div class="sk-cube"></div>
                            <div class="sk-cube"></div>
                            <div class="sk-cube"></div>
                            <div class="sk-cube"></div>
                            <div class="sk-cube"></div>
                            <div class="sk-cube"></div>
                            <div class="sk-cube"></div>
                            <div class="sk-cube"></div>
                            <div class="sk-cube"></div>
                        </div>
                        <form method="POST" id="form-submit"
                            action="{{ isset($doctor) ? route('appointment.store', $doctor->id) : '#' }}"
                            class="form-horizontal appointment-form" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Ngày khám <span class="claim">*</span></label>
                                <div class="col-sm-3 input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control" id="day-examination" name="day_examination">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10">
                                    @error('day_examination')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Khoảng thời gian khám</label>
                                <div class="col-sm-2 px-0">
                                    <select class="form-control m-b" name="type" id="time-interval">
                                        <option value="15">15 phút</option>
                                        <option value="30" selected>30 phút</option>
                                        <option value="60">1 giờ</option>
                                        <option value="120">2 giờ</option>
                                    </select>
                                    @error('type')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10 mt-3">
                                    <div class="radio radio-success radio-inline pt-0">
                                        <input type="radio" id="all-day" value="all_day" name="type_time">
                                        <label for="all-day">Cả ngày</label>
                                    </div>
                                    <div class="radio radio-warning radio-inline pt-0">
                                        <input type="radio" id="morning" value="morning" name="type_time">
                                        <label for="morning">Sáng</label>
                                    </div>
                                    <div class="radio radio-danger radio-inline pt-0">
                                        <input type="radio" id="afternoon" value="afternoon" name="type_time">
                                        <label for="afternoon">Chiều</label>
                                    </div>
                                    <div class="radio radio-inline pt-0">
                                        <input type="radio" id="night" value="night" name="type_time">
                                        <label for="night">Tối</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Chọn giờ khám <span class="claim">*</span></label>
                                <div class="col-sm-10 px-0" id="time-slots"></div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10">
                                    @if ($errors->has('hour_examination'))
                                        <p class="error">{{ $errors->first('hour_examination') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    <button class="btn btn-primary" type="submit" id="submit-button" {{ isset($doctor) ? '' : 'disabled' }}>Thêm lịch khám</button>
                                </div>
                            </div>
                            <input type="hidden" name="doctor_id" value="{{ isset($doctor) ? $doctor->id : '' }}" id="doctor-id">
                            <input type="hidden" value="true" id="is-appointment">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
    @if ($errors->has('doctor_id'))
        <script>
            toastr.options = {
                closeButton: false,
                debug: false,
                progressBar: true,
                preventDuplicates: false,
                positionClass: "toast-top-right",
                onclick: null,
                showDuration: "400",
                hideDuration: "10000",
                timeOut: "5000",
                extendedTimeOut: "1000",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
            };

            toastr.error("{{ $errors->first('doctor_id') }}");
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
        //Xử lý input date 
        const today = new Date();
        const oneMonthLater = new Date();
        oneMonthLater.setMonth(oneMonthLater.getMonth() + 1);

        $('#day-examination').datepicker({
            format: 'dd-mm-yyyy',
            startDate: today,       
            endDate: oneMonthLater,
            autoclose: true,
            todayHighlight: true
        });

        const day = today.getDate().toString().padStart(2, '0');
        const month = (today.getMonth() + 1).toString().padStart(2, '0');
        const year = today.getFullYear();

        const formattedToday = `${day}-${month}-${year}`;
        $('#day-examination').val(formattedToday);

    </script>

@endsection
