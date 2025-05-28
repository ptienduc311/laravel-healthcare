@extends('layouts.admin')

@section('title', 'Sửa chuyên khoa y tế')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Chuyên khoa y tế</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">Trang chủ</a>
            </li>
            <li>
                <a>Chuyên khoa y tế</a>
            </li>
            <li class="active">
                <strong>Sửa chuyên khoa</strong>
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
                    <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('medical-specialty.update', ['id' => $medical_specialty->id]) }}" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tên chuyên khoa<span class="claim">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{$medical_specialty->name}}">
                                @error('name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ảnh icon chuyên khoa<span class="claim">*</span></label>
                            <div class="col-sm-10">
                                <div class="fileinput {{ !empty($medical_specialty->image_icon_id) ? "fileinput-exists" : "fileinput-new"}}" data-provides="fileinput">
                                    <div>
                                      <span class="btn btn-default btn-file">
                                        <span class="fileinput-new">Chọn ảnh</span>
                                        <span class="fileinput-exists">Thay đổi</span>
                                        <input type="file" name="image_icon" accept="image/*" value="{{$medical_specialty->image_icon_id}}">
                                      </span>
                                      <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Xóa</a>
                                    </div>
                                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="{{ !empty($medical_specialty->image_icon_id) ? 'display: block;' : ''}}width: 200px; height: 200px; border:none; line-height: 200px;">
                                        @if($medical_specialty->image_icon_id)
                                            <img src="{{ Storage::url($medical_specialty->image_icon->src) }}" alt="Ảnh icon chuyên khoa" style="max-width: 100%; max-height: 100%;">
                                        @endif
                                    </div>
                                    @error('image_icon')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <input type="hidden" name="remove_image_icon" class="remove-image-flag" value="0">
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ảnh chuyên khoa<span class="claim">*</span></label>
                            <div class="col-sm-10">
                                <div class="fileinput {{ !empty($medical_specialty->image_id) ? "fileinput-exists" : "fileinput-new"}}" data-provides="fileinput">
                                    <div>
                                      <span class="btn btn-default btn-file">
                                        <span class="fileinput-new">Chọn ảnh</span>
                                        <span class="fileinput-exists">Thay đổi</span>
                                        <input type="file" name="image" accept="image/*" value="{{$medical_specialty->image_id}}">
                                      </span>
                                      <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Xóa</a>
                                    </div>
                                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="{{ !empty($medical_specialty->image_id) ? 'display: block;' : ''}}width: 200px; height: 200px; border:none; line-height: 200px;">
                                        @if($medical_specialty->image_id)
                                            <img src="{{ Storage::url($medical_specialty->image->src) }}" alt="Ảnh chuyên khoa" style="max-width: 100%; max-height: 100%;">
                                        @endif
                                    </div>
                                    @error('image')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <input type="hidden" name="remove_image" class="remove-image-flag" value="0">
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Trạng thái</label>
                            <div class="col-sm-10 mt-2">
                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" class="onoffswitch-checkbox" id="status" name="status" {{$medical_specialty->status == 1 ? "checked" : ""}}>
                                        <label class="onoffswitch-label" for="status">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">Sửa chuyên khoa</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection