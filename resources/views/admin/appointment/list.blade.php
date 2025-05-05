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
                            <div class="col-sm-3 m-b-xs">
                                <div class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control" value="{{ request('date') }}" id="day-filter" name="date">
                                </div>
                            </div>
                            <div class="col-sm-5"></div>
                            <div class="col-sm-1 m-b-xs"></div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" name="keyword" placeholder="Nhập tên bác sĩ"
                                           value="{{ request('keyword') }}"
                                           class="input-sm form-control">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ảnh đại diện</th>
                                <th colspan="2">Tên bác sĩ</th>
                                <th colspan="2">Ngày khám</th>
                                <th>Người tạo</th>
                                <th>Hoạt động</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $index = 1; @endphp
                        @foreach($groupedAppointments as $doctorId => $dates)
                            @php
                                $doctor = $dates->first()->first()->doctor;
                            @endphp
                            <tr>
                                <td rowspan="{{ count($dates) }}">{{ $index++ }}</td>
                                <td rowspan="{{ count($dates) }}">
                                    <img src="{{ $doctor->avatar_url }}" alt="Ảnh {{ $doctor->name }}" class="thumb">
                                </td>
                                <td rowspan="{{ count($dates) }}">
                                    <span>{{ $doctor->name }}</span>
                                    <a href="{{ route('appointment.add', $doctor->id) }}" class="link-appointment">Thêm lịch khám</a>
                                </td>
                                <td rowspan="{{ count($dates) }}">
                                    @if ($doctor->specialty_id)
                                        <span class="{{ $doctor->specialty?->status == 1 ? 'active-cat' : 'inactive-cat' }}">
                                            {{ $doctor->specialty?->name }}
                                        </span>
                                    @else
                                        <span class="no-cat">Chưa chọn chuyên khoa</span>
                                    @endif
                                </td>
                                @foreach($dates as $dateInt => $appointments)
                                    @php
                                        $formattedDate = date('d/m/Y', $dateInt);
                                        $hours = $appointments->pluck('hour_examination')->sort()->join(', ');
                                        $user = $appointments->first()->user;
                                    @endphp
                    
                                    @if (!$loop->first)
                                        <tr>
                                    @endif
                                        <td>{{ $formattedDate }}</td>
                                        <td>
                                            <span class="created_by" data-toggle="tooltip" title="{{ $hours }}">
                                                {{ $appointments->count() }} cuộc hẹn
                                            </span>
                                        </td>
                                        <td>
                                            <span class="created_by" data-toggle="tooltip"
                                                  title="{{ $user?->roles?->pluck('name')->join(', ') }}">
                                                  {{ $user?->name }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('appointment.edit', ['doctorId' => $doctor->id, 'date' => $dateInt]) }}" title="Sửa" class="edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="{{ route('appointment.destroy', ['doctorId' => $doctor->id, 'date' => $dateInt]) }}" title="Xóa" class="delete"
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                        @endforeach
                        </tbody>
                    </table>
                    {{$paginator->links()}}
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

    <script>
        $('#day-filter').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });
    </script>
@endsection