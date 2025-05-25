@extends('layouts.admin')

@section('title', 'Cập nhật hồ sơ')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Hồ sơ</h2>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('admin.dashboard') }}">Trang chủ</a>
            </li>
            <li>
                <a>Hồ sơ</a>
            </li>
            <li class="active">
                <strong>Cập nhật hồ sơ tài khoản</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <form method="POST" class="form-horizontal" enctype="multipart/form-data" action="{{ route('admin.profile_update') }}" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-lg-9">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Thông tin tài khoản</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}" name="email" readonly>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tên người dùng</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ old('name', Auth::user()->name) }}" name="name">
                                @error('username')
                                    <p class="error">{{ $message }}</p>
                                @enderror    
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mật khẩu mới</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control pe-5" value="" name="password">
                                <div class="toggle-password">
                                    <i class="fa fa-eye-slash"></i>
                                </div>
                                @error('password')
                                    <p class="error">{{ $message }}</p>
                                @enderror    
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Xác nhận mật khẩu</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control pe-5" value="" name="password_confirmation">
                                <div class="toggle-password">
                                    <i class="fa fa-eye-slash"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3" style="max-height: 300px;overflow: hidden;">
                <div class="ibox-title">
                    <h5>Ảnh hồ sơ</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <div class="fileinput fileinput-exists" data-provides="fileinput">
                                <div>
                                    <span class="btn btn-default btn-file">
                                    <span class="fileinput-new">Chọn ảnh</span>
                                    <span class="fileinput-exists">Thay đổi</span>
                                    <input type="file" name="image" accept="image/*" value="{{Auth::user()->image_id}}">
                                    </span>
                                    <a href="#" class="btn btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Xóa</a>
                                </div>
                                <div class="fileinput-preview img-thumbnail" data-trigger="fileinput" style="display: block; width: 160px; height: 160px; border:none; border:1px solid #ececec; border-radius: 50%; margin:20px; overflow: hidden;">
                                    <img src="{{ Auth::user()->avatar_user }}" alt="Ảnh bìa" style="max-width: 100%; max-height: 100%;">
                                </div>
                                @error('image')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <input type="hidden" name="remove_image" value="0" class="remove-image-flag">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title"></h5>
                        <h5>Thông tin các nhân <small>(Không bắt buộc)</small></h5>
                    </div>
                    <div class="ibox-content">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Số điện thoại</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ngày sinh</label>
                            <div class="col-sm-3">
                                <div class="input-group date">
                                    <span class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control" id="day-birth" value="{{ old('birth', Auth::user()->birth) }}" name="birth">
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Giới tính</label>
                            <div class="col-sm-10">
                                <select class="form-control m-b" name="gender">
                                    <option value="1" {{ Auth::user()->gender == 1 ? 'selected' : '' }}>Nam</option>
                                    <option value="2" {{ Auth::user()->gender == 2 ? 'selected' : '' }}>Nữ</option>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tỉnh/Thành phố</label>
                            <div class="col-sm-10">
                                <select class="form-control m-b" id="province">
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Quận/Huyện</label>
                            <div class="col-sm-10">
                                <select class="form-control m-b" id="district">
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phường/Xã</label>
                            <div class="col-sm-10">
                                <select class="form-control m-b" id="ward">
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Địa chỉ</label>
                            <div class="col-sm-10">
                                <textarea class="form-control message-input" name="address">{{ old('address', Auth::user()->address) }}</textarea>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <input type="hidden" id="province-id" name="province_id" value="{{ Auth::user()->province_id }}">
                        <input type="hidden" id="district-id" name="district_id" value="{{ Auth::user()->district_id }}">
                        <input type="hidden" id="ward-id" name="ward_id" value="{{ Auth::user()->ward_id }}">
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit">Cập nhật</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
    @if (session('warning'))
        <script>
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "progressBar": false,
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

            toastr.warning("{{session('warning')}}")
        </script>
    @endif

<script>
    $('#day-birth').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    });
    $(document).ready(function(){
        $("#province").select2();
        $("#district").select2();
        $("#ward").select2();

        //Tỉnh/Thành phố, Quận/Huyện, Xã/Phường(https://oapi.vn/api-tinh-thanh-viet-nam)
        const $provinceSelect = $("#province");
        const $districtSelect = $("#district");
        const $wardSelect = $("#ward");

        let listProvince = [];
        let listDistricts = [];
        let listWards = [];

        $districtSelect.prop("disabled", true);
        $wardSelect.prop("disabled", true);

        $provinceSelect.html(`<option value="">---Chọn Tỉnh/Thành phố---</option>`);
        $districtSelect.html(`<option value="">---Chọn Quận/Huyện---</option>`);
        $wardSelect.html(`<option value="">---Chọn Phường/Xã---</option>`);

        $.get("/api-get-provinces", function (res) {
            if (res && res.data) {
                listProvince = res.data;
                listProvince.forEach(province => {
                    $provinceSelect.append(`<option value="${province.id}">${province.name}</option>`);
                });

                const savedProvinceId = $("#province-id").val();
                const savedDistrictId = $("#district-id").val();
                const savedWardId = $("#ward-id").val();

                if (savedProvinceId) {
                    $provinceSelect.val(savedProvinceId).trigger('change');

                    loadDistricts(savedProvinceId, function () {
                        if (savedDistrictId) {
                            $districtSelect.val(savedDistrictId).trigger('change');

                            loadWards(savedDistrictId, function () {
                                if (savedWardId) {
                                    $wardSelect.val(savedWardId).trigger('change');
                                }
                            });
                        }
                    });
                }
            }
        }).fail(function () {
            alert("Không thể tải danh sách tỉnh/thành phố.");
        });

        $provinceSelect.on("change", function () {
            const provinceId = $(this).val();
            $('#select2-district-container').text('');
            $('#select2-ward-container').text('');

            $districtSelect.html(`<option value="">Chọn Quận/Huyện</option>`);
            $wardSelect.html(`<option value="">Chọn Phường/Xã</option>`);
            $wardSelect.prop("disabled", true);

            if (provinceId) {
                loadDistricts(provinceId);
                $("#province-id").val(provinceId);
                $("#district-id").val('');
                $("#ward-id").val('');
            } else {
                $districtSelect.prop("disabled", true);
                $wardSelect.prop("disabled", true);
            }
        });

        $districtSelect.on("change", function () {
            const districtId = $(this).val();
            $('#select2-ward-container').text('');

            $wardSelect.html(`<option value="">Chọn Phường/Xã</option>`);
            $wardSelect.prop("disabled", true);

            if (districtId) {
                loadWards(districtId);
                $("#district-id").val(districtId);
                $("#ward-id").val('');
            }
        });

        $wardSelect.on("change", function () {
            const wardId = $(this).val();
            $("#ward-id").val(wardId);
        });

        function loadDistricts(provinceId, callback = null) {
            $districtSelect.prop("disabled", true);

            $.get(`/api-get-districts?province_id=${provinceId}`, function (res) {
                if (res.status === 'success') {
                    listDistricts = res.data;
                    listDistricts.forEach(district => {
                        $districtSelect.append(`<option value="${district.id}">${district.name}</option>`);
                    });
                    $districtSelect.prop("disabled", false);
                    if (callback) callback();
                } else {
                    alert(res.message || 'Không thể tải danh sách quận/huyện.');
                }
            }).fail(function () {
                alert("Lỗi khi tải quận/huyện.");
            });
        }

        function loadWards(districtId, callback = null) {
            $wardSelect.prop("disabled", true);

            $.get(`/api-get-wards?district_id=${districtId}`, function (res) {
                if (res.status === 'success') {
                    listWards = res.data;
                    listWards.forEach(ward => {
                        $wardSelect.append(`<option value="${ward.id}">${ward.name}</option>`);
                    });
                    $wardSelect.prop("disabled", false);
                    if (callback) callback();
                } else {
                    alert(res.message || 'Không thể tải danh sách phường/xã.');
                }
            }).fail(function () {
                alert("Lỗi khi tải phường/xã.");
            });
        }
    });
</script>
@endsection