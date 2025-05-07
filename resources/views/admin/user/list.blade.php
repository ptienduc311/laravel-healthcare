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
                            </div>
                            <div class="col-sm-2 m-b-xs">
                            </div>
                            <div class="col-sm-2 m-b-xs">
                            </div>
                            <div class="col-sm-2 m-b-xs">
                            </div>
                            <div class="col-sm-1 m-b-xs"></div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" name="keyword" placeholder="Nhập tên người dùng"
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
                                        @foreach ($item->roles as $role)
                                            <span class="badge {{ $role->name }}">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('user.edit', $item->id) }}" title="Sửa" class="edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="{{ route('user.destroy', $item->id) }}" title="Xóa" class="delete" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                            <i class="fa fa-trash"></i>
                                        </a>
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
@endsection