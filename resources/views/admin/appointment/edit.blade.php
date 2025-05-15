@extends('layouts.admin')

@section('title', 'Sửa lịch khám bệnh')
@section('content')
<style>
    button.confirm.ladda-button[disabled]{
        cursor: not-allowed;
        filter: alpha(opacity=65);
        -webkit-box-shadow: none;
        box-shadow: none;
        opacity: .65;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Bác sĩ</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Trang chủ</a>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Bác sĩ {{$doctor->name}}</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('appointment.update', ['doctorId' => $doctorId, 'date' => $date]) }}" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ngày khám <span class="claim">*</span></label>
                            <div class="col-sm-3 input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" class="form-control" id="day-examination" value="{{ date('d-m-Y', $date) }}" name="day_examination">
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
                                    <option value="15" {{ $type == 15 ? 'selected' : '' }}>15 phút</option>
                                    <option value="30"  {{ $type == 30 ? 'selected' : '' }}>30 phút</option>
                                    <option value="60"  {{ $type == 60 ? 'selected' : '' }}>1 giờ</option>
                                    <option value="120"  {{ $type == 120 ? 'selected' : '' }}>2 giờ</option>
                                </select>
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
                                @if($errors->has('hour_examination'))
                                    <p class="error">{{ $errors->first('hour_examination') }}</p>
                                @endif   
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">Sửa lịch khám</button>
                                <a href="/admin/appointment" class="btn btn-info ms-2">Quay lại</a>
                            </div>
                        </div>
                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}" id="doctor-id">
                        <input type="hidden" value="true" id="is-appointment">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
    @if (session('error'))
        <script>
            toastr.options = {
            "closeButton": false,
            "debug": false,
            "progressBar": false,
            "preventDuplicates": false,
            "positionClass": "toast-top-center",
            "onclick": null,
            "showDuration": "400",
            "hideDuration": "1000",
            "timeOut": "2400",
            "extendedTimeOut": "1000",
            "showEasing": "linear",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
            }

            toastr.error("{{session('error')}}")
        </script>
    @endif

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
    @if (session('confirm_remove'))
        <script>
            const type = "{{ session('type') }}";
            const newHours = {!! json_encode(session('newHours')) !!};
            const hoursAdd = {!! json_encode(session('hoursAdd')) !!};
            const hoursAppointment = {!! json_encode(session('hoursAppointment')) !!};
            const appointmentIds = {!! json_encode(session('appointmentIds')) !!};
            const date = "{{ session('date') }}";
            const doctorId = "{{ session('doctorId') }}";

            const arrHoursAppointment = Object.values(hoursAppointment)
            const strHoursAppointment = arrHoursAppointment.join(', ');
            const swalText = `Bạn đã xóa ${arrHoursAppointment.length} giờ có lịch hẹn: ${strHoursAppointment}.
                Bạn có chắc muốn xóa?`;

            swal({
                title: "Xác nhận thay đổi lịch khám?",
                text: swalText,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Chắc chắn",
                cancelButtonText: "Không",
                closeOnConfirm: false,
                showLoaderOnConfirm: false
            }, function(isConfirm) {
                if (isConfirm) {
                    console.log(type, newHours, hoursAdd, hoursAppointment, appointmentIds, date, doctorId)
                    const $btn = $('.sweet-alert .confirm');
                    $btn.addClass('ladda-button')
                    const ladda = Ladda.create($btn[0]);
                    ladda.start();
                    $btn.find('.ladda-label').text('Đang gửi email...');

                    $.ajax({
                        url: "{{ route('appointment.confirm-remove') }}", // bạn tạo route này
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            doctor_id: doctorId,
                            date: date,
                            type: type,
                            newHours: newHours,
                            hoursAdd: hoursAdd,
                            hoursAppointment: hoursAppointment,
                            appointmentIds: appointmentIds,
                        },
                        success: function (res) {
                            ladda.stop();
                            if (res.success) {
                                swal("Thành công!", res.message, "success");
                                setTimeout(() => {
                                    location.href = `/admin/appointment/edit/${doctorId}/${date}`;
                                }, 1500);
                            } else {
                                swal("Lỗi!", res.message, "error");
                            }
                        },
                        error: function () {
                            ladda.stop();
                            swal("Lỗi!", "Không thể xử lý yêu cầu.", "error");
                        }
                    });
                }
            });
        </script>
    @endif

    <script>
        const dateVal = $('#day-examination').val();
        $('#day-examination').datepicker({
            format: 'dd-mm-yyyy',
            startDate: dateVal,
            endDate: dateVal,
            autoclose: true
        });

        // $(document).ready(function (){

        //     var l = $( '.ladda-button-demo' ).ladda();

        //     l.click(function(){
        //         // Start loading
        //         l.ladda( 'start' );

        //         // Timeout example
        //         // Do something in backend and then stop ladda
        //         setTimeout(function(){
        //             l.ladda('stop');
        //         },12000)
        //     });
        // });
    </script>

@endsection