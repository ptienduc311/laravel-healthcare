@extends('layouts.admin')

@section('title', 'Danh sách danh mục')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    @if (session('status'))
    @section('custom-js')
        <script>
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "progressBar": true,
            "preventDuplicates": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "400",
            "hideDuration": "1000",
            "timeOut": "7000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        toastr.success("{{session('status')}}")
        </script>
    @endsection
    @endif
    <div class="col-lg-10">
        <h2>Danh mục bài viết</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Home</a>
            </li>
            <li>
                <a>Danh mục bài viết</a>
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

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên danh mục</th>
                                <th>Trạng thái</th>
                                <th>Hoạt động</th>
                            </tr>
                        </thead>
                        @foreach($categories as $key => $item)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$item->name}}</td>
                                <td style="color:{{$item->status == 1 ? "green" : "red"}}">{{$item->status == 1 ? "Hoạt động" : "Không hoạt động"}}</td>
                                <td>
                                    <a href="{{ route('post_category.edit', $item->id) }}" title="Sửa" class="edit">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <a href="{{ route('post_category.destroy', $item->id) }}" title="Xóa" class="delete" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        <tbody>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection