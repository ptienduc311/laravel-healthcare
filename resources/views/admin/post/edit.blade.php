@extends('layouts.admin')

@section('title', 'Sửa bài viết')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Bài viết</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Trang chủ</a>
            </li>
            <li>
                <a>Bài viết</a>
            </li>
            <li class="active">
                <strong>Sửa bài viết</strong>
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
                    <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('post.update', ['id' => $post->id]) }}" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tiêu đề bài viết<span class="claim">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="title" value="{{$post->title}}">
                                @error('title')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Mô tả bài viết</label>
                            <div class="col-sm-10">
                                <textarea class="form-control message-input" name="description">{{$post->description}}</textarea>
                                @error('description')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nội dung bài viết<span class="claim">*</span></label>
                            <div class="col-sm-10">
                                <textarea id="editor" class="form-control message-input" name="content">{{$post->content}}</textarea>
                                @error('content')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Danh mục bài viết<span class="claim">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control m-b" name="category_id">
                                    <option>Chọn danh mục</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}" {{ $post->category_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>                            
                            @error('category_id')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ảnh bìa<span class="claim">*</span></label>
                            <div class="col-sm-10">
                                <div class="fileinput {{ !empty($post->image_id) ? "fileinput-exists" : "fileinput-new"}}" data-provides="fileinput">
                                    <div>
                                      <span class="btn btn-default btn-file">
                                        <span class="fileinput-new">Chọn ảnh</span>
                                        <span class="fileinput-exists">Thay đổi</span>
                                        <input type="file" name="image" accept="image/*" value="{{$post->image_id}}">
                                      </span>
                                      <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Xóa</a>
                                    </div>
                                    <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="{{ !empty($post->image_id) ? 'display: block;' : ''}}width: 200px; height: 200px; border:none; line-height: 200px;">
                                        @if($post->image_id)
                                            <img src="{{ Storage::url($post->image->src) }}" alt="Ảnh bìa" style="max-width: 100%; max-height: 100%;">
                                        @endif
                                    </div>
                                    @error('image')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Trạng thái</label>
                            <div class="col-sm-10 mt-2">
                                <div class="switch">
                                    <div class="onoffswitch">
                                        <input type="checkbox" class="onoffswitch-checkbox" id="status" name="status" {{$post->status == 1 ? "checked" : ""}}>
                                        <label class="onoffswitch-label" for="status">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <input type="hidden" name="remove_image" value="0" id="remove-image-flag">
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">Sửa bài viết</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection