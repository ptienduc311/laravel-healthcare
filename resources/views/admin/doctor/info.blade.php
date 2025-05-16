@extends('layouts.admin')

@section('title', 'Thông tin bác sĩ')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Bác sĩ</h2>
        <ol class="breadcrumb">
            <li>
                <a href="/">Trang chủ</a>
            </li>
            <li>
                <a>Bác sĩ</a>
            </li>
            <li class="active">
                <strong>Thông tin bác sĩ</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    @if ($isAdmin)
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins" id="ibox1">
                    <div class="ibox-title">
                        <h5>Tìm kiếm bác sĩ</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="sk-spinner sk-spinner-circle">
                            <div class="sk-circle1 sk-circle"></div>
                            <div class="sk-circle2 sk-circle"></div>
                            <div class="sk-circle3 sk-circle"></div>
                            <div class="sk-circle4 sk-circle"></div>
                            <div class="sk-circle5 sk-circle"></div>
                            <div class="sk-circle6 sk-circle"></div>
                            <div class="sk-circle7 sk-circle"></div>
                            <div class="sk-circle8 sk-circle"></div>
                            <div class="sk-circle9 sk-circle"></div>
                            <div class="sk-circle10 sk-circle"></div>
                            <div class="sk-circle11 sk-circle"></div>
                            <div class="sk-circle12 sk-circle"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-7 b-r">
                                <div class="row">
                                    <div class="col-sm-3 m-b-xs">
                                        <select name="specialty_id" class="input-sm form-control" id="specialty-id">
                                            <option value="">Chọn chuyên khoa</option>
                                            @foreach ($specialties as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-7 m-b-xs">
                                        <input type="text" name="name" placeholder="Nhập tên bác sĩ" class="input-sm form-control" id="doctor-name">
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="input-sm btn btn-sm btn-primary btn-search-doctor"><strong>Tìm kiếm</strong></button>
                                    </div>
                                    <input type="hidden" value="true" id="is-profile">
                                </div>
                                <div class="img-search">
                                    <img src="{{ asset('admin/img/search.png') }}" alt="">
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <h4>Danh sách bác sĩ</h4>
                                <div class="list-doctor"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        {{-- Hiển thị giao diện tại đây --}}
        <div id="doctor-profile"></div>
        <div class="col-lg-12">
            <div class="ibox float-e-margins show-loading-bottom">
                <div class="ibox-content" id="no-found-doctor">
                    <div class="sk-spinner sk-spinner-cube-grid">
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                        <div class="sk-cube"></div>
                    </div>
                    <div class="gif-search">
                        <h3>Tìm kiếm bác sĩ để hiển thị thông tin</h3>
                        <div class="img">
                            <img src="{{ asset('admin/img/search.gif') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@if (isset($doctor))
    @section('custom-js')
        <script>
            $(document).ready(function () {
                // Ẩn phần "Tìm kiếm bác sĩ"
                $('#no-found-doctor').hide();

                const doctorId = {{ $doctor->id }};
                $.ajax({
                    url: '{{ route("doctor.show-profile") }}',
                    type: 'GET',
                    data: {
                        doctorId: doctorId
                    },
                    success: function (response) {
                        if(response.status == 'success'){
                            $('#doctor-profile').html(response.html);
                        }else{
                            toastr.warning("Không thể tải thông tin bác sĩ.");
                        }
                    },
                    error: function () {
                        toastr.warning("Không thể tải thông tin bác sĩ.");
                    },
                    complete: function () {
                        $('.show-loading-bottom .ibox-content').removeClass('sk-loading');
                    }
                });
            });
        </script>

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
@endif