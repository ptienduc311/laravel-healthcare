@extends('layouts.admin')

@section('title', 'Danh sách bác sĩ')
@section('content')
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
                <strong>Danh sách lịch khám</strong>
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
                    <div class="row mb-3">
                        <form action="{{ route('appointment.index') }}" method="get" class="row mb-4 ms-0" autocomplete="off">
                            <div class="col-sm-4 m-b-xs d-flex align-items-center">
                                <p class="mb-0" style="flex-basis: 25%;">Ngày bắt đầu</p>
                                <div class="input-group date" style="flex-basis: 75%">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control" value="{{ request('start_date') }}" id="day-start" name="start_date">
                                </div>
                            </div>
                            <div class="col-sm-4 m-b-xs d-flex align-items-center">
                                <p class="mb-0" style="flex-basis: 25%;">Ngày kết thúc</p>
                                <div class="input-group date" style="flex-basis: 75%">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control" value="{{ request('end_date') }}" id="day-end" name="end_date">
                                </div>
                            </div>
                            <div class="col-sm-1 m-b-xs"></div>
                            <div class="col-sm-3">
                                @if ($isAdmin)
                                    <div class="input-group">
                                        <input type="text" name="keyword" placeholder="Nhập tên bác sĩ" value="{{ request('keyword') }}" class="input-sm form-control">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                                        </span>
                                    </div>
                                @else
                                    <div class="input-group float-end me-4">
                                        <button type="submit" class="btn btn-sm btn-primary">Lọc</button>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ảnh đại diện</th>
                                <th colspan="2">Tên bác sĩ</th>
                                <th colspan="2">Ngày khám</th>
                                <th>Hoạt động</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($appointments as $key => $item)
                            <tr>
                                <td>{{ $key++ }}</td>
                                <td>
                                    <img src="{{ $item->doctor?->avatar_url }}" alt="Ảnh bác sĩ" class="thumb">
                                </td>
                                <td>
                                    <span>{{ $item->doctor?->name }}</span>
                                    <a href="{{ route('appointment.add', $item->doctor?->id) }}" class="link-appointment">Thêm lịch khám</a>
                                </td>
                                <td>
                                    @if ($item->doctor?->specialty_id)
                                        <span class="{{ $item->doctor?->specialty?->status == 1 ? 'active-cat' : 'inactive-cat' }}">
                                            {{ $item->doctor?->specialty?->name }}
                                        </span>
                                    @else
                                        <span class="no-cat">Chưa chọn chuyên khoa</span>
                                    @endif
                                </td>
                                <td>{{ date('d/m/Y', $item->day_examination) }}</td>
                                <td>
                                    <span class="created_by" data-toggle="tooltip" title="{{ $item->hours }}">
                                        {{ $item->total_appointments }} lịch khám
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('appointment.edit', ['doctorId' => $item->doctor_id, 'date' => $item->day_examination]) }}" title="Sửa" class="edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="{{ route('appointment.destroy', ['doctorId' => $item->doctor_id, 'date' => $item->day_examination]) }}" title="Xóa" class="delete"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    {{$appointments->links()}}
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
            const hoursAppointment = {!! json_encode(session('hoursAppointment')) !!};
            const appointmentIds = {!! json_encode(session('appointmentIds')) !!};
            const date = "{{ session('date') }}";
            const doctorId = "{{ session('doctorId') }}";

            const arrHoursAppointment = Object.values(hoursAppointment)
            const strHoursAppointment = arrHoursAppointment.join(', ');
            const swalText = `Bạn đã xóa ${arrHoursAppointment.length} giờ khám có lịch hẹn: ${strHoursAppointment}.
                Bạn có chắc chắn muốn xóa?`;

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
                    // console.log(hoursAppointment, appointmentIds, date, doctorId)
                    const $btn = $('.sweet-alert .confirm');
                    $btn.addClass('ladda-button')
                    const ladda = Ladda.create($btn[0]);
                    ladda.start();
                    $btn.find('.ladda-label').text('Đang gửi email...');

                    $.ajax({
                        url: "{{ route('appointment.confirm-delete') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            doctor_id: doctorId,
                            date: date,
                            hoursAppointment: hoursAppointment,
                            appointmentIds: appointmentIds,
                        },
                        success: function (res) {
                            if (res.success) {
                                swal("Thành công!", res.message, "success");
                                setTimeout(() => {
                                    location.href = '/admin/appointment';
                                }, 1500);
                            } else {
                                swal("Lỗi!", res.message, "error");
                            }
                        },
                        error: function () {
                            swal("Lỗi!", "Không thể xử lý yêu cầu.", "error");
                        },
                        complete: function () {
                            ladda.stop();
                        }
                    });
                }
            });
        </script>
    @endif

    <script>
        $('#day-start').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });
        $('#day-end').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });
    </script>
@endsection