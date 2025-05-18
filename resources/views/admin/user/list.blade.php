@extends('layouts.admin')

@section('title', 'Danh sách thành viên')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Thành viên</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Trang chủ</a>
            </li>
            <li>
                <a>Thành viên</a>
            </li>
            <li class="active">
                <strong>Danh sách thành viên</strong>
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
                        <form action="{{ route('user.index') }}" method="get" class="row mb-4 ms-0">
                            <div class="col-sm-2 m-b-xs">
                                <select name="role_id" class="input-sm form-control input-s-sm inline">
                                    <option value="">---Chọn vai trò---</option>
                                    @foreach ($roles as $item)
                                        <option value="{{ $item->id }}" {{ request('role_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2 m-b-xs">
                                <select name="is_account" class="input-sm form-control input-s-sm inline">
                                    <option value="">---Trạng thái kích hoạt---</option>
                                    <option value="1" {{ request('is_account') == 1 ? 'selected' : '' }}>Kích hoạt</option>
                                    <option value="2" {{ request('is_account') == 2 ? 'selected' : '' }}>Chưa kích hoạt</option>
                                </select>
                            </div>
                            <div class="col-sm-2 m-b-xs">
                                <select name="is_block" class="input-sm form-control input-s-sm inline">
                                    <option value="">---Trạng thái tài khoản---</option>
                                    <option value="1" {{ request('is_block') == 1 ? 'selected' : '' }}>Hoạt động</option>
                                    <option value="2" {{ request('is_block') == 2 ? 'selected' : '' }}>Chặn</option>
                                </select>
                            </div>
                            <div class="col-sm-2 m-b-xs">
                            </div>
                            <div class="col-sm-1 m-b-xs"></div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" name="keyword" placeholder="Nhập tên email người dùng"
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
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Vai trò</th>
                                <th colspan="2">Trạng thái</th>
                                <th>Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        {{ $item->name }}
                                    </td>
                                    <td>
                                        {{ $item->email }}
                                    </td>
                                    <td>
                                        @if (!empty($item->roles) && count($item->roles) > 0)
                                            @foreach ($item->roles as $role)
                                                <span class="badge {{ $role->name }}">{{ $role->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="no-cat">Chưa cấp quyền</span>
                                        @endif

                                    </td>
                                    <td>
                                        @if ($item->email_verified_at)
                                            <span class="fw-semibold text-success">Kích hoạt</span>
                                        @else
                                            <span class="fw-semibold text-danger">Chưa kích hoạt</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == 1)
                                            <span class="fw-semibold text-success">Hoạt động</span>
                                        @else
                                            <span class="fw-semibold text-danger">Chặn</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('user.edit', $item->id) }}" title="Cập nhật" class="edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        @if ($item->status == 1)
                                            <a href="{{ route('user.status-update', ['userId' => $item->id, 'statusCode' => 2]) }}" title="Chặn" class="blocked">
                                                <i class="fa fa-ban"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('user.status-update', ['userId' => $item->id, 'statusCode' => 1]) }}" title="Bỏ chặn" class="active">
                                                <i class="fa fa-check"></i>
                                            </a>
                                        @endif
                                        @if (Auth::id() != $item->id)
                                            <a href="{{ route('user.destroy', $item->id) }}" title="Xóa" class="delete" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                                <i class="fa fa-trash"></i>
                                            </a> 
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$users->links()}}
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
@endsection