 @extends('layouts.admin')

@section('title', 'Danh sách chuyên khoa y tế')
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
                        <form action="{{ route('medical-specialty.index') }}" method="get" class="row mb-4 ms-0">
                            <div class="col-sm-2 m-b-xs">
                                <select name="status" class="input-sm form-control input-s-sm inline">
                                    <option value="">Trạng thái</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                                    <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Không hoạt động</option>
                                </select>
                            </div>
                            <div class="col-sm-7 m-b-xs"></div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" name="keyword" placeholder="Nhập tên chuyên khoa"
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
                                    <th>Tên chuyên khoa</th>
                                    <th>Ảnh icon chuyên khoa</th>
                                    <th>Ảnh chuyên khoa</th>
                                    <th>Trạng thái</th>
                                    <th>Hoạt động</th>
                                </tr>
                            </thead>
                            @foreach($medical_specialties as $key => $item)
                                <tr>
                                    <td>{{$key + 1}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        <img src="{{ Storage::url($item->image_icon?->src) }}" alt="Ảnh icon {{$item->title}}" class="thumb">
                                    </td>
                                    <td>
                                        <img src="{{ Storage::url($item->image?->src) }}" alt="Ảnh {{$item->title}}" class="thumb">
                                    </td>
                                    <td style="color:{{$item->status == 1 ? "green" : "red"}}">{{$item->status == 1 ? "Hoạt động" : "Không hoạt động"}}</td>
                                    <td>
                                        <a href="{{ route('medical-specialty.edit', $item->id) }}" title="Sửa" class="edit">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a href="{{ route('medical-specialty.destroy', $item->id) }}" title="Xóa" class="delete" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    {{$medical_specialties->links()}}
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
                "timeOut": "4500",
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