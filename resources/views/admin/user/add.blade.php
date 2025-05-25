@extends('layouts.admin')

@section('title', 'Tạo tài khoản')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Người dùng</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">Trang chủ</a>
            </li>
            <li>
                <a>Người dùng</a>
            </li>
            <li class="active">
                <strong>Tạo tài khoản</strong>
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
                    <form method="POST" class="form-horizontal" id="form-submit" action="{{ route('user.store') }}" autocomplete="off">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tên tài khoản<span class="claim">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @error('name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email<span class="claim">*</span></label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" value="{{ old('email') }}" name="email">
                                @error('email')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Mật khẩu<span class="claim">*</span></label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control pe-5" name="password">
                                <div class="toggle-password">
                                    <i class="fa fa-eye-slash"></i>
                                </div>
                                @error('password')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Xác nhận mật khẩu</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control pe-5" name="password_confirmation">
                                <div class="toggle-password">
                                    <i class="fa fa-eye-slash"></i>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Vai trò</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="role" id="role-user">
                                    <option value="">---Chọn vai trò---</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" data-slug-role="{{ $role->slug_role }}">
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="connect-doctor" data-toggle="modal" data-target="#myModal">
                                    <i class="fa fa-link"></i>
                                    Liên kết bác sĩ
                                </div>
                                <div class="show-doctor-connect"></div>
                                @error('role')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kich hoạt tài khoản</label>
                            <div class="col-sm-10">
                                <div class="checkbox checkbox-danger">
                                    <input id="activate" type="checkbox" name="is_activate">
                                    <label for="activate">
                                        Kích hoạt
                                    </label>
                                </div>
                                <small class="d-block pt-3 fst-italic">Tài khoản <b>Admin</b> sẽ tự động kích hoạt tài khoản.</small>
                            </div>
                        </div>
                        {{-- <input type="hidden" name="doctor_id" id="doctor-id"> --}}
                        <input type="hidden" value="true" id="is-create-user">
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit" name="action" value="create">Tạo tài khoản</button>
                                <button class="btn btn-primary ladda-button ladda-button-send-mail" type="submit" name="action" value="create_and_send" data-style="zoom-in">Gửi email xác nhận</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal inmodal" id="myModal" tabindex="-1" role="dialog"p>
            <div class="modal-dialog">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <div class="col-md-4 mb-3 pe-0 ps-2">
                            <select name="" id="specialty-id" class="form-control">
                                <option value="">---Chuyên khoa---</option>
                                @foreach ($specialties as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3 pe-0 ps-2">
                            <input type="text" id="doctor-name" class="form-control" placeholder="Nhập tên bác sĩ">
                        </div>
                        <div class="col-md-2 mb-3 pe-0 ps-2">
                            <button class="btn btn-success w-100 btn-search-connect-doctor ladda-button" data-style="zoom-in" type="button">
                                <span class="bold"> Tìm kiếm</span>
                            </button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="list-doctor"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom-js')
    <script>
        Ladda.bind('.ladda-button-send-mail');

        document.querySelector('.form-horizontal').addEventListener('submit', function(event) {
            var buttonClicked = event.submitter;
            
            if (buttonClicked && buttonClicked.value === "create_and_send") {
                var laddaButton = Ladda.create(buttonClicked);
                laddaButton.start();
            }
        });
    </script>

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
                "hideDuration": "1000",
                "timeOut": "5000",
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