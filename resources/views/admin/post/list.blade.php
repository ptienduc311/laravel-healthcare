@extends('layouts.admin')

@section('title', 'Danh sách danh mục')
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
                        <form action="{{ route('post.index') }}" method="get" class="row mb-4 ms-0">
                            <div class="col-sm-2 m-b-xs">
                                <select name="category_id" class="input-sm form-control input-s-sm inline">
                                    <option value="">Chọn danh mục</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}" {{ request('category_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2 m-b-xs">
                                <select name="status" class="input-sm form-control input-s-sm inline">
                                    <option value="">Trạng thái</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Không hoạt động</option>
                                </select>
                            </div>
                            <div class="col-sm-5 m-b-xs"></div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" name="keyword" placeholder="Nhập tiêu đề"
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
                                <th colspan="2">Tiêu đề</th>
                                <th>Danh mục</th>
                                <th>Trạng thái</th>
                                <th>Người tạo</th>
                                <th>Hoạt động</th>
                            </tr>
                        </thead>
                        @foreach($posts as $key => $item)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td class="title-col">{{$item->title}}</td>
                                <td>
                                    <img src="{{ Storage::url($item->image?->src) }}" alt="Ảnh {{$item->title}}" class="thumb">
                                </td>
                                <td>
                                    <span class="{{ $item->category?->status == 1 ? 'active-cat' : 'inactive-cat' }}">{{$item->category?->name}}</span>
                                </td>
                                <td style="color:{{$item->status == 1 ? "green" : "red"}}">{{$item->status == 1 ? "Hoạt động" : "Không hoạt động"}}</td>
                                <td>
                                    <span class="created_by" data-toggle="tooltip" title="{{$item->user?->roles?->pluck('name')->join(', ')}}">{{$item->user?->name}}</span>
                                </td>
                                <td>
                                    <a href="{{ route('post.edit', $item->id) }}" title="Sửa" class="edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="{{ route('post.destroy', $item->id) }}" title="Xóa" class="delete" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{$posts->links()}}
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
                "timeOut": "3000",
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