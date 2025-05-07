@extends('layouts.admin')

@section('title', 'Thêm vai trò')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Vai trò</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Trang chủ</a>
            </li>
            <li>
                <a>Vai trò</a>
            </li>
            <li class="active">
                <strong>Thêm vai trò</strong>
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
                    <form method="POST" class="form-horizontal" action="{{ route('role.store') }}" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tên vai trò<span class="claim">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{old('name')}}">
                                @error('name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Mô tả<span class="claim">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="description" value="{{old('description')}}">
                                @error('description')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <strong>Vai trò này có quyền gì?<span class="claim">*</span></strong>
                        <small class="d-block">Check vào module hoặc các hành động bên dưới để chọn quyền.</small>
                        <label class="checkbox-inline">
                            <input type="checkbox" id="check-all"><strong>Chọn tất cả quyền</strong> 
                        </label> 
                        @foreach ($permissions as $moduleName => $modulePermissions)
                            <div class="card permission-group">
                                <div class="card-header">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" class="group-check"><strong>Module {{ ucfirst($moduleName) }}</strong> 
                                    </label> 
                                </div>
                                <div class="card-body">
                                    @foreach ($modulePermissions as $permission)
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="permission_id[]" class="permission-checkbox" value="{{ $permission->id }}" {{ in_array($permission->id, old('permission_id', [])) ? 'checked' : '' }}>{{ $permission->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        @error('permission_id')
                            <p class="error">{{ $message }}</p>
                        @enderror
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">Thêm vai trò</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection