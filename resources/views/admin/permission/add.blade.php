@extends('layouts.admin')

@section('title', 'Thêm quyền')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Phân quyền</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Trang chủ</a>
            </li>
            <li>
                <a>Phân quyền</a>
            </li>
            <li class="active">
                <strong>Thêm quyền</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-4">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Thêm quyền</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" class="form-horizontal" action="{{ route('permission.store') }}" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên quyền<span class="claim">*</span></label>
                            <input type="text" placeholder="Nhập tên quyền" class="form-control" name="name" id="name" value="{{ old('name') }}">
                            @error('name')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug<span class="claim">*</span></label>
                            <small class="form-text d-block text-muted pb-2 mb-3">Ví dụ: posts.add</small>
                            <input type="text" placeholder="Nhập slug" class="form-control" name="slug" id="slug" value="{{ old('slug') }}">
                            @error('slug')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control message-input" name="description" id="description">{{old('description')}}</textarea>
                            @error('description')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <button class="btn btn-sm btn-primary" type="submit">
                            <strong>Thêm quyền</strong>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Danh sách quyền</h5>
                </div>
                <div class="ibox-content">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên quyền</th>
                                <th>Slug</th>
                                <th>Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($permissions as $moduleName => $modulePermissions)
                                <tr>
                                    <td scope="row"></td>
                                    <td><strong class="text-uppercase">Module {{ ucfirst($moduleName) }}</strong></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @foreach ($modulePermissions as $permission)
                                    <tr>
                                        <td scope="row">{{ $i++ }}</td>
                                        <td>|---{{ $permission->name }}</td>
                                        <td>{{ $permission->slug }}</td>
                                        <td>
                                            <a href="{{ route('permission.edit', $permission->id) }}" title="Sửa" class="edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="{{ route('permission.destroy', $permission->id) }}" title="Xóa" class="delete" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
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