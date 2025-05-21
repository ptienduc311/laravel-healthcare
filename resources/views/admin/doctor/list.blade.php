@extends('layouts.admin')

@section('title', 'Danh sách bác sĩ')
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
                <strong>Danh sách</strong>
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
                        <form action="{{ route('doctor.index') }}" method="get" class="row mb-4 ms-0">
                            <div class="col-sm-2 m-b-xs">
                                <select name="specialty_id" class="input-sm form-control input-s-sm inline">
                                    <option value="">Chọn chuyên khoa</option>
                                    @foreach ($medical_specialties as $item)
                                        <option value="{{ $item->id }}" {{ request('specialty_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2 m-b-xs">
                                <select name="academic_title" class="input-sm form-control input-s-sm inline">
                                    <option value="">Chọn học hàm</option>
                                    @foreach ($academicTitles as $id => $title)
                                        <option value="{{ $id }}" {{ request('academic_title') == $id ? 'selected' : '' }}>
                                            {{ $title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2 m-b-xs">
                                <select name="degree" class="input-sm form-control input-s-sm inline">
                                    <option value="">Chọn học vị</option>
                                    @foreach ($degrees as $id => $name)
                                        <option value="{{ $id }}" {{ request('degree') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2 m-b-xs">
                                <select name="status" class="input-sm form-control input-s-sm inline">
                                    <option value="">Trạng thái</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Tạm dừng</option>
                                </select>
                            </div>
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
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ảnh đại diện</th>
                                    <th colspan="2">Tên bác sĩ</th>
                                    <th>Chuyên khoa</th>
                                    <th>Học hàm</th>
                                    <th>Học vị</th>
                                    <th>Trạng thái</th>
                                    <th>Người tạo</th>
                                    <th>Hoạt động</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($doctors as $key => $item)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>
                                        <img src="{{ $item->avatar_url }}" alt="Ảnh {{$item->name}}" class="thumb">
                                    </td>
                                    <td>
                                        <a href="{{ route('doctor.profile-doctor', $item->id) }}">
                                            <span class="text-muted fw-semibold" data-toggle="tooltip" data-placement="top" title="Thông tin bác sĩ">{{ $item->name }}</span>
                                        </a>
                                        <a href="{{ route('appointment.add', $item->id) }}" class="link-appointment">Thêm lịch khám</a>
                                    </td>
                                    <td>
                                        <span class="fw-semibold {{ $item->gender == 1 ? "text-danger" : "text-info" }}">Bác sĩ {{ $item->gender == 1 ? "nam" : "nữ" }}</span>
                                    </td>
                                    <td>
                                        @if ($item->specialty_id)
                                            <span class="{{ $item->specialty?->status == 1 ? 'active-cat' : 'inactive-cat' }}">{{ $item->specialty?->name }}</span>
                                        @else
                                            <span class="no-cat">Chưa chọn chuyên khoan</span>
                                        @endif
                                    </td>
                                    <td>{{ $academicTitles[$item->academic_title] ?? '' }}</td>
                                    <td>{{ $degrees[$item->degree] ?? '' }}</td>
                                    <td style="color:{{$item->status == 1 ? "green" : "red"}}">{{$item->status == 1 ? "Hoạt động" : "Tạm dừng"}}</td>
                                    <td>
                                        <span class="created_by" data-toggle="tooltip" title="{{$item->user?->roles?->pluck('name')->join(', ')}}">{{$item->user?->name}}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('doctor.edit', $item->id) }}" title="Sửa" class="edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="{{ route('doctor.destroy', $item->id) }}" title="Xóa" class="delete" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{$doctors->links()}}
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