@extends('layouts.admin')

@section('title', 'Thêm chuyên khoa y tế')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Chuyên khoa y tế</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Trang chủ</a>
            </li>
            <li>
                <a>Chuyên khoa y tế</a>
            </li>
            <li class="active">
                <strong>Thêm chuyên khoa</strong>
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
                    <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('medical-specialty.store') }}" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tên chuyên khoa</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{old('name')}}">
                                @error('name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ảnh chuyên khoa</label>
                            <div class="col-sm-10">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div>
                                      <span class="btn btn-default btn-file">
                                        <span class="fileinput-new">Chọn ảnh</span>
                                        <span class="fileinput-exists">Thay đổi</span>
                                        <input type="file" name="image" accept="image/*">
                                      </span>
                                      <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Xóa</a>
                                    </div>
                                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="width: 200px; height: 200px; border:none;"></div>
                                    @error('image')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Trạng thái</label>
                            <div class="col-sm-10 mt-5">
                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" class="onoffswitch-checkbox" id="status" name="status" checked>
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
                                <button class="btn btn-primary" type="submit">Tạo chuyên khoa</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileinput = document.querySelector('.fileinput');

        const preview = fileinput.querySelector('.fileinput-preview');

        const updatePreviewVisibility = () => {
            if (fileinput.classList.contains('fileinput-exists')) {
            preview.style.display = 'block';
            } else {
            preview.style.display = 'none';
            }
        };

        updatePreviewVisibility();

        const observer = new MutationObserver(updatePreviewVisibility);
        observer.observe(fileinput, { attributes: true, attributeFilter: ['class'] });
    });
</script>
@endsection